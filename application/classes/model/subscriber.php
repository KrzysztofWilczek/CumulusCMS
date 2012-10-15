<?php
class Model_Subscriber extends Model {
	
	const TABLE_NAME = 'subscribers';
	
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
				return self::insert($data);
			}
			else
			{
				return self::update($data, $id);
			}
		}
		else 
		{
			return $validators->errors();
		}
		
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
	
		$query = DB::insert(self::TABLE_NAME, array(
			'title', 'content', 'send_date', 'insert_date', 'modification_date', 'user_id'	
		))->values(array(
			$data['title'], $data['content'], $data['send_date'], $now, $now, $user_id
		));
		$query->execute();
		return true;
	}
	
	public static function update(array $data, $id)
	{
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$id);
		$query->execute();
		return true;
	}
	
	public static function deleteById($id)
	{
                $query = DB::update(self::TABLE_NAME)->set(array('is_removed' => true))->where('id','=',$id);
		$query->execute();
		Model_Newsletter::clearQueueBySubscriberId($id);
		return true;
	}
        
	
        
}