<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Newsletters extends Controller_Admin_Cms {
	 
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
		
		$query = Model_Newsletter::getListQuery();
		$search = array('title'); // set on which column(s) you want to search
		$sort = array('id' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
		$this->template->body = View::factory('admin/newsletters/index');
		$this->template->body->pagination = new Automatify($query, $search, $sort);
	}
	
	/**
	 * Show admin panel
	 */
	public function action_edit()
	{
		$this->setMetatags();
		$newsletter_id = Request::current()->param('id', null);
		if (!$newsletter_id)
		{
			Request::current()->redirect('admin/newsletter');
		}
		$newsletter = Model_Newsletter::getById($newsletter_id);
		if (!$newsletter)
		{
			Request::current()->redirect('admin/newsletter');
		}
		
		if (Request::current()->method() == 'POST')
		{
			unset($_POST['submit']);
			$result = Model_Newsletter::save($_POST, $newsletter_id);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messageNewsletterSaved', array('title' => $_POST['title'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/newsletter');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/newsletters/edit')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/newsletters/edit')->bind('data',$newsletter)->bind('errors', $errors);
		}
		
	}
	
	public function action_test()
	{
		$newsletter_id = Request::current()->param('id', null);
		if (!$newsletter_id)
		{
			Request::current()->redirect('admin/newsletter');
		}
		$newsletter = Model_Newsletter::getById($newsletter_id);
		if (!$newsletter)
		{
			Request::current()->redirect('admin/newsletter');
		}
	
		$swiftMail = email::connect();

		$message = new Swift_Message();
		$message->setFrom(Model_Mail::EMAIL_ADMIN);
		$message->setBody($newsletter['content'],'text/html');
		$message->setTo(array(Model_Mail::EMAIL_ADMIN));
		$message->setSubject($newsletter['title']);
			
		$result = $swiftMail->send($message);
		if ($result)
		{
			Messenger::add(__('messageNewsletterTest', array('title' => $newsletter['title'], 'email' => Model_Mail::EMAIL_ADMIN)), Messenger::TYPE_INFO);	
		}
		
		Request::current()->redirect('admin/newsletter');
	}
	
	public function action_send()
	{
		$newsletter_id = Request::current()->param('id', null);
		if (!$newsletter_id)
		{
			Request::current()->redirect('admin/newsletter');
		}
		$newsletter = Model_Newsletter::getById($newsletter_id);
		if (!$newsletter)
		{
			Request::current()->redirect('admin/newsletter');
		}
		
		$result = Model_Newsletter::update(array('is_sent'=>1), $newsletter_id);
		Messenger::add(__('messageNewsletterSend', array('title' => $newsletter['title'])), Messenger::TYPE_INFO);
		Request::current()->redirect('admin/newsletter');
		
	}
	
	public function action_copy()
	{
		$newsletter_id = Request::current()->param('id', null);
		if (!$newsletter_id)
		{
			Request::current()->redirect('admin/newsletter');
		}
		$newsletter = Model_Newsletter::getById($newsletter_id);
		if (!$newsletter)
		{
			Request::current()->redirect('admin/newsletter');
		}
		
		$result = Model_Newsletter::copy($newsletter_id);
		Messenger::add(__('messageNewsletterCopy', array('title' => $newsletter['title'])), Messenger::TYPE_INFO);
		Request::current()->redirect('admin/newsletter/edit/'.$result[0]);
		
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
			$result = Model_Newsletter::save($_POST);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messageNewsletterSaved', array('title' => $_POST['title'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/newsletter');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/newsletters/add')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/newsletters/add')->bind('data',$page)->bind('errors', $errors);
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
			Request::current()->redirect('admin/newsletter');
		}
		
		$result = Model_Newsletter::deleteById($id);
		if ($result)
		{
			Messenger::add(__('messageNewsletterDeleted'), Messenger::TYPE_INFO);
			Request::current()->redirect('admin/newsletter');
		}
		else
		{
			// TODO : some shit has happen
			Request::current()->redirect('admin/newsletter');
		}
	}

} 
