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

use Platform\Menus\Menu;

class Extensions_Install
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

		/* # Create Menu Items
		================================================== */

		// Find the system menu
		$system = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'admin-system');
		});

		// Create extensions link
		$extensions = new Menu(array(
			'name'          => 'Extensions',
			'extension'     => 'extensions',
			'slug'          => 'admin-extensions',
			'uri'           => 'extensions',
			'user_editable' => 0,
			'status'        => 1,
		));

		$extensions->last_child_of($system);
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{

	}

}
