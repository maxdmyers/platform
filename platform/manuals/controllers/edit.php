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
use Gitsy\GitsyRequestException;
use Gitsy\Gitsy;

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
	 * Shows the edit screen for a manual article
	 *
	 * @param   string  $manual
	 * @param   string  $chapter
	 * @param   string  $article_name
	 * @return  View
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

	/**
	 * Saves a manual article.
	 *
	 * If the user isn't logged
	 * in to either GitHub or 'anonymous', we'll save their
	 * changes in the session and require they login before
	 * their changes are 'saved'.
	 *
	 * @param   string  $manual
	 * @param   string  $chapter
	 * @param   string  $article_name
	 * @return  Redirect
	 */
	public function post_edit($manual, $chapter, $article_name)
	{
		// Fire up gitsy
		Bundle::start('gitsy');

		echo '<pre>';

		try
		{
			$cy_username = 'cartalyst';
			$cy_repo     = 'manuals';
			$user_auth   = $_SERVER['GITHUB_TOKEN'];

			$cy_manuals = Gitsy::org($cy_username)->repo($cy_repo);
			$user = Gitsy::user(null, $user_auth);

			// Fork the repo
			$user_manuals = $user->fork($cy_manuals);

			// Get the master git ref object
			$master_ref = $user_manuals->git_ref('refs/heads/master');

			// Get the latest commit from the master git ref object
			$latest_commit = $user_manuals->git_commit($master_ref['object']['sha']);

			// Create a new blob
			$new_blob = $user_manuals->create_git_blob(array(
				'content'  => Input::get('article'),
				'encoding' => 'utf-8',
			));

			$new_tree = $user_manuals->create_git_tree(array(

				/**
				 * Base tree - we want to base
				 * this tree off the current
				 * latest commit tree
				 */
				'base_tree' => $latest_commit['tree']['sha'],

				// New tree setup
				'tree' => array(
					array(
						'path' => Manual::relative_path($manual, $chapter, $article_name),
						'mode' => '100644',
						'type' => 'blob',
						'sha'  => $new_blob['sha'],
					),
				),
			));

			// Create a new commit with the new tree
			$new_commit = $user_manuals->create_git_commit(array(

				// Parent commit - the current latest commit
				'parents' => array($latest_commit['sha']),

				// Our new tree is what the commit is referencing
				'tree'    => $new_tree['sha'],

				// Message
				'message' => Input::get('message', 'Manuals changes.'),
			));

			// Update our master ref with the new commit
			$master_ref->update(array(
				'sha'   => $new_commit['sha'],
				'force' => true,
			));

			// Create a pull request
			$pull = $user_manuals->create_pull(Input::get('message', 'Manuals changes.'), Input::get('message', 'Manuals changes.'));
		}

		catch (GitsyRequestException $e)
		{
			throw $e;
		}

		return Redirect::to('manuals/'.$manual.'/'.$chapter);
	}

}
