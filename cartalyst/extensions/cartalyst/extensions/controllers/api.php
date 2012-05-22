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

use Extensions\Manager;

class Extensions_API_Controller extends API_Controller
{

	public function get_datatable()
	{
		// CartTable defaults
		$defaults = array(
			'select'    => array(
				'id'          => Lang::line('extensions::extensions.id')->get(),
				'name'        => Lang::line('extensions::extensions.name')->get(),
				'slug'        => Lang::line('extensions::extensions.slug')->get(),
				'author'      => Lang::line('extensions::extensions.author')->get(),
				'description' => Lang::line('extensions::extensions.description')->get(),
				'version'     => Lang::line('extensions::extensions.version')->get(),
				'is_core'     => Lang::line('extensions::extensions.is_core')->get(),
				'enabled'     => Lang::line('extensions::extensions.enabled')->get(),
			),
			'where'     => array(),
			'order_by'  => array('slug' => 'asc'),
		);

		// Get total count
		$count_total = Manager::count();

		// Get the filtered count
		$count_filtered = Manager::count('id', function($query) use($defaults)
		{
			// Sets the were clause from passed settings
			$query = Table::count($query, $defaults);

			return $query;
		});

		// Paging
		$paging = Table::prep_paging($count_filtered, 20);

		// Get Table items
		$items = Manager::all(function($query) use ($defaults, $paging)
		{
			list($query, $columns) = Table::query($query, $defaults, $paging);

			return $query->select($columns);
		});

		// Get items
		$items = ($items) ?: array();

		// Return our data
		return array(
			'columns'        => $defaults['select'],
			'rows'           => $items,
			'count'          => $count_total,
			'count_filtered' => $count_filtered,
			'paging'         => $paging,
		);
	}

	/**
	 * Returns an array of uninstalled extensions
	 * that are present in the filesystem, in a structure
	 * similar to that returned from the database.
	 *
	 * @return  array
	 */
	public function get_uninstalled()
	{
		// Installed extensions
		$installed = array();

		// Get an array of installed extension slugs
		$results = Manager::all(function($query)
		{
			return $query->select('slug');
		});

		foreach ($results as $result)
		{
			$installed[] = $result->slug;
		}

		// Get all extensions in the extensions folder
		$extensions = glob(path('bundle').'*');

		// Array of uninstalled extensions
		$uninstalled = array();

		// Loop through and find extension files
		foreach ($extensions as $extension)
		{
			// Get the extension slug
			$slug = basename($extension);

			// Work out the extension file
			$file = $extension.DS.'extension'.EXT;

			// No extension file? Not a valid extension
			if ( ! file_exists($file))
			{
				continue;
			}

			// Get extension info
			$info = require $file;

			// If we don't have information about the extension
			if ( ! isset($info['info']) or ! is_array($info['info']))
			{
				continue;
			}

			// Change our ke
			$info = $info['info'];

			// Only continue if we're not currently installed
			if ( ! in_array($slug, $installed))
			{
				// Add to the array
				$uninstalled[] = array(
					'name'        => isset($info['name']) ? $info['name'] : '',
					'slug'        => isset($info['slug']) ? $info['slug'] : '',
					'author'      => isset($info['author']) ? $info['author'] : '',
					'description' => isset($info['description']) ? $info['description'] : '',
					'version'     => isset($info['version']) ? $info['version'] : '',
				);
			}
		}

		return $uninstalled;
	}

	/**
	 * Installs an extension by the given slug.
	 *
	 * @param  string  $slug
	 * @return
	 */
	public function post_install()
	{
		$slug = Input::get('slug', function()
		{
			throw new Exception('Invalid slug provided.');
		});

		return Cartalyst::extensions_manager()->install($slug);
	}

	public function post_enable()
	{
		$id = Input::get('id', function()
		{
			throw new Exception('Invalid id provided.');
		});

		return Cartalyst::extensions_manager()->enable($id);
	}

	public function post_disable()
	{
		$id = Input::get('id', function()
		{
			throw new Exception('Invalid id provided.');
		});

		return Cartalyst::extensions_manager()->disable($id);
	}

}
