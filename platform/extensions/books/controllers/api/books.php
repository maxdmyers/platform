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

use Books\Book;

class Books_Api_Books_Controller extends API_Controller
{

	public function get_datatable()
	{
		$defaults = array(
			'select'   => array(
				'id'          => Lang::line('books::books.general.id')->get(),
				'title'       => Lang::line('books::books.general.book_title')->get(),
				'author'      => Lang::line('books::books.general.author')->get(),
				'description' => Lang::line('books::books.general.book_description')->get(),
				'year'        => Lang::line('books::books.general.year')->get(),
			),
			'where'    => array(),
			'order_by' => array('id' => 'desc'),
		);

		// lets get to total book count
		$count_total = Book::count();

		// get the filtered count
		// we set to distinct because a book can be in multiple groups
		$count_filtered = Book::count_distinct('id', function($query) use ($defaults)
		{
			// sets the where clause from passed settings
			$query = Table::count($query, $defaults);

			return $query;
		});

		// set paging
		$paging = Table::prep_paging($count_filtered, 20);

		$items = Book::all(function($query) use ($defaults, $paging)
		{
			list($query, $columns) = Table::query($query, $defaults, $paging);

			return $query;
		});

		$items = ($items) ?: array();

		return array(
			'columns'        => $defaults['select'],
			'rows'           => $items,
			'count'          => $count_total,
			'count_filtered' => $count_filtered,
			'paging'         => $paging,
		);
	}

	public function get_book()
	{
		return ($book = Book::find(Input::get('id'))) ?: new Book();
	} 

	public function post_book()
	{
		$book = new Book(Input::get());
		$result = $book->save();

		if ($result)
		{
			return array('status' => true);
		}

		// $book->validation()->errors->all()

		return array(
			'status'  => false,
			'message' => 'Book failed to update.',
		);
	}

}
