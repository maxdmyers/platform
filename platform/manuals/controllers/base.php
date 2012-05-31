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

use Platform\Manuals\Manual;

class Manuals_Base_Controller extends Base_Controller
{

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();

		// Add assets
		$this->assets();

		// View composers to add
		// to template (e.g. Navigation)
		$this->composers();
	}

	/**
	 * Adds assets to the container.
	 *
	 * @return  Manuals_Index_Controller
	 */
	protected function assets()
	{
		// Setup CSS
		Asset::add('bootstrap', 'platform/manuals/css/bootstrap.min.css');
		Asset::add('manuals', 'platform/manuals/css/manuals.css');

		// Setup JS
		Asset::add('jquery', 'platform/manuals/js/jquery.js');
		Asset::add('prettify', 'platform/manuals/js/prettify/prettify.js');
		Asset::add('bootstrap', 'platform/manuals/js/bootstrap.min.js', array('jquery'));
		Asset::add('manuals', 'platform/manuals/js/manuals.js', array('jquery'));

		return $this;
	}

	/**
	 * Adds view composers to the template.
	 *
	 * @return  Manuals_Index_Controller
	 */
	protected function composers()
	{
		// Add navigation
		$manuals       = Manual::all();
		$active_manual = (($segment = URI::segment(2)) !== 'edit') ? $segment : URI::segment(3);

		View::composer('manuals::template', function($view) use ($manuals, $active_manual)
		{
			$view->with('manuals', $manuals)
			     ->with('active_manual', $active_manual);
		});

		return $this;
	}

}
