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

namespace Platform\Themes;

use Crud;

/**
 * Product Model
 *
 * @author  Daniel Petrie
 */
class Theme extends Crud
{

	protected static $_table = 'theme_options';

	/**
	 * @var  string  $_filepath  Path for theme_options.css file
	 */
	protected static $_filepath = null;

	/**
	 * @var  string  $_css_content  Content for theme_options css file
	 */
	protected static $_css_content = null;

	/**
	 * Called right after validation before inserting/updating to the database
	 *
	 * @param   array  $attributes  attribute array
	 * @return  array
	 */
	protected function prep_attributes($attributes)
	{
		// generate css file contents
		$options = $attributes['options'];

		foreach ($options as $id => $option)
		{
			$selector = $options[$id]['selector'];
			$styles = '';
			foreach ($option['styles'] as $attribute => $value)
			{
				$styles .= "\t".$attribute.': '.$value.';'."\n";
			}
			static::$_css_content .= $selector.' {'."\n".$styles.'}'."\n\n";
		}

		// get compile dir from theme bundle
		$compile_dir = str_finish(\Config::get('theme::theme.compile_directory'), DS);

		// set path for css file
		static::$_filepath = path('public').\Theme::get_directory().$compile_dir.$attributes['type'].DS.$attributes['theme'].DS.'assets'.DS.'css'.DS.'theme_options.css';

		// encode options for db storage
		$attributes['options'] = json_encode($attributes['options']);

		return $attributes;
	}

	/**
	 * Gets call after the insert() query is exectuted to modify the result
	 * Must return a proper result
	 *
	 * @return  object  Model object result
	 */
	protected function after_insert($result)
	{
		if ($result)
		{
			// find css file and rewrite contents
			file_put_contents(static::$_filepath, static::$_css_content);
		}

		return $result;
	}

	/**
	 * Gets call after the update() query is exectuted to modify the result
	 * Must return a proper result
	 *
	 * @return  object  Model object result
	 */
	protected function after_update($result)
	{
		if ($result)
		{
			// find css file and rewrite contents
			file_put_contents(static::$_filepath, static::$_css_content);
		}

		return $result;
	}

	/**
	 * Gets call after the find() query is exectuted to modify the result
	 * Must return a proper result
	 *
	 * @return  object  Model object result
	 */
	protected function after_find($result)
	{
		if ($result)
		{
			$result->options = ($result->options) ? json_decode($result->options) : array();
		}

		return $result;
	}

	/**
	 * Fetches Themes
	 *
	 * @param   string  theme type
	 * @param   string  theme name
	 * @return  array   result array of themes with info
	 */
	public static function fetch($type, $name = null)
	{
		// use default namespace to use theme class, rather than pointing to this model
		$path = path('public').\Theme::get_directory().$type;
		$theme_list = \Theme::find_all($type);

		$themes = array();
		foreach ($theme_list as $theme)
		{
			$theme_info        = \Theme::info($type.DS.$theme);
			$theme_info['dir'] = $theme;
			$themes[$theme]    = $theme_info; //$theme_info;
		}

		if ($name != null)
		{
			return (array_key_exists($name, $themes)) ? $themes[$name] : array();
		}

		return $themes;
	}

}
