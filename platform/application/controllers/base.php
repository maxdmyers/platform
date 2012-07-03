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

class Base_Controller extends Controller
{
	public function __construct()
	{
		$this->filter('before', 'csrf')->on('post');
	}

	/**
	 * Flag for whether the controller is RESTful.
	 *
	 * @var bool
	 */
	public $restful = true;

	/**
	 * Catch-all method for requests that can't be matched.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function __call($method, $parameters)
	{
		return Event::first('404');
	}

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		Event::fire('platform.controller.before');
		return parent::before();
	}

	/**
	 * This function is called after the action is executed.
	 *
	 * @param  Response  $response  Response from action
	 * @return void
	 */
	public function after($response)
	{
		Event::fire('platform.controller.after', array($response));
		return parent::after($response);
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
