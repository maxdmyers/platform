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

class Themes_Install
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		/**
		 * Create theme tables
		 */

		Schema::create('theme_options', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('type');
			$table->string('default');
			$table->text('options')->nullable();
			$table->boolean('status');
		});

		/**
		 * Add base theme configuration options
		 */

		$frontend = DB::table('configuration')->insert(array(
			'extension' => 'themes',
			'type'      => 'theme',
			'name'      => 'frontend',
			'value'     => 'frontend/default',
		));

		$backend = DB::table('configuration')->insert(array(
			'extension' => 'themes',
			'type'      => 'theme',
			'name'      => 'admin',
			'value'     => 'backend/default',
		));

		/**
		 * Add theme to menu
		 */

		$admin = Menu::admin_menu();

		// Find the system menu
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
			));

			$primary->last_child_of($admin);
		}

		// Themes menu
		$themes = new Menu(array(
			'name'          => 'Themes',
			'slug'          => 'themes',
			'uri'           => 'themes',
			'user_editable' => 0,
		));

		$themes->last_child_of($primary);
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		/**
		 * Drop theme table
		 */

		Schema::drop('theme_options');

		/**
		 * Drop Theme Menu Items
		 */



	}

}
