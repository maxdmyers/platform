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

namespace Installer;

use Bundle;
use Cartalyst;
use File;
use Exception;
use Laravel\CLI\Command;
use Str;

/**
 * Installer model - handles
 * operations of the install process.
 *
 * @author Ben Corlett
 */
class Installer
{

	/**
	 * Returns an array of available database drivers
	 *
	 * @return  array
	 */
	public static function database_drivers()
	{
		return array(
			'sqlite' => 'SQLite',
			'mysql'  => 'MySQL',
			'pgsql'  => 'PostgreSQL',
			'sqlsrv' => 'SQL Server',
		);
	}

	/**
	 * Creates a database config file.
	 *
	 * @param   array  $config
	 * @return  void
	 */
	public static function create_database_config($config = array())
	{
		// Load config file stub. Default to file for driver or fallback
		// to standard config.
		$string = File::get(Bundle::path('installer').'stubs'.DS.'database'.DS.$config['driver'].EXT, function()
		{
			return File::get(Bundle::path('installer').'stubs'.DS.'database'.EXT);
		});

		// Determine replacements
		$replacements = array();
		foreach ($config as $key => $value)
		{
			$replacements['{{'.$key.'}}'] = $value;
		}

		// Make replacements
		$string = str_replace(array_keys($replacements), array_values($replacements), $string);

		// Write the new file
		File::put(path('app').'config'.DS.'database'.EXT, $string);
	}

	/**
	 * Checks a connection to the database.
	 *
	 * @param   array  $config
	 * @return  bool
	 */
	public static function check_database($config = array())
	{
		switch ($config['driver'])
		{
			case 'sqlite':
				$driver = new \Laravel\Database\Connectors\SQLite;
				break;

			case 'mysql':
				$driver = new \Laravel\Database\Connectors\MySQL;
				break;

			case 'pgsql':
				$driver = new \Laravel\Database\Connectors\Postgres;
				break;

			case 'sqlsrv':
				$driver = new \Laravel\Database\Connectors\SQLServer;
				break;

			default:
				throw new Exception("Database driver [{$config['driver']}] is not supported.", 1000);
		}

		// Create a connection
		$connection = new \Laravel\Database\Connection($driver->connect($config), $config);

		// If no credentials are provided,
		// we need to try get contents of a table.
		// Use a random table name so that it doesn't
		// actually exist.
		$connection->table(Str::random(10, 'alpha'))->get();

		// If we got this far without an exception been thrown,
		// we've connected
		return true;
	}

	/**
	 * Prepares the system to install all extensions.
	 *
	 * @return  void
	 */
	public static function prepare_db_for_extensions()
	{
		// Load the extension manager singleton. Ensures
		// the 'extensions' extension is loaded, which
		// we need soon
		Cartalyst::extensions_manager();

		// Resolves core tasks.
		require_once path('sys').'cli/dependencies'.EXT;

		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_start();

		// Install the migrations table
		Command::run(array('migrate:install'));

		// Run extensions migration. This will prepare
		// the table we need to install the core extensions
		Command::run(array('migrate', 'extensions'));

		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_end_clean();
	}

	/**
	 * Installs the extensions into the database
	 *
	 * @return  void
	 */
	public static function install_extensions()
	{
		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_start();

		/**
		 * @todo work out dependencies so I can remove this.
		 */
		$extensions = Cartalyst::extensions_manager()->uninstalled();

		// Just push the menu to the front
		usort($extensions, function($a, $b)
		{
			return $a === 'menus' ? -1 : 1;
		});

		foreach ($extensions as $extension)
		{
			// Install AND enable every uninstalled extension
			Cartalyst::extensions_manager()->install($extension, true);

			if (in_array($extension, array('menus')))
			{
				Cartalyst::extensions_manager()->start($extension);
			}
		}

		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_end_clean();
	}

}
