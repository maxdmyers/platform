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

class Pages_Pages_Controller extends Public_Controller
{
	public function before()
	{
		parent::before();
		$this->active_menu('home');
	}

	public function get_index()
	{
		return Theme::make('pages::index');
	}

	public function get_about()
	{
		$this->active_menu('about');
		return 'about page';
	}

	public function get_contact()
	{
		$this->active_menu('contact');
		return 'contact page';
	}
}
