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

namespace Platform\Users\Widgets;

use API;
use Lang;
use Sentry;
use Theme;

class Groups_Form
{
	/**
	 * Create User Form
	 *
	 * @return  View
	 */
	public function create()
	{
		return Theme::make('users::widgets.groups.form.create', $data = array());
	}

	/**
	 * Edit User - General
	 *
	 * @return  View
	 */
	public function edit($id)
	{
		// get user being edited
		$group = API::get('users/groups', array(
			'where' => array('id', '=', $id)
		));

		if ($group['status'])
		{
			$data['group'] = $group['groups'][0];
		}
		else
		{
			// group doesn't exist, redirect
			return Redirect::to('admin/users/groups');
		}

		return Theme::make('users::widgets.groups.form.edit', $data);
	}

	/**
	 * Edit User - Permissions
	 *
	 * @return  View
	 */
	public function permissions($id)
	{
		$bundle_rules = Sentry\Sentry_Rules::fetch_bundle_rules();

		$extension_rules = array();
		foreach ($bundle_rules as $bundle => $rules)
		{
			foreach ($rules as $rule)
			{
				// set title
				$title  = '';

				// check if a bundle is present, if so we will categorize it
				if (strpos($rule, '::') !== false)
				{
					$lang = str_replace($bundle.'::', '', $rule);
					//list($bundle, $lang) = explode('::', $rule);

					$input_name = $bundle.'_'.\Str::slug($rule, '_');

					$title_path = explode('.', str_replace('@', '.', $lang));
					for ($i = 0; $i < count($title_path) - 1; $i++)
					{
						$title .= $title_path[$i].'.';
					}

					$title = Lang::line($bundle.'::permissions.'.$title.'_title_')->get();
					$lang = $bundle.'::permissions.'.str_replace('@', '.', $lang);
				}
				else
				{
					$lang = $rule;

					$title_path = explode('.', str_replace('@', '.', $lang));
					for ($i = 0; $i < count($title_path) - 1; $i++)
					{
						$title .= $title_path[$i].'.';
					}

					$input_name = $bundle.'_'.\Str::slug($rule, '_');
					$title = Lang::line($bundle.'::permissions.'.$title.'_title_')->get();
					$lang = $bundle.'::permissions.'.$rule;
				}

				$slug = \Str::slug($title, '_');

				$extension_rules[$slug]['title']               = $title;
				$extension_rules[$slug]['values'][$input_name] = Lang::line($lang)->get();
			}
		}

		$data = array(
			'id'              => $id,
			'extension_rules' => $extension_rules
		);

		return Theme::make('users::widgets.groups.form.permissions', $data);
	}

}
