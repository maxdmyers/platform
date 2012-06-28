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
            implements ArrayAccess, Iterator
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
	protected $session_key = 'messages';

	/**
	 * Flag to use the session or not
	 * with the mesages class
	 *
	 * @var bool
	 */
	protected $use_session = false;

	/**
	 * Create a new Messages instance
	 *
	 * @param   array  $messages    Messages
	 * @param   bool   $use_session Use session with messages class
	 * @return  void
	 */
	public function __construct($messages = array(), $use_session = false)
	{
		// Flag to use session
		$this->use_session = (bool) $use_session;

		// If we're to use the session to
		// persist our messages
		if ($this->use_session === true)
		{
			// Get messages from session and merge
			$messages = array_merge_recursive(Session::get($this->session_key, array()), $messages);

			// After the controller has been executed
			// we want to persist the messages instance
			// to the session
			Event::listen('platform.controller.after', function()
			{
				Messages::instance()->persist();
			});
		}

		// Call our parent
		parent::__construct($messages);
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
		return $this;
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

	/**
	 * Add a message to the collector.
	 *
	 * <code>
	 *		// Add a message for the e-mail attribute
	 *		$messages->add('email', 'The e-mail address is invalid.');
	 * </code>
	 *
	 * @param  string  $key
	 * @param  string  $message
	 * @return Messages
	 */
	public function add($key, $message)
	{
		if ( ! is_array($message))
		{
			$message = array($message);
		}
		foreach ($message as $m)
		{
			parent::add($key, $m);
		}

		return $this;
	}

	/**
	 * Get all of the messages from the container for a given key.
	 *
	 * <code>
	 *		// Echo all of the messages for the e-mail attribute
	 *		echo $messages->get('email');
	 *
	 *		// Format all of the messages for the e-mail attribute
	 *		echo $messages->get('email', '<p>:message</p>');
	 * </code>
	 *
	 * @param  string  $key
	 * @param  string  $format
	 * @return array
	 */
	public function get($key, $format = ':message')
	{
		$formatted = parent::get($key, $format);

		// If we're using session - we need to delete
		// the items out after they've been displayed
		// so they're not persisted again
		if ($this->use_session and array_key_exists($key, $this->messages))
		{
			unset($this->messages[$key]);
		}

		return $formatted;
	}

	/**
	 * Get all of the messages for every key in the container.
	 *
	 * <code>
	 *		// Get all of the messages in the collector
	 *		$all = $messages->all();
	 *
	 *		// Format all of the messages in the collector
	 *		$all = $messages->all('<p>:message</p>');
	 * </code>
	 *
	 * @param  string  $format
	 * @return array
	 */
	public function all($format = ':message')
	{
		$formatted = parent::get($key, $format);

		// If we're using session - we need to delete
		// the items out after they've been displayed
		// so they're not persisted again
		if ($this->use_session) $this->messages = array();

		return $formatted;
	}

	/**
	 * Forget a message type or all messages
	 *
	 *		<code>
	 * 			// Forget all notice messages
	 *          $messages->forget('notice');
	 *
	 *			// Forget all messages (reset messages)
	 *			$messages->forget();
	 *		</code>
	 *
	 * @param   string  $key  Message key to forget
	 * @return  void
	 */
	public function forget($key = null)
	{
		// If the user didn't provide a key, remove all messages
		if ($key === null)
		{
			$this->messages = array();
		}

		elseif ($this->has($key))
		{
			unset($this->messages[$key]);
		}
	}

	/*
	|--------------------------------------------------------------------------
	| ArrayAccess implementation
	|--------------------------------------------------------------------------
	|
	| You can access messages as if the Messages class was a plain old array if
	| this is your preferred method.
	|
	|		foreach ($messages['foo'] as $message)
	|		{
	|			echo '<p>'.$foo.'</p>';
	|		}
	|
	*/

	/**
	 * ArrayAccess - Set an offset in the
	 * messages array
	 *
	 * @param   string  $key      Element key
	 * @param   string  $message  Message
	 * @return  void
	 */
	public function offsetSet($key, $message)
	{
		$this->add($key, $message);
	}

	/**
	 * ArrayAccess - Determine if an element
	 * exists in the messages array
	 *
	 * @param   string  $key  Element key
	 * @return  void
	 */
	public function offsetExists($key)
	{
		return $this->has($key);
	}

	/**
	 * ArrayAccess - Unset an element in the
	 * messages array
	 *
	 * @param   string  $key  Element key
	 * @return  void
	 */
	public function offsetUnset($key)
	{
		$this->forget($key);
	}

	/**
	 * ArrayAccess - Get an element in the
	 * messages array
	 *
	 * @param   string  $key  Element key
	 * @return  void
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}

	/*
	|--------------------------------------------------------------------------
	| Iterator implementation
	|--------------------------------------------------------------------------
	|
	| By implementing the iterator interface, you can treat the Messages class
	| as if it were an array, using foreach loops
	|
	*/

	/**
	 * Iterator - Rewind the messsages array to
	 * the first element
	 *
	 * @return  void
	 */
	public function rewind()
	{
		reset($this->messages);
	}

	/**
	 * Iterator - Return the current element
	 * of the messages array
	 *
	 * @return  array  Current messages element
	 */
	public function current()
	{
		return current($this->messages);
	}

	/**
	 * Iterator - Returns the key of the current
	 * element of the messages array
	 *
	 * @return  string   Current key
	 */
	public function key()
	{
		return key($this->messages);
	}

	/**
	 * Iterator - Iterates to the next
	 * element in the array
	 *
	 * @return  array  Next messages element
	 */
	public function next()
	{
		return next($this->messages);
	}

	/**
	 * Iterator - Checks if a current
	 * position is valid
	 *
	 * @return  bool   Valid
	 */
	public function valid()
	{
		return key($this->messages) !== null;
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
