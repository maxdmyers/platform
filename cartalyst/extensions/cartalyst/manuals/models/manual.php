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

namespace Manuals;

use Bundle;
use MarkdownExtra_Parser;

class Manual
{
	/**
	 * Instance of the PHP Markdown Extra
	 * parser.
	 *
	 * @var MarkdownExtra_Parser
	 */
	protected static $parser = null;

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

}