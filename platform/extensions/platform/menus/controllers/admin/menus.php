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

	protected $primary_slug = 'system';

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
		            ->with('menu_id', $id ? $id : 'false');
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
