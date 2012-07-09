<?php

class Route extends Laravel\Routing\Route
{
	/**
	 * Call a given route and return the route's response.
	 *
	 * @return Response
	 */
	public function call()
	{
		// The route is responsible for running the global filters, and any
		// filters defined on the route itself, since all incoming requests
		// come through a route (either defined or ad-hoc).
		$response = Filter::run($this->filters('before'), array(), true);

		if (is_null($response))
		{
			$response = $this->response();
		}

		// We always return a Response instance from the route calls, so
		// we'll use the prepare method on the Response class to make
		// sure we have a valid Response instance.
		$response = Response::prepare($response);

		Filter::run($this->filters('after'), array($response));

		Router::queue_next();

		return $response;
	}
}