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
		$groups = Input::get('groups');

		unset($user_data['groups']);
		$user = new User($user_data);

		// save user
		try
		{
			if ($user->save())
			{
				// respond
				return array(
					'status'  => true,
					'message' => Lang::line('users::users.create_success')->get()
				);
			}
			else
			{
				return array(
					'status'  => false,
					'message' => ($user->validation()->errors->has()) ? $user->validation()->errors : Lang::line('user::users.create_error')->get()
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

	public function post_edit()
	{
		// set user data
		$user_data = Input::get();
		$groups = Input::get('groups');

		unset($user_data['groups']);
		$user = new User($user_data);

		// save user
		try
		{
			if ($user->save())
			{
				// save log
				// $lang = array(
				// 	'id'   => $user['id'],
				// 	'user' => $user['metadata']['first_name'].' '.$user['metadata']['last_name']
				// );

				// Logger::add(Logger::INSERT, 'users', Lang::line('users.log_create', $lang));

				// respond
				return array(
					'status'  => true,
					'message' => Lang::line('users::users.update_success')->get()
				);
			}
			else
			{
				return array(
					'status'  => false,
					'message' => ($user->validation()->errors->has()) ? $user->validation()->errors : Lang::line('users::users.update_error')->get()
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
			print_r($user);
			exit;
			// throw http not found if user does not exist
			if ( ! $user)
			{
				// log event only if admin is editing
				// if (Sentry::check() and Sentry::user()->has_access())
				// {
				// 	$lang = array(
				// 		'id'   => $user['id'],
				// 		'user' => $user['metadata']['first_name'].' '.$user['metadata']['last_name']
				// 	);
				// 	Logger::add(Logger::DELETE, 'users', Lang::line('users.log_delete', $lang));
				// }

				return array(
					'status'  => false,
					'message' => Lang::line('users::users.not_found')->get()
				);
			}

			// save user data
			if ($user->delete())
			{
				return array(
					'status'  => true,
					'message' => Lang::line('users::users.delete_success')->get(),
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
				'users.id'            => Lang::line('users::users.id')->get(),
				'first_name'          => Lang::line('users::users.first_name')->get(),
				'last_name'           => Lang::line('users::users.last_name')->get(),
				'email'               => Lang::line('users::users.email')->get(),
				'groups.name'         => Lang::line('users::users.groups')->get(),
				'configuration.name'  => Lang::line('users::users.status')->get(),
				'created_at'          => 'Created At',
			),
			'alias'     => array(
				'users.id'            => 'id',
				'groups.name'         => 'groups',
				'configuration.name'  => 'status'
			),
			'where'     => array(),
			'order_by'  => array('users.id' => 'desc'),
		);

		// lets get to total user count
		$count_total = User::count();

		// get the filtered count
		// we set to distinct because a user can be in multiple groups
		$count_filtered = User::count_distinct('users.id', function($query) use ($defaults)
		{
			// sets the where clause from passed settings
			$query = Table::count($query, $defaults);

			// test comment
			return $query
				->left_join('users_metadata', 'users.id', '=', 'users_metadata.user_id')
				->left_join('users_groups', 'users.id', '=', 'users_groups.user_id')
				->left_join('groups', 'users_groups.group_id', '=', 'groups.id')
				->join('configuration', 'configuration.value', '=', 'users.status')
				->where('configuration.extension', '=', 'users')
				->where('configuration.type', '=', 'status');
		});

		// set paging
		$paging = Table::prep_paging($count_filtered, 20);

		$items = User::all(function($query) use ($defaults, $paging)
		{
			list($query, $columns) = Table::query($query, $defaults, $paging);

			$columns[] = \DB::raw('GROUP_CONCAT(groups.name ORDER BY groups.name ASC SEPARATOR \',\') AS groups');

			return $query
				->select($columns)
				->join('configuration', 'configuration.value', '=', 'users.status')
				->where('configuration.extension', '=', 'users')
				->where('configuration.type', '=', 'status');

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
				if ( ! Sentry::user(Input::get('email'))) //->has_access()
				{
					// user was not an admin - return false
					return array(
						'status'  => false,
						'message' => Lang::line('users::users.not_admin')->get()
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
				'message' => Lang::line('users::users.invalid_login')->get()
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
		$reset = Sentry::reset_password(Input::get('email'), Input::get('password'));

		if ($reset)
		{
			// TODO: email
			// set email properties
			// $mail = Email::forge();
			// $mail->to(Input::post('email'));
			// $mail->from('admin@site.com', 'Site'); // TODO - Grab email from site config
			// $mail->subject('Sitrep - Password Reset'); // TODO - Grab subject from site config
			// $mail->body(
			// 	'Please go to the link provided below to reset your password to: '.$post['password']."\n\n" .
			// 	"\t".Config::get('base_url').'users/reset_password_confirm/'.$response['link']
			// );

			// // send email
			// try
			// {
			//     $mail->send();
			// }
			// catch(\EmailValidationFailedException $e)
			// {
			// 	return $this->response(array(
			// 		'status'  => false,
			// 		'message' => $e->getMessage()
			// 	));
			// }
			// catch(\EmailSendingFailedException $e)
			// {
			//     return $this->response(array(
			// 		'status'  => false,
			// 		'message' => $e->getMessage()
			// 	));
			// }

			return array(
				'status'  => true,
				'message' => Lang::line('users::users.reset_password_success')->get()
			);
		}

		return array(
			'status'  => false,
			'message' => Lang::line('users::users.reset_password_error')->get()
		);

	}

	public function post_reset_password_confirm()
	{
		$reset = Sentry::reset_password_confirm(Input::get('email'), Input::get('password'));

		if ($reset)
		{
			return array(
				'status'  => true,
				'message' => Lang::line('users::users.reset_password_confirm_success')->get()
			);
		}

		return array(
			'status'  => false,
			'message' => Lang::line('users::users.reset_password_confirm_error')->get()
		);
	}

}
