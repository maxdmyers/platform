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

// Editing a manual
Route::get('manuals/edit/(:any?)/(:any?)/(:any?)', function($manual, $chapter, $article_name)
{
	return View::make('manuals::edit')
	           ->with('manual', $manual)
	           ->with('chapter', $chapter)
	           ->with('article_name', $article_name);
});

// Reading a manual
Route::get(array('manuals/(:any?)', 'manuals/(:any?)/(:any?)'), function($manual, $chapter = 'introduction')
{
	// Get all table of contents' for the manual / chapter
	$toc         = Manual::toc($manual);
	$chapter_toc = Manual::chapter_toc($manual, $chapter);

	// Array of articles for the current chapter. The closure
	// must return either an instance of View or a string which
	// will be used as the article content.
	$articles = Manual::articles($manual, $chapter, $chapter_toc, function($article, $manual, $chapter, $article_name)
	{
		return View::make('manuals::chapter.article')
		           ->with('article', Manual::parse($article))
		           ->with('manual', $manual)
		           ->with('chapter', $chapter)
		           ->with('article_name', $article_name);
	});

	// Return the chapter page for a manual.
	return View::make('manuals::chapter')
	           ->with('toc', Manual::parse($toc))
	           ->with('chapter_toc', Manual::parse($chapter_toc))
	           ->with('articles', $articles);
});

// List all manuals
Route::get('manuals', function()
{
	return View::make('manuals::index');
});