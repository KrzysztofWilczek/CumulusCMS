<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Articles extends Controller_Admin_Cms {
	 
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
		
		$query = Model_Article::getListQuery();
		$search = array('title'); // set on which column(s) you want to search
		$sort = array('id' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
		$this->template->body = View::factory('admin/articles/index');
		$this->template->body->pagination = new Automatify($query, $search, $sort);
	}
	
	/**
	 * Show admin panel
	 */
	public function action_edit()
	{
		$this->setMetatags();
		$article_id = Request::current()->param('id', null);
		if (!$article_id)
		{
			Request::current()->redirect('admin/articles');
		}
		$article = Model_Article::getById($article_id);
		if (!$article)
		{
			Request::current()->redirect('admin/articles');
		}
		
		if (Request::current()->method() == 'POST')
		{
			//TODO : get and save $_FILES
			unset($_POST['submit']);
			$result = Model_Article::save($_POST, $article_id);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messageArticleSaved', array('title' => $_POST['title'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/articles');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/articles/edit')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$files = Model_Article::fetchAllFiles($article_id);
			$this->template->body = View::factory('admin/articles/edit')->bind('files',$files)->bind('data',$article)->bind('errors', $errors);
		}
		
	}
	
	/**
	 * Add new article
	 */
	public function action_add()
	{
		$this->setMetatags();
	
		if (Request::current()->method() == 'POST')
		{
			unset($_POST['submit']);
			$result = Model_Article::save($_POST);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messageArticleSaved', array('title' => $_POST['title'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/articles');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/articles/add')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/articles/add')->bind('data',$page)->bind('errors', $errors);
		}
		
	}
	
	/**
	 * Show admin panel
	 */
	public function action_del()
	{
	
		$article_id = Request::current()->param('id', null);
		if (!$article_id)
		{
			Request::current()->redirect('admin/articles');
		}
		
		$result = Model_Article::deleteById($article_id);
		if ($result)
		{
			Messenger::add(__('messageArticleDeleted'), Messenger::TYPE_INFO);
			Request::current()->redirect('admin/articles');
		}
		else
		{
			// TODO : some shit has happen
			Request::current()->redirect('admin/articles');
		}
	}

} 
