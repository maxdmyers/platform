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

class Settings_Install
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

		/* # Create Settings Table
		================================================== */
		Schema::create('settings', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('extension');
			$table->string('type');
			$table->string('name');
			$table->text('value');
		});

		/* # Create Menu Items
		================================================== */

		// Find the system menu
		$system = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'admin-system');
		});

		// Create settings link
		$settings = new Menu(array(
			'name'          => 'Settings',
			'extension'     => 'settings',
			'slug'          => 'admin-settings',
			'uri'           => 'settings',
			'user_editable' => 0,
			'status'        => 1,
		));

		$settings->last_child_of($system);

		/* # Configuration Settings
		================================================== */

		// Platform version
		$version = DB::table('settings')->insert(array(
			'extension' => 'platform',
			'type'      => 'system',
			'name'      => 'version',
			'value'     => 'beta',
		));

		// Site title
		$query = DB::table('settings')->insert(array(
			'extension' 	=> 'settings',
			'type' 			=> 'site',
			'name' 			=> 'title',
			'value' 		=> 'Platform',
		));

		// Site tagline
		$query = DB::table('settings')->insert(array(
			'extension' 	=> 'settings',
			'type' 			=> 'site',
			'name' 			=> 'tagline',
			'value' 		=> 'A base application on Laravel',
		));

	}
	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('settings');
	}

}
