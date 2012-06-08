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
			return $menu;
		}

		return new Menu();
	}

	/**
	 * Saves a menu
	 */
	public function post_menu($id = false)
	{
		try
		{
			$menu = Menu::from_hierarchy_array($id, Input::get('items'), function($item)
			{
				if ( ! $item->user_editable and ! $item->is_new())
				{
					$duplicate = clone $item;
					$duplicate->reload();

					// Reset relevent values
					$item->{Menu::nesty_col('name')} = $duplicate->{Menu::nesty_col('name')};
					$item->slug = $duplicate->slug;
					$item->uri  = $duplicate->uri;
				}

				return $item;
			});
		}
		catch (\Exception $e)
		{
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
	 * Gets the admin menu.
	 *
	 * @return array
	 */
	public function get_admin_menu()
	{
		return Menu::admin_menu()->children(Input::get('depth', 0));
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

		if ( ! $children = $parent->children(Input::get('depth', 0)))
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

}
