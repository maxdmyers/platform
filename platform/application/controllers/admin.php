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

	/**
	 * If the extension doesn't match a primary navigation
	 * item, provide the slug of the primary navigation item
	 * for who's children items we use in our secondary menu.
	 *
	 * @var string
	 */
	protected $parent_menu;

	public function __construct()
	{
		$this->filter('before', 'admin_auth');
	}

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
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

		// Find menu slug for secondary navigation
		$parent_menu = ($this->parent_menu) ?: URI::segment(2);

		/**
		 * @todo See if we can not hard-code the view name... Maybe have a
		 *       'primary_template' or something as an option of the theme...
		 */
		View::composer('templates.template', function($view) use ($parent_menu)
		{
			$view->with('parent_menu', '');
		});
	}

	/**
	 * Sets the active menu slug.
	 *
	 * @param   string  $slug
	 * @return  void
	 */
	public function active_menu($slug)
	{
		API::post('menus/active', array(
			'slug' => $slug,
		));
	}

}
