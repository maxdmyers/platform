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

namespace Platform\Manuals;

use Bundle;
use Closure;
use Exception;
use File;
use MarkdownExtra_Parser;
use Str;

class Manual
{

	/**
	 * Instance of the PHP Markdown Extra
	 * parser.
	 *
	 * @var MarkdownExtra_Parser
	 */
	protected static $parser = null;

	/**
	 * Returns the names of all menus.
	 *
	 * Format is array('folder' => 'Manual Name'),
	 * such as array('foo_bar' => 'Foo Bar');
	 *
	 * @return  array
	 */
	public static function all()
	{
		// Get contents of the storage/manuals directory.
		$dir_contents = glob(path('storage').'manuals'.DS.'*');

		// Fallback for manuals
		$manuals = array();

		foreach ($dir_contents as $path)
		{
			// Skip files (such as README files of repos etc)
			if ( ! is_dir($path))
			{
				continue;
			}

			$folder_name = basename($path);

			// Virtually a reverese of Str::classify().
			$manual_name = Str::title(str_replace(array('_', '-', '.'), ' ', $folder_name));

			// Add to our manuals.
			$manuals[$folder_name] = $manual_name;
		}

		return $manuals;
	}

	/**
	 * Parses a string of Markdown and returns
	 * the equivilent HTML.
	 *
	 * @param   string  $string
	 * @return  string
	 */
	public static function parse($string)
	{
		// Lazy load the parser object
		if (static::$parser === null)
		{
			// Lazy load the parser class
			if ( ! class_exists('MarkdownExtra_Parser', false))
			{
				require_once Bundle::path('manuals').'libraries'.DS.'markdown-extra'.DS.'markdown'.EXT;
			}

			static::$parser = new MarkdownExtra_Parser();
		}

		return static::$parser->transform($string);
	}

	/**
	 * Returns the base path for a manual (or manuals
	 * as a whole if the manual isn't provided).
	 *
	 * @param   string  $manual
	 * @return  string  $path
	 */
	public static function path($manual = null)
	{
		$path = path('storage').'manuals'.DS;

		if ($manual !== null)
		{
			$path .= $manual.DS;
		}

		return $path;
	}

	/**
	 * Opens a file within a manual.
	 *
	 * @return  string
	 */
	public static function open($manual, $file)
	{
		$path = static::path($manual).$file;

		return File::get($path, function() use ($manual, $path)
		{
			throw new Exception("Cannot open manual [$manual] at [$path].");
		});
	}

	/**
	 * Returns the Markdown of the table of contents
	 * for a given manual.
	 *
	 * @param   string  $manual
	 * @param   string  $chapter
	 * @return  string
	 */
	public static function toc($manual)
	{
		return static::open($manual, 'toc.md');
	}

	/**
	 * Returns the Markdown of the table of contents
	 * for a given manual / chapter.
	 *
	 * @param   string  $manual
	 * @param   string  $chapter
	 * @return  string
	 */
	public static function chapter_toc($manual, $chapter)
	{
		return static::open($manual, $chapter.DS.'toc.md');
	}

	/**
	 * Returns an array of articles for the given table
	 * of contents string. This method loops through all
	 * of the links and looks for the file located in the
	 * manual that matches that link.
	 *
	 * @param   string   $manual
	 * @param   string   $chapter
	 * @param   string   $chapter_toc
	 * @param   Closure  Filter
	 * @return  string
	 */
	public static function articles($manual, $chapter, $chapter_toc, $filter = null)
	{
		// Find articles
		preg_match_all('/"\/manuals\/'.$manual.'\/'.$chapter.'\/([^"]*)"/', $chapter_toc	, $article_names);

		// Article names to load, in order
		$article_names = $article_names[1];

		// Fallback for articles
		$articles = array();

		// Loop through article names
		foreach ($article_names as $article_name)
		{
			$article = static::article($manual, $chapter, $article_name);

			// Check the filter paramter, if it is
			// a closure then we'll let it modify
			// the markdown and do whatever it wants to
			// it before we add it to our array.
			if ($filter instanceof Closure)
			{
				$article = $filter($article, $manual, $chapter, $article_name);
			}

			$articles[] = $article;
		}

		return $articles;
	}

	/**
	 * Returns the markdown content for a given article
	 * in a chapter for a manual.
	 *
	 * @param   string   $manual
	 * @param   string   $chapter
	 * @param   string   $article_name
	 * @return  string   $article
	 */
	public static function article($manual, $chapter, $article_name)
	{
		return static::open($manual, $chapter.DS.$article_name.'.md');
	}

	/**
	 * Returns the relative path of an article file.
	 *
	 * @param   string   $manual
	 * @param   string   $chapter
	 * @param   string   $article_name
	 * @return  string
	 */
	public static function relative_path($manual, $chapter, $article_name)
	{
		return $manual.DS.$chapter.DS.$article_name.'.md';
	}

}
