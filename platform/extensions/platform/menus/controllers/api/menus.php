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

use Platform\Menus\Menu;

class Menus_API_Menus_Controller extends API_Controller
{

	/**
	 * Get a list of menus
	 *
	 * @return array
	 */
	public function get_index()
	{
		return Menu::menus();
		return ($id = Input::get('id')) ? Menu::find($id) : Menu::menus();
	}

	/**
	 * Gets a menu by the provided id
	 */
	public function get_menu()
	{
		$menu = Menu::find(Input::get('id'));

		if ($menu)
		{
			$menu->children();
		}
		else
		{
			$menu = new Menu();
		}

		return array(
			'status' => true,
			'menu'   => $menu,
		);
	}

	/**
	 * Gets the last item ID from the table (used by JS)
	 */
	public function get_last_item_id()
	{
		return array(
			'status'       => true,
			'last_item_id' => (($last_item = Menu::find('last')) === null) ? 0 : $last_item->id,
		);
	}

	/**
	 * Saves a menu
	 */
	public function post_menu()
	{
		try
		{
			$id   = Input::get('id');
			$name = Input::get('name');
			$slug = Input::get('slug');

			$menu = Menu::from_hierarchy_array($id, Input::get('items'), function($root_item) use ($id, $name, $slug)
			{
				if ($name and ( ! $id or $root_item->user_editable))
				{
					$root_item->name = $name;
				}

				if ($slug and ( ! $id or $root_item->user_editable))
				{
					$root_item->slug = $slug;
				}

				if ( ! $id)
				{
					$root_item->user_editable = 1;
				}

				return $root_item;
			});

			$menu->children();
		}
		catch (\Exception $e)
		{
			echo $e->getMessage();
			exit;
			return array(
				'status'  => true,
				'message' => $e->getMessage(),
			);
		}

		return array(
			'status' => true,
			'menu'   => $menu,
		);
	}

	/**
	 * Returns the children of a menu with the
	 * given item ID.
	 *
	 *	<code>
	 *		API::get('menus/children', array(
	 *			'id'    => 5,
	 *			'depth' => 2,
	 *		));
	 *	</code>
	 *
	 * @return  array
	 */
	public function get_children()
	{
		if ($id = Input::get('id'))
		{
			$parent = Menu::find(Input::get('id'));
		}
		elseif ($slug = Input::get('slug'))
		{
			$parent = Menu::find(function($query) use ($slug)
			{
				return $query->where('slug', '=', $slug);
			});
		}
		else
		{
			return array(
				'status'  => false,
				'message' => 'Either a parent ID or slug is required to retrieve it\'s children.',
			);
		}

		// Invalid ID bafor parent
		// Nesty
		if ($parent === null)
		{
			return array(
				'status'  => false,
				'message' => "The parent Nesty model ID [$id] is invalid",
			);
		}

		if ( ! $children = $parent->enabled_children(Input::get('depth', 0)))
		{
			return array(
				'status'  => false,
				'message' => 'There are no children for the given menu.',
			);
		}

		return array(
			'status'   => true,
			'children' => $children,
		);
	}

	/**
	 * Sets the active menu in the Menu instance.
	 *
	 * @return  array
	 */
	public function post_active()
	{
		$active = Input::get('slug', Input::get('id'));

		if (Menu::active($active) === false)
		{
			return array(
				'status'  => false,
				'message' => "The active menu [$active] doesn't exist.",
			);
		}

		return array('status' => true);
	}

	/**
	 * Gets the active menu in the Menu instance.
	 *
	 * @return  array
	 */
	public function get_active()
	{
		if ( ! $active = Menu::active())
		{
			return array(
				'status'  => false,
				'message' => 'There is no active menu defined.',
			);
		}

		return array(
			'status'      => true,
			'active'      => $active,
			'active_path' => Menu::active_path(), // Always returns something if Menu::active() does
		);
	}

