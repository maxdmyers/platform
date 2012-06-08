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

class Extensions_API_Extensions_Controller extends API_Controller
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
		$count_total = Extension::count();

		// Get the filtered count
		$count_filtered = Extension::count('id', function($query) use($defaults)
		{
			// Sets the were clause from passed settings
			$query = Table::count($query, $defaults);

			return $query;
		});

		// Paging
		$paging = Table::prep_paging($count_filtered, 20);

		// Get Table items
		$items = Extension::all(function($query) use ($defaults, $paging)
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
		$uninstalled = Platform::extensions_manager()->uninstalled();

		// If we want detailed info about extension,
		// not just the slug
		if (Input::get('detailed') == true)
		{
			foreach ($uninstalled as $index => $slug)
			{
				$info = Platform::extensions_manager()->info($slug);
				$uninstalled[$index] = $info['info'];
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

		return Platform::extensions_manager()->install($slug);
	}

	/**
	 * Uninstalls an extension
	 *
	 * @param  string  $slug
	 * @return 
	 */
	public function post_uninstall()
	{
		$id = Input::get('id', function()
		{
			throw new Exception('Invalid id provided.');
		});

		return Platform::extensions_manager()->uninstall($id);
	}

	public function post_enable()
	{
		$id = Input::get('id', function()
		{
			throw new Exception('Invalid id provided.');
		});

		return Platform::extensions_manager()->enable($id);
	}

	public function post_disable()
	{
		$id = Input::get('id', function()
		{
			throw new Exception('Invalid id provided.');
		});

		return Platform::extensions_manager()->disable($id);
	}

}
