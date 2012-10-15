<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Auth extends Controller_Admin_Cms {
	
	public $template = 'admin/auth';
	
	/**
	 * Standard admin login
	 */
	public function action_login()
	{
		$this->setMetatags();
		
		// If user is logged in and try login logout him first
		if(Model_Auth::is_logged_in()) 
		{
			Model_Auth::logout();
		}

		$login = null; $password = null;
		if (Request::current()->method() == 'POST')
		{
			$login = Request::current()->post('login');
			$password = Request::current()->post('password');

			if (empty($login) || empty($password))
			{
				Messenger::add(__('messageFullfill'), Messenger::TYPE_ERROR);
			}
			else
			{
				if (Model_Auth::login($login, $password))
				{
					$url = Session::instance()->get('url', 'admin/index');
					Messenger::add(__('messageLogged'), Messenger::TYPE_INFO);
					Request::current()->redirect('http://'.$_SERVER['HTTP_HOST'].'/'.$url);
				}
				else
				{
					Messenger::add(__('messageWrongLoginData'), Messenger::TYPE_ERROR);
				}
			}
		}
	
		$data = array('login'=>$login, 'password'=>'');
		$this->template->body = View::factory('admin/login')->bind('data', $data);
		
	}

	/**
	 * User logout action
	 */
	public function action_logout()
	{
		Model_Auth::logout();
		Messenger::add(__('messageLogout'), Messenger::TYPE_INFO);
		Request::current()->redirect('admin/login');
	}
	
	public function action_restore()
	{
		// Get login and password
		$login = Request::current()->param('login', null);
		$password = Request::current()->param('password', null);
		if (empty($login) || empty($password))
		{
			Request::current()->redirect('admin/login');	
		}
		
		if (Model_User::restorePassword($password, $login))
		{
			Messenger::add(__('messagePasswordChanged'), Messenger::TYPE_INFO);
		}
		else
		{
			Messenger::add(__('messagePasswordChangeFail'), Messenger::TYPE_ERROR);
		}
		Request::current()->redirect('admin/login');
	}
	
	/**
	 * User forgot password, we create new and send him an e-mail message
	 */
	public function action_forgot()
	{
		$this->setMetatags();
		if (Request::current()->method() == 'POST')
		{
			$login = Request::current()->post('login');
		
			if (empty($login))
			{
				Messenger::add(__('messageFullfill'), Messenger::TYPE_ERROR);
			}
			else
			{
				$user = Model_User::checkLogin($login);
				if ($user)
				{
					$password = Model_User::generatePassword();
					
					$link = 'http://'.$_SERVER['HTTP_HOST'].'/'.Route::get('auth')->uri(array(
						'controller' => 'auth', 
						'action'     => 'restore', 
						'login'         =>  $login,
						'password'	=> sha1($password)));
					
					$data = array('PASS' => $password, 'LINK_ACTIVATE' => $link);
					$mail = array(
						'to' => $user->email,
						'from' => Model_Mail::EMAIL_ADMIN,
						'content' => Model_Template::render('forgot', $data),
						'title' => 'Przypomnienie hasła'
					);
					Model_Mail::insert($mail);
					Model_User::setNewPassword(sha1($password), $user->id);
					Messenger::add(__('messageForgot'), Messenger::TYPE_INFO);
				}
				else
				{
					Messenger::add(__('messageWrongLogin'), Messenger::TYPE_ERROR);
				}
			}
		}
	
		
		$this->template->body = View::factory('admin/forgot');
	}
} 
