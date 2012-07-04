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

class Books_Admin_Books_Controller extends Admin_Controller
{

	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();
		$this->active_menu('books-list');
	}

	public function get_index()
	{
		// Grab our datatable
		$datatable = API::get('books/datatable', Input::get());

		$data = array(
			'columns' => $datatable['columns'],
			'rows'    => $datatable['rows'],
		);

		// If this was an ajax request, only return the body of the datatable
		if (Request::ajax())
		{
			return json_encode(array(
				'content'        => Theme::make('books::partials.table_books', $data)->render(),
				'count'          => $datatable['count'],
				'count_filtered' => $datatable['count_filtered'],
				'paging'         => $datatable['paging'],
			));
		}

		return Theme::make('books::index', $data);
	}

	public function get_create()
	{
		return $this->get_edit();
	}

	public function get_edit($id = false)
	{
		$book = API::get('books/book', array(
			'id' => $id,
		));

		return Theme::make('books::edit')
		            ->with('book', $book)
		            ->with('book_id', (isset($book['id']) and $book['id']) ? $book['id'] : false);
	}

	public function post_edit($id = false)
	{
		$result = API::post('books/book', array_merge(array(
			'id' => $id,
		), Input::get()));

		if ( ! $result['status'])
		{
			Platform::messages()->error($result['message']);
		}

		return Redirect::to(ADMIN.'/books');
	}

}
