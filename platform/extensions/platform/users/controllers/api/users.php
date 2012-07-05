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

use Platform\Users\User;

class Users_API_Users_Controller extends API_Controller
{

	public function get_index()
	{
		$config = Input::get() + array(
			'select'   => array('users.id', 'users.email', 'users_metadata.*', 'users.status',
				\DB::raw('GROUP_CONCAT(groups.name ORDER BY groups.name ASC SEPARATOR \',\') AS groups')
			),
			'where'    => array(),
			'order_by' => array(),
			'take'     => null,
			'skip'     => 0,
		);

		$users = User::find_custom($config['select'], $config['where'], $config['order_by'], $config['take'], $config['skip']);

		foreach ($users as &$user)
		{
			$user->groups = explode(',', $user->groups);
		}

		if ($users)
		{
			return array(
				'status' => true,
				'users'  => $users
			);
		}

		return array(
			'status'  => false,
			'message' => 'No users exist within the give parameters.'
		);
	}

	public function post_create()
	{
		// set user data
		$user_data = Input::get();

		$user = new User($user_data);

		// save user
		try
		{
			if ($user->save())
			{
				// respond
				return array(
					'status'  => true,
					'message' => Lang::line('users::users.create.success')->get()
				);
			}
			else
			{
				return array(
					'status'  => false,
					'message' => ($user->validation()->errors->has()) ? $user->validation()->errors->all() : Lang::line('user::users.create.error')->get()
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
		$user_data = Input::get();

		$user = new User($user_data);

		// save user
		try
		{
			if ($user->save())
			{
				return array(
					'status'  => true,
					'message' => Lang::line('users::users.update.success')->get()
				);
			}
			else
			{
				return array(
					'status'  => false,
					'message' => ($user->validation()->errors->has()) ? $user->validation()->errors->all() : Lang::line('users::users.update.error')->get()
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
				'message' => Lang::line('users::users.id_required')->get(),
	 		);
		}

		// set user
		try
		{
			$user = User::find((int) Input::get('id'));

			// throw http not found if user does not exist
			if ( ! $user)
			{
				return array(
					'status'  => false,
					'message' => Lang::line('users::users.general.not_found')->get()
				);
			}

			// save user data
			if ($user->delete())
			{
				return array(
					'status'  => true,
					'message' => Lang::line('users::users.delete.success')->get(),
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
			'select'   => array(
				'users.id'       => Lang::line('users::users.general.id')->get(),
				'first_name'     => Lang::line('users::users.general.first_name')->get(),
				'last_name'      => Lang::line('users::users.general.last_name')->get(),
				'email'          => Lang::line('users::users.general.email')->get(),
				'groups.name'    => Lang::line('users::users.general.groups')->get(),
				'settings.name'  => Lang::line('users::users.general.status')->get(),
				'created_at'     => 'Created At',
			),
			'alias'    => array(
				'users.id'      => 'id',
				'groups.name'   => 'groups',
				'settings.name' => 'status'
			),
			'where'    => array(),
			'order_by' => array('users.id' => 'desc'),
		);

		// lets get to total user count
		$count_total = User::count();

		// get the filtered count
		// we set to distinct because a user can be in multiple groups
		$count_filtered = User::count_distinct('users.id', function($query) use ($defaults)
		{
			// sets the where clause from passed settings
			$query = Table::count($query, $defaults);

			return $query
				->left_join('users_metadata', 'users.id', '=', 'users_metadata.user_id')
				->left_join('users_groups', 'users.id', '=', 'users_groups.user_id')
				->left_join('groups', 'users_groups.group_id', '=', 'groups.id')
				->join('settings', 'settings.value', '=', 'users.status')
				->where('settings.extension', '=', 'users')
				->where('settings.type', '=', 'status');
		});

		// set paging
		$paging = Table::prep_paging($count_filtered, 20);

		$items = User::all(function($query) use ($defaults, $paging)
		{
			list($query, $columns) = Table::query($query, $defaults, $paging);

			$columns[] = \DB::raw('GROUP_CONCAT(groups.name ORDER BY groups.name ASC SEPARATOR \',\') AS groups');

			return $query
				->select($columns)
				->join('settings', 'settings.value', '=', 'users.status')
				->where('settings.extension', '=', 'users')
				->where('settings.type', '=', 'status');

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

	/**
	 * Auth API Methods
	 */


	public static function post_login()
	{
		// log the user out
		Sentry::logout();

		try
		{
			// check for admin only login
			if (Input::get('is_admin') === true)
			{
				// check if user is an admin
				if ( ! Sentry::user(Input::get('email'))->has_access())
				{
					// user was not an admin - return false
					return array(
						'status'  => false,
						'message' => Lang::line('users::users.general.not_admin')->get()
					);
				}

			}

			// log the user in
			if (Sentry::login(Input::get('email'), Input::get('password'), Input::get('remember')))
			{
				return array(
					'status'  => true
				);
			}

			// could not log the user in
			return array(
				'status'  => false,
				'message' => Lang::line('users::users.general.invalid_login')->get()
			);
		}
		catch (Sentry\SentryException $e)
		{
			// issue logging in via Sentry - lets catch the sentry error thrown
			return array(
				'status'  => false,
				'message' => $e->getMessage()
			);
		}
	}

	public function get_logout()
	{
		Sentry::logout();

		return array(
			'status' => true
		);
	}

	public function post_reset_password()
	{
		try
		{
			$reset = Sentry::reset_password(Input::get('email'), Input::get('password'));
		}
		catch(\Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage(),
			);
		}

		if ($reset)
		{
			// start up swiftmailer
			Bundle::start('swiftmailer');

			// Get the Swift Mailer instance
			$mailer = IoC::resolve('mailer');

			$link = URL::to(ADMIN.'/reset_password_confirm/'.$reset['link']);

			// set body
			$body = file_get_contents(path('public').'platform'.DS.'emails'.DS.'reset_password.html');
			$body = preg_replace('/{{SITE_TITLE}}/', Platform::get('settings.general.title'), $body);
			$body = preg_replace('/{{RESET_LINK}}/', $link, $body);

			// Construct the message
			$message = Swift_Message::newInstance()
				->setSubject(Platform::get('settings.site.title').' - Password Reset')
			    ->setFrom(Platform::get('settings.site.email'), Platform::get('settings.site.title'))
			    ->setTo(Input::get('email'))
			    ->setBody($body,'text/html');

			// Send the email
			$mailer->send($message);

			return array(
				'status'  => true,
				'message' => Lang::line('users::users.reset.password_success')->get()
			);
		}

		return array(
			'status'  => false,
			'message' => Lang::line('users::users.reset.password_error')->get()
		);

	}

	public function post_reset_password_confirm()
	{
		$reset = Sentry::reset_password_confirm(Input::get('email'), Input::get('password'));

		if ($reset)
		{
			return array(
				'status'  => true,
				'message' => Lang::line('users::users.reset.password_confirm_success')->get()
			);
		}

		return array(
			'status'  => false,
			'message' => Lang::line('users::users.reset.password_confirm_error')->get()
		);
	}

}
