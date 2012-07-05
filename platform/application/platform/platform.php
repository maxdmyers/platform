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

use Laravel\Messages;

class Platform
{

	/**
	 * Flag for whether Platform is initalized
	 *
	 * @var bool
	 */
	protected static $initialized = false;

	/**
	 * Extensions Manager
	 *
	 * @var Extnesions\Manager
	 */
	protected static $extensions_manager = null;

	/**
	 * Handles system messages for Platform
	 *
	 * @var Messages
	 */
	protected static $messages = null;

	/**
	 * Holds an array of Platform Widgets
	 *
	 * @var array
	 */
	protected static $widgets = array();

	/**
	 * Holds an array of Platform Plugins
	 *
	 * @var array
	 */
	protected static $plugins = array();

	/**
	 * Holds extension settings
	 *
	 * @var array
	 */
	protected static $settings = array();

	/**
	 * Starts up Platform necessities
	 *
	 * @access  public
	 * @return  void
	 */
	public static function start()
	{
		// If we have already initalised Platform
		if (static::$initialized === true)
		{
			return;
		}

		// Now that we have checked if Platform was initialized, we will set the variable to be true
		$initialized = true;

		// Register blade extensions
		static::register_blade_extensions();

		// Register Extensions
		static::extensions_manager()->start_extensions();
	}

	/**
	 * Return the Platform Messages object
	 *
	 * @access  public
	 * @return  Messages  Platform messages object
	 */
	public static function messages()
	{
		if (static::$messages === null)
		{
			// Setup Messages class. Second param to persist messages to session
			static::$messages = \Messages::instance();
		}

		return static::$messages;
	}

	/**
	 * Gets the Platform User
	 *
	 * @return Sentry\User
	 */
	public static function user()
	{
		return Sentry::user();
	}

	/**
	 * Registers Platform extensions for blade
	 *
	 * @return  void
	 */
	protected static function register_blade_extensions()
	{
		// TODO: add error logging when widget/plugin fails
		// register @widget with blade
		Blade::extend(function($view)
		{
			$pattern = Blade::matcher('widget');

			return preg_replace($pattern, '<?php echo Platform::widget$2; ?>', $view);
		});

		// register @plugin with blade
		Blade::extend(function($view)
		{
			$pattern = "/\s*@plugin\s*\(\s*\'(.*?)\'\s*\,\s*\'(.*?)\'\s*\,(.*?)\)/";

			return preg_replace($pattern, '<?php $$2 = Platform::plugin(\'$1\',$3); ?>', $view);
		});

		// register @get with blade
		Blade::extend(function($view)
		{
			$pattern = "/@get\.([^\s\"<]*)/";

			return preg_replace($pattern, '<?php echo Platform::get(\'$1\'); ?>', $view);
		});
	}

	/**
	 * Retrieves the extensions manager instance
	 *
	 * @return  Extensions\Manager
	 */
	public static function extensions_manager()
	{
		if (static::$extensions_manager === null)
		{
			static::$extensions_manager = new ExtensionsManager();
		}

		return static::$extensions_manager;
	}

	/**
	 * Retrieves a setting by the given setting key
	 *
	 * @param   string  $setting
	 * @return  mixed
	 */
	public static function get($setting, $default = null)
	{
		$settings = explode('.', $setting);
		$extension = array_shift($settings);
		if (count($settings) > 1)
		{
			$type = array_shift($settings);
			$name = array_shift($settings);
		}
		else
		{
			$type = $extension;
			$name = array_shift($settings);
		}

		if ( ! array_key_exists($extension, static::$settings))
		{
			// find all settings for requested extension
			$ext_settings = API::get('settings', array(
				'where' => array(
					array('extension', '=', $extension),
				),
				'organize' => true
			));

			// add extension settings to the settings array
			if ($ext_settings['status'])
			{
				static::$settings[$extension] = $ext_settings['settings'];
			}
			// add to array anyways to prevent errors
			else
			{
				static::$settings[$extension] = array();
			}
		}

		// find the setting value if it exists
		if (isset(static::$settings[$extension][$type][$name]))
		{
			return static::$settings[$extension][$type][$name]['value'];
		}

		return value($default);
	}

