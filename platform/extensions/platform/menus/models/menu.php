<?php
/**
 * Part of the Platform application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Platform
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Platform\Menus;

use Closure;
use DB;
use Exception;
use Nesty\Nesty;
use Str;

class Menu extends Nesty
{

	/**
	 * The name of the table associated with the model.
	 *
	 * @var string
	 */
	protected static $_table = 'menus';

	/**
	 * Indicates if the model has update and creation timestamps.
	 *
	 * @var bool
	 */
	protected static $_timestamps = false;

	/**
	 * The active menu slug.
	 *
	 * @var Menu
	 */
	protected static $_active;

	/**
	 * The path of active menu IDs.
	 *
	 * @var string
	 */
	protected static $_active_path = array();

	/**
	 * Array of nesty column default names
	 *
	 * @var array
	 */
	protected static $_nesty_cols = array(
		'left'  => 'lft',
		'right' => 'rgt',
		'tree'  => 'menu_id',
	);

	/**
	 * Returns an array of root menu items.
	 *
	 * @return  array
	 */
	public static function menus()
	{
		return static::all(function($query)
		{
			return $query->where(Menu::nesty_col('left'), '=', 1);
		});
	}

	/**
	 * Get the children for this model.
	 *
	 * @param   int   $limit
	 * @param   array $columns
	 * @return  array
	 */
	public function enabled_children($limit = false, $columns = array('*'))
	{
		// If we have set the children property as
		// false, there are no children
		if ($this->children === false)
		{
			return array();
		}

		// Lazy load children
		if (empty($this->children))
		{
			// Get an array of children from the database
			$children_array = $this->query_enabled_children_array($limit, $columns);

			// If we got an empty array of children
			if (empty($children_array))
			{
				$this->children = false;
				return $this->children();
			}

			// Hydrate our children. If hydrate children
			// returns false, there are no children for this
			// model. That means that $this->children === false,
			// so we call this same method again which handles empty
			// children
			if ($this->fill_children($children_array) === false)
			{
				$this->children = false;
				return $this->children();
			}
		}

		return $this->children;
	}

	/**
	 * Queries the database for all children
	 * nodes of the current nesty model.
	 *
	 * This method is used in conjunction with
	 * Nesty::hydrate_children() by
	 * Nesty::get_children() [the public method]
	 * to retrieve a hierarchical array of children.
	 *
	 * @param   int      $limit
	 * @param   array    $columns
	 * @return  array
	 */
	protected function query_enabled_children_array($limit = false, $columns = array('*'))
	{
		// Table name
		$table = static::table();

		// Primary key
		$key   = static::key();

		// Nesty cols
		extract(static::$_nesty_cols, EXTR_PREFIX_ALL, 'n');

		// Work out the columns to select
		$sql_columns = '';
		foreach ($columns as $column)
		{
			$sql_columns .= ' `nesty`.'.($column == '*' ? $column : '`'.$column.'`');
		}

		// Status column
		$status = 'status';

		// This is the magical query that is the sole
		// reason we're using the MPTT pattern
		$sql = <<<SQL
SELECT   $sql_columns,
         (COUNT(`parent`.`$key`) - (`sub_tree`.`depth` + 1)) AS `depth`

FROM     `$table` AS `nesty`,
         `$table` AS `parent`,
         `$table` AS `sub_parent`,
         (
             SELECT `nesty`.`$key`,
                    (COUNT(`parent`.`$key`) - 1) AS `depth`

             FROM   `$table` AS `nesty`,
                    `$table` AS `parent`

             WHERE  `nesty`.`$n_left`  BETWEEN `parent`.`$n_left` AND `parent`.`$n_right`
             AND    `nesty`.`$key`     = {$this->{static::key()}}
             AND    `nesty`.`$n_tree`  = {$this->{$n_tree}}
             AND    `parent`.`$n_tree` = {$this->{$n_tree}}

             GROUP BY `nesty`.`$key`

             ORDER BY `nesty`.`$n_left`
         ) AS `sub_tree`

WHERE    `nesty`.`$n_left`   BETWEEN `parent`.`$n_left`     AND `parent`.`$n_right`
AND      `nesty`.`$n_left`   BETWEEN `sub_parent`.`$n_left` AND `sub_parent`.`$n_right`
AND      `sub_parent`.`$key` = `sub_tree`.`$key`
AND      `nesty`.`$n_tree`   = {$this->{$n_tree}}
AND      `parent`.`$n_tree`  = {$this->{$n_tree}}
AND      `nesty`.`$status`   = 1

GROUP BY `nesty`.`$key`

HAVING   `depth` > 0
SQL;

		// If we have a limit
		if ($limit)
		{
			$sql .= PHP_EOL.'AND      `depth` <= '.$limit;
		}

		// Finally, add an ORDER BY
		$sql .= str_repeat(PHP_EOL, 2).'ORDER BY `nesty`.`'.$n_left.'`';

		// And return the array of results
		return DB::query($sql);
	}

	/**
	 * Used for initiating a new root menu, or returning
	 * the existing root menu by the given name.
	 *
	 * <code>
	 *		// Retrieve the admin menu
	 *		$menu = Menu::admin_menu();
	 *
	 *		// Retrieve the "foo-bar" menu
	 *		// Note, the second param is for what
	 *		// to replace the underscores in the method
	 *		// with. Withou it, the slug would be 'foo_bar'
	 *		$foo = Menu::foo_bar_menu('_');
	 */
	public static function __callStatic($method, $parameters)
	{
		// Loading a menu
		if (ends_with($method, '_menu'))
		{
			// Configure menu properties
			$name_parts = explode('_', substr($method, 0, -5));
			$name       = Str::title(implode(' ', $name_parts));
			$slug       = Str::slug($name);

			// Query for the menu
			$menu = static::find(function($query) use ($slug)
			{
				return $query->where(Menu::nesty_col('left'), '=', 1)
				             ->where('slug', '=', $slug);
			});

			// If we have no menu, create it
			if ($menu === null)
			{
				// Create a new menu
				$menu = new static(array(
					'name'          => $name,
					'slug'          => $slug,
					'user_editable' => 0,
					'status'        => 1,
				));

				if ($callback = array_shift($parameters) and $callback instanceof Closure)
				{
					$menu = $callback($menu);
				}

				$menu->root();
			}

			return $menu;
		}

		throw new Exception('Call to undefined method '.__CLASS__.$method.'() in '.__FILE__);
	}

	/**
	 * Creates or updates a Nesty tree structure based on
	 * the hierarchical array of items passed through. 
	 *
	 * A callback may be provided for each Nesty object just
	 * before it's persisted to the database. Returning false
	 * from the closure means no changes are made.
	 *
	 * @param  int      $id
	 * @param  array    $items
	 * @param  Closure  $before_root_persist
	 * @param  Closure  $before_persist
	 * @throws NestyException
	 * @return Nesty
	 */
	public static function from_hierarchy_array($id, array $items, Closure $before_root_persist = null, Closure $before_persist = null)
	{
		// Default the closure...
		if ($before_persist === null)
		{
			$before_persist = function($item)
			{
				if ( ! $item->is_new() and ! $item->user_editable)
				{
					$duplicate = clone $item;
					$duplicate->reload();

					// Reset relevent values
					$item->name   = $duplicate->name;
					$item->slug   = $duplicate->slug;
					$item->uri    = $duplicate->uri;
					$item->secure = $duplicate->secure;
				}
				elseif ($item->is_new())
				{
					$item->user_editable = 1;
				}

				return $item;
			};
		}

		return parent::from_hierarchy_array($id, $items, $before_root_persist, $before_persist);
	}

	/**
	 * Sets / gets the active menu in the Menu instance.
	 *
	 * @param   string  $slug
	 * @return  bool
	 */
	public static function active($value = null)
	{
		// Returning the active menu
		if ($value === null)
		{
			// If we have just cached the id or
			// slug, lazy-query the database now
			if (is_array(static::$_active))
			{
				extract(static::$_active);

				// Find the menu item
				$active = static::find(function($query) use($property, $value)
				{
					return $query->where($property, '=', $value);
				});

				if ($active === null)
				{
					return false;
				}

				// Cache
				static::$_active = $active;

				// Get the active path
				static::$_active_path = $active->path(static::key(), 'array');
			}

			// Return the active object
			return static::$_active;
		}

		// Just cache the property
		// and value for now, save doing
		// 2 queries (in case we don't
		// actually use the active menu)
		static::$_active = array(
			'property' => (is_numeric($value)) ? static::key() : 'slug',
			'value'    => $value,
		);

		return true;
	}

	/**
	 * Gets the active menu path.
	 *
	 * @return  array
	 */
	public static function active_path()
	{
		return static::$_active_path;
	}

}
