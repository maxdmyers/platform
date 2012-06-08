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

use Platform\Themes\Theme;

class Themes_API_Themes_Controller extends API_Controller
{

	public function get_index()
	{
		$type = Input::get('type', array('frontend', 'backend'));
		$name = Input::get('name');

		if ( ! is_array($type))
		{
			$type = array($type);
		}

		$themes = array();

		if (in_array('frontend', $type))
		{
			$themes['frontend'] = Theme::fetch('frontend', $name);
		}

		if (in_array('backend', $type))
		{
			$themes['backend'] = Theme::fetch('backend', $name);
		}

		return array(
			'status' => true,
			'themes' => $themes
		);
	}

	public function get_options()
	{
		$type  = Input::get('type');
		$theme = Input::get('theme');

		if ( ! isset($type) or ! isset($theme))
		{
			return array(
				'status'  => false,
				'message' => 'Type and Theme are required.'
			);
		}

		$theme_options = Theme::find(function($query) use ($type, $theme)
		{
			return $query->where('type', '=', $type)
			             ->where('theme', '=', $theme);
		});


		// if ( ! empty($theme_options))
		// {
		// 	$theme_options['options'] = json_decode($theme_options['options']);
		// }
		// else
		// {
		// 	$theme_options['options'] = array();
		// }

		return array(
			'status'  => true,
			'options' => $theme_options
		);
	}

	public function post_update()
	{
		// make sure type and theme were passed
		if ( ! Input::get('type') or ! Input::get('theme'))
		{
			return array(
				'status'  => false,
				'message' => 'Type and Theme are required'
			);
		}

		if ( ! is_array(Input::get('options')) and Input::get('options') != NULL )
		{
			return array(
				'status'  => false,
				'message' => 'Options must be null or an array'
			);
		}

		// reformat options for database input to reflect same json string as theme.info
		$options = (Input::get('options')) ?: array();

		$theme = Theme::fetch(Input::get('type'), Input::get('theme'));

		$options = array_replace_recursive($theme['options'], $options);

		if (Input::get('id'))
		{
			// theme_options exist - update it
			$theme = new Theme(array(
				'id'      => Input::get('id'),
				'type'    => Input::get('type'),
				'theme'   => Input::get('theme'),
				'options' => $options,
				'status'  => Input::get('status')
			));
		}
		else
		{
			// theme_options do not exist - create it
			$theme = new Theme(array(
				'type'    => Input::get('type'),
				'theme'   => Input::get('theme'),
				'options' => $options,
				'status'  => Input::get('status')
			));
		}

		if ($theme->save())
		{
			return array(
				'status'  => true,
				'message' => 'Theme updated',
			);
		}

		return array(
			'status'  => false,
			'message' => 'Theme not updated'
		);
	}

}
