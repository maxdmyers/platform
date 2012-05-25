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

class Users_Add_Option_Strings
{

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('option_strings')
		  ->insert(array(
		  	'slug'  => 'user_status',
		  	'value' => 0,
		  	'text'  => 'disabled',
		  ));

		DB::table('option_strings')
		  ->insert(array(
		  	'slug'  => 'user_status',
		  	'value' => 1,
		  	'text'  => 'enabled',
		  ));
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::table('option_strings')
		  ->where('slug', '=', 'user_status')
		  ->delete();
	}

}
