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
		$result = API::get('menus/active');

		if ( ! $result['status'])
		{
			return false;
		}

		// Grab all children items from the API
		$items = API::get('menus/children', array(
			'id'    => $result['active_path'][(int) $start_depth],
			'depth' => (int) $children_depth,
		));

		return Theme::make('menus::widgets.nav')
		            ->with('items', $items['children'])
		            ->with('active_path', $result['active_path'])
		            ->with('class', $class)
		            ->with('before_uri', $before_uri);
	}

}
