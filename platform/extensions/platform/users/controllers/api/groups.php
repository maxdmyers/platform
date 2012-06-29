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

use Platform\Users\Group;

class Users_API_Groups_Controller extends API_Controller
{

	public function get_index()
	{
		$config = Input::get() + array(
			'select'   => array('id', 'name'),
			'where'    => array(),
			'order_by' => array(),
			'take'     => null,
			'skip'     => 0,
		);

		$groups = Group::find_custom($config['select'], $config['where'], $config['order_by'], $config['take'], $config['skip']);

		if ($groups)
		{
			return array(
				'status' => true,
				'groups'  => $groups
			);
		}

		return array(
			'status'  => false,
			'message' => Lang::line('users::groups.errors.no_groups_exist')->get()
		);
	}

	public function post_create()
	{
		// set user data
		$group = new Group(Input::get());

		// save user
		try
		{
			if ($group->save())
			{
				return array(
					'status'  => true,
					'message' => Lang::line('users::groups.create.success')->get()
				);
			}
			else
			{
				return array(
					'status'  => false,
					'message' => ($group->validation()->errors->has()) ? $group->validation()->errors->all() : Lang::line('users::groups.create.error')->get()
				);
			}
		}
		catch (\Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage()
			);
		}
	}

	public function post_update()
	{
		// set user data
		$group_data = Input::get();

		$group = new Group($group_data);

		// save user
		try
		{
			if ($group->save())
			{
				return array(
					'status'  => true,
					'message' => Lang::line('users::groups.update.success')->get()
				);
			}
			else
			{
				return array(
					'status'  => false,
					'message' => ($group->validation()->errors->has()) ? $group->validation()->errors->all() : Lang::line('users::groups.update.error')->get()
				);
			}
		}
		catch (\Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage()
			);
		}
	}

	public function post_delete()
	{
		// check if id is set
		if ( ! Input::get('id'))
		{
			return array(
				'status'  => false,
				'message' => Lang::line('users::groups.general.id_required')->get(),
	 		);
		}

		// set user
		try
		{
			$group = Group::find((int) Input::get('id'));

			// throw http not found if user does not exist
			if ( ! $group)
			{
				// log event only if admin is editing
				// if (Sentry::check() and Sentry::user()->has_access())
				// {
				// 	$lang = array(
				// 		'id'   => $group['id'],
				// 		'user' => $group['metadata']['first_name'].' '.$group['metadata']['last_name']
				// 	);
				// 	Logger::add(Logger::DELETE, 'users', Lang::line('users.log_delete', $lang));
				// }

				return array(
					'status'  => false,
					'message' => Lang::line('users::groups.general.not_found')->get()
				);
			}

			// save user data
			if ($group->delete())
			{
				return array(
					'status'  => true,
					'message' => Lang::line('users::groups.delete.success')->get(),
				);
			}

			return array(
				'status'  => false,
				'message' => 'User was not deleted'
			);
		}
		catch (\Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage()
			);
		}
	}

	public function get_datatable()
	{
		$defaults = array(
			'select'    => array(
				'groups.id'     => Lang::line('users::groups.general.id')->get(),
				'name'          => Lang::line('users::groups.general.name')->get(),
			),
			'alias'     => array(
				'groups.id' => 'id',
			),
			'where'     => array(),
			'order_by'  => array('id' => 'desc'),
		);

		// lets get to total user count
		$count_total = Group::count();

		// get the filtered count
		// we set to distinct because a user can be in multiple groups
		$count_filtered = Group::count('groups.id', false, function($query) use ($defaults)
		{
			// sets the where clause from passed settings
			$query = Table::count($query, $defaults);

			return $query;
		});

		// set paging
		$paging = Table::prep_paging($count_filtered, 20);

		$items = Group::all(function($query) use ($defaults, $paging)
		{
			list($query, $columns) = Table::query($query, $defaults, $paging);

			return $query
				->select($columns);

		});

		$items = ($items) ?: array();

		return array(
			'columns'        => $defaults['select'],
			'rows'           => $items,
			'count'          => $count_total,
			'count_filtered' => $count_filtered,
			'paging'         => $paging,
		);
	}

}
