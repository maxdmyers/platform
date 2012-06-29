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

namespace Platform\Users;

use Crud;
use Event;
use Sentry;
use Sentry\SentryException;

class Group extends Crud
{
	/**
	 * The primary key for the model on the database table.
	 *
	 * @var string
	 */
	public static $key = 'id';

	/**
	 * @var  array  $rules  Validation rules for model attributes
	 */
	protected static $_rules = array(
		'name' => 'required|unique:groups'
	);

	/**
	 * Save the model instance to the database.
	 *
	 * @return bool
	 */
	public function save()
	{
		// first check if we want timestamps as this will append to attributes
		if (static::$_timestamps)
		{
			$this->timestamp();
		}

		// now we grab the attributes
		$attributes = $this->attributes();

		// run validation if rules are set
		if ( ! empty(static::$_rules))
		{
			$validated = $this->run_validation($attributes, static::$_rules);

			if ( ! $validated )
			{
				return false;
			}
		}

		// prep attribute values after validation is done
		$attributes = $this->prep_attributes($attributes);

		// If the model exists, we only need to update it in the database, and the update
		// will be considered successful if there is one affected row returned from the
		// fluent query instance. We'll set the where condition automatically.
		if ( ! $this->is_new())
		{
			// make sure a key is set then grab and remove it from the attributes array
			if ( ! isset($attributes[static::key()]) or empty($attributes[static::key()]))
			{
				// the key is not set or empty, throw an exception
				throw new \Exception('A primary key is required to update.');
			}

			// grab the key and remove it from the attributes array
			$key = $attributes[static::key()];
			unset($attributes[static::key()]);

			try
			{
				list($query, $attributes) = $this->before_update(null, $attributes);
				$result = Sentry::group((int) $key)->update($attributes) === true;
				$result = $this->after_update($result);

				if (static::$_events)
				{
					// fire update event
					Event::fire(static::event().'.update', array($this));
				}
			}
			catch (SentryException $e)
			{
				throw new \Exception($e->getMessage());
			}

		}

		// If the model does not exist, we will insert the record and retrieve the last
		// insert ID that is associated with the model. If the ID returned is numeric
		// then we can consider the insert successful.
		else
		{
			try
			{
				list($query, $attributes) = $this->before_insert(null, $attributes);
				$result = Sentry::group()->create($attributes);
				$result = $this->after_insert($result);

				$attributes['id'] = (int) $result;
				$this->fill($attributes);

				$this->is_new( ! (bool) $result);

				if (static::$_events)
				{
					// fire create event
					Event::fire(static::event().'.create', array($this));
				}
			}
			catch (SentryException $e)
			{
				return $e->getMessage();
			}

		}

		return $result;
	}

	/**
	 * Delete a model from the datatabase
	 *
	 * @return  bool
	 */
	public function delete()
	{
		// make sure a key is set then grab and remove it from the attributes array
		if ( ! isset($this->{static::key()}) or empty($this->{static::key()}))
		{
			// the key is not set or empty, throw an exception
			throw new \Exception('A primary key is required to delete.');
		}

		try
		{
			$this->before_delete(null);
			$result = Sentry::group($this->{static::key()})->delete();

			if (static::$_events)
			{
				// fire delete event
				Event::fire(static::event().'.delete', array($this));
			}

			return $this->after_delete($result);
		}
		catch(SentryException $e)
		{
			throw new \Exception($e->getMessage());
		}
	}

	/**
	 * Find a model by its primary key.
	 *
	 * @param  string  $id
	 * @param  array   $columns
	 * @return Model
	 */
	public static function find($id = null, $columns = null)
	{
		if ($id == null)
		{
			return array();
		}

		try
		{
			$group = Sentry::group((int) $id)->get($columns);

			return new static($group);
		}
		catch (SentryException $e)
		{
			return $e->getMessage();
		}
	}

	/**
	 * Find Custom
	 *
	 * @param  array  select
	 * @param  array  where
	 * @param  array  order by
	 * @param  int    take/limit
	 * @param  int    skip/offset
	 * @return object Model Object
	 */
	public static function find_custom($select, $where, $order_by, $take, $skip)
	{
		$model = new static;

		list($query, $select) = $model->before_find($model->query(), $select);

		if ( ! empty($where))
		{
			if (is_array($where[0]))
			{
				foreach ($where as $where)
				{
					$query = $query->where($where[0], $where[1], $where[2]);
				}
			}
			else
			{
				$where = $where;
				$query = $query->where($where[0], $where[1], $where[2]);
			}
		}

		if ( is_array($order_by))
		{
			foreach ($order_by as $_field => $_direction)
			{
				$query = $query->order_by($_field, $_direction);
			}
		}
		else
		{
			$query = $query->order_by($order_by);
		}

		if ($take !== null)
		{
			$query = $query->take($take)->skip($skip);
		}

		$result = $query
			->get($select);

		$models = array();
		foreach($result as $r)
		{
			$models[] = new static($r, true);
		}

		return $model->after_find($models);
	}

	/**
	 * Gets called before the validation is ran.
	 *
	 * @param   array  $data  The validation data
	 * @return  array
	 */
	protected function before_validation($data, $rules)
	{
		if ( ! $this->is_new())
		{
			// add id to the unique clause to prevent errors if same email
			$rules['name'] .= ',name,'.$data['id'];

			// if password is empty, remove it from rules and dataset, not updating
			if (empty($data['password']))
			{
				unset($rules['password']);
			}
		}

		if (isset($data['id']) and isset($data['permissions']) and count($data) == 2)
		{
			$rules = array();
		}

		return array($data, $rules);
	}

}
