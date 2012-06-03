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

use Platform\Manuals\Manual;

class Manuals_Index_Controller extends Manuals_Base_Controller
{

	/**
	 * Lists all manuals stored in the manuals paths.
	 *
	 * @return  View
	 */
	public function get_index()
	{
		return View::make('manuals::index')
		           ->with('manuals', Manual::all())
		           ->with('active_manual', (($segment = URI::segment(2)) !== 'edit') ? $segment : URI::segment(3));
	}

	/**
	 * Read a manual
	 *
	 * @param   string  $manual
	 * @param   string  $chapter
	 * @return  View
	 */
	public function get_read($manual, $chapter = 'introduction')
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
	}

}
