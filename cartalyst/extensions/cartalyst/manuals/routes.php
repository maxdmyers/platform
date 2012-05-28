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

use Manuals\Manual;

// Reading a manual
Route::get(array('manuals/(:any?)', 'manuals/(:any?)/(:any?)'), function($manual, $chapter = null)
{
	// Get all chapters for the manual
	$chapters = Manual::chapters($manual);

	// Read the manual for the given manual / chapter.
	$contents = Manual::read($manual, $chapter, function($article)
	{

	});

	return View::make('manuals::view')
	           ->with('chapters', $chapters)
	           ->with('contents', $contents);
});

// List all manuals
Route::get('manuals', function()
{
	return View::make('manuals::index');
});