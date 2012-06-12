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

class Menus_Admin_Menus_Controller extends Admin_Controller
{

	// Set parent menu for secondary navigation
	protected $parent_menu = 'system';

	public function get_index()
	{
		return Theme::make('menus::index')
		            ->with('menus', API::get('menus'));
	}

	public function get_create()
	{
		return $this->get_edit();
	}

	public function get_edit($id = false)
	{
		// Get menu from API
		$menu = API::get('menus/menu', array(
			'id' => $id,
		));

		// Loop through and build menu recursively
		$menus_view = '';
		foreach ($menu['children'] as $child)
		{
			$menus_view .= $this->make_menus_view_recursively($child);
		}

		// Set new menu template
		$item_template = json_encode((string) Theme::make('menus::edit/item_template'));

		return Theme::make('menus::edit')
		            ->with('menu', $menu)
		            ->with('menus_view', $menus_view)
		            ->with('item_template', $item_template)
		            ->with('menu_id', $id ? $id : 'false')
		            ->with('last_item_id', API::get('menus/last_item_id'));
	}

	public function post_edit($id = false)
	{
		$items    = array();

		foreach (Input::get('items') as $item)
		{
			$this->process_item_recursively($item, $items);
		}

		API::post('menus/menu', array(
			'id'    => $id,
			'name'  => Input::get('name'),
			'slug'  => Input::get('slug'),
			'items' => $items,
		));
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


	protected function make_menus_view_recursively($menu)
	{
		$view = Theme::make('menus::edit/menu')
		             ->with('menu', $menu);

		$children = array();

		// If the menu has children
		if (isset($menu['children']) and is_array($menu['children']) and is_array($menu['children']))
		{
			foreach ($menu['children'] as $child)
			{
				$children[] = $this->make_menus_view_recursively($child);
			}
		}

		return $view->with('children', $children);
	}

}
