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
use Theme;

class Menus
{

	/**
	 * Returns the admin navigation for Platform.
	 * Currently the main nav is limited to 1 level
	 * of depth.
	 *
	 * @return  View
	 */
	public function nav()
	{
		// Get menu items
		$items = API::get('menus/admin_menu', array('depth' => 0));

		return Theme::make('menus::widgets.nav')
		            ->with('items', $items);
	}

}
