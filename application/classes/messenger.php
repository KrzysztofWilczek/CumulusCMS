<?php
/**
 * Flash messenger class
 * @author Krzysztof Wilczek
 */
class Messenger {

	// Types of messages
	const TYPE_ERROR = 'alert alert-error';
	const TYPE_INFO = 'alert alert-success';
	const TYPE_ALERT = 'alert alert-error';
	const TYPE_DEFAULT = 'alert alert-info';
		
	/**
	 * Add new message
	 * @param String $message
	 * @param String $type
	 */
	public static function add($message, $type = null)
	{
		$session = Session::instance();
		$messages = $session->get('messenger', array()); 
		if (!$messages)
		{
			$session->set('messenger', array());
		}
		
		array_push($messages, array('message'=>$message, 'type'=>$type));
		$session->set('messenger', $messages);
	}
	
	/**
	 * Clear messages list
	 */
	public static function clear()
	{
		$session = Session::instance();
		$session->set('messenger', array());
	}
	
	/**
	 * 
	 * Show all messages list,
	 * @param unknown_type $type
	 */
	public static function show($type = null, $clear_after = true)
	{
		// Prepare messages list view
		$session = Session::instance();
		$messages = $session->get('messenger', array()); 
		if (!$messages)
		{
			$session->set('messenger', array());
		}	
		$view = '<div class="messenger">';
		
		if (count($messages) > 0)
		{
			foreach($messages as $message)
			{
				if ($type != null)
				{
					if ($message['type'] == $type)
					{
						$view .= '<div class="'.$message['type'].'">'.$message['message'].'</div>';
					}
				}
				else
				{
					$view .= '<div class="'.$message['type'].'">'.$message['message'].'</div>';
				}
			}
		}
		$view .= '</div>';
		
		// Clear messages list
		if ($clear_after)
		{
			self::clear();
		}
		
		return $view;
	}
}