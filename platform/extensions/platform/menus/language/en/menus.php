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

	'title'       => 'Menus Management',
	'tagline' => 'Manage menus and their items.',

	/* General */
	'general' => array(
		'yes'         => 'Yes',
		'no'          => 'No',
		'name'        => 'Name',
		'slug'        => 'Slug',
		'uri'         => 'Uri',
		'secure'      => 'Secure (HTTPS)',
		'status'      => 'Enabled',
		'new_item'    => 'New Item',
	),

	/* Buttons */
	'button' => array(
		'create'               => 'Create Menu',
		'cancel'               => 'Cancel',
		'delete'               => 'Delete',
		'edit'                 => 'Edit',
		'update'               => 'Save Changes',
		'add_item'             => 'Add Item',
		'remove_item'          => 'Remove Item',
		'remove_item_disabled' => 'Required - Cannot Remove',
		'toggle_items_details' => 'Toggle All',
	),

	/* Create User */
	'create' => array(
		'title'          => 'Create User',
		'description'    => 'Please supply the following information.',
		'error'          => 'User was not created, please try again.',
		'metadata_error' => 'Unable to add user metadata. Please try again.',
		'success'        => 'User created successfully.',
	),

	/* Update User */
	'update' => array(
		'title'          => 'Update Menu',
		'description'    => 'Please update the following information.',
		// 'error'          => 'User was not updated, please try again',
		// 'metadata_error' => 'Unable to add user metadata. Please try again',
		'success'        => 'User updated successfully.',
	),

	/* Delete User */
	'delete' => array(
		'error'   => 'There was an issue deleting the user. Please try again.',
		'success' => 'The user was deleted successfully.',
	),

	/* Tabs */
	'tabs' => array(
		'items'   => 'Items',
		'options' => 'Menu Options',
	),

	/* Logs */
	'log' => array(
		'create' => 'Created User: :user - Id: :id.',
		'edit'   => 'Edited User: :user - Id: :id.',
		'delete' => 'Deleted User: :user - Id: :id.',
	),

	/* General Errors */
	'errors' => array(
		'count_error' => 'There was an issue retrieving the count, please try again.',
		'invalid_request' => 'Not a valid request.',
	)

);
