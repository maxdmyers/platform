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
			$name_parts = explode('_', substr($method, 0, 5));
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
				));

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
					$item->name = $duplicate->name;
					$item->slug = $duplicate->slug;
					$item->uri  = $duplicate->uri;
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
