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

	/* Header */
	'title'			=> 	'Settings',
	'description'	=>	'You can change your preferences at anytime by choosing from the sections below.',

	/* Widgets */

	/* Form General */
	'general' => array(
		'title'	      => 'General',
		'description' => '',

		'store' => array(
			'name'    => 'Name',
			'tagline' => 'Tagline',
			'url'     => 'Cartalyst Address (URL)',
			'brand'   => 'Brand'
		),

		'address' => array(
			'name'    => 'Name',
			'country' => 'Country',
			'street'  => 'Street',
			'city'    => 'City',
			'state'   => 'State',
			'zip'     => 'Zip/Post Code',
		),

		'fieldset' => array(
			'details' => 'Store Details',
			'address' => 'Store Address',
			'brand'   => 'Store Branding',
		),

	),

	'localization' => array(
		/* Form localization */
		'title'       => 'Localization',
		'description' => '',
		'country'     => 'Country',
	),


	/* Descriptions */

	'section_2_desc'	=>	'It is highly recommended that you have a SSL Certificate if in production. Below are some extra security settings to help assist you during development vs production.',
	'section_3_desc'	=>	'',

	/* Logs */
	'log_edit' => 'Edited Site Settings',

);
