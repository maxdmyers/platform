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

use Laravel\CLI\Command;
use Platform\Menus\Menu;

class Users_Install
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

		/* # Create User Tables
		================================================== */

		// Migrate Sentry
		Command::run(array('migrate', 'sentry'));

		// Remove the username column, we don't
		// use it at all.
		Schema::table('users', function($table)
		{
			$table->drop_column('username');
		});

		// Create the sentry groups
		Sentry::group()->create(array(
			'name' => 'admin',
		));

		Sentry::group()->create(array(
			'name' => 'users',
		));

		/* # Create Menu Items
		================================================== */

		// Set Admin menu
		$admin = Menu::admin_menu();

		// Create users link
		$users = new Menu(array(
			'name'          => 'Users',
			'extension'     => 'users',
			'slug'          => 'admin-users',
			'uri'           => 'users',
			'user_editable' => 0,
			'status'        => 1,
		));

		$users->last_child_of($admin);

		// Create users list link
		$users_list = new Menu(array(
			'name'          => 'Users',
			'extension'     => 'users',
			'slug'          => 'admin-users-list',
			'uri'           => 'users',
			'user_editable' => 0,
			'status'        => 1,
		));

		$users_list->last_child_of($users);

		// Create groups link
		$groups = new Menu(array(
			'name'          => 'Groups',
			'extension'     => 'users',
			'slug'          => 'admin-groups-list',
			'uri'           => 'users/groups',
			'user_editable' => 0,
			'status'        => 1,
		));

		$groups->last_child_of($users);

		/* # Configuration Settings
		================================================== */

		// Status Disabled
		$status_disabled = DB::table('settings')->insert(array(
			'extension' 	=> 'users',
			'type' 			=> 'status',
			'name' 			=> 'disabled',
			'value' 		=> '0',
		));

		// Status Enabled
		$status_enabled = DB::table('settings')->insert(array(
			'extension' 	=> 'users',
			'type' 			=> 'status',
			'name' 			=> 'enabled',
			'value' 		=> '1',
		));

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// Normally we'd rollback, but we're resetting
		// as this is the first migration.
		Command::run(array('migrate:reset', 'sentry'));
	}

}
