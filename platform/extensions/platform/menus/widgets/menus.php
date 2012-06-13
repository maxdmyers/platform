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
	 * Returns a navigation menu, based off the active menu.
	 *
	 * @param   int     $start_depth
	 * @param   int     $children_depth
	 * @param   string  $class
	 * @param   string  $before_uri
	 * @param   string  $class
	 */
	public function nav($start_depth = 0, $children_depth = 0, $class = null, $before_uri = null)
	{
		// Get the active menu
		$active_result = API::get('menus/active');

		if ( ! $active_result['status'])
		{
			return '';
		}

		// Check the start depth exists
		if ( ! isset($active_result['active_path'][(int) $start_depth]))
		{
			return '';
		}

		// Grab all children items from the API
		$items_result = API::get('menus/children', array(
			'id'    => $active_result['active_path'][(int) $start_depth],
			'depth' => (int) $children_depth,
		));

		// If there are no children of the given menu,
		// return an empty string
		if ( ! isset($items_result['children']) or ! is_array($items_result['children']) or empty($items_result['children']))
		{
			return '';
		}


		// Return teh 
		return Theme::make('menus::widgets.nav')
		            ->with('items', $items_result['children'])
		            ->with('active_path', $active_result['active_path'])
		            ->with('class', $class)
		            ->with('before_uri', $before_uri);
	}

}
