<?php
class Model_User extends Model {
	
	const TABLE_NAME = 'users';
	
	const ROLE_GUEST = 1;
        const ROLE_USER = 2;
        const ROLE_ADMIN = 3;
        
        public static $rolesNames = array(
            self::ROLE_GUEST => 'Gość',
            self::ROLE_USER => 'Użytkownik',
            self::ROLE_ADMIN => 'Administrator'
        );
	
	public static function getAvatarPath($user_id, $absolute = true)
	{
		$path = '/upload/users';
		if ($absolute)
		{
			$path = DOCROOT . substr($path, 1, strlen($path)-1);
		}
		if (!is_dir($path) && $absolute)
		{
			mkdir($path);
			chmod($path, 0777);
		}
		
		return $path.'/';
	}
	
	public static function fetchAll($page = null)
	{
		$query = DB::select('*')->from(self::TABLE_NAME)->where('is_removed','=',0);
		if ($page)
		{
			$query->offset(($page-1)*Constants::ITEMS_PER_PAGE)->limit(Constants::ITEMS_PER_PAGE);
		}
		
		$result = $query->as_object()->execute();
		return $result;
	}
	
	public static function getListQuery()
	{
		$query = DB::select('*')->from(self::TABLE_NAME);
		$query->where('is_removed','=',0);
		return $query;
	}
	public static function getById($id)
	{
		if (!$id)
		{
			return;
		}
		
		$query = DB::select('*')->from(self::TABLE_NAME)->where('id','=',$id);
		$result = $query->execute();
		if(count($result)>0) {
			return $result[0];
		}
		return;
	}
	
	
	public static function checkLoginPassword($login, $password)
	{
		$query = DB::query(Database::SELECT, 'SELECT * FROM '.self::TABLE_NAME.' WHERE (login = \''.$login.'\' OR email = \''.$login.'\') AND password = \''.sha1($password).'\' AND is_removed = 0');
		$result = $query->as_object()->execute();
		if (!$result->count())
		{
			return null;
		}
		else
		{
			return $result[0];
		}
	}	
	
	public static function save(array $data, $id = null)
	{
		
		$validators = Validation::factory($data);
		$validators->rule('login', 'not_empty');
		$validators->rule('email', 'email');
		
		if (!$id)
		{
			$validators->rule('password', 'not_empty');
			$validators->rule('password', 'min_length', array(':value', '6'));
			$validators->rule('password_repeat',  'matches', array(':validation', 'password_repeat', 'password'));
				
		}
		$files = Validation::factory( $_FILES );
			
		if ($validators->check())
		{
			$data['avatar'] = $files['avatar']['name'];
			
			if (!$id)
			{
				$result = self::insert($data);
				if ($result[0])
				{
					$path = self::getAvatarPath($result[0]);
					$filename = upload::save($files['avatar'], $files['avatar']['name'], $path);
					return true;
				}
				
			}
			else
			{
				$files = Validation::factory( $_FILES );
				$path = self::getAvatarPath($id);
				$filename = upload::save($files['avatar'], $files['avatar']['name'], $path);
				return self::update($data, $id);
			}
		}
		else 
		{
			return $validators->errors();
		}
		
	}
	
	public static function insert(array $data)
	{
		// Get current time
		$now = date('Y-m-d H:i:s');

		$query = DB::insert(self::TABLE_NAME, array(
			'login', 'password', 'registration_date', 'modification_date', 'role', 'avatar'
		))->values(array(
			$data['login'], sha1($data['password']), $now, $now, $data['role'], $data['avatar']
		));
		return $query->execute();
		
	}
	
	public static function update(array $data, $id)
	{
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$id);
		$query->execute();
		return true;
	}
	public static function setNewPassword($password, $user_id)
	{
		self::update(array('password_new'=>$password),$user_id);	
	}
	
	public static function restorePassword($password, $login)
	{
		$user = self::checkLogin($login);
		if (!$user)
		{
			return false;
		}
		if ($user->password_new != $password)
		{
			return false;
		}
		self::update(array('password'=>$password, 'password_new'=>null),$user->id);
		return true;
	}
	
	/**
	 * Generate random password
	 * @return string $password
	 **/
	public static function generatePassword($length = 8)
	{
		$chars = "23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ";
		$i = 0;
		$password = '';

		while ($i < $length)
		{
			$password .= $chars{mt_rand(0,mb_strlen($chars))};
			$i++;
		}
		return $password;
	}
	
	public static function checkLogin($login)
	{
		$query = DB::query(Database::SELECT, 'SELECT * FROM '.self::TABLE_NAME.' WHERE (login = \''.$login.'\' OR email = \''.$login.'\') AND is_removed = 0');
		$result = $query->as_object()->execute();
		if (!$result->count())
		{
			return null;
		}
		else
		{
			return $result[0];
		}
	}
	
	public static function createToken($user_id)
	{
		$token = sha1(date('Y-m-d h:s:i'));
		DB::update(self::TABLE_NAME)->set(array('token' => $token))->where('id','=',$user_id);
		return $token;
	}
	
	public static function removeToken($token)
	{
		DB::update(self::TABLE_NAME)->set(array('token' => ''))->where('token','=',$token);
		
	}
}