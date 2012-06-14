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

	/* Titles */
	'title'        => 'Group Management',
	'description' => 'Create groups and assign access rights to groups.',
	'title_create' => 'Create Group',
	'title_edit'   => 'Edit Group',

	/* General */
	'id'	                => 'Id',
	'name'            		=> 'Name',

	/* Buttons */
	'btn_create'         => 'Create Group',
	'btn_cancel'         => 'Cancel',
	'btn_delete'         => 'Delete',
	'btn_edit'           => 'Edit',
	'btn_new_group'      => 'New Group',
	'btn_update'         => 'Save Changes',

	/* Get */
	'count_error' => 'There was an issue retrieving the count, please try again.',

	/* Create Group */
	'create_error'          => 'Group was not created, please try again.',
	'create_success'        => 'Group created successfully.',

	/* Update Group */
	'update_error'          => 'Group was not updated, please try again',
	'update_success'        => 'Group updated successfully.',

	/* Delete Group */
	'delete_error'   => 'There was an issue deleting the group. Please try again.',
	'delete_success' => 'The group was deleted successfully.',

	/* Invalid AJAX requests */
	'invalid_request' => 'Not a valid request.',

	/* Logs */
	'log_create' => 'Created Group: :group - Id: :id.',
	'log_edit'   => 'Edited Group: :group - Id: :id.',
	'log_delete' => 'Deleted Group: :group - Id: :id.',

);
