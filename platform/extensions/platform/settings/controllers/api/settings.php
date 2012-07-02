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

use Platform\Settings\Model\Setting;

class Settings_API_Settings_Controller extends API_Controller
{

	public function get_index()
	{
		$where    = Input::get('where');
		$organize = Input::get('organize', false);

		$result = Setting::all(function($query) use ($where) {

			if ( ! is_array($where) or ! is_array($where[0]))
			{
				$where = array($where);
			}

			foreach ($where as $w)
			{
				if (count($w) == 3)
				{
					$query = $query->where($w[0], $w[1], $w[2]);
				}
			}

			return $query;

		});

		// if there was no result
		if ( ! $result)
		{
			return array(
				'status'  => false,
				'message' => 'No settings found.'
			);
		}

		if ($organize)
		{
			$settings = array();
			foreach ($result as $setting)
			{
				$settings[$setting['type']][$setting['name']] = $setting;
			}

			$result = $settings;
		}

		return array(
			'status'    => true,
			'settings'  => $result
		);
	}

	public function post_index()
	{
		// set vars
		$settings   = Input::get('settings');
		$updated    = array();
		$errors     = array();

		if ( ! isset($settings[0]))
		{
			$settings = array($settings);
		}

		// loop through settings and update
		foreach ($settings as $setting)
		{
			// lets make sure value are set
			$setting['values']['extension'] = isset($setting['values']['extension']) ? $setting['values']['extension'] : '';
			$setting['values']['type']      = isset($setting['values']['type'] ) ? $setting['values']['type'] : '';
			$setting['values']['name']      = isset($setting['values']['name']  ) ? $setting['values']['name']  : '';
			$setting['values']['value']     = isset($setting['values']['value'] ) ? $setting['values']['value'] : '';

			// type is optional, so we'll set it to null if its not set
			if ( ! isset($setting['values']['type']))
			{
				$setting['values']['type'] = $setting['values']['extension'];
			}

			$setting_model = Setting::find(function($query) use($setting)
			{
				// if an id was passed, we'll just use that to find the setting
				if (isset($setting['id']))
				{
					return $query
						->where('id', '=', $setting['id']);
				}

				return $query
					->where('extension', '=', $setting['values']['extension'])
					->where('type', '=', $setting['values']['type'])
					->where('name', '=', $setting['values']['name']);
			});

			// if setting model doesn't exist, make one
			if ( ! $setting_model)
			{
				unset($setting['value']['id']);
				$setting_model = new Setting($setting['values']);
			}
			// otherwise update the value
			else
			{
				$setting_model->extension = $setting['values']['extension'];
				$setting_model->type      = $setting['values']['type'];
				$setting_model->name      = $setting['values']['name'];
				$setting_model->value     = $setting['values']['value'];
			}

			// now we'll set the validation rules and labels for the settings
			$rules  = array();
			$labels = array();

			foreach ($setting['values'] as $col => $val)
			{
				if (isset($setting['validation'][$col]))
				{
					$rules[$col] = $setting['validation'][$col];
				}

				if (isset($setting['labels'][$col]))
				{
					$labels[$col] = $setting['labels'][$col];
				}
			}

			// pass validation and labels to the model
			$setting_model->set_validation($rules, $labels);

			try
			{
				// now save the setting
				if ($setting_model->save())
				{
					$updated[] = ucfirst($setting_model->name).' setting has been updated.';
				}
				else
				{
					// get errors
					foreach($setting_model->validation()->errors->all() as $error)
					{
						$errors[] = $error;
					}
				}
			}
			catch (\Exception $e)
			{
				$errors[] = $e->getMessage();
			}
		}
		
		return array(
			'status'  => true,
			'updated' => $updated,
			'errors'  => $errors
		);
	}

}
