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
		'name'        => 'Books',
		'slug'        => 'books',
		'author'      => 'Cartalyst LLC',
		'description' => 'Lists every single book in the world.',
		'version'     => '1.0',
	),

	'dependencies' => array(
		'menus',
		'dashboard',
		'settings',
	),

	'bundles' => array(
		'handles'  => 'books',
		'location' => 'path: '.__DIR__,
	),

	'events' => array(

	),

	'listeners' => function() {

	},

	'global_routes' => function() {

	},

	'rules' => array(

	),

);
