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
				'id'          => Lang::line('extensions::extensions.table.id')->get(),
				'name'        => Lang::line('extensions::extensions.table.name')->get(),
				'slug'        => Lang::line('extensions::extensions.table.slug')->get(),
				'author'      => Lang::line('extensions::extensions.table.author')->get(),
				'description' => Lang::line('extensions::extensions.table.description')->get(),
				'version'     => Lang::line('extensions::extensions.table.version')->get(),
				'is_core'     => Lang::line('extensions::extensions.table.is_core')->get(),
				'enabled'     => Lang::line('extensions::extensions.table.enabled')->get(),
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
	 * Returns an array of installed extensions
	 * that are present in the filesystem, in a structure
	 * similar to that returned from the database.
	 *
	 * @return  array
	 */
	public function get_installed()
	{
		return Platform::extensions_manager()->installed(null, true);
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
		return Platform::extensions_manager()->uninstalled(null, true);
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

		try
		{
			$extension = Platform::extensions_manager()->install($slug);
		}
		catch (Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage(),
			);
		}

		return array(
			'status'    => true,
			'extension' => $extension,
		);
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

		try
		{
			return array(
				'status' => Platform::extensions_manager()->uninstall($id),
			);
		}
		catch (Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage(),
			);
		}
	}

	/**
	 * Checks if extensions have updates
	 *
	 * @return array
	 */
	public function get_updates()
	{
		$extensions = Input::get('extensions');

		foreach ($extensions as &$extension)
		{
			$extension['update'] = Platform::extensions_manager()->has_update($extension['slug']);
		}

		return $extensions;
	}

	public function post_update()
	{
		$id = Input::get('id');

		Platform::extensions_manager()->update($id);
	}

	public function post_enable()
	{
		$id = Input::get('id', function()
		{
			throw new Exception('Invalid id provided.');
		});

		try
		{
			$extension = Platform::extensions_manager()->enable($id);
		}
		catch (Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage(),
			);
		}

		return array(
			'status'    => true,
			'extension' => $extension,
		);
	}

	public function post_disable()
	{
		$id = Input::get('id', function()
		{
			throw new Exception('Invalid id provided.');
		});

		try
		{
			$extension = Platform::extensions_manager()->disable($id);
		}
		catch (Exception $e)
		{
			return array(
				'status'  => false,
				'message' => $e->getMessage(),
			);
		}

		return array(
			'status'    => true,
			'extension' => $extension,
		);
	}

}
