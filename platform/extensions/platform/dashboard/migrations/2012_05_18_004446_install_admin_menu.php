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

class Dashboard_Install_Admin_Menu
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$admin = Menu::admin_menu();

		$dashboard = new Menu(array(
			'name'          => 'Dashboard',
			'slug'          => 'dashboard',
			'uri'           => '',
			'user_editable' => 0,
		));

		$dashboard->first_child_of($admin);
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
