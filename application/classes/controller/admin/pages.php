<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Pages extends Controller_Admin_Cms {
	 
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
	
		$query = Model_Page::getListQuery();
		$search = array('title'); // set on which column(s) you want to search
		$sort = array('id' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
		$this->template->body = View::factory('admin/pages/index');
		$this->template->body->pagination = new Automatify($query, $search, $sort);
	}
	
	/**
	 * Show admin panel
	 */
	public function action_add()
	{
		$this->setMetatags();
		
		if (Request::current()->method() == 'POST')
		{
			unset($_POST['submit']);
			$result = Model_Page::save($_POST);
			var_dump($result);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messagePageSaved', array('title' => $_POST['title'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/pages');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/pages/add')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/pages/add')->bind('data',$page)->bind('errors', $errors);
		}
		
	}
	
	/**
	 * Show admin panel
	 */
	public function action_edit()
	{
		$this->setMetatags();
		$page_id = Request::current()->param('id', null);
		if (!$page_id)
		{			
			Request::current()->redirect('admin/pages');
		}
		$page = Model_Page::getPageById($page_id);
		if (!$page)
		{
			Request::current()->redirect('admin/pages');
		}
		
		if (Request::current()->method() == 'POST')
		{
			unset($_POST['submit']);
			$result = Model_Page::save($_POST, $page_id);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messagePageSaved', array('title' => $_POST['title'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/pages');
			}
			else
			{
				Messenger::add(__('messageFromErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/pages/edit')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/pages/edit')->bind('data',$page)->bind('errors', $errors);
		}
		
	}
	
	/**
	 * Show admin panel
	 */
	public function action_del()
	{
		$page_id = Request::current()->param('id', null);
		if (!$page_id)
		{
			Request::current()->redirect('admin/pages');
		}
		$page = Model_Page::getPageById($page_id);
		if (!$page)
		{
			Request::current()->redirect('admin/pages');
		}
		if (!$page['is_removable'])
		{
			Messenger::add(__('messagePageIrremovable'), Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/pages');
		}
		if (Model_Page::deletePageById($page_id))
		{
			Messenger::add(__('messagePageDeleted'), Messenger::TYPE_INFO);
			Request::current()->redirect('admin/pages');
		}
		
	}

} 