	/**
	 * Loads a widget
	 *
	 * @param   string  $name  Name of the widget
	 * @return  mixed
	 */
	public static function widget($name)
	{
		// Get the widget name
		$name = trim($name);

		// Any parameters passed to the widget.
		$parameters = array_slice(func_get_args(), 1);

		if (strpos($name, '::') !== false)
		{
			list($bundle_path, $action) = explode('::', strtolower($name));

			// see if there is a namespace present
			if (strpos($bundle_path, '.') !== false)
			{
				list ($namespace, $bundle) = explode('.', $bundle_path);
			}
			else
			{
				$bundle = $bundle_path;
				$namespace = '';
			}

			$path = explode('.', $action);

			$method = array_pop($path);
			$class = implode('_', $path);
		}

		$class = ucfirst($namespace).'\\'.ucfirst($bundle).'\\Widgets\\'.ucfirst($class);

		if (array_key_exists($class, static::$widgets))
		{
			$widget = static::$widgets[$class];
		}
		else
		{
			! Bundle::started($bundle) and Bundle::start($bundle);

			if ( ! class_exists($class))
			{
				return '';
				// throw new \Exception('Class: '.$class.' does not exist.');
			}

			$widget = new $class();

			// store the object
			static::$widgets[$class] = $widget;
		}

		if ( ! is_callable($class, $method))
		{
			return '';
			throw new \Exception('Method: '.$method.' does not exist in class: '.$class);
		}

		return call_user_func_array(array($widget, $method), $parameters);
	}

	/**
	 * Loads a plugin
	 *
	 * @param   string  $name  Name of the plugin
	 * @return  mixed
	 */
	public static function plugin($name)
	{
		// Get the plugin name
		$name = trim($name);

		// Any parameters passed to the widget.
		$parameters = array_slice(func_get_args(), 1);

		if (strpos($name, '::') !== false)
		{
			list($bundle_path, $action) = explode('::', strtolower($name));

			// see if there is a namespace present
			if (strpos($bundle_path, '.') !== false)
			{
				list ($namespace, $bundle) = explode('.', $bundle_path);
			}
			else
			{
				$bundle = $bundle_path;
				$namespace = '';
			}

			$path = explode('.', $action);

			$method = array_pop($path);
			$class = implode('_', $path);
		}

		$class = ucfirst($namespace).'\\'.ucfirst($bundle).'\\Plugins\\'.ucfirst($class);

		if (array_key_exists($class, static::$plugins))
		{
			$plugin = static::$plugins[$class];
		}
		else
		{
			! Bundle::started($bundle) and Bundle::start($bundle);

			if ( ! class_exists($class))
			{
				return '';
				//throw new \Exception('Class: '.$class.' does not exist.');
			}

			$plugin = new $class();

			// store the object
			static::$plugins[$class] = $plugin;
		}

		if ( ! is_callable($class, $method))
		{
			return '';
			// throw new \Exception('Method: '.$method.' does not exist in class: '.$class);
		}

		return call_user_func_array(array($plugin, $method), $parameters);
	}

	/**
	 * Determines if Platform has been installed or not.
	 *
	 * @return  bool
	 */
	public static function is_installed()
	{
		$installed = true;

		// Check for the database config file
		if ( ! File::exists(path('app').'config'.DS.'database'.EXT))
		{
			$installed = false;
		}

		// List installed extensions. If the count is more than 0, we
		// have installed Platform.
		try
		{
			// Extension table exists, but is empty.
			if (count(Platform::extensions_manager()->enabled()) === 0)
			{
				$installed = false;
			}
		}

		// Extensions table doesn't exist
		catch (Exception $e)
		{
			$installed = false;
		}

		// Now, count the users table.
		try
		{
			if (DB::table('users')->count() === 0)
			{
				$installed = false;
			}
		}
		catch (Exception $e)
		{
			$installed = false;
		}

		return $installed;
	}
}
