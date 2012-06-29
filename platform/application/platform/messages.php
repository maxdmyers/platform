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
 * @copyright  (c) 2011-2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

use Laravel\IoC;

/**
 * Messages container - used for storing
 * feedback for system operations within
 * Platform
 *
 * @author Ben Corlett
 */
class Messages extends Laravel\Messages
{

	/**
	 * The key used in the IoC instance
	 *
	 * @var string
	 */
	protected static $ioc_key = 'messages';

	/**
	 * The key used for the messages property
	 * in the Session
	 *
	 * @var string
	 */
	protected $session_key = 'platform';

	/**
	 * Create a new Messages instance
	 *
	 * @param   array  $messages    Messages
	 * @param   bool   $use_session Use session with messages class
	 * @return  void
	 */
	public function __construct($messages = array())
	{
		// After the controller has been executed
		// we want to persist the messages instance
		// to the session
		Event::listen('platform.controller.after', function()
		{
			Messages::instance()->persist();
		});

		// Call our parent
		parent::__construct();
	}

	/**
	 * Persists the Messages to the
	 * session
	 *
	 * @return  Messages
	 */
	public function persist()
	{
		Session::flash($this->session_key, $this->messages);
	}

	/**
	 * Adds an error message
	 *
	 * @param  string  $message  Message string
	 * @return Messages
	 */
	public function error($message)
	{
		return $this->add('errors', $message);
	}

	/**
	 * Adds an warning message
	 *
	 * @param  string  $message  Message string
	 * @return Messages
	 */
	public function warning($message)
	{
		return $this->add('warnings', $message);
	}

	/**
	 * Adds an success message
	 *
	 * @param  string  $message  Message string
	 * @return Messages
	 */
	public function success($message)
	{
		return $this->add('success', $message);
	}

	/**
	 * Adds an info message
	 *
	 * @param  string  $message  Message string
	 * @return Messages
	 */
	public function info($message)
	{
		return $this->add('info', $message);
	}

	public function add($key, $message)
	{
		$message = ( ! is_array($message)) ? array($message) : $message;
		// print_r($message);
		// exit;
		if (isset($this->messages[$key]))
		{
			$this->messages[$key] = array_merge($this->messages[$key], $message);
		}
		else
		{
			$this->messages[$key] = $message;
		}
	}

	/**
	 * Returns one instance of the messages
	 * object.
	 *
	 * Note, all parameters will be passed to
	 * a new instance, they won't be used to access
	 * future instances.
	 *
	 * @param   array  $messages    Messages
	 * @param   bool   $use_session Use session with messages class
	 * @return  Messages
	 */
	public static function instance($messages = array(), $use_session = false)
	{
		// Register singleton with IoC
		// container
		IoC::singleton(static::$ioc_key, function($messages = array(), $use_session = false)
		{
			return new Messages($messages, $use_session);
		});

		return IoC::resolve(static::$ioc_key, array($messages, $use_session));
	}

}
