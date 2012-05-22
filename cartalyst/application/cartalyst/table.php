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

/**
 * @author  Daniel Petrie
 */
class Table
{

	public static function query($query, $defaults, $paging = array())
	{
		$data = Input::get() + $defaults;

		extract($data);

		if ( isset($live_search) and ! empty($live_search))
		{
			// if search all was passed
			$query = static::build_query($live_search, $select, $query);
		}

		if ( ! empty($where))
		{
			// if search all was passed
			$query = static::build_query($where, $select, $query);
		}

		// set order by statements
		foreach ($order_by as $field => $dir)
		{
			$query = $query->order_by($field, $dir);
		}

		if (count($paging))
		{
			// set limit for paging
			$query = $query->take($paging['limit']);

			// set offset for paging
			$query = $query->skip($paging['offset']);
		}

		// set columsn to grab
		$columns = array();

		// alias columsn if the array and key exists
		if (array_key_exists('alias', $defaults))
		{
			foreach ($defaults['select'] as $key => $val)
			{
				if (array_key_exists($key, $defaults['alias']))
				{
					$columns[] = $key . ' as ' . $defaults['alias'][$key];
				}
				else
				{
					$columns[] = $key;
				}
			}
		}
		// alias isn't set, so just grab the keys
		else
		{
			$columns = array_keys($defaults['select']);
		}

		return array($query, $columns);
	}

	/**
	 * Get number of records with filtering
	 *
	 * @param   object  DB object
	 * @return  object  DB object
	 */
	public static function count($query, $defaults = array())
	{
		$where = Input::get('where');

		if ( ! empty($where))
		{
			if ( empty($defaults) )
			{
				$defaults['select'] = array();
			}
			$query = static::build_query($where, $defaults['select'], $query);
		}

		return $query;
	}

	public static function prep_paging($item_count, $threshold = 20)
	{
		$threshold   = 10;
		$where       = Input::get('where', null);
		$live_search = Input::get('live_search', null);
		$page        = Input::get('page', 1);
		$pages       = 10;

		if ($item_count > $threshold and ( count($where) or count($live_search) ))
		{
			// find offset and limit
			$limit = ceil( $item_count / $pages );

			// if the limit is less than threshold, set to limit to threshold to prevent uneccessary paging
			if ($limit < $threshold)
			{
				$limit = $threshold;
			}

			$offset = $limit * ( $page - 1 );
		}
		else
		{
			// otherwise use defaults
			$offset = 0;
			$limit  = $threshold;
		}

		return array(
			'limit'  => $limit,
			'offset' => $offset,
			'pages'  => $pages
		);
	}

	protected static function build_query(&$where, $select, $query)
	{
		// if search all was passed
		if (array_key_exists('search_all', $where))
		{
			if ( ! is_array($where['search_all']))
			{
				$where['search_all'] = array($where['search_all']);
			}
			// loop through search all array
			foreach($where['search_all'] as $search)
			{
				// split spaces into words
				$words = explode(' ', trim($search));

				// loop through all search words
				foreach ($words as $word)
				{
					// open a new and where clause for current search word
					if ( ! empty($select))
					{
						$query = $query->where(function($query) use($select, $word)
						{
							// find all columns selected and search for word
							foreach ($select as $col => $val)
							{
								$query = $query->or_where($col, 'like', '%'.$word.'%');
							}
						});
					}
				}
			}

			// remove search all from array to prevent searching later on
			unset($where['search_all']);
		}

		// set column specific filters
		foreach ($where as $col => $search)
		{
			// split spaces into words
			$words = explode(' ', trim($search));

			if ( ! empty($words))
			{
				// open a new and where clause for current search word
				$query = $query->where(function($query) use($col, $words) {

					// loop through all search words
					foreach ($words as $word)
					{
						$query = $query->where($col, 'like', '%'.$word.'%');
					}
				});
			}
		}

		return $query;
	}

}
