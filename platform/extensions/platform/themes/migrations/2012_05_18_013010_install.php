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
		/* # Create Theme Tables
		================================================== */

		Schema::create('theme_options', function($table)
		{
			$table->increments('id')->unsigned();
			$table->string('type');
			$table->string('theme');
			$table->text('options')->nullable();
			$table->boolean('status');
		});

		/* # Create Menu Items
		================================================== */

		// Find the system menu
		$system = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'admin-system');
		});

		// Create themes link
		$themes = new Menu(array(
			'name'          => 'Themes',
			'extension'     => 'themes',
			'slug'          => 'admin-themes',
			'uri'           => 'themes',
			'user_editable' => 0,
			'status'        => 1,
		));

		$themes->last_child_of($system);

		// Create frontend link
		$frontend = new Menu(array(
			'name'          => 'Frontend',
			'extension'     => 'themes',
			'slug'          => 'admin-frontend',
			'uri'           => 'themes/frontend',
			'user_editable' => 0,
			'status'        => 1,
		));

		$frontend->last_child_of($themes);

		// Create backend link
		$backend = new Menu(array(
			'name'          => 'Backend',
			'extension'     => 'themes',
			'slug'          => 'admin-backend',
			'uri'           => 'themes/backend',
			'user_editable' => 0,
			'status'        => 1,
		));

		$backend->last_child_of($themes);

		/* # Configuration Settings
		================================================== */

		// Set frontend default theme
		$query = DB::table('settings')->insert(array(
			'extension' => 'themes',
			'type'      => 'theme',
			'name'      => 'frontend',
			'value'     => 'default',
		));

		// Set backend default theme
		$query = DB::table('settings')->insert(array(
			'extension' => 'themes',
			'type'      => 'theme',
			'name'      => 'backend',
			'value'     => 'default',
		));

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
