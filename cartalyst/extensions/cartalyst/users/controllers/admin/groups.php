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

class Users_Admin_Groups_Controller extends Admin_Controller
{

	public $restful = true;

	/**
	 * Admin Users Dashboard / Base View
	 *
	 * @return  View
	 */
	public function get_index()
	{
		// get all the input
		$options = Input::get();

		// grab our table data from the users api
		$datatable = API::get('users/groups/datatable', $options);

		// format data for passing
		$data = array(
			'columns' => $datatable['columns'],
			'rows'    => $datatable['rows'],
		);

		// if this was an ajax request, only return the body of the table
		if (Request::ajax())
		{
			$data = (json_encode(array(
				"content"        => Theme::make('users::groups.partials.table_groups', $data)->render(),
				"count"          => $datatable['count'],
				"count_filtered" => $datatable['count_filtered'],
				"paging"         => $datatable['paging'],
			)));

			return $data;
		}

		return Theme::make('users::groups.index', $data);
	}

	/**
	 * Create Group
	 *
	 * @return  View
	 */
	public function get_create()
	{
		return Theme::make('users::groups.create', $data = array());
	}

	public function post_create()
	{
		// create the user
		$create_group = API::post('users/groups/create', Input::get());

		if ($create_group['status'])
		{
			// user was created - set success and redirect back to admin/users
			Cartalyst::messages()->success($create_group['message']);
			return Redirect::to('admin/users/groups');
		}
		else
		{
			// there was an error creating the user - set errors
			Cartalyst::messages()->error($create_group['message']);
			return Redirect::to('admin/users/groups/create')->with_input();
		}
	}

	/**
	 * Edit Group Form
	 *
	 * @param   int  user id
	 * @return  View
	 */
	public function get_edit($id = null)
	{
		// get user being edited
		$group = API::get('users/groups', array(
			'where' => array('id', '=', $id)
		));

		if ($group['status'])
		{
			$data['group'] = $group['groups'][0];
		}
		else
		{
			// group doesn't exist, redirect
			return Redirect::to('admin/users/groups');
		}

		return Theme::make('users::groups.edit', $data);
	}

	/**
	 * Edit Group Form Processing
	 *
	 * @return  Redirect
	 */
	public function post_edit($id = null)
	{
		// initialize data array
		$data = array(
			'id'   => $id,
			'name' => Input::get('name'),
		);

		// update user
		$edit_group = API::post('users/groups/edit', $data);

		if ($edit_group['status'])
		{
			// user was edited - set success and redirect back to admin/users
			Cartalyst::messages()->success($edit_group['message']);
			return Redirect::to(ADMIN.'/users/groups');
		}
		else
		{
			// there was an error editing the user - set errors
			Cartalyst::messages()->error($edit_group['message']);
			return Redirect::to(ADMIN.'/uers/groups/edit/'.$id)->with_input();
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
		$delete_group = API::post('users/groups/delete', array('id' => $id));

		if ($delete_group['status'])
		{
			// user was edited - set success and redirect back to admin/users
			Cartalyst::messages()->success($delete_group['message']);
			return Redirect::to(ADMIN.'/users/groups');
		}
		else
		{
			// there was an error editing the user - set errors
			Cartalyst::messages()->error($delete_group['message']);
			return Redirect::to(ADMIN.'/users/groups');
		}
	}

}
