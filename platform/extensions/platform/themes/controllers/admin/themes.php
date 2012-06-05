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

class Themes_Admin_Themes_Controller extends Admin_Controller
{

	protected $primary_slug = 'system';

	/**
	 * Default View
	 * Points to frontend theme
	 *
	 * @return  View
	 */
	public function get_index()
	{
		return Redirect::to('admin/themes/frontend');
	}

	/**
	 * Shows Frontend Themes with associated options
	 *
	 * @return  View
	 */
	public function get_frontend()
	{
		$data = $this->theme_data('frontend');

		return Theme::make('themes::index', $data);
	}

	/**
	 * Shows Frontend Themes with associated options
	 *
	 * @return  View
	 */
	public function post_frontend()
	{
		$this->process_post('frontend');
		return Redirect::to(ADMIN.'/themes/frontend');
	}

	/**
	 * Shows Backend Themes with associated options
	 *
	 * @return  View
	 */
	public function get_backend()
	{
		$data = $this->theme_data('backend');

		return Theme::make('themes::index', $data);
	}

	/**
	 * Shows Backend Themes with associated options
	 *
	 * @return  View
	 */
	public function post_backend()
	{
		$this->process_post('backend');
		return Redirect::to(ADMIN.'/themes/backend');
	}

	/**
	 * Processes post data for both theme types
	 *
	 * @param   string  theme type - frotend/backend
	 * @return  array   result array
	 */
	protected function process_post($type)
	{
		// if theme switch was posted
		if (Input::get('form_themes'))
		{
			$result = API::post('settings', array(
				'settings' => array(
					'values' => array(
						'extension' => 'themes',
						'type'      => 'theme',
						'name'      => $type,
						'value'     => Input::get('theme'),
					),

					// validation
					'validation' => array(
						'name'  => 'required',
						'value' => 'required',
					),

					// labels
					'labels' => array(
						'name' => 'Theme'
					),
				),
			));

			if ($result['status'])
			{
				Platform::messages()->success($result['updated']);
			}
			else
			{
				Platform::messages()->error($result['errors']);
			}
		}

		// if options was posted
		if (Input::get('form_options'))
		{
			$result = API::post('themes/update', array(
				'id'      => Input::get('id'),
				'type'    => $type,
				'theme'   => Input::get('theme'),
				'options' => Input::get('options'),
				'status'  => Input::get('status')
			));

			if ($result['status'])
			{
				Platform::messages()->success($result['message']);
			}
			else
			{
				Platform::messages()->error($result['message']);
			}
		}
	}

	/**
	 * Gets all theme data necessary for views
	 *
	 * @param   string  theme type - frotend/backend
	 * @return  array   theme data
	 */
	protected function theme_data($type)
	{
		// retrieve all themes of type requested
		$themes = API::get('themes', array(
			'type' => $type
		));

		$data['themes'] = $themes['themes'][$type];

		// get active themes
		$active = API::get('settings', array(
			'extension' => 'themes',
			'where'     => array(
				array('extension', '=', 'themes'),
				array('type', '=', 'theme'),
				array('name', '=', $type)
			),
		));

		$active = $active['settings'][0];

		// get active theme info and remove from array
		if ( array_key_exists($active['value'], $data['themes']))
		{
			$data['active'] = $data['themes'][$active['value']];
			$data['exists'] = true;
		}
		else
		{
			$data['active']['name'] = $active['value'];
			$data['exists'] = false;
		}

		// get active custom theme options
		$active_custom = API::get('themes/options', array(
			'type'  => $type,
			'theme' => $active['value']
		));

		// merge data
		$data['active'] = $active_custom['options'] + $data['active'];

		return $data;
	}

}
