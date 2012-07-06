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

class Settings_Admin_Settings_Controller extends Admin_Controller
{
	protected $validation = array(
		// general settings
		'general' => array(
			'site:name' => 'required',
			'site:email' => 'required|email'
		)
	);

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();
		$this->active_menu('admin-settings');
	}

	/**
	 * Alias for general
	 *
	 * @return View
	 */
	public function get_index()
	{
		// echo '<pre>';
		// // $menu = Menu::admin_menu();


		// // print_r($menu);

		// $users_list = Menu::find(function($query)
		// {
		// 	return $query->where('slug', '=', 'users-list');
		// });

		// echo $users_list->path();

		// echo str_repeat(PHP_EOL, 3);

		// $users_list->parent();

		// print_r($users_list);

		return $this->get_general();
	}

	/**
	 * General Site Settings
	 *
	 * @return View
	 */
	public function get_general()
	{
		return Theme::make('settings::index');
	}

	public function post_general()
	{

		$post = Input::get();

		$settings = array();
		foreach ($post as $field => $value)
		{
			// Find the type and name for the respective field.
			// If a field contains a ':', then a type was given
			if (strpos($field, ':') !== false)
			{
				list($type, $name) = explode(':', $field);
			}
			else
			{
				$type = '';
				$name = $field;
			}

			// set the values
			$values = array(
				'extension' => 'settings',
				'type'      => $type,
				'name'      => $name,
				'value'     => $value,
			);

			// set validation for the field if it exists
			$validation = null;
			if (array_key_exists($field, $this->validation['general']))
			{
				if (is_array($this->validation['general'][$field]))
				{
					$validation = $this->validation['general'][$feild];
				}
				else
				{
					$validation = array('value' => $this->validation['general'][$field]);
				}
			}

			$settings[] = array(
				'values'     => $values,
				'validation' => $validation
			);
		}

		$update = Api::post('settings', array('settings' => $settings));

		if ($update['status'])
		{
			Platform::messages()->success($update['updated']);
			Platform::messages()->error($update['errors']);
		}

		return Redirect::to_secure(ADMIN.'/settings/general');
	}

}
