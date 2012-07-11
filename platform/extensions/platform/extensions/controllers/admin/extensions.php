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
		$this->active_menu('admin-extensions');
	}

	public function get_index()
	{
		// Get list of installed extensions in the system
		$installed = API::get('extensions/installed');

		// Get list of uninstalled extensions in the system
		$uninstalled = API::get('extensions/uninstalled', array(
			'detailed' => true,
		));

		// check for updates on installed extensions
		$installed = API::get('extensions/updates', array(
			'extensions' => $installed,
		));

		$data = array(
			// 'columns'     => $datatable['columns'],
			// 'rows'        => $datatable['rows'],
			'installed'   => $installed,
			'uninstalled' => $uninstalled,
		);

		return Theme::make('extensions::index', $data);
	}

	public function get_install($slug)
	{
		$result = API::post('extensions/install', array('slug' => $slug));

		if ( ! $result['status'])
		{
			Platform::messages()->error($result['message']);
		}

		return Redirect::to_secure(ADMIN.'/extensions');
	}

	public function get_uninstall($id)
	{
		$result = API::post('extensions/uninstall', array('id' => $id));

		if ( ! $result['status'])
		{
			Platform::messages()->error($result['message']);
		}

		return Redirect::to_secure(ADMIN.'/extensions');
	}

	public function get_enable($id)
	{
		$result = API::post('extensions/enable', array('id' => $id));

		if ( ! $result['status'])
		{
			Platform::messages()->error($result['message']);
		}

		return Redirect::to_secure(ADMIN.'/extensions');
	}

	public function get_disable($id)
	{
		$result = API::post('extensions/disable', array('id' => $id));

		if ( ! $result['status'])
		{
			Platform::messages()->error($result['message']);
		}

		return Redirect::to_secure(ADMIN.'/extensions');
	}

	public function get_update($id)
	{
		$result = API::post('extensions/update', array('id' => $id));

		if ( ! $result['status'])
		{
			Platform::messages()->error($result['message']);
		}

		return Redirect::to_secure(ADMIN.'/extensions');
	}

}
