<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Admin_Cms {
	 
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
			
		$query = Model_User::getListQuery();
		$search = array('login'); // set on which column(s) you want to search
		$sort = array('login' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
		$this->template->body = View::factory('admin/users/index');
		$this->template->body->pagination = new Automatify($query, $search, $sort);
	}
	
	/**
	 * Show admin panel
	 */
	public function action_edit()
	{
		$this->setMetatags();
		$user_id = Request::current()->param('id', null);
		if (!$user_id)
		{
			Request::current()->redirect('admin/users');
		}
		$user = Model_User::getById($user_id);
		if (!$user)
		{
			Request::current()->redirect('admin/users');
		}
		
		if (Request::current()->method() == 'POST')
		{
			unset($_POST['submit']);
			$result = Model_User::save($_POST, $user_id);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messageUserSaved', array('login' => $_POST['login'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/users');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/users/edit')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/users/edit')->bind('data',$user)->bind('errors', $errors);
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
			$result = Model_User::save($_POST);
			if (is_bool($result) && $result)
			{
				Messenger::add(__('messageUserSaved', array('login' => $_POST['login'])), Messenger::TYPE_INFO);
				Request::current()->redirect('admin/users');
			}
			else
			{
				Messenger::add(__('messageFormErrors'), Messenger::TYPE_ERROR);
				$this->template->body = View::factory('admin/users/add')
					->bind('data',$_POST)
					->bind('errors', $result);
			}
		}
		else
		{
			$errors = null;
			$this->template->body = View::factory('admin/users/add')->bind('data',$page)->bind('errors', $errors);
		}
		
	}
	
        public function action_password()
        {
                $user_id = Request::current()->param('id', null);
		if (!$user_id)
		{
			Request::current()->redirect('admin/users');
		}
                $user = Model_User::getById($user_id);
                if (!$user)
                {
                        Request::current()->redirect('admin/users');
                }
		
                $password = Model_User::generatePassword();
		$result = Model_User::update(array('password' => sha1($password)), $user_id);
                
                			
                $data = array('PASS' => $password);
		$mail = array(
			'to' => $user['email'],
			'from' => Model_Mail::EMAIL_ADMIN,
			'content' => Model_Template::render('password', $data),
			'title' => 'Administracyjna zmiana hasła'
    		);
		Model_Mail::insert($mail);
                
                Messenger::add(__('messageUserAdminPassChange'), Messenger::TYPE_INFO);
		Request::current()->redirect('admin/users');
        }
        
	/**
	 * Show admin panel
	 */
	public function action_del()
	{
	
		$user_id = Request::current()->param('id', null);
		if (!$user_id)
		{
			Request::current()->redirect('admin/users');
		}
		
		$result = Model_User::deleteById($user_id);
		if ($result)
		{
			Messenger::add(__('messageUserDeleted'), Messenger::TYPE_INFO);
			Request::current()->redirect('admin/users');
		}
		else
		{
			// TODO : some shit has happen
			Request::current()->redirect('admin/users');
		}
	}

} 
