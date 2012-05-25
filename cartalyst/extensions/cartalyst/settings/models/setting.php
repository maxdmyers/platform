<?php
/**
 * Part of the Cartalyst application.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.  It is also available at
 * the following URL: http://www.opensource.org/licenses/BSD-3-Clause
 *
 * @package    Cartalyst
 * @version    1.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011 - 2012, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Settings\Model;

use Crud;

/**
 * Product Model
 *
 * @author  Dan Horrigan
 */
class Setting extends Crud
{

	protected static $_table = 'configuration';

	// /**
	//  * Save the model instance to the database.
	//  *
	//  * @return bool
	//  */
	// public function save()
	// {
	// 	// first check if we want timestamps as this will append to attributes
	// 	if (static::$_timestamps)
	// 	{
	// 		$this->timestamp();
	// 	}

	// 	// now we grab the attributes
	// 	$attributes = $this->attributes();

	// 	// run - if rules are set
	// 	if ( ! empty(static::$_rules))
	// 	{
	// 		$validated = $this->run_validation($attributes, static::$_rules);

	// 		if ( ! $validated)
	// 		{
	// 			return false;
	// 		}
	// 	}

	// 	// prep attribute values after validation is done
	// 	$attributes = $this->prep_attributes($attributes);

	// 	// If the model is not new, we only need to update it in the database, and the update
	// 	// will be considered successful if there is one affected row returned from the
	// 	// fluent query instance. We'll set the where condition automatically.
	// 	if ( ! $this->is_new())
	// 	{
	// 		// make sure a key is set then grab and remove it from the attributes array
	// 		if ( ! isset($attributes[static::key()]) or empty($attributes[static::key()]))
	// 		{
	// 			// the key is not set or empty, throw an exception
	// 			throw new \Exception('A primary key is required to update.');
	// 		}

	// 		$key = $attributes[static::key()];
	// 		unset($attributes[static::key()]);

	// 		$query = $this->query()->where(static::key(), '=', $key);

	// 		list($query, $attributes) = $this->before_update($query, $attributes);

	// 		$result = $query->update($attributes);

	// 		$result = $this->after_update($result);
	// 	}

	// 	// If the model is new, we will insert the record and retrieve the last
	// 	// insert ID that is associated with the model. If the ID returned is numeric
	// 	// then we can consider the insert successful.
	// 	else
	// 	{

	// 		if ( ! is_int($attributes['extension']))
	// 		{
	// 			$query = DB::connection(static::$_connection)
	// 				->table('extensions')
	// 				->where('slug', '=', $attributes['extension'])
	// 				->first();

	// 			if (empty($query))
	// 			{
	// 				throw new \Exception('Extension with slug: '.$vars['extension']. ' does not exist.');
	// 			}

	// 			$vars['extension_id'] = $query['id'];
	// 		}
	// 		else
	// 		{
	// 			$vars['extension_id'] = $vars['extension'];
	// 		}
	// 		unset($vars['extension']);

	// 		$query = $this->query();

	// 		list($query, $attributes) = $this->before_insert($query, $attributes);

	// 		$key = $this->query()->insert_get_id($attributes, static::$_sequence);

	// 		$key = $this->after_insert($key);

	// 		// If we didn't already have a primary
	// 		// key, assign what is returned from
	// 		// the database insert
	// 		if ( ! isset($this->{static::key()}))
	// 		{
	// 			$this->{static::key()} = $key;
	// 		}

	// 		$this->is_new( ! (bool) $key);
	// 	}

	// 	return $key;
	// }

	/**
	 * Set validation rules and labels
	 *
	 * @param  array  validation rules
	 * @param  array  labels
	 */
	public function set_validation($rules = array(), $labels = array())
	{
		static::$_rules  = $rules;
		// static::$_labels = $labels;
	}

}
