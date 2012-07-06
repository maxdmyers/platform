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
	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();
		$this->active_menu('admin-menus');
	}

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
		$result = API::get('menus/menu', array(
			'id' => $id,
		));
		$menu   = $result['menu'];

		// Get last item ID
		$result       = API::get('menus/last_item_id');
		$last_item_id = $result['last_item_id'];

		// Get
		$result = API::get('menus/slugs', array(
			'not_id' => isset($menu['id']) ? $menu['id'] : false,
		));
		$persisted_slugs  = $result['slugs'];

		return Theme::make('menus::edit')
		            ->with('menu', $menu)
		            ->with('menu_id', (isset($menu['id'])) ? $menu['id'] : false)
		            ->with('item_template', json_encode(Theme::make('menus::edit/item_template')->render()))
		            ->with('last_item_id', $last_item_id)
		            ->with('root_slug', isset($menu['slug']) ? $menu['slug'] : null)
		            ->with('persisted_slugs', json_encode($persisted_slugs));
	}

	public function post_edit($id = false)
	{
		$items = array();

		$input_hierarchy = Input::get('items_hierarchy');

		// JSON string on non-AJAX form
		if (is_string($input_hierarchy))
		{
			$input_hierarchy = json_decode($input_hierarchy, true);
		}

		foreach ($input_hierarchy as $item)
		{
			$this->process_item_recursively($item, $items);
		}

		$result = API::post('menus/menu', array(
			'id'    => $id,
			'name'  => Input::get('name'),
			'slug'  => Input::get('slug'),
			'items' => $items,
		));

		// Ajax form
		if (Request::ajax())
		{
			// The menu is usually a property of the
			// API response, don't need to transport
			// all of this data...
			array_forget($result, 'menu');

			return new Response(json_encode($result));
		}

		// Traditional form submission
		if ( ! $result['status'])
		{
			Cartalyst::messages()->error($result['message']);
		}

		return Redirect::to_secure(ADMIN.'/menus/edit/'.array_get($result, 'menu.id'));
	}

	public function get_delete($id)
	{
		$result = API::post('menus/delete', array(
			'id' => $id,
		));

		return Redirect::to_secure(ADMIN.'/menus');
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
			'name'    => Input::get('item_fields.'.$item['id'].'.name'),
			'slug'    => Input::get('item_fields.'.$item['id'].'.slug'),
			'uri'     => Input::get('item_fields.'.$item['id'].'.uri'),
			'status'  => Input::get('item_fields.'.$item['id'].'.status', 1),
		);

		// Determine if we're a new item or not. If we're
		// new, we don't attach an ID. Nesty will handle the
		// rest.
		if ( ! Input::get('item_fields.'.$item['id'].'.is_new'))
		{
			$new_item['id'] = $item['id'];
		}

		// Now, look for secure URLs
		if (URL::valid($new_item['uri']))
		{
			$new_item['secure'] = (int) starts_with($new_item['uri'], 'https://');
		}

		// Relative URL, look in the POST data
		else
		{
			$new_item['secure'] = Input::get('item_fields.'.$item['id'].'.secure', 0);
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
