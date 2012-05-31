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
	public function post_save($id = false)
	{
		$response = array();
		$items    = array();

		/**
		 * @todo Process these items recursively
		 */
		foreach (Input::get('items') as $item)
		{
			$this->process_item_recursively($item, $items);
		}

		try
		{
			Menu::from_hierarchy_array($id, $items);
		}
		catch (\Exception $e)
		{
			echo 'Error thrown: \''.$e->getMessage().'\'';
			Log::error($e->getMessage());
		}
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
		$parent = Menu::find(Input::get('id'));

		// Invalid ID for parent
		// Nesty
		if ($parent === null)
		{
			return array(
				'status' => false,
				'message' => "The parent Nesty model ID [$id] is invalid",
			);
		}

		return $parent->children(Input::get('depth', 0));
	}

	/**
	 * Recursively processes an item and it's children
	 * based on POST data.
	 *
	 * @param   array  $item
	 * @param   array  $items
	 */
	protected function process_item_recursively($item, &$items)
	{
		$new_item = array(
			'name' => Input::get('inputs.'.$item['id'].'.name'),
			'slug' => Input::get('inputs.'.$item['id'].'.slug'),
			'uri'  => Input::get('inputs.'.$item['id'].'.uri'),
		);

		// Determine if we're a new item or not. If we're
		// new, we don't attach an ID. Nesty will handle the
		// rest.
		if ( ! Input::get('inputs.'.$item['id'].'.is_new'))
		{
			$new_item['id'] = $item['id'];
		}

		// If we have children, call the function again
		if (isset($item['children']) and is_array($item['children']) and count($item['children']) > 0)
		{
			$children = array();

			foreach ($item['children'] as $child)
			{
				$this->process_item_recursively($child, $children);
			}

			$new_item['children'] = $children;
		}

		$items[] = $new_item;
	}

}
