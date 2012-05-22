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

namespace Extensions;

use Bundle;
use Closure;
use Exception;
use Laravel\CLI\Command;
use Str;

/**
 * Extension Manager class.
 *
 * @author Ben Corlett
 */
class Manager
{

	/**
	 * Array of started Cartalyst Extensions
	 *
	 * @var array
	 */
	protected $extensions = array();

	/**
	 * An array of extensions that are exempt
	 * from being treated like normal extensions.
	 */
	protected $exempt = array('extensions', 'installer');

	/**
	 * Starts all installed extensions with Cartalyst
	 *
	 * @return  Manager
	 */
	public function start_extensions()
	{
		// Get all enabled extensions
		$extensions = $this->enabled();

		/**
		 * @todo, remove, this is temporary
		 */
		$this->start('menus')->start('users');

		// Loop through and start every extension
		foreach ($extensions as $extension)
		{
			$this->start($extension);
		}

		return $this;
	}

	/**
	 * Starts an extension object or value
	 *
	 * @param   string  $name
	 * @param   mixed   $value
	 */
	public function start($extension)
	{
		// We might have been given the slug
		// of an extension to start
		if ( ! $extension instanceof Extension)
		{
			$model = Extension::find(function($query) use ($extension)
			{
				return $query->where('slug', '=', $extension);
			});

			if ($model === null)
			{
				throw new Exception("Cartalyst Extension [$extension] doesn't exist in database.");
			}

			$extension = $model;
		}

		// If the extension is already started
		if (array_key_exists($extension->slug, $this->extensions))
		{
			return $this;
		}

		// Determine extension file
		$file = path('bundle').$extension->slug.DS.'extension'.EXT;

		// Check that :extension/extension.php exists.
		// This is what sets up the Cartalyst extension.
		if ( ! file_exists($file))
		{
			throw new Exception("Cartalyst Extension [{$extension->name}] doesn't exist.");
		}

		// Get the information about the extension
		$info = require $file;

		// Register the bundle with Laravel
		array_key_exists('bundles', $info) and Bundle::register($extension->slug, $info['bundles']);

		// Start the bundle
		Bundle::start($extension->slug);

		// Register global routes
		if (array_key_exists('global_routes', $info))
		{
			// Check we've been given a closure
			if ( ! $info['global_routes'] instanceof Closure)
			{
				throw new Exception("'global_routes' must be a function / closure in [$file]");
				
			}

			$info['global_routes']();
		}

		// Register listeners
		if (array_key_exists('listeners', $info))
		{
			// Check we've been given a closure
			if ( ! $info['listeners'] instanceof Closure)
			{
				throw new Exception("'listeners' must be a function / closure in [$file]");
				
			}

			$info['listeners']();
		}

		return $this;
	}

	/**
	 * Installs an extension by the given slug.
	 *
	 * @param   string  $slug
	 * @return  Extension
	 */
	public function install($slug, $enable = false)
	{
		$file = path('bundle').$slug.DS.'extension'.EXT;

		if ( ! file_exists($file))
		{
			throw new Exception("Cartalyst Extension [$slug] doesn't exist.");
		}

		// Get extension info
		$info = require $file;

		// Create a new model instance.
		$extension = new Extension(array(
			'name'        => isset($info['info']['name']) ? $info['info']['name'] : '',
			'slug'        => isset($info['info']['slug']) ? $info['info']['slug'] : '',
			'version'     => isset($info['info']['version']) ? $info['info']['version'] : '',
			'author'      => isset($info['info']['author']) ? $info['info']['author'] : '',
			'description' => isset($info['info']['description']) ? $info['info']['description'] : '',
			'is_core'     => isset($info['info']['is_core']) ? $info['info']['is_core'] : '',
			'enabled'     => (int) $enable,
		));
		$extension->save();

		// Resolves core tasks.
		require_once path('sys').'cli/dependencies'.EXT;

		// Run extensions migration. This will prepare
		// the table we need to install the core extensions
		ob_start();
		Bundle::register($extension->slug);
		Command::run(array('migrate', $extension->slug));
		ob_end_clean();

		return $extension;
	}

