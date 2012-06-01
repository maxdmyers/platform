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

class Manuals_Edit_Controller extends Manuals_Base_Controller
{

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();

		// Add markdown-extra JS
		Asset::add('markdown', 'platform/manuals/js/markdown-extra.js');
		Asset::add('tabby', 'platform/manuals/js/jquery/tabby.js');
	}

	/**
	 * Shows the edit screen for a manual.
	 *
	 * @param  string  $manual
	 * @param  string  $chapter
	 * @param  string  $article_name
	 */
	public function get_edit($manual, $chapter, $article_name)
	{
		// Retrieve the article
		$article = Manual::article($manual, $chapter, $article_name);

		// Return the edit view
		return View::make('manuals::edit')
		           ->with('manual', $manual)
		           ->with('chapter', $chapter)
		           ->with('article_name', $article_name)
		           ->with('article', $article);
	}

}
