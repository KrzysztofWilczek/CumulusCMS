<?php
class Model_File extends Model {
	
	const TABLE_NAME = 'files';
	const TABLE_ARTICLES_FILES = 'articles_files';
	
	public static function fetchAll($page = null)
	{
		$query = DB::select('*')->from(self::TABLE_NAME);
		if ($page)
		{
			$query->offset(($page-1)*Constants::ITEMS_PER_PAGE)->limit(Constants::ITEMS_PER_PAGE);
		}
		
		$result = $query->as_object()->execute();
		return $result;
	}
	
        public static function bindToArticle($file_id, $article_id)
        {
                $query = DB::insert(self::TABLE_ARTICLES_FILES, array(
			'file_id', 'article_id'	
		))->values(array(
			$file_id, $article_id
		));
		$query->execute();
		return true;
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
		$now = date(Constants::DATE_FORMAT);
		if (!array_key_exists('insert_date', $data))
		{
			$data['insert_date'] = $now;
		}
		$query = DB::insert(self::TABLE_NAME, array(
			'name', 'path', 'insert_date', 'is_image'	
		))->values(array(
			$data['name'], $data['path'], $data['insert_date'], $data['is_image']
		));
		return $query->execute();
		
	}
	
	public static function update(array $data, $id)
	{
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$id);
		$query->execute();
		return true;
	}
	
        //TODO: change that (relations tables)
	public static function deleteById($id)
	{
		$query = DB::delete(self::TABLE_NAME)->where('id','=',$id);
		$query->execute();
		return true;
	}
	
}