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

return array(

	'info' => array(
		'name'        => 'Users',
		'slug'        => 'users',
		'author'      => 'Cartalyst LLC',
		'description' => 'Manages your website users, groups and roles.',
		'version'     => '1.0',
		'is_core'     => true,
	),

	'dependencies' => array(
		'menus',
	),

	'bundles' => array(
		'handles' => 'users',
	),

	'listeners' => function() {

	},

	'global_routes' => function() {
		Route::any('admin/login', 'users::admin.users@login');
		Route::any('admin/logout', 'users::admin.users@logout');
		Route::any('admin/reset_password', 'users::admin.users@reset_password');
		Route::any('admin/reset_password_confirm', 'users::admin.users@reset_password_confirm');
	},

	'rules' => array(
		'users::admin@index',
		'users::admin@create',
		'users::admin@edit',
		'users::admin@delete',
		'users::admin.group@index',
	),

);
