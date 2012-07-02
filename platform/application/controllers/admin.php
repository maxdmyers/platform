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

class Admin_Controller extends Authorized_Controller
{

	public function __construct()
	{
		$this->filter('before', 'admin_auth');
		parent::__construct();
	}

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		if ( Config::get('application.ssl') and ! Request::secure())
		{
			//return Redirect::to_secure(URI::current())->send();
		}

		// now check to make sure they have bundle specific permissions
		if ( ! Sentry::user()->has_access())
		{
			Platform::messages()->error('Insufficient Permissions');
			Redirect::to(ADMIN.'/dashboard')->send();
			exit;
		}

		// Set the active theme based on the database contents,
		// falling back to the theme config.
		Theme::active('backend/'.Platform::get('themes.theme.backend'));
		Theme::fallback('backend/default');
	}

}
