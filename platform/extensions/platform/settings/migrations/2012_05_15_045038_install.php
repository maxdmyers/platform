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
		Schema::create('configuration', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('extension');
			$table->string('type');
			$table->string('name');
			$table->text('value');
		});

		/**
		 *  Current platform version
		 */

		$frontend = DB::table('configuration')->insert(array(
			'extension' => 'platform',
			'type'      => 'system',
			'name'      => 'version',
			'value'     => 'beta',
		));


		/* #Create Menu
		================================================== */

		$admin = Menu::admin_menu();

		// Find the primary menu
		$primary = Menu::find(function($query) use ($admin)
		{
			return $query->where('slug', '=', 'system');
		});

		if ($primary === null)
		{
			$primary = new Menu(array(
				'name'          => 'System',
				'slug'          => 'system',
				'uri'           => 'settings',
				'user_editable' => 0,
				'status'        => 1,
			));

			$primary->last_child_of($admin);
		}


		// Settings menu
		$settings = new Menu(array(
			'name'          => 'Settings',
			'extension'     => 'settings',
			'slug'          => 'settings',
			'uri'           => 'settings',
			'user_editable' => 0,
			'status'        => 1,
		));

		$settings->last_child_of($primary);

		/* # Configuration Settings
		================================================== */

		// Site Title
		$query = DB::table('configuration')->insert(array(
			'extension' 	=> 'settings',
			'type' 			=> 'general',
			'name' 			=> 'title',
			'value' 		=> 'Platform',
		));

		// Site Tagline
		$query = DB::table('configuration')->insert(array(
			'extension' 	=> 'settings',
			'type' 			=> 'general',
			'name' 			=> 'tagline',
			'value' 		=> 'A base application on Laravel',
		));

		// Site email
		$query = DB::table('configuration')->insert(array(
			'extension' 	=> 'settings',
			'type' 			=> 'general',
			'name' 			=> 'email',
			'value' 		=> 'site@getplatform.com',
		));


	}
	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('configuration');
	}

}
