<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Cron extends Controller {
	
	public function before(){
		if(!Kohana::$is_cli){
			throw new HTTP_Exception_404('The requested page does not exist!');
		}else{
			if(!isset($_SERVER['HTTP_HOST'])){
				$_SERVER['HTTP_HOST'] = 'bazaurlopowa.test';
			}
		}
	}
	
	//TODO: send queued newsletters
	public function action_sendnewsletters()
	{
		echo 'Send newsletters from queue'."\n";
		$mails = Model_Newsletter::getQueuedToSend();
		$swiftMail = email::connect();
		$done_item = array();
		$done_newsletter = array();
		if (!count($mails))
		{
			echo 'Nothing to send';
			return;
			
		}
		foreach ($mails as $mail)
		{
			$message = new Swift_Message();
			$message->setFrom(Model_Mail::EMAIL_ADMIN);
			$message->setBody($mail->content,'text/html');
			$message->setTo(array($mail->subscriber_email));
			$message->setSubject($mail->title);
			
			$result = $swiftMail->send($message);
			if ($result)
			{
				if (!in_array($mail->newsletter_id, $done_newsletter))
				{
					array_push($done_newsletter, $mail->newsletter_id);	
				}
				array_push($done_item, $mail->newsletter_queue_id);
			}
			
		}
		
		Model_Newsletters::moveToArchive($done_item);
		Model_Newsletters::setSent($done_newsletter);
		echo 'Sended '.count($done).' e-mail'."\n";
	}
	
	//TODO: send from system queue
	public function action_sendmails(){
		echo 'Send mails from queue'."\n";
		$mails = Model_Mail::getQueuedToSend();
		$swiftMail = email::connect();
				
		foreach ($mails as $mail)
		{
			$message = new Swift_Message();
			$message->setFrom(array($mail->from));
			$message->setBody($mail->content,'text/html');
			$message->setTo(array($mail->to));
			$message->setSubject($mail->title);
			
			$result = $swiftMail->send($message);
			if ($result)
			{
				Model_Mail::setSent($mail->id);
			}
			
		}
		echo 'Sended '.count($mails).' e-mail'."\n";
	}

} 