<?php
class Model_Auth extends Model {
	
	const user_session = 'user';
	
	static public function is_logged_in()
	{
		$session = Session::instance(); 
		$token = $session->get('token', null);
		if (empty($token))
		{
			return false;
		}
		
		return true;
	}
	
	/**
	 * User login 
	 * @param String $login
	 * @param String $password
	 * @return String (token)
	 */
	static public function login($login, $password)
	{
		if (empty($login) || empty($password))
		{
			return false;
		}
		$user = Model_User::checkLoginPassword($login, $password);
		if ($user == null)
		{
			return false;
		}
		$token = Model_User::createToken($user->id);
		if (empty($token))
		{
			return false;
		}
		$session = Session::instance();
		$session->set('user', $user);
		$session->set('token', $token);
		return $token;
			
	}
	
	static public function logout()
	{
		$session = Session::instance();
		$token = $session->get('token', null);
		if (empty($token))
		{
			return true;
		}
		Model_User::removeToken($token);
		$session->destroy();
		
		return true;
	}
	
}