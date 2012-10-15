<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Comments extends Controller_Admin_Cms {
	 
	public function before() {
		parent::before();
		if(!Model_Auth::is_logged_in()) {
			Request::current()->redirect('admin/login');
		}
	}

	public function action_index()
	{		
		$page = Request::current()->param('page', 1);
		$resource_id = Request::current()->param('item', null);
		$resource_type = Request::current()->param('type', null);
		
		$this->setMetatags();
			
		$query = Model_Comment::getListQuery($resource_id, $resource_type);
		$search = array('content'); // set on which column(s) you want to search
		$sort = array('content' => 'ASC'); // set the def sort (key is the column, value is the sorting type)
		$this->template->body = View::factory('admin/comments/index');
		$this->template->body->pagination = new Automatify($query, $search, $sort);
	}

	public function action_del()
	{
	
		$comment_id = Request::current()->param('id', null);
		if (!$comment_id)
		{
			Request::current()->redirect('admin/comments');
		}
		
		$result = Model_Comment::deleteById($comment_id);
		if ($result)
		{
			Messenger::add(__('messageCommentDeleted'), Messenger::TYPE_INFO);
			Request::current()->redirect('admin/comments');
		}
		else
		{
			// TODO : some shit has happen
			Request::current()->redirect('admin/comments');
		}
	}

} 
