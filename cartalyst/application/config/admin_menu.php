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

/**
 * Note, this is only temporary for development.
 * When released, this will be part of each extensions' migrations.
 *
 * @author Ben Corlett
 */
return array(

	// Dashboard
	array(
		'name'          => 'Dashboard',
		'slug'          => 'dashboard',
		'uri'           => 'dashboard',
		'user_editable' => 0,
	),

	// Products
	array(
		'name'          => 'Products',
		'slug'          => 'products',
		'uri'           => 'products',
		'user_editable' => 0,
		'children'      => array(
			array(
				'name'          => 'Manage',
				'slug'          => 'products-manage',
				'uri'           => 'products',
				'user_editable' => 0,
			),
			array(
				'name'          => 'Settings',
				'slug'          => 'products-settings',
				'uri'           => 'products/settings',
				'user_editable' => 0,
			),
		),
	),

	// Orders
	array(
		'name'          => 'Orders',
		'slug'          => 'orders',
		'uri'           => 'orders',
		'user_editable' => 0,
		'children'      => array(
			array(
				'name'          => 'Manage',
				'slug'          => 'orders-manage',
				'uri'           => 'orders',
				'user_editable' => 0,
			),
			array(
				'name'          => 'Settings',
				'slug'          => 'orders-settings',
				'uri'           => 'orders/settings',
				'user_editable' => 0,
			),
		),
	),

	// Users
	array(
		'name'          => 'Users',
		'slug'          => 'users',
		'uri'           => 'users',
		'user_editable' => 0,
		'children'      => array(
			array(
				'name'          => 'Manage',
				'slug'          => 'users-manage',
				'uri'           => 'users',
				'user_editable' => 0,
			),
			array(
				'name'          => 'Groups',
				'slug'          => 'users-groups',
				'uri'           => 'users/groups',
				'user_editable' => 0,
			),
			array(
				'name'          => 'Permissions',
				'slug'          => 'users-permissions',
				'uri'           => 'users/permissions',
				'user_editable' => 0,
			),
		),
	),

	// System
	array(
		'name'          => 'System',
		'slug'          => 'system',
		'uri'           => 'system/general',
		'user_editable' => 0,
		'children'      => array(
			array(
				'name'          => 'General',
				'slug'          => 'system-general',
				'uri'           => 'system/general',
				'user_editable' => 0,
			),
			array(
				'name'          => 'Localization',
				'slug'          => 'system-localization',
				'uri'           => 'system/localization',
				'user_editable' => 0,
			),
		),
	),
);