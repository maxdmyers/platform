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

	'title'        => 'Extension Management',
	'tagline'  => 'Install, uninstall, disable extensions for platform',

	/* Table */
	'table' => array(
		'id'          => 'Id',
		'name'        => 'Name',
		'slug'        => 'Slug',
		'author'      => 'Author',
		'description' => 'Description',
		'version'     => 'Version',
		'is_core'     => 'Is Core Extension',
		'enabled'     => 'Enabled',
		'actions'     => 'actions',
	),

	// Values for tinyint fields
	'bool' => array(
		'yes' => 'Yes',
		'no'  => 'No',
	),

);
