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

	/**
	 * NOTE:
	 * check Sentry (application/bundles/sentry) for more lang options concerning groups
	 */

	/* General */
	'general' => array(
		'title'        => 'Group Management',
		'description'  => 'Create groups and assign access rights to groups.',
		'title_create' => 'Create Group',
		'title_edit'   => 'Edit Group',
		'id'	       => 'Id',
		'id_required'  => 'A group id is required.',
		'name'         => 'Name',
		'not_found'    => 'Group not found.',
	),

	/* Buttons */
	'button' => array(
		'create'         => 'Create Group',
		'cancel'         => 'Cancel',
		'delete'         => 'Delete',
		'edit'           => 'Edit',
		'login'          => 'Sign In',
		'reset_password' => 'Reset',
		'update'         => 'Save Changes',
	),

	/* Create Group */
	'create' => array(
		'title'          => 'Create Group',
		'description'    => 'Please supply the following information.',
		'error'          => 'Group was not created, please try again.',
		'success'        => 'Group created successfully.',
	),

	/* Update Group */
	'update' => array(
		'title'          => 'Update Group',
		'description'    => 'Please update the following information.',
		'error'          => 'Group was not updated, please try again',
		'success'        => 'Group updated successfully.',
	),

	/* Delete Group */
	'delete' => array(
		'error'   => 'There was an issue deleting the group. Please try again.',
		'success' => 'The group was deleted successfully.',
	),

	/* Logs */
	'log' => array(
		'create' => 'Created Group: :group - Id: :id.',
		'edit'   => 'Edited Group: :group - Id: :id.',
		'delete' => 'Deleted Group: :group - Id: :id.',
	),

	/* General Errors */
	'errors' => array(
		'count_error'     => 'There was an issue retrieving the count, please try again.',
		'invalid_request' => 'Not a valid request.',
		'no_groups_exist' => 'No groups exist within the give parameters.'
	)

);
