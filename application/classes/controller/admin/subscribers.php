<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Subscribers extends Controller_Admin_Cms {
	 
	public function before() {
		parent::before();
		if(!Model_Auth::is_logged_in()) {
			Request::current()->redirect('admin/login');
		}
	}
	
	/**
	 * Show admin panel
	 */
	public function action_index()
	{		
		$page = Request::current()->param('page', 1);
		
		$this->setMetatags();
		
		$query = Model_Subscriber::getListQuery();
		$search = array('email'); // set on which column(s) you want to search
		$sort = array('email' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
		$this->template->body = View::factory('admin/subscribers/index');
		$this->template->body->pagination = new Automatify($query, $search, $sort);
	}
	
	/**
	 * Show admin panel
	 */
	public function action_del()
	{
	
		$id = Request::current()->param('id', null);
		if (!$id)
		{
			Request::current()->redirect('admin/subscribers');
		}
		
		$result = Model_Subscriber::deleteById($id);
		if ($result)
		{
			Messenger::add(__('messageSubscriberDeleted'), Messenger::TYPE_INFO);
			Request::current()->redirect('admin/subscribers');
		}
		else
		{
			// TODO : some shit has happen
			Request::current()->redirect('admin/subscribers');
		}
	}

} 
