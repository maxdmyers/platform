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

class Admin_Users_Form
{
	/**
	 * Create User Form
	 *
	 * @return  View
	 */
	public function create()
	{
		// get and set groups
		$groups = Sentry::group()->all();
		//$groups = API::get('users/groups');
		$data = array();
		foreach ($groups as $group)
		{
			$data['groups'][$group['name']] = ucfirst($group['name']);
		}

		if (empty($data['groups']))
		{
			$data['groups'] = array();
		}

		return Theme::make('users::widgets.form.create', $data);
	}

	/**
	 * Edit User - General
	 *
	 * @return  View
	 */
	public function edit($id)
	{
		// get user being edited
		$user = API::get('users', array(
			'where' => array('users.id', '=', $id)
		));

		if ($user['status'])
		{
			$data['user'] = $user['users'][0];
		}
		else
		{
			// user doesn't exist, redirect
			return Redirect::to('admin/users');
		}

		// set status options
		$data['status_options'] = array(
			1 => __('users.enabled'),
			0 => __('users.disabled'),
		);

		// get and set group options
		$user_groups = Sentry::group()->all();

		foreach ($user_groups as $user_group)
		{
			$data['user_groups'][$user_group['name']] = ucfirst($user_group['name']);
		}

		return Theme::make('users::widgets.form.edit', $data);
	}

	/**
	 * Edit User - Permissions
	 *
	 * @return  View
	 */
	public function permissions($id)
	{
		$bundle_rules = Sentry\Sentry_Rules::fetch_bundle_rules();

		// get current group permissions
		$current_permissions = json_decode(Sentry\Sentry::user((int) $id)->get('permissions'), 'assoc');
		$current_permissions = ($current_permissions) ?: array();

		$extension_rules = array();
		foreach ($bundle_rules as $bundle => $rules)
		{
			foreach ($rules as $rule)
			{
				// reformat to grab language file
				$lang = str_replace($bundle.'::', '', $rule);
				$lang = str_replace('@', '.', $lang);

				// find the title language path
				$title = '';
				$title_path = explode('.', $lang);
				for ($i = 0; $i < count($title_path) - 1; $i++)
				{
					$title .= $title_path[$i].'.';
				}

				// set vars
				$title = Lang::line($bundle.'::permissions.'.$title.'_title_')->get();
				$lang  = $bundle.'::permissions.'.$lang;
				$slug  = \Str::slug($title, '_');

				$extension_rules[$slug]['title'] = $title;
				$extension_rules[$slug]['permissions'][] = array(
					'value'	=> Lang::line($lang)->get(),
					'slug'  => \Str::slug($rule, '_'),
					'has'   => (array_key_exists($rule, $current_permissions) and $current_permissions[$rule] == 1) ? 1 : '',
				);
			}
		}

		$data = array(
			'id'                  => $id,
			'extension_rules'     => $extension_rules
		);

		return Theme::make('users::widgets.form.permissions', $data);
	}

}
