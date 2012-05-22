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

	/**
	 * NOTE:
	 * check Sentry (application/bundles/sentry) for more lang options concerning users
	 */

	/* Titles */
	'title'        => 'User Management',
	'title_create' => 'Create User',
	'title_edit'   => 'Edit User',

	/* General */
	'disabled'              => 'Disabled',
	'email'                 => 'Email',
	'enabled'               => 'Enabled',
	'first_name'            => 'First Name',
	'groups'                => 'Groups',
	'id'	                => 'Id',
	'id_required'           => 'A user Id is required.',
	'invalid_login'         => 'Invalid user name or password.',
	'last_name'             => 'Last Name',
	'login'                 => 'Login',
	'new_password'          => 'New Password',
	'not_admin'             => 'Invalid admin user.',
	'not_found'             => 'User not found.',
	'password'              => 'Password',
	'password_confirmation' => 'Confirm Password',
	'password_help'         => 'Leave password fields blank unless you want to change them.',
	'remember_me'           => 'Remember Me',
	'reset_password'        => 'Reset Password',
	'status'                => 'Status',

	/* Buttons */
	'btn_create'         => 'Create User',
	'btn_cancel'         => 'Cancel',
	'btn_delete'         => 'Delete',
	'btn_edit'           => 'Edit',
	'btn_login'          => 'Sign In',
	'btn_new_user'       => 'New User',
	'btn_reset_password' => 'Reset',
	'btn_update'         => 'Save Changes',

	/* Get */
	'count_error' => 'There was an issue retrieving the count, please try again.',

	/* Create User */
	'create_error'          => 'User was not created, please try again.',
	'create_metadata_error' => 'Unable to add user metadata. Please try again.',
	'create_success'        => 'User created successfully.',

	/* Update User */
	'update_error'          => 'User was not updated, please try again',
	'update_metadata_error' => 'Unable to add user metadata. Please try again',
	'update_success'        => 'User updated successfully.',

	/* Delete User */
	'delete_error'   => 'There was an issue deleting the user. Please try again.',
	'delete_success' => 'The user was deleted successfully.',

	/* Invalid AJAX requests */
	'invalid_request' => 'Not a valid request.',

	/* Reset Password */
	'reset_password_confirm_success' => 'Your password reset has confirmed and updated successfully. You may now log in with your new password.',
	'reset_password_confirm_error'   => 'There was an error confirming your password reset. Please try again.',
	'reset_password_error'           => 'Unable to reset your password, please make sure both Email and Password are set and you are using a registered email address.',
	'reset_password_success'         => 'Your password has been reset, please check your email to confirm.',

	/* Logs */
	'log_create' => 'Created User: :user - Id: :id.',
	'log_edit'   => 'Edited User: :user - Id: :id.',
	'log_delete' => 'Deleted User: :user - Id: :id.',

);
