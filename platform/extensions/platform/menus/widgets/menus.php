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

namespace Platform\Menus\Widgets;

use API;
use Input;
use Theme;

class Menus
{


	/**
	 * Returns navigation menus for Platform.
	 *
	 * @param   string|int  $parent
	 * @return  View
	 */
	public function tabs($parent)
	{
		// Parameters for the API call
		$api_params = array(
			'depth' => 0,
		);

		if (is_numeric($parent))
		{
			$api_params['id'] = $parent;
		}
		else
		{
			$api_params['slug'] = $parent;
		}

		// Get secondary navigation
		$result = API::get('menus/children', $api_params);

		// No children
		if ( ! $result['status'])
		{
			return '';
		}

		return Theme::make('menus::widgets.tabs')
		            ->with('items', $result['children']);
	}

	/**
	 * Returns navigation menus for Platform.
	 *
	 * @param   string|int  $parent
	 * @return  View
	 */
	public function pills($parent)
	{
		// Parameters for the API call
		$api_params = array(
			'depth' => 0,
		);

		if (is_numeric($parent))
		{
			$api_params['id'] = $parent;
		}
		else
		{
			$api_params['slug'] = $parent;
		}

		// Get secondary navigation
		$result = API::get('menus/children', $api_params);

		// No children
		if ( ! $result['status'])
		{
			return '';
		}

		return Theme::make('menus::widgets.pills')
		            ->with('items', $result['children']);
	}

	public function pills_stacked($parent)
	{
		// Parameters for the API call
		$api_params = array(
			'depth' => 0,
		);

		if (is_numeric($parent))
		{
			$api_params['id'] = $parent;
		}
		else
		{
			$api_params['slug'] = $parent;
		}

		// Get secondary navigation
		$result = API::get('menus/children', $api_params);

		// No children
		if ( ! $result['status'])
		{
			return '';
		}

		return Theme::make('menus::widgets.pills_stacked')
		            ->with('items', $result['children']);
	}

}
