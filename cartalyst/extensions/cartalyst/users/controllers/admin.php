<?php
/**
 * Part of the Cartalyst application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Cartalyst
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

class Users_Admin_Controller extends Admin_Controller
{

	public function __construct()
	{
		// Whitelist login methods
		$this->filter('before', 'admin_auth')->except(array('login', 'logout', 'reset_password', 'reset_password_confirm'));
	}

	/**
	 * Admin Users Dashboard / Base View
	 *
	 * @return  View
	 */
	public function get_index()
	{
		// Grab our datatable
		$datatable = API::get('users/datatable', Input::get());

		$data = array(
			'columns' => $datatable['columns'],
			'rows'    => $datatable['rows'],
		);

		// If this was an ajax request, only return the body of the datatable
		if (Request::ajax())
		{
			return json_encode(array(
				"content"        => Theme::make('users::partials.table_users', $data)->render(),
				"count"          => $datatable['count'],
				"count_filtered" => $datatable['count_filtered'],
				"paging"         => $datatable['paging'],
			));
		}

		return Theme::make('users::index', $data);
	}

	/**
	 * Create User Form
	 *
	 * @return  View
	 */
	public function get_create()
	{
		// get and set groups
		$groups = Sentry::group()->all();
		//$groups = API::get('users/groups');
		$data = array();
		foreach ($groups as $group)
		{
			$data['groups'][$group['name']] = ucfirst($group['name']);
		}

		if (empty($data['groups']))
		{
			$data['groups'] = array();
		}

		return Theme::make('users::create', $data);
	}

	/**
	 * Create User Form Processing
	 *
	 * @return  Redirect
	 */
	public function post_create()
	{
		$user = array(
			'email'                 => Input::get('email'),
			'password'              => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation'),
			'groups'                => Input::get('groups'),
			'metadata'              => array(
				'first_name' => Input::get('first_name'),
				'last_name'  => Input::get('last_name'),
			)
		);

		// create the user
		$create_user = API::post('users/create', $user);

		if ($create_user['status'])
		{
			// user was created - set success and redirect back to admin/users
			Cartalyst::messages()->success($create_user['message']);
			return Redirect::to(ADMIN.'/users');
		}
		else
		{
			// there was an error creating the user - set errors
			Cartalyst::messages()->error($create_user['message']);
			return Redirect::to(ADMIN.'/users/create')->with_input();
		}
	}

	/**
	 * Edit User Form
	 *
	 * @param   int  user id
	 * @return  View
	 */
	public function get_edit($id = null)
	{
		// get user being edited
		$user = API::get('users', array(
			'where' => array('users.id', '=', $id)
		));

		if ($user['status'])
		{
			$data['user'] = $user['users'][0];
		}
		else
		{
			// user doesn't exist, redirect
			return Redirect::to('admin/users');
		}

		// set status options
		$data['status_options'] = array(
			1 => __('users.enabled'),
			0 => __('users.disabled'),
		);

		// get and set group options
		$user_groups = Sentry::group()->all();

		foreach ($user_groups as $user_group)
		{
			$data['user_groups'][$user_group['name']] = ucfirst($user_group['name']);
		}

		// get users current group
		// $current_groups = Sentry::user((int)$id)->groups();
		// foreach ($current_groups as $group)
		// {
		// 	$data['current_groups'][$group['id']] = $group['name'];
		// }

		return Theme::make('users::edit', $data);
	}

	/**
	 * Edit User Form Processing
	 *
	 * @return  Redirect
	 */
	public function post_edit($id = null)
	{
		// initialize data array
		$data = array(
			'id'                    => $id,
			'email'                 => Input::get('email'),
			'password'              => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation'),
			'status'                => Input::get('status'),
			'groups'                => Input::get('groups'),
			'metadata'              => array(
				'first_name' => Input::get('first_name'),
				'last_name'  => Input::get('last_name'),
			)
		);

		// update user
		$edit_user = API::post('users/edit', $data);

		if ($edit_user['status'])
		{
			// user was edited - set success and redirect back to admin/users
			Cartalyst::messages()->success($edit_user['message']);
			return Redirect::to(ADMIN.'/users');
		}
		else
		{
			// there was an error editing the user - set errors
			Cartalyst::messages()->error($edit_user['message']);
			return Redirect::to(ADMIN.'/users/edit/'.$id)->with_input();
		}
	}

	/**
	 * Delete a user - AJAX request
	 *
	 * @param   int     user id
	 * @return  object  json object
	 */
	public function get_delete($id)
	{
		// delete the user
		$delete_user = API::post('users/delete', array('id' => $id));

		if ($delete_user['status'])
		{
			// user was edited - set success and redirect back to admin/users
			Cartalyst::messages()->success($delete_user['message']);
			return Redirect::to(ADMIN.'/users');
		}
		else
		{
			// there was an error editing the user - set errors
			Cartalyst::messages()->error($delete_user['message']);
			return Redirect::to(ADMIN.'/users');
		}
	}

	// /**
	//  * Call Groups Controller
	//  *
	//  * @return  Controller
	//  */
	// public function get_groups($method = 'index', $params = null)
	// {
	// 	$params = explode('/', URI::current());
	// 	$params = array_slice($params, 4);

	// 	return Controller::call('users::groups.admin@'.$method, $params);
	// }

	/**
	 * Auth Methods
	 */

	/**
	 * Login Form
	 *
	 * @return  View
	 */
	public function get_login()
	{
		API::get('users/logout');

		return Theme::make('users::auth/login');
	}

	/**
	 * Login Form Processing
	 */
	public function post_login()
	{
		$login = API::post('users/login', array(
			'email'    => Input::get('email'),
			'password' => Input::get('password'),
			'is_admin' => true
		));

		if ($login['status'])
		{
			$data = array(
				'status'   => true,
				'redirect' => (\Session::get('last_url')) ?: URL::to(ADMIN)
			);
		}
		else
		{
			$data = array(
				'status' => false,
				'message' => $login['message']
			);
		}

		// TODO - Show Login Error

		// send json response
		return json_encode($data);
	}

	/**
	 * Log user out
	 *
	 * @return  Redirect
	 */
	 public function get_logout()
	 {
	 	$logout = API::get('users/logout');
	 	if ($logout['status'])
	 	{
	 		return Redirect::to(ADMIN.'/login');
	 	}
	 }

	/**
	 * Reset Password Form
	 *
	 * @return View
	 */
	public function get_reset_password()
	{
		return Theme::make('users::auth/reset_password');
	}

	/**
	 * Reset Password Processing
	 *
	 * @return object  json
	 */
	public function post_reset_password()
	{
		$data = API::post('users/reset_password', array(
			'email'    => Input::get('email'),
			'password' => Input::get('password')
		));

		return json_encode($data);
	}

	/**
	 * Reset Password Confirmation
	 *
	 * @param   string  users encoded email
	 * @param   string  encoded confirmation hash
	 * @return  View
	 */
	public function get_reset_password_confirm($email = null, $password = null)
	{
		$data = array();

		$reset = API::post('users/reset_password_confirm', array(
			'email'    => $email,
			'password' => $password,
		));

		if ($reset['status'])
		{
			// TODO: - Set Success message
			return Redirect::to(ADMIN.'/login');
		}

		// TODO: - Set error message
		return Redirect::to(ADMIN.'/reset_password');
	}

}
