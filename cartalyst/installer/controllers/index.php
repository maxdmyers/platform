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

use Installer\Installer;

class Installer_Index_Controller extends Base_Controller
{

	public function before()
	{
		parent::before();

		// Setup CSS
		Asset::add('bootstrap', 'cartalyst/installer/css/bootstrap.min.css');
		Asset::add('installer', 'cartalyst/installer/css/installer.css');

		// Setup JS
		Asset::add('jquery', 'cartalyst/installer/js/jquery.js');
		Asset::add('bootstrap', 'cartalyst/installer/js/bootstrap.js', array('jquery'));
		Asset::add('installer', 'cartalyst/installer/js/installer.js', array('jquery'));
	}

	/**
	 * Show the initial installer step, license agreement
	 */
	public function get_index()
	{
		// Normally, we show an "Agree to our terms"

		// Redirect to appropriate step
		return Redirect::to('installer/index/step_'.$this->determine_step());
	}

	/**
	 * Step 1 - Database credentials
	 */
	public function get_step_1()
	{
		return View::make('installer::step_1')->with('drivers', Installer::database_drivers());
	}

	/**
	 * Step 1 - Creates a config file
	 */
	public function post_step_1()
	{
		// Create database config
		Installer::create_database_config(Input::get());

		// Redirect
		return Redirect::to('installer');
	}

	/**
	 * Confirm database - Step 1
	 */
	public function post_confirm_db()
	{
		if ( ! Request::ajax())
		{
			return Event::fire('404');
		}

		try
		{
			Installer::check_database(array(
				'driver'   => Input::get('driver'),
				'host'     => Input::get('host'),
				'database' => Input::get('database'),
				'username' => Input::get('username'),
				'password' => Input::get('password'),
			));
		}
		catch (Exception $e)
		{
			// Error 1146 is actually good, because it
			// means we connected fine, just couldn't
			// get the contents of the random table above.
			// For some reason this exception has a code of "0"
			// whereas all of the other exceptions match the
			// database errors. Life goes on.
			if ($e->getCode() !== 0)
			{
				return new Response(json_encode(array(
					'error'   => true,
					'message' => $e->getMessage(),
				)));
			}
		}

		return json_encode(array(
			'error'   => false,
			'message' => 'Successfully connected to the database using the provided credentials',
		));
	}

	/**
	 * Step 2 - Lists extensions to install
	 */
	public function get_step_2()
	{
		if ($this->determine_step() < 2)
		{
			return Redirect::to('installer/index');
		}

		return View::make('installer::step_2');
	}

	/**
	 * Step 2 - Installs core extensions
	 */
	public function post_step_2()
	{
		if ($this->determine_step() < 2)
		{
			return Redirect::to('installer/index');
		}

		/**
		 * Normally, we'd get an array of extensions
		 * to install, but for now we're just installing
		 * all of them.
		 */

		// Prepare the database for extensions
		Installer::prepare_db_for_extensions();

		// Install all extensions
		Installer::install_extensions();

		return Redirect::to('installer/index');
	}

	/**
	 * Step 3 - Provide credentials
	 */
	public function get_step_3()
	{
		if ($this->determine_step() < 3)
		{
			return Redirect::to('installer/index');
		}

		return View::make('installer::step_3');
	}

	public function post_step_3()
	{
		$user = array(
			'email'                 => Input::get('email'),
			'password'              => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation'),
			'groups'                => array('admin', 'users'),
			'metadata'              => array(
				'first_name' => Input::get('first_name'),
				'last_name'  => Input::get('last_name'),
			),
		);

		// Start the users extensions
		Cartalyst::extensions_manager()->start('users');

		// Get the result from creating a user
		$create_user = API::post('users/create', $user);

		if ($create_user['status'])
		{
			// Cartalyst::messages()->success($create_user['message']);
			// Session::put('created_user', true);

			return Redirect::to('installer/index');
		}
		else
		{
			// Cartalyst::messages()->error($create_user['message']);

			return Redirect::to('installer/index')->with_input();
		}
	}

	public function get_step_4()
	{
		return View::make('installer::step_4');
	}

	/**
	 * Determines what step we are allowed to be on
	 * based on what's installed in the system.
	 *
	 * @return  int  $step
	 */
	protected function determine_step()
	{
		/**
		 * @todo replace this with checking the current user
		 *       when my pull request gets accepted.
		 */
		try
		{
			if (DB::table('users')->count() > 0)
			{
				return 4;
			}
		}
		catch (Exception $e)
		{

		}

		// If we have any active extensions, we've passed step
		// 2.
		try
		{
			// We get an exception thrown if the table doesn't exist
			return (count(Cartalyst::extensions_manager()->enabled()) > 0) ? 3 : 2;
		}
		catch (Exception $e)
		{

		}

		// We have a database file, go to step 2
		if (File::exists(path('app').'config'.DS.'database'.EXT))
		{
			return 2;
		}

		return 1;
	}

}
