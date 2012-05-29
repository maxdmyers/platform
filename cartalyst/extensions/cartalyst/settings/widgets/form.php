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

namespace Cartalyst\Settings\Widgets;

use API;
use Theme;

class Form
{

	public function general()
	{
		// get extension settings from db
		$settings = API::get('settings', array(
			'extension' => 'settings'
		));

		if ($settings['status'])
		{
			$data['has_settings'] = true;
			$data['settings'] = $settings['settings'];
		}
		else
		{
			$data['has_settings'] = false;
			$data['message'] = $settings['message'];
		}

		return Theme::make('settings::widgets.form.general', $data);
	}

}
