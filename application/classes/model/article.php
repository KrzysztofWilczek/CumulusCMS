<?php
class Model_Article extends Model {
	
	const TABLE_NAME = 'articles';
	const FILES_LIST_VIEW = 'articles_files_list';
	const ARTICLES_LIST_VIEW = 'articles_list';
	
	public static function getFilePath($article_id, $absolute = true)
	{
		$path = '/upload/articles';
		if ($absolute)
		{
			$path = DOCROOT . substr($path, 1, strlen($path)-1);
		}
		if (!is_dir($path) && $absolute)
		{
			@mkdir($path);
			@chmod($path, 0777);
		}
		if ($article_id)
		{
			$path .= '/'.$article_id;
		}
		
		if (!is_dir($path) && $absolute)
		{
			@mkdir($path);
			@chmod($path, 0777);
		}
		
		return $path.'/';
	}
	
	public static function fetchAllFiles($artilce_id)
	{
		$query = DB::select('*')->from(self::FILES_LIST_VIEW)->where('article_id','=',$artilce_id);
		$result = $query->as_object()->execute();
		return $result;
	}
	
	public static function getListQuery()
	{
		$query = DB::select('*')->from(self::ARTICLES_LIST_VIEW);
		return $query;
	}
	
	public static function fetchAll($page = null)
	{
		$query = DB::select('*')->from(self::ARTICLES_LIST_VIEW);
		if ($page)
		{
			$query->offset(($page-1)*Constants::ITEMS_PER_PAGE)->limit(Constants::ITEMS_PER_PAGE);
		}
		
		$result = $query->as_object()->execute();
		return $result;
	}
	
	public static function uploadFiles($article_id)
	{
		$path = self::getFilePath($article_id);
		for($i = 0;$i <= count($_FILES['files']['name']);$i++)
		{
			if (@move_uploaded_file($_FILES['files']['tmp_name'][$i], $path . $_FILES['files']['name'][$i]))
			{
				$data = array();
				$data['name'] = $_FILES['files']['name'][$i];
				$data['path'] = $_FILES['files']['name'][$i];
				$data['is_image'] =0;
				
				if (getimagesize($path. $_FILES['files']['name'][$i]))
				{
					$data['is_image'] =1;	
				}
				
				$result = Model_File::insert($data);
				
				if ($result[0])
				{
					Model_File::bindToArticle($result[0], $article_id);
				}
					
			}
		}
		
	}
	
	public static function save(array $data, $id = null)
	{
		$validators = Validation::factory($data)
			->rules('title', array(array('not_empty')))
			->labels(array(
				'title'=>'Tytuł',
			));
		if ($validators->check())
		{
			
			if (!$id)
			{
				$result = self::insert($data);
				if ($result[0])
				{
					self::uploadFiles($result[0]);
					return true;
				}
			}
			else
			{
				
				$result = self::update($data, $id);
				self::uploadFiles($id);
				return $result;
			}
		}
		else 
		{
			return $validators->errors();
		}
		
	}
	
	public static function fetchAllPublished()
	{
		$query = DB::select('*')->from(self::TABLE_NAME)
			->where('publication_date','<=',date('Y-m-d H:i:s'))
			->where('is_published','=',1)
			->where('is_removed','=',0);
		$result = $query->as_object()->execute();
		return $result;
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
	
	public static function insert(array $data)
	{
		// Get current time
		$now = date('Y-m-d H:i:s');
		$user_id = Session::instance()->get('user')->id;
		if (!array_key_exists('is_published', $data))
		{
			$data['is_published'] = 0;
		}
		$query = DB::insert(self::TABLE_NAME, array(
			'title', 'brief', 'content', 'publication_date', 'insert_date', 'modification_date', 'author', 'user_id', 'is_published'	
		))->values(array(
			$data['title'], $data['brief'], $data['content'], $data['publication_date'], $now, $now, $data['author'], $user_id, $data['is_published']
		));
		return $query->execute();
		
	}
	
	public static function update(array $data, $id)
	{
		$files_list = '';
		if (!empty($data['attached']))
		{
		foreach($data['attached'] as $file)
		{
			$files_list .= $file.', ';
		}
		}
		$files_list = substr($files_list,0, strlen($files_list)-2);
		if (!empty($files_list))
		{
			$where = 'AND file_id NOT IN ('.$files_list.')';
		}
		$query = DB::query(Database::DELETE, 'DELETE FROM articles_files WHERE article_id = '.$id.' '.$where);
		$query->execute();
		unset($data['attached']);
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$id);
		$query->execute();
		return true;
	}
	
	public static function deleteById($id)
	{
		$query = DB::delete(self::TABLE_NAME)->where('id','=',$id);
		$query->execute();
		return true;
	}
	
}