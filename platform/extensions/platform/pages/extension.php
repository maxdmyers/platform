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
		'name'        => 'Pages',
		'slug'        => 'pages',
		'author'      => 'Cartalyst LLC',
		'description' => 'An extension to manage pages until a CMS is completed.',
		'version'     => '1.0',
		'is_core'     => true,
	),

	'dependencies' => array(

	),

	'bundles' => array(
		'handles'  => 'pages',
		'auto'     => true,
		'location' => 'path: '.__DIR__,
	),

	'listeners' => function() {

	},

	'global_routes' => function() {

		Route::any('/', 'pages::pages@index');

		Route::any('(:any)', function($page = 'index') {
			// check if the page is a bundle
			if ( ! Bundle::exists($page))
			{
				$page = ($page == 'home') ? 'index' : $page;

				return Controller::call('pages::pages@'.$page);
			}
		});
	},

	'rules' => array(

	),

);
