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
		'settings',
	),

	'bundles' => array(
		'handles'  => 'users',
		'location' => 'path: '.__DIR__,
	),

	'events' => array(
		'user.create',
		'user.update',
		'user.delete',
		'group.create',
		'group.update',
		'group.delete',
	),

	'listeners' => function() {

	},

	'global_routes' => function() {
		Route::any('register', 'users::auth@register');
		Route::any('activate/(:any)/(:any)', 'users::auth@activate');
		Route::any('login', 'users::auth@login');
		Route::any('logout', 'users::auth@logout');
		Route::any('reset_password', 'users::auth@reset_password');
		Route::any('reset_password_confirm/(:any)/(:any)', 'users::auth@reset_password_confirm');
	},

	'rules' => array(
		'admin.is_another_admin',
		'users::admin.users@index',
		'users::admin.users@create',
		'users::admin.users@edit',
		'users::admin.users@delete',
		'users::admin.groups@index',
	),

);
