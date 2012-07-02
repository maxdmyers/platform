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

namespace Platform\Settings\Model;

use Crud;

/**
 * Product Model
 *
 * @author  Daniel Petrie
 */
class Setting extends Crud
{

	/**
	 * Set validation rules and labels
	 *
	 * @param  array  validation rules
	 * @param  array  labels
	 */
	public function set_validation($rules = array(), $messages = array())
	{
		static::$_rules  = $rules;
		// static::$_messages = $messages;
	}

}
