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

	/* General */
	'general' => array(
		'title'                 => 'Books Management',
		'author'                => 'Author',
		'book_title'            => 'Title',
		'book_description'      => 'Description',
		'description'           => 'Manage books.',
		'disabled'              => 'Disabled',
		'email'                 => 'Email',
		'enabled'               => 'Enabled',
		'first_name'            => 'First Name',
		'groups'                => 'Groups',
		'id'                    => 'Id',
		'id_required'           => 'A book Id is required.',
		'image'                 => 'Image',
		'invalid_login'         => 'Invalid book name or password.',
		'last_name'             => 'Last Name',
		'link'                  => 'Link',
		'login'                 => 'Login',
		'new_password'          => 'New Password',
		'not_admin'             => 'Invalid admin book.',
		'not_found'             => 'Book not found.',
		'password'              => 'Password',
		'password_confirmation' => 'Confirm Password',
		'password_help'         => 'Leave password fields blank unless you want to change them.',
		'price'                 => 'Price',
		'remember_me'           => 'Remember Me',
		'reset_password'        => 'Reset Password',
		'reset_help'            => 'An email will be sent with instructions.',
		'status'                => 'Status',
		'year'                  => 'Year',
	),

	/* Buttons */
	'button' => array(
		'create'         => 'Create Book',
		'cancel'         => 'Cancel',
		'delete'         => 'Delete',
		'edit'           => 'Edit',
		'login'          => 'Sign In',
		'reset_password' => 'Reset',
		'update'         => 'Save Changes',
	),

	/* Create Book */
	'create' => array(
		'title'          => 'Create Book',
		'description'    => 'Please supply the following information.',
		'error'          => 'Book was not created, please try again.',
		'metadata_error' => 'Unable to add book metadata. Please try again.',
		'success'        => 'Book created successfully.',
	),

	/* Update Book */
	'update' => array(
		'title'          => 'Update Book',
		'description'    => 'Please update the following information.',
		'error'          => 'Book was not updated, please try again',
		'metadata_error' => 'Unable to add book metadata. Please try again',
		'success'        => 'Book updated successfully.',
	),

	/* Delete Book */
	'delete' => array(
		'error'   => 'There was an issue deleting the book. Please try again.',
		'success' => 'The book was deleted successfully.',
	),

	/* Tabs */
	'tabs' => array(
		'general'     => 'General',
		'permissions' => 'Permissions',
	),

	/* Reset Password */
	'reset' => array(
		'password_confirm_success' => 'Your password reset has confirmed and updated successfully. You may now log in with your new password.',
		'password_confirm_error'   => 'There was an error confirming your password reset. Please try again.',
		'password_error'           => 'Unable to reset your password, please make sure both Email and Password are set and you are using a registered email address.',
		'password_success'         => 'Your password has been reset, please check your email to confirm.',
	),

	/* Logs */
	'log' => array(
		'create' => 'Created Book: :book - Id: :id.',
		'edit'   => 'Edited Book: :book - Id: :id.',
		'delete' => 'Deleted Book: :book - Id: :id.',
	),

	/* General Errors */
	'errors' => array(
		'count_error' => 'There was an issue retrieving the count, please try again.',
		'invalid_request' => 'Not a valid request.',
	)

);
