<?php

abstract class Controller extends Laravel\Routing\Controller
{
	/**
	 * Call an action method on a controller.
	 *
	 * <code>
	 *		// Call the "show" method on the "user" controller
	 *		$response = Controller::call('user@show');
	 *
	 *		// Call the "user/admin" controller and pass parameters
	 *		$response = Controller::call('user.admin@profile', array($username));
	 * </code>
	 *
	 * @param  string    $destination
	 * @param  array     $parameters
	 * @return Response
	 */
	public static function call($destination, $parameters = array())
	{
		static::references($destination, $parameters);

		list($bundle, $destination) = Bundle::parse($destination);

		// We will always start the bundle, just in case the developer is pointing
		// a route to another bundle. This allows us to lazy load the bundle and
		// improve speed since the bundle is not loaded on every request.
		Bundle::start($bundle);

		list($name, $method) = explode('@', $destination);

		$controller = static::resolve($bundle, $name);

		// For convenience we will set the current controller and action on the
		// Request's route instance so they can be easily accessed from the
		// application. This is sometimes useful for dynamic situations.
		if ( ! is_null($route = Request::route()))
		{
			$controller_route = $route;

			$controller_route->bundle = $bundle;

			$controller_route->controller = $name;

			$controller_route->controller_action = $method;

			Router::add_to_queue($controller_route);
		}

		// If the controller could not be resolved, we're out of options and
		// will return the 404 error response. If we found the controller,
		// we can execute the requested method on the instance.
		if (is_null($controller))
		{
			return Event::first('404');
		}

		$response = $controller->execute($method, $parameters);

		if ( ! is_null($route))
		{
			Router::queue_next();
		}

		return $response;
	}
}