<?php
class Model_Template extends Model {
	
	const TABLE_NAME = 'templates';
	
	public static function getTypes()
	{
		return array(
			1 => 'Szablon maila',
			2 => 'Szablon PDF'
		);
	}
	
	public static function showTagsList($tags)
	{
		$tags = explode(',', $tags);
		$list = '';
		foreach ($tags as $tag)
		{
			$list .= '||'.$tag.'||, ';
		}
		$list = substr($list, 0, strlen($list)-2);
		return $list;
	}
	
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
	
	public static function getListQuery()
	{
		$query = DB::select('*')->from(self::TABLE_NAME);
		return $query;
	}
	
	public static function getByCode($code)
	{
		if (!$code)
		{
			return;
		}
		$query = DB::select('*')->from(self::TABLE_NAME)->where('code','=',$code);
		$result = $query->as_object()->execute();
		if(count($result)>0) {
			return $result[0];
		}
		return;
	}
	
	public static function render($code, array $data)
	{
		$template = self::getByCode($code);
		$tags = explode(',',$template->tags);
		$to_replace = array();
		$replace_with = array();
		foreach ($tags as $tag)
		{
			if (array_key_exists(trim($tag), $data))
			{
				array_push($to_replace, '||'.trim($tag).'||');
				array_push($replace_with, $data[trim($tag)]);
			}
		}
		return str_replace($to_replace, $replace_with, $template->content);
	}
	
	public static function deleteById($id)
	{
		if (!$id)
		{
			return;
		}
		$query = DB::delete(self::TABLE_NAME)->where('id','=',$id);
		$result = $query->execute();
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
	
	// TODO: write save method with validation
	public static function save(array $data, $id = null)
	{
		$validators = Validation::factory($data)
			->rules('code', array(array('not_empty')))
			->labels(array(
				'title'=>'Nazwa kodowa',
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
	
	public static function update(array $data, $id)
	{	
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$id);
		$query->execute();
		return true;
	}
	
}