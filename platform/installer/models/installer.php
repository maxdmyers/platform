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

namespace Installer;

use Bundle;
use Config;
use DB;
use File;
use Exception;
use Laravel\CLI\Command;
use Platform;
use Session;
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
	 * Prepares the system for an install.
	 *
	 * @return  void
	 */
	public static function prepare()
	{
		// Always flush session, as new users are
		// created
		Session::flush();
	}



	/**
	 * Check file & folder permissions
	 *
	 * @return  array
	 */
	public static function permissions()
	{

		 //Folders
        $files = array(
                path('app').'config'.DS.'application.php',
                path('app').'config'.DS.'database.php',
                path('public').'platform'.DS.'themes'.DS.'compiled'.DS,
        );

        $permissions = array();
        foreach ($files as $path)
        {
            $permissions[$path] = is_writable($path);
        }

        return $permissions;

	}

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
	public static function check_database_connection($config = array())
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
	 * Installs the extensions into the database
	 *
	 * @return  void
	 */
	public static function install_extensions()
	{
		Platform::extensions_manager()->prepare_db_for_extensions();

		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_start();

		/**
		 * @todo work out dependencies so I can remove this.
		 */
		$extensions = Platform::extensions_manager()->uninstalled();

		// Sort dependencies.
		$extensions = Platform::extensions_manager()->sort_dependencies($extensions);

		foreach ($extensions as $extension)
		{
			$info = Platform::extensions_manager()->info($extension);

			if (isset($info['info']['is_core']) and $info['info']['is_core'])
			{
				// Install extension - this'll run migrations, put in
				// the database etc...
				Platform::extensions_manager()->install($extension, true);
			}
		}

		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_end_clean();
	}

	public static function remember_step_data($step, $data)
	{
		if ( ! is_int($step) or $step < 2)
		{
			throw new Exception("Invalid step provided");
		}

		Session::put(Config::get('installer::installer.session_key', 'installer').'.steps.'.$step, $data);
	}

	public static function get_step_data($step = null, $default = null)
	{
		// echo Config::get('installer::installer.session_key', 'installer').'.steps'.($step ? '.'.$step : null);
		return Session::get(Config::get('installer::installer.session_key', 'installer').'.steps'.($step ? '.'.$step : null), $default);
	}

	public static function generate_key()
	{
		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_start();

		// Resolves core tasks.
		require_once path('sys').'cli/dependencies'.EXT;

		// Run extensions migration. This will prepare
		// the table we need to install the core extensions
		Command::run(array('key:generate'));

		/**
		 * @todo remove when my pull request gets accepted
		 */
		ob_end_clean();
	}

}
