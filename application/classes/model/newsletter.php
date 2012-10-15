<?php
class Model_Newsletter extends Model {
	
	const TABLE_NAME = 'newsletters';
        const QUEUE_TABLE_NAME = 'newsletters_queue';
        const ARCHIVE_TABLE_NAME = 'newsletters_archive';
	const TO_SEND_VIEW = 'newsletters_to_send';
        
        const STATUS_DRAFT = 1;
        const STATUS_SCHEDULED = 2;
        const STATUS_SENT = 3;
        
        public static $statusNames = array(
            self::STATUS_DRAFT => 'Szkic',
            self::STATUS_SCHEDULED => 'Oczekujący',
            self::STATUS_SENT => 'Wysłany'
        );
	
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
		
		$result = $query->execute();
		//self::addToQueue($result[0]);
		return true;
	}
	
	public static function update(array $data, $id)
	{
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$id);
		$query->execute();
		if (array_key_exists('is_sent', $data))
		{
			self::clearQueueByNewsletterId($id);
			self::addToQueue($id);
		}
		return true;
	}
	
	public static function deleteById($id)
	{
                $query = DB::update(self::TABLE_NAME)->set(array('is_removed' => true))->where('id','=',$id);
		$query->execute();
                // Clear queue list
                self::clearQueueByNewsletterId($id);
		return true;
	}
        
        public static function clearQueueByNewsletterId($newsletter_id)
        {
                $query = DB::delete(self::QUEUE_TABLE_NAME)->where('newsletter_id','=',$newsletter_id);
		$query->execute();
		return true;
        }
	
	public static function clearQueueBySubscriberId($subscriber_id)
        {
                $query = DB::delete(self::QUEUE_TABLE_NAME)->where('subscriber_id','=',$subscriber_id);
		$query->execute();
		return true;
        }
	
	public static function addToQueue($newsletter_id)
	{
		// Insert subscribers to queue
		$query = DB::query(Database::INSERT, 'INSERT INTO '.self::QUEUE_TABLE_NAME.' (newsletter_id, subscriber_id) SELECT '.$newsletter_id.', s.id FROM subscribers s WHERE is_removed = 0 AND is_confirmed = 1');
		$query->execute();
		// Update newsletter data (subscribers_count)
		$query = DB::select('*')->from(self::QUEUE_TABLE_NAME)->where('newsletter_id','=',$newsletter_id);
		$result = $query->as_object()->execute();
		$query = DB::update(self::TABLE_NAME)->set(array('subscribers_count' => count($result)))->where('id','=',$newsletter_id);
		$query->execute();
		
		return true;
	}
	
	public static function copy($newsletter_id)
	{
		$query = DB::query(Database::INSERT, 'INSERT INTO '.self::TABLE_NAME.' (title, content, user_id) SELECT n.title, n.content, n.user_id FROM '.self::TABLE_NAME.' n WHERE n.id = '.$newsletter_id);
		return $query->execute();
	
	}
	
	public static function getQueuedToSend()
	{
		$query = DB::select('*')->from(self::TO_SEND_VIEW);
		return $query->as_object()->execute();
	}
        
        public static function getStatus($newsletter)
        {
                if (!$newsletter->is_sent)
                {
                    return self::STATUS_DRAFT;
                }
                else
                {
                    if (!$newsletter->is_mailed)
                    {
                        return self::STATUS_SCHEDULED;
                    }
                    else
                    {
                        return self::STATUS_SENT;
                    }
                }
        }
	
	public static function setSent($newsletters)
	{
		$list = '';
		foreach ($newsletters as $item)
		{
			$list .= $item.', ';
		}
		$list = substr($list,0,strlen($list)-2);
		$query = DB::query(Database::UPDATE, 'UPDATE '.self::TABLE_NAME.' SET is_sent = 1 WHERE id IN ('.$list.')');
		$query->execute();
	}
	
	public static function moveToArchive($queued)
	{
		$list = '';
		foreach ($queued as $item)
		{
			$list .= $item.', ';
		}
		$list = substr($list,0,strlen($list)-2);
		$query = DB::query(Database::INSERT, 'INSERT INTO '.self::ARCHIVE_TABLE_NAME.' (newsletter_id, subscriber_id) SELECT q.newsletter_id, q.subscriber_id FROM '.self::QUEUE_TABLE_NAME.' q WHERE id IN ('.$list.')');
		$query->execute();
	}
        
        public static function getStatusName($newsletter)
        {
                $status = self::getStatus($newsletter);
                return self::$statusNames[$status];
		
        }
        
       
	
}