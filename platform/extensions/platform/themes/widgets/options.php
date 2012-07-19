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

namespace Platform\Themes\Widgets;

use API;
use Theme;
use Request;

class Options
{

	public function css()
	{
		// set type
		$theme_type = (strpos(Request::route()->controller, 'admin') === false) ? 'frontend' : 'backend';

		// get active theme
		$active = API::get('settings', array(
			'where' => array(
				array('extension', '=', 'themes'),
				array('type', '=', 'theme'),
				array('name', '=', $theme_type),
			),
		));

		$active = $active['settings'][0];

		// get active custom theme options
		$active_custom = API::get('themes/options', array(
			'type'  => $theme_type,
			'theme' => $active['value']
		));

		$status = (isset($active_custom['options']['status'])) ? $active_custom['options']['status'] : 0;

		return Theme::make('themes::widgets.theme_options_css')
		            ->with('css_file', Theme::active_path().str_finish(Theme::assets_directory(), DS).'css'.DS.'theme_options.css')
		            ->with('status', $status);
	}

}
