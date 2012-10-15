<?php
class Model_Comment extends Model {
	
	const TABLE_NAME = 'comments';
        const COMMENTS_LIST_VIEW = 'comments_list';
	
        const TYPE_ARTICLE = 1;
        const TYPE_PAGE = 2;
        const DEFAULT_TYPE = 1;
		
	public static function fetchAll($page = null, $resource_id = null, $resource_type = null)
	{
		$query = DB::select('*')->from(self::COMMENTS_LIST_VIEW);
		if ($resource_id && $resource_type)
		{
			$query->where('resource_type','=',$resource_type);
			$query->where('resource_id','=',$resource_id);
		}
		if ($page)
		{
			$query->offset(($page-1)*Constants::ITEMS_PER_PAGE)->limit(Constants::ITEMS_PER_PAGE);
		}
		
		$result = $query->as_object()->execute();
		return $result;
	}
	
	public static function getListQuery($resource_id = null, $resource_type = null)
	{
		$query = DB::select('*')->from(self::COMMENTS_LIST_VIEW);
		if ($resource_id && $resource_type)
		{
			$query->where('resource_type','=',$resource_type);
			$query->where('resource_id','=',$resource_id);
		}
		return $query;
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
                                return $result;
			}
			else
			{
				
				$result = self::update($data, $id);
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
		$query = DB::select('*')->from(self::COMMENTS_LIST_VIEW)
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
                // You cannot add comment to undefined resource id
		if (!array_key_exists('resource_id', $data))
                {
                    return;
                }
                if (!array_key_exists('resource_type', $data))
                {
                    $data['resource_type'] = self::DEFAULT_TYPE;
                }
		$now = date('Y-m-d H:i:s');
		$user_id = Session::instance()->get('user')->id;
		$query = DB::insert(self::TABLE_NAME, array(
			'content', 'insert_date', 'user_id', 'resource_id', 'resource_type'	
		))->values(array(
			$data['content'], $now, $user_id, $data['resource_id'], $data['resource_type']
		));
		return $query->execute();
		
	}
	
	public static function update(array $data, $id)
	{
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