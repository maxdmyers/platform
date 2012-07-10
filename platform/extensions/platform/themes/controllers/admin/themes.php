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
	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();
		$this->active_menu('admin-themes');
	}

	/**
	 * Default View
	 * Points to frontend theme
	 *
	 * @return  View
	 */
	public function get_index()
	{
		return Redirect::to_secure(ADMIN.'/themes/frontend');
	}

	/**
	 * Shows Frontend Themes
	 *
	 * @return  View
	 */
	public function get_frontend()
	{
		$data = $this->theme_data('frontend');
		$this->active_menu('admin-frontend');

		return Theme::make('themes::index', $data);
	}

	/**
	 * Shows Backend Themes
	 *
	 * @return  View
	 */
	public function get_backend()
	{
		$data = $this->theme_data('backend');
		$this->active_menu('admin-backend');

		return Theme::make('themes::index', $data);
	}

	/**
	 * Edit Themes with associated options
	 *
	 * @return  View
	 */
	public function get_edit($type, $theme)
	{

		// Set menu active states
		if ($type == 'frontend')
		{
			$this->active_menu('frontend');
		}
		else
		{
			$this->active_menu('backend');
		}

		// get theme.info data
		$theme_info = API::get('themes', array(
			'type' => $type,
			'name' => $theme,
		));

		// get custom theme options
		$options = API::get('themes/options', array(
			'type'  => $type,
			'theme' => $theme
		));

		$data['theme'] = $theme_info['themes'][$type];

		$data['theme'] = $options['options'] + $data['theme'];

		return Theme::make('themes::edit', $data);
	}

	/**
	 * Processes post data for theme options
	 *
	 * @param   string  theme type - frotend/backend
	 * @return  array   result array
	 */
	protected function post_edit($type, $theme)
	{

		$result = API::post('themes/update', array(
			'id'      => Input::get('id'),
			'type'    => $type,
			'theme'   => $theme,
			'options' => Input::get('options'),
			'status'  => Input::get('status', 1)
		));

		if ($result['status'])
		{
			Platform::messages()->success($result['message']);

			return Redirect::to_secure(ADMIN.'/themes/edit/'.$type.'/'.$theme);
		}
		else
		{
			echo Platform::messages()->error($result['message']);
		}

	}


	/**
	 * Activates a theme
	 *
	 * @param   string  theme type - frotend/backend
	 * @return  array   result array
	 */
	protected function post_activate($type, $theme)
	{

		$result = API::post('settings', array(
			'settings' => array(
				'values' => array(
					'extension' => 'themes',
					'type'      => 'theme',
					'name'      => Input::get('type'),
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

			$data = $this->theme_data('backend');

			return Redirect::to_secure(ADMIN.'/themes/'.$type);
		}
		else
		{
			echo Platform::messages()->error($result['errors']);
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

		$themes = $themes['themes'][$type];

		// get active theme
		$active = API::get('settings', array(
			'where'     => array(
				array('extension', '=', 'themes'),
				array('type', '=', 'theme'),
				array('name', '=', $type)
			),
		));

		$active = $active['settings'][0];

		// get active theme info and remove from array
		if ( array_key_exists($active['value'], $themes))
		{
			$data['exists'] = true;

			// set active and remove theme from array
			$data['active'] = $themes[$active['value']];
			unset($themes[$active['value']]);

			// set all other themes to inactive
			$data['inactive'] = $themes;
		}
		else
		{
			$data['exists'] = false;

			// theme doesn't exist so we'll just give a name
			$data['active']['name'] = $active['value'];

			// set all themes to inactive
			$data['inactive'] = $themes['themes'];
		}

		return $data;
	}

}
