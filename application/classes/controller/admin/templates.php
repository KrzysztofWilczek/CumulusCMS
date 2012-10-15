<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Templates extends Controller_Admin_Cms {
	 
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
		
		$query = Model_Template::getListQuery();
		$search = array('name'); // set on which column(s) you want to search
		$sort = array('name' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
		$this->template->body = View::factory('admin/templates/index');
		$this->template->body->pagination = new Automatify($query, $search, $sort);
	}
	
	/**
	 * Show admin panel
	 */
	public function action_edit()
	{
		$this->setMetatags();
		$id = Request::current()->param('id', null);
		if (!$id)
		{
			//Messenger::add('Nie podano ID szablonu', Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/templates');
		}
		$template = Model_Template::getById($id);
		if (!$template)
		{			
			//Messenger::add('Szablon o podany ID nie istnieje', Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/templates');
		}
		
		if (Request::current()->method() == 'POST')
		{
			unset($_POST['submit']);
			$result = Model_Template::save($_POST, $id);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messageTemplateSaved', array('name' => $_POST['name'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/templates');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/templates/edit')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/templates/edit')->bind('data',$template)->bind('errors', $errors);
		}
		
	}
	
	/**
	 * Show admin panel
	 */
	public function action_del()
	{
		$id = Request::current()->param('id', null);
		if (!$id)
		{
			Request::current()->redirect('admin/templates');
		}
		$template = Model_Page::getById($id);
		if (!$template)
		{
			Request::current()->redirect('admin/templates');
		}
		if (!$template['is_removable'])
		{
			Messenger::add(__('messageTemplateIrremovable'), Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/templates');
		}
		if (Model_Template::deleteById($id))
		{
			Messenger::add(__('messageTemplateDeleted'), Messenger::TYPE_INFO);
			Request::current()->redirect('admin/templates');
		}
		
	}

} 
