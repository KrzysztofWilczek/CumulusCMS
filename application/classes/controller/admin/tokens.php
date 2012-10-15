<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Tokens extends Controller_Admin_Cms {
	 
	public function before() {
		parent::before();
		if(!Model_Auth::is_logged_in()) {
			Request::current()->redirect('admin/login');
		}
	}
	
        
        
	/**
	 * Show admin panel
	 */
	public function action_index()
	{		
		$page = Request::current()->param('page', 1);
		
		$this->setMetatags();
		$tokens = Model_Token::fetchAll();
		
		$pagination = Pagination::factory(array(
			'current_page'   => array('source' => 'route', 'key' => 'page'), // route
			'total_items'    => count($tokens),
			'items_per_page' => Constants::ITEMS_PER_PAGE
		));
		
		$tokens = Model_Token::fetchAll($page);
		$this->template->body = View::factory('admin/tokens/index')
			->bind('tokens', $tokens)
			->bind('pagination', $pagination);
	}
	
	
	/**
	 * Delete selected user device token 
	 */
	public function action_del()
	{
	
		$token_id = Request::current()->param('id', null);
		if (!$token_id)
		{
			Request::current()->redirect('admin/tokens');
		}
		
		$result = Model_Token::deleteById($token_id);
		if ($result)
		{
			Messenger::add('Wybrane urządzenie zostało odłączone', Messenger::TYPE_INFO);
			Request::current()->redirect('admin/tokens');
		}
		else
		{
			// TODO : some shit has happen
			Request::current()->redirect('admin/tokens');
		}
	}

} 
