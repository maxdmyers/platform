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

	/* Header */
	'title'			=> 	'Installer',
	'description'	=>	'You can change your preferences at anytime by choosing from the sections below.',

	/* Form General */
	'general' => array(
		'legend'           => 'General Settings',
		'description'      => '',
		'title'            => 'Site Title',
		'tagline'          => 'Site Tagline',
		'site-email'     => 'Site Email Address',
		'brand'   => 'Brand',

		'address' => array(
			'name'    => 'Name',
			'country' => 'Country',
			'street'  => 'Street',
			'city'    => 'City',
			'state'   => 'State',
			'zip'     => 'Zip/Post Code',
		),

		'fieldset' => array(
			'details' => 'Site Details',
			'address' => 'Site Address',
			'brand'   => 'Site Branding',
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
