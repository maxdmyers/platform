<?php

class Router extends Laravel\Routing\Router
{
	/**
	 * The wildcard patterns supported by the router.
	 *
	 * @var array
	 */
	public static $patterns = array(
		'(:num)' => '([0-9]+)',
		'(:any)' => '([a-zA-Z0-9\.\-_%=]+)',
		'(:all)' => '(.*)',
	);

	/**
	 * The optional wildcard patterns supported by the router.
	 *
	 * @var array
	 */
	public static $optional = array(
		'/(:num?)' => '(?:/([0-9]+)',
		'/(:any?)' => '(?:/([a-zA-Z0-9\.\-_%=]+)',
		'/(:all?)' => '(?:/(.*)',
	);

	 /**
	  * Requested Route Queue
	  *
	  * @var array
	  */
	public static $route_queue = array();

	/**
	 * Search the routes for the route matching a method and URI.
	 *
	 * @param  string   $method
	 * @param  string   $uri
	 * @return Route
	 */
	public static function route($method, $uri)
	{
		Bundle::start($bundle = Bundle::handles($uri));

		$routes = (array) static::method($method);

		// Of course literal route matches are the quickest to find, so we will
		// check for those first. If the destination key exists in the routes
		// array we can just return that route now.
		if (array_key_exists($uri, $routes))
		{
			$action = $routes[$uri];

			$route = new Route($method, $uri, $action);

			static::add_to_queue($route);
			
			return new Route($method, $uri, $action);
		}

		// If we can't find a literal match we'll iterate through all of the
		// registered routes to find a matching route based on the route's
		// regular expressions and wildcards.
		if ( ! is_null($route = static::match($method, $uri)))
		{
			static::add_to_queue($route);

			return $route;
		}
	}

	/**
	 * Process the route queue
	 */
	public static function queue_next()
	{
		// We process the queue by setting Request::$route to the last route in the queue.
		// If the queue is empty, it Request::$route remains the same
		if (count(static::$route_queue))
		{
			Request::$route = array_pop(static::$route_queue);
		}
	}

	/**
	 * Adds the previous route the the queue and sets the current Request route
	 *
	 * @param  object  Route Object
	 */
	public static function add_to_queue($route)
	{
		// We only store the previous route into the queue, the active route is not stored
		if (Request::$route)
		{
			static::$route_queue[] = Request::$route;
			Request::$route = $route;
		}
	}
}