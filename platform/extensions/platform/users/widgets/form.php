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

class Form
{

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

	public function permissions($id)
	{
		$user_rules = Sentry\Sentry_Rules::fetch_rules();

		$rules = array();
		foreach ($user_rules as $rule)
		{
			$title  = '';
			$bundle = '';
			if (strpos($rule, '::') !== false)
			{
				list($bundle, $lang) = explode('::', $rule);

				$input_name = $bundle.'_'.str_replace('.', '_', $lang);
				$input_name = str_replace('@', '_', $input_name);

				$title_path = explode('.', str_replace('@', '.', $lang));
				for ($i = 0; $i < count($title_path) - 1; $i++)
				{
					$title .= $title_path[$i].'.';
				}

				$title = Lang::line($bundle.'::permissions.'.$title.'_title_')->get();

				$lang = $bundle.'::permissions.'.str_replace('@', '.', $lang);

				$slug = \Str::slug($title);
				$rules[$slug]['title']               = $title;
				$rules[$slug]['values'][$input_name] = Lang::line($lang)->get();
			}
		}

		$data = array(
			'id'              => $id,
			'extension_rules' => $rules
		);

		return Theme::make('users::widgets.form.permissions', $data);
	}

}
