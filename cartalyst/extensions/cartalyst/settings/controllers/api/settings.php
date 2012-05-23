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

use Cartalyst\Settings\Model\Setting;

class Settings_API_Settings_Controller extends API_Controller
{

	public function get_index()
	{
		$ext   = Input::get('extension');
		$where = Input::get('where');
		$settings = array();


		$result = Setting::all(function($query) use ($ext, $where) {

			$query = $query
				->select(Setting::table().'.*')
				->join('extensions', 'extensions.id', '=', Setting::table().'.extension_id');

			if ($ext !== null)
			{
				$query = $query->where('extensions.slug', '=', $ext);
			}

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

		return array(
			'status'    => true,
			'settings'  => $result
		);
	}

	public function post_index()
	{
		// set vars
		$extension  = Input::get('extension');
		$settings   = Input::get('settings');
		$validation = Input::get('validation');
		$labels     = Input::get('labels');
		$updated    = null;
		$errors     = null;

		// loop through settings and update
		foreach ($settings as $name => $value)
		{
			// // set validation
			$rules  = isset($validation[$name]) ? array('value' => $validation[$name]) : array();
			$labels = isset($labels[$name]) ? array('value' => $labels[$name]) : array('value' => $name);

			// find setting
			//$setting = Setting::all($extension, array('configuration.name', '=', $name));

			$setting = Setting::all(function($query) use($extension, $name) {

				$query = $query
					->select(Setting::table().'.*')
					->join('extensions', 'extensions.id', '=', Setting::table().'.extension_id')
					->where('extensions.slug', '=', $extension)
					->where(Setting::table().'.name', '=', $name);

				return $query;

			});

			// if settings already exists - update
			if ( ! empty($setting))
			{
				$setting = $setting[0];

				// if values are the same - skip
				if ($setting['value'] == $value)
				{
					continue;
				}

				// set and update setting
				$setting = new Setting(array(
					'id'    => $setting['id'],
					'value' => $value
				));

			}
			// else we need to insert
			else
			{
				$setting = new Setting(array(
					'extension' => $extension,
					'name'      => $name,
					'value'     => $value
				));
			}

			try
			{
				// pass validation and labels to the model
				$setting->set_validation($rules, $labels);

				// now save the setting
				if ($setting->save())
				{
					$updated .= $labels['value'] . ' has been updated.<br />';
				}
				else
				{
					// get errors
					$errors .= $setting->validation()->errors;
				}
			}
			catch (\Exception $e)
			{
				$errors .= $e->getMessage();
			}

		}

		return array(
			'status'  => true,
			'updated' => $updated,
			'errors'  => $errors
		);
	}

}
