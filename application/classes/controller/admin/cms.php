<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Cms extends Controller_Website {
	
    public $template = 'admin/cms';
    
    public function before()
    {
	parent::before();
		
	$this->prepareMenu();
	
    }
    
    protected function prepareMenu()
    {
	$this->template->menu = Menu::factory()
	    ->add(__('menuHome'), 'admin/home')
	    ->add(__('menuNews'), 'admin/articles')
	    ->add(__('menuPages'), 'admin/pages')
	    ->add(__('menuTemplates'), 'admin/templates')
	    ->add(__('menuNewsletter'), 'admin/newsletter')
	    ->add(__('menuUsers'), 'admin/users')
	    ->add(__('menuLogout'), 'admin/auth/logout');
    }

} 
