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

class Extensions_Admin_Extensions_Controller extends Admin_Controller
{
	/**
	 * This function is called before the action is executed.
	 *
	 * @return void
	 */
	public function before()
	{
		parent::before();
		$this->active_menu('extensions');
	}

	public function get_index()
	{
		// Grab our datatable
		$datatable = API::get('extensions/datatable');

		// Get list of uninstalled extensions in the system
		$uninstalled = API::get('extensions/uninstalled', array(
			'detailed' => true,
		));

		$data = array(
			'columns'     => $datatable['columns'],
			'rows'        => $datatable['rows'],
			'uninstalled' => $uninstalled,
		);

		// If this was an ajax request, only return the body of the datatable
		if (Request::ajax())
		{
			return json_encode(array(
				'content'        => Theme::make('extensions::partials.table_extensions', $data)->render(),
				'count'          => $datatable['count'],
				'count_filtered' => $datatable['count_filtered'],
				'paging'         => $datatable['paging'],
			));
		}

		return Theme::make('extensions::index', $data);
	}

	public function get_install($slug)
	{
		$result = API::post('extensions/install', array('slug' => $slug));

		return Redirect::to(ADMIN.'/extensions');
	}

	public function get_uninstall($id)
	{
		$result = API::post('extensions/uninstall', array('id' => $id));

		if ( ! $result['status'])
		{
			Cartalyst::messages()->error($result['message']);
		}

		return Redirect::to(ADMIN.'/extensions');
	}

	public function get_enable($id)
	{
		API::post('extensions/enable', array('id' => $id));

		return Redirect::to(ADMIN.'/extensions');
	}

	public function get_disable($id)
	{
		API::post('extensions/disable', array('id' => $id));

		return Redirect::to(ADMIN.'/extensions');
	}

}
