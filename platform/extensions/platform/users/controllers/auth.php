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

class Users_Auth_Controller extends Public_Controller
{

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();
		$this->active_menu('primary-home');
	}

	public function get_register()
	{
		return Theme::make('users::auth/register');
	}

	public function post_register()
	{
		$register = API::post('users/register', array(
			'email'                 => Input::get('email'),
			'email_confirmation'    => Input::get('email_confirm'),
			'password'              => Input ::get('password'),
			'password_confirmation' => Input::get('password_confirm'),
			'metadata' => array(
				'first_name' => Input::get('first_name'),
				'last_name'  => Input::get('last_name'),
			),
		));

		if ($register['status'])
		{
			return Redirect::to('login');
		}

		Platform::messages()->error($register['message']);

		return Redirect::to('register')->with_input();
	}

	public function get_activate($email, $code)
	{
		$activate = API::post('users/activate', array(
			'email' => $email,
			'code'  => $code,
		));

		if ($activate['status'])
		{
			Platform::messages()->success($activate['message']);
		}
		else
		{
			Platform::messages()->error($activate['message']);
		}

		return Redirect::to('login');
	}

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
		));

		if ($login['status'])
		{
			$data = array(
				'status'   => true,
				'redirect' => (\Session::get('last_url')) ?: URL::to('')
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
		if (Request::ajax())
		{
			// send json response
			return json_encode($data);
		}

		if ($data['status'])
		{
			return Redirect::to($data['redirect']);
		}
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
	 		$data = array(
				'status'   => true,
				'redirect' => (\Session::get('last_url')) ?: URL::to('')
			);
	 	}
	 	if ($data['status'])
		{
			return Redirect::to($data['redirect']);
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
		$reset = API::post('users/reset_password', array(
			'email'    => Input::get('email'),
			'password' => Input::get('password')
		));

		if ($reset['status'])
		{
			$data = array(
				'status'   => true,
				'redirect' => URL::to_secure('login')
			);
		}
		else
		{
			$data = array(
				'status' => false,
				'message' => $reset['message']
			);
		}

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
			return Redirect::to_secure('login');
		}

		// TODO: - Set error message
		return Redirect::to_secure('reset_password');
	}

}


