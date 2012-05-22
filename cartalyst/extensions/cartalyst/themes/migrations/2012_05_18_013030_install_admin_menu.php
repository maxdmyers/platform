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

use Cartalyst\Menus\Menu;

class Themes_Install_Admin_Menu
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		$admin = Menu::admin_menu();

		// Find the system menu
		$system = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'system');
		});

		if ($system === null)
		{
			$system = new Menu(array(
				'name'          => 'System',
				'slug'          => 'system',
				'uri'           => '',
				'user_editable' => 0,
			));

			$system->last_child_of($admin);
		}

		// Themes menu
		$themes = new Menu(array(
			'name'          => 'Themes',
			'slug'          => 'themes',
			'uri'           => 'themes',
			'user_editable' => 0,
		));

		$themes->last_child_of($system);
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