	/**
	 * Enables menus with given filters.
	 *
	 * @return  array
	 */
	public function post_enable()
	{
		// Enabling an ID
		if ($id = Input::get('id'))
		{
			$menu = Menu::find($id);

			if ($menu !== null)
			{
				$menu->status = 1;
				$menu->save();

				return array('status' => true);
			}
		}

		// Enabling by slug
		elseif ($slug = Input::get('slug'))
		{
			$menu = Menu::find(function($query) use ($slug)
			{
				return $query->where('slug', '=', $slug);
			});

			if ($menu !== null)
			{
				$menu->status = 1;
				$menu->save();

				return array('status' => true);
			}
		}

		// Enabling by extension
		if ($extension = Input::get('extension'))
		{
			$menus = Menu::all(function($query) use ($extension)
			{
				return $query->where('extension', '=', $extension);
			});

			if ( ! empty($menus))
			{
				foreach ($menus as $menu)
				{
					$menu->status = 1;
					$menu->save();
				}

				return array('status'  => true);
			}
		}

		// Failure
		return array(
			'status'  => false,
			'message' => 'Could\'t find menu to enable.',
		);
	}

	/**
	 * Disables menus with given filters.
	 *
	 * @return  array
	 */
	public function post_disable()
	{
		// Disabling an ID
		if ($id = Input::get('id'))
		{
			$menu = Menu::find($id);

			if ($menu !== null)
			{
				$menu->status = 0;
				$menu->save();

				return array('status' => true);
			}
		}

		// Disabling by slug
		elseif ($slug = Input::get('slug'))
		{
			$menu = Menu::find(function($query) use ($slug)
			{
				return $query->where('slug', '=', $slug);
			});

			if ($menu !== null)
			{
				$menu->status = 0;
				$menu->save();

				return array('status' => true);
			}
		}

		// Disabling by extension
		if ($extension = Input::get('extension'))
		{
			$menus = Menu::all(function($query) use ($extension)
			{
				return $query->where('extension', '=', $extension);
			});

			if ( ! empty($menus))
			{
				foreach ($menus as $menu)
				{
					$menu->status = 0;
					$menu->save();
				}

				return array('status'  => true);
			}
		}

		// Failure
		return array(
			'status'  => false,
			'message' => 'Could\'t find menu to disable.',
		);
	}

	/**
	 * Deletes a menu. Must be a root item.
	 *
	 * @return  array
	 */
	public function post_delete()
	{
		if ( ! $id = Input::get('id'))
		{
			return array(
				'status'  => false,
				'message' => 'A Menu ID must be provided.',
			);
		}

		$menu = Menu::find($id);

		if ($menu === null)
		{
			return array(
				'status'  => false,
				'message' => 'Couldn\'t find menu to delete.',
			);
		}

		if ( ! $menu->is_root())
		{
			return array(
				'status'  => false,
				'message' => 'Provided menu to delete wasn\'t a root node.',
			);
		}

		if ( ! $menu->user_editable)
		{
			return array(
				'status'  => false,
				'message' => 'Menu is not user editable. Cannot be deleted.',
			);
		}

		try
		{
			$result = $menu->delete_with_children();

			return array(
				'status'  => true,
				'result'  => $result,
			);
		}
		catch (Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage(),
			);
		}
	}

	/**
	 * Returns an array of menu slugs.
	 *
	 * @return  array
	 */
	public function get_slugs()
	{
		// Get an array of slugs
		$slugs = array();

		// The ID of the menu to not include
		// when fetching slugs. This is used
		// in the menu scaffolding
		$not_id = Input::get('not_id', false);

		// Get items
		$items = Menu::all(function($query) use ($not_id)
		{
			if ($not_id !== false)
			{
				$query->where(Menu::nesty_col('tree'), '!=', $not_id);
			}

			return $query;
		}, array('slug'));

		foreach ($items as $item)
		{
			$slugs[] = $item->slug;
		}

		// We can't really go wrong, can we?
		return array(
			'status' => true,
			'slugs'  => $slugs,
		);
	}

}
