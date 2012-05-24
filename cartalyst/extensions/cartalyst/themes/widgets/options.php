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

namespace Cartalyst\Themes\Widgets;

use API;
use Theme;
use Request;

class Options
{

	public function css()
	{
		// // get active theme
		$active = API::get('settings', array(
			'extension' => 'themes',
		));

		$active = $active['settings'];
		echo Request::route()->controller;
		// $type = (strpos(Request::route()->controller, 'Controller_Admin') === false) ? 'frontend' : 'backend';

		// // get active custom theme options
		// $active_custom = API::get('themes/options', array(
		// 	'type'  => $type,
		// 	'theme' => $active[$type.'_theme']['value']
		// ));

		// $data['status'] = (isset($active_custom['options']['status'])) ? $active_custom['options']['status'] : 0;

		// return Theme::make('themes::widgets.theme_options_css', $data);
	}

}
