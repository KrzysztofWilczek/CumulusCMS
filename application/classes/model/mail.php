<?php
/**
 * Mail model class, get queued and other stuff
 * @author Krzysztof Wilczek
 *
 */
class Model_Mail extends Model {
	
	const TABLE_NAME = 'mails';
	
	const EMAIL_ADMIN = 'krzysztof.wilczek@gmail.com';
	
	/**
	 * Get list of all mails in DB
	 * @param Boolean $show_hidden
	 * @return Object
	 */
	public static function fetchAll($show_hidden = false)
	{
		$query = DB::select('*')->from(self::TABLE_NAME);
		if (!$show_hidden)
		{
			$query->where('is_hidden','=',0);
		}
		return $query->as_object()->execute();	
	}
	
	public static function fetchById($mail_id)
	{
		$query = DB::select('*')->from(self::TABLE_NAME)->where('id','=',$mail_id);
		$mails = $query->as_object()->execute();
		if (count($mails) > 0)
		{
			return $mails[0];
		}

	}
	
	public static function update(array $data, $id)
	{	
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$id);
		$query->execute();
		return true;
	}
	

	public static function insert($data)
	{
		if (!array_key_exists('send_date', $data))
		{
			$data['send_date'] = date(Constants::DATE_FORMAT);
		}
		$query = DB::insert(self::TABLE_NAME, array_keys($data))->values(array_values($data));
		$query->execute();
		return true;
	}
	/**
	 * Add new mail
	 * @param Array $data
	 * TODO: rewrite
	 */
	public static function addContactMail($data)
	{
		$data['email'] = self::EMAIL_ADMIN;
		$data['is_hidden'] = 0;
		$data['status'] = self::STATUS_TO_SEND;
		$data['title'] = 'Formularz kontaktowy diabakter.pl';
		$query = DB::insert(self::TABLE_NAME, array_keys($data))->values(array_values($data));
		return $query->execute();
	}
	
	/**
	 * Grab all mails to send in queue
	 * @return Object
	 */
	public static function getQueuedToSend()
	{
		$query = DB::select('*')->from(self::TABLE_NAME)
			->where('is_sent','=',0)
			->order_by('send_date','desc');
		return $query->as_object()->execute();
	}
	
	public static function setSent($mail_id)
	{
		self::update(array('is_sent'=>1), $mail_id);
	}
	
	public static function render($mail)
	{
		if (is_int($mail))
		{
			$mail = self::fetchById($mail);
		}
		$template = View::factory('mails/default');
		$template->set('title', $mail->title);
		$template->set('content', $mail->content);
		return $template->render();
	}
	
	/**
	 * Set status to specyfied mail
	 * @param Integer $mail_id
	 * @param Integer $status
	 */
	public static function setStatus($mail_id, $status)
	{

		$data = array('status' => $status);
		if ($status == self::STATUS_SENDED)
		{
			$data['send_date'] = date('Y-m-d H:i:s');
		}
		$query = DB::update(self::TABLE_NAME)->set($data)->where('id','=',$mail_id);
		$query->execute();
	}
	
}