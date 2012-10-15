<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Objects extends Controller_Admin_Cms {
	 
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
		$objects = Model_Object::fetchAll();
		
		$pagination = Pagination::factory(array(
			'current_page'   => array('source' => 'route', 'key' => 'page'), // route
			'total_items'    => count($objects),
			'items_per_page' => Constants::ITEMS_PER_PAGE
		));
		
		$objects = Model_Object::fetchAll($page);
		$this->template->body = View::factory('admin/objects/index')
			->bind('pages', $objects)
			->bind('pagination', $pagination);
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
				Messenger::add('Strona pt. '.$_POST['title'].' została zapisana', Messenger::TYPE_INFO);
				Request::current()->redirect('admin/pages');
			}
			else
			{
				Messenger::add('Wystąpiły błędy w formularzu', Messenger::TYPE_ERROR);
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
			Messenger::add('Nie podano ID podstrony', Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/pages');
		}
		$page = Model_Page::getPageById($page_id);
		if (!$page)
		{
			Messenger::add('Strona o podany ID nie istnieje', Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/pages');
		}
		
		if (Request::current()->method() == 'POST')
		{
			unset($_POST['submit']);
			$result = Model_Page::save($_POST, $page_id);
			if (is_bool($result) && $result)
			{
				Messenger::add('Strona pt. '.$_POST['title'].' została zapisana', Messenger::TYPE_INFO);
				Request::current()->redirect('admin/pages');
			}
			else
			{
				Messenger::add('Wystąpiły błędy w formularzu', Messenger::TYPE_ERROR);
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
			Messenger::add('Nie podano ID podstrony', Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/pages');
		}
		$page = Model_Page::getPageById($page_id);
		if (!$page)
		{
			Messenger::add('Strona o podany ID nie istnieje', Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/pages');
		}
		if (!$page['is_removable'])
		{
			Messenger::add('Strona nie może zostać usunięta', Messenger::TYPE_ERROR);
			Request::current()->redirect('admin/pages');
		}
		if (Model_Page::deletePageById($page_id))
		{
			Messenger::add('Wybrana podstrona została usunięta', Messenger::TYPE_INFO);
			Request::current()->redirect('admin/pages');
		}
		
	}

} 
