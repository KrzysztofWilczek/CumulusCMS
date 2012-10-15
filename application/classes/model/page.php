<?php
class Model_Page extends Model {
	
	const TABLE_NAME = 'pages';
	
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
	
	public static function getPageByURL($url)
	{
		if (!$url)
		{
			return;
		}
		$query = DB::select('*')->from(self::TABLE_NAME)->where('url','=',$url);
		$result = $query->as_object()->execute();
		if(count($result)>0) {
			return $result[0];
		}
		return;
	}
	
	public static function deletePageById($page_id)
	{
		if (!$page_id)
		{
			return;
		}
		$query = DB::delete(self::TABLE_NAME)->where('id','=',$page_id);
		$result = $query->execute();
		return true;
	}
	
	public static function getPageById($page_id)
	{
		if (!$page_id)
		{
			return;
		}
		
		$query = DB::select('*')->from(self::TABLE_NAME)->where('id','=',$page_id);
		$result = $query->execute();
		if(count($result)>0) {
			return $result[0];
		}
		return;
	}
	
	// TODO: write save method with validation
	public static function save(array $page, $page_id = null)
	{
		$validators = Validation::factory($page)
			->rules('title', array(array('not_empty')))
			->labels(array(
				'title'=>'TytuŇā',
			));
		if ($validators->check())
		{
			if (!$page_id)
			{
				return self::insert($page);
			}
			else
			{
				return self::update($page, $page_id);
			}
		}
		else 
		{
			return $validators->errors();
		}
		
	}
	
	public static function insert(array $page)
	{
		// Create link
		if (empty($page['url']))
		{
			$page['url'] = GoodText::seolink($page['title']);
		}
		
		// Set free url for seo links
		$url = self::setFreeLink($page['url']);
		
		// Get current time
		$now = date(Constants::DATE_FORMAT);
		$user_id = Session::instance()->get('user')->id;
		
		$query = DB::insert(self::TABLE_NAME, array(
			'title', 'content', 'url', 'keywords', 'description', 'modification_date', 'insert_date', 'user_id'
		))->values(array(
			$page['title'], $page['content'], $url, $page['keywords'], $page['description'], $now, $now, $user_id
		));
		$response = $query->execute();
		return ($response[0] > 0);
		
		
	}
	
	public static function update(array $page, $page_id)
	{
		// Create link
		if (empty($page['url']))
		{
			$page['url'] = GoodText::seolink($page['title']);
		}
		
		// Set free url for seo links
		$url = self::setFreeLink($page['url'], $page_id);
		
		// Add modyfication date
		$page['modification_date'] = date(Constants::DATE_FORMAT);
		$query = DB::update(self::TABLE_NAME)->set($page)->where('id','=',$page_id);
		$query->execute();
		return true;
	}
	
	/**
	 * Check existense of page url
	 * @param String $url
	 * @return Boolean
	 */
	protected static function checkLinkName($url, $page_id = null)
	{
		if (empty($url))
		{
			return false;
		}
		$query = DB::select('*')->from(self::TABLE_NAME);
		$query->where('url','=',$url);
		if ($page_id)
		{
			$query->where('id','!=',$page_id);
		}
		$result = $query->as_object()->execute();
	
		if (count($result) > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	/**
	 * Find first free link for element
	 * @param String $link
	 * @return String
	 */
	protected static function setFreeLink($link, $page_id = null)
	{
		if (empty($link))
		{
			return null;
		}
	
		$link = GoodText::seolink($link);
		$i = 0;
		$free = false;
		$test_link = $link;
		while (!$free) 
		{
			if (self::checkLinkName($test_link, $page_id))
			{
				$free = true;
			}
			else
			{
				$i++;
				$test_link = $link .'-'. $i;  	
			}
		}
		return $test_link;
	}
	
}