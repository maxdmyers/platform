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

class Books_Install
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{

		/* # Create Book Tables
		================================================== */

		Schema::create('books', function($table)
		{
			$table->increments('id');
			$table->string('title');
			$table->string('author');
			$table->text('description')->nullable();
			$table->string('image')->nullable();
			$table->string('link')->nullable();
			$table->float('price')->nullable();
			$table->string('publisher')->nullable();
			$table->string('year')->nullable();
		});

		/* # Create Menu Items
		================================================== */

		// Create a menu item
		$books = new Menu(array(
			'name'          => 'Books',
			'extension'     => 'books',
			'slug'          => 'books-list',
			'uri'           => 'books',
			'user_editable' => 0,
			'status'        => 1,
		));

		// Find dashboard menu item
		$dashboard = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'dashboard');
		});

		// Fallback
		if ($dashboard === null)
		{
			$admin = Menu::admin_menu();
			$books->last_child_of($admin);
		}

		else
		{
			$books->next_sibling_of($dashboard);
		}

		/* # Configuration Settings
		================================================== */

	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		// Remove the books table
		Schema::drop('books');

		// Remove the books item
		$books = Menu::find(function($query)
		{
			return $query->where('slug', '=', 'books-list');
		});

		$books->delete();
	}

}
