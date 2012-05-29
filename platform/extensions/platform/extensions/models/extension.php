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

namespace Extensions;

use Bundle;
use Closure;
use Config;
use Crud;
use Exception;
use Menus\Menu;

/**
 * Extension class.
 *
 * @author Ben Corlett
 */
class Extension extends Crud
{

	/**
	 * The name of the table associated with the model.
	 *
	 * @var string
	 */
	protected static $_table = 'extensions';

	/**
	 * Indicates if the model has update and creation timestamps.
	 *
	 * @var bool
	 */
	protected static $_timestamps = false;

}
