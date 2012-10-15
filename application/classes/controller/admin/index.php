<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Index extends Controller_Admin_Cms {
	 
	public function before() {
		parent::before();
		if(!Model_Auth::is_logged_in()) {
			Request::current()->redirect('admin/login');
		}
	}
	
	public function action_index()
	{
		Request::current()->redirect('admin/home');
	}
	
	/**
	 * Show admin panel
	 */
	public function action_home()
	{
		//Request::current()->redirect('admin/pages');
		$this->setMetatags();
		$this->template->body = View::factory('admin/home');
	}

} 
