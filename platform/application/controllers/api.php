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

class API_Controller extends Base_Controller
{
	// Override construct as it doesn't need CSRF checks for internal API calls
	public function __construct() {}

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		// see if the request is coming from the internal API
		if ( ! API::is_internal())
		{
			return Event::first('404');
			exit;
		}

		return parent::before();
	}

	/**
	 * Execute a controller method with the given parameters.
	 *
	 * @param  string    $method
	 * @param  array     $parameters
	 * @return Response
	 */
	public function execute($method, $parameters = array())
	{
		$filters = $this->filters('before', $method);

		// Again, as was the case with route closures, if the controller "before"
		// filters return a response, it will be considered the response to the
		// request and the controller method will not be used.
		$response = Filter::run($filters, array(), true);

		if (is_null($response))
		{
			$this->before();

			$response = $this->response($method, $parameters);
		}

		switch (Request::foundation()->headers->get('content-type'))
		{
			case 'application/json':
				$response = json_encode($response);
			break;
			case 'application/vnd.php.serialized':
				$response = serialize($response);
			break;
			default:
				$response = json_encode($response);
			break;
		}

		// The "after" function on the controller is simply a convenient hook
		// so the developer can work on the response before it's returned to
		// the browser. This is useful for templating, etc.
		$this->after($response);

		Filter::run($this->filters('after', $method), array($response));

		return $response;
	}

}