	/**
	 * Enables an extension.
	 *
	 * @param   int  $id
	 * @return  Extension
	 */
	public function enable($id)
	{
		$extension = Extension::find($id);

		if ($extension === null)
		{
			throw new Exception('Cartalyst extension doesn\'t exist.');
		}

		$extension->enabled = 1;
		$extension->save();

		return $extension;
	}

	/**
	 * Disables an extension.
	 *
	 * @param   int  $id
	 * @return  Extension
	 */
	public function disable($id)
	{
		$extension = Extension::find($id);

		if ($extension === null)
		{
			throw new Exception('Cartalyst extension doesn\'t exist.');
		}

		$extension->enabled = 0;
		$extension->save();

		return $extension;
	}

	/**
	 * Installs the hard-coded admin menu.
	 *
	 * @todo Remove - this will be sorted into
	 *       individual extensiosn.
	 *
	 * @return  void
	 */
	public function install_admin_menu()
	{
		// Get the admin menu
		$admin = Menu::admin();

		// For now, just remove the entire admin menu tree
		Menu::query()->where(Menu::nesty_col('tree'), '=', $admin->{Menu::nesty_col('tree')})->delete();

		// Now, get a new admin menu
		$admin = Menu::admin();

		// Array of items
		$items = Config::get('admin_menu');

		Menu::from_hierarchy_array($admin->{Menu::key()}, $items);
	}

	/**
	 * Returns all installed extensions as an array
	 * of Extensions\Extenion models.
	 *
	 * @return  array
	 */
	public function installed($condition = null)
	{
		return Extension::all($condition);
	}

	/**
	 * Returns all enabled extensions as an array
	 * of Extensions\Extenion models.
	 *
	 * @param   Closure  $condition
	 * @return  array
	 */
	public function enabled($condition = null)
	{
		return Extension::all(function($query) use ($condition)
		{
			$query->where('enabled', '=', 1);

			if ($condition instanceof Closure)
			{
				$query = $condition($query);
			}

			return $query;
		});
	}

	/**
	 * Returns all disabled extensions as an array
	 * of Extensions\Extenion models.
	 *
	 * @param   Closure  $condition
	 * @return  array
	 */
	public function disabled($condition = null)
	{
		return Extension::all(function($query) use ($condition)
		{
			$query->where('enabled', '=', 0);

			if ($condition instanceof Closure)
			{
				$query = $condition($query);
			}

			return $query;
		});
	}

	/**
	 * Returns a simple array of uninstalled
	 * extensions, with numberic keys, and
	 * where the slug (which is
	 * the folder name of the extension) is the
	 * value.
	 *
	 * @param   Closure  $condition
	 * @return  array
	 */
	public function uninstalled($condition = null)
	{
		// Firstly, get all installed extensions
		$results = $this->installed(function($query) use ($condition)
		{
			// We only want to select the slug
			$query->select('slug');

			// Check if we have a closure provided as
			// a condition to this function
			if ($condition instanceof Closure)
			{
				$query = $condition($query);
			}

			return $query;
		});

		// Build a basic array of installed extensions
		$installed = array();
		foreach ($results as $result)
		{
			$installed[] = $result->slug;
		}

		// Build an array of uninstalled extensions
		$uninstalled = array();
		foreach ($this->extensions_directories() as $extension)
		{
			// Get our extension slug - always
			// matches the folder name.
			$slug = Str::lower(basename($extension));

			! in_array($slug, $installed) and $uninstalled[] = $slug;
		}

		return $uninstalled;
	}

	/**
	 * Returns an array of extensions' directories.
	 *
	 * @return  array
	 */
	public function extensions_directories()
	{
		$directories = glob(path('bundle').'*', GLOB_NOSORT);

		foreach ($directories as $index => $directory)
		{
			if (in_array(basename($directory), $this->exempt))
			{
				unset($directories[$index]);
			}
		}

		return $directories;
	}

}
