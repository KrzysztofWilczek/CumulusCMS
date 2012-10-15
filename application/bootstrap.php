<?php defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------

// Load the core Kohana class
require SYSPATH.'classes/kohana/core'.EXT;

if (is_file(APPPATH.'classes/kohana'.EXT))
{
	// Application extends the core
	require APPPATH.'classes/kohana'.EXT;
}
else
{
	// Load empty core extension
	require SYSPATH.'classes/kohana'.EXT;
}

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/Warsaw');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'pl_PL.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('pl-Pl');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::'.strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	//'base_url'   => '/',
	'base_url'   => 'http://cumulus.test',
	'index_file' => false,
	'errors' => true
));

//set_exception_handler(array('Kohana_Exception', 'handler'));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	
	'database'	=> MODPATH.'database',  	// Database access
	'orm'		=> MODPATH.'orm',        	// Object Relationship Mapping
	'lessphp'	=> MODPATH.'lessphp',		// Add less support
	'email' 	=> MODPATH.'email', 			// Add sending mails
	'pagination'	=> MODPATH.'pagination',
	'image'      	=> MODPATH.'image',      // Image manipulation
	'automatify'	=> MODPATH.'automatify',
	
	));
	
	
// TODO: Add sam placeholder page form admin work time
$plug = 0;
//Kohana_Exception::$error_view = 'plug';
if ($plug)
{
	
	throw new Kohana_Exception();
}	


/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
	
Route::set('plug', 'powitanie')
	->defaults(array(
		'controller' => 'plug',
		'action'     => 'index',
	));
Route::set('cron', 'cron/<action>')
	->defaults(array(
		'controller' => 'cron',
		'action'     => 'sendmails',
));

// Admin panel part (CMS)
Route::set('comments_list', 'admin/comments(/<item>/<type>)(/page(/<page>))', 
	array(
		'page' => '[0-9]+',
		'item' => '[0-9]+',
		'type' => '[0-9]+'
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'comments',
		'action'     => 'index',
	));
Route::set('comments_edit', 'admin/comments(/<action>(/<id>))', 
	array(
		'action' => '(index|del)'
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'comments',
		'action'     => 'index',
	));
Route::set('mails_edit', 'admin/mails(/<action>(/<id>))', 
	array(
		'action' => '(index|edit|del|preview|send|reply)'
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'mails',
		'action'     => 'index',
	));
Route::set('tokens_list', 'admin/tokens(/page(/<page>))', 
	array(
		'page' => '[0-9]+',
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'tokens',
		'action'     => 'index',
	));
Route::set('tokens_edit', 'admin/tokens(/<action>(/<id>))', 
	array(
		'action' => '(index|del)',

	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'tokens',
		'action'     => 'index',
	));
Route::set('user_edit', 'admin/users(/<action>(/<id>))', 
	array(
		'action' => '(index|add|edit|password|del)',

	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'users',
		'action'     => 'index',
	));
Route::set('user_list', 'admin/users(/page(/<page>))', 
	array(
		'page' => '[0-9]+',
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'users',
		'action'     => 'index',
	));
Route::set('subscriber_list', 'admin/subscribers(/page(/<page>))', 
	array(
		'page' => '[0-9]+',
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'subscribers',
		'action'     => 'index',
	));
Route::set('subscriber_edit', 'admin/subscribers(/<action>(/<id>))', 
	array(
		'action' => '(index|del)',

	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'subscribers',
		'action'     => 'index',
	));

Route::set('newsletter_list', 'admin/newsletter(/page(/<page>))', 
	array(
		'page' => '[0-9]+',
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'newsletters',
		'action'     => 'index',
	));
Route::set('newsletter_edit', 'admin/newsletter(/<action>(/<id>))', 
	array(
		'action' => '(index|add|edit|del|copy|test|send)',

	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'newsletters',
		'action'     => 'index',
	));
Route::set('article_list', 'admin/articles(/page(/<page>))', 
	array(
		'page' => '[0-9]+',
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'articles',
		'action'     => 'index',
	));
Route::set('article_edit', 'admin/articles(/<action>(/<id>))', 
	array(
		'action' => '(index|add|edit|del)',

	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'articles',
		'action'     => 'index',
	));
	
Route::set('template_list', 'admin/templates(/page)(/<page>)',  
	array(
		'page'=>'[0-9]+'
	))
	->defaults(array(
		'directory'	=> 'admin',
		'controller' => 'templates',
		'action'     => 'index',
	));
Route::set('template_edit', 'admin/templates(/<action>(/<id>))', 
	array(
		'action' => '(index|edit|del)'
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'templates',
		'action'     => 'index',
	));	
	
Route::set('subpage_list', 'admin/pages(/page)(/<page>)',  
	array(
		'page'=>'[0-9]+'
	))
	->defaults(array(
		'directory'	=> 'admin',
		'controller' => 'pages',
		'action'     => 'index',
	));	
Route::set('subpage_edit', 'admin/pages(/<action>(/<id>))', 
	array(
		'action' => '(index|edit|del)'
	))
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'pages',
		'action'     => 'index',
	));	
Route::set('auth', 'admin/<action>(/<login>(/<password>))',
  	array(
    	'action' => '(login|logout|forgot|restore)'
  	))
  	->defaults(array(
  		'directory'	 => 'admin',
    	'controller' => 'auth'
  	));
Route::set('home', 'admin/home')
  	->defaults(array(
  		'directory'	 => 'admin',
		'controller' => 'index',
		'action' => 'home'
  	));
Route::set('admin', 'admin(/<controller>(/<action>(/<id>)))')
	->defaults(array(
		'directory'	 => 'admin',
		'controller' => 'index',
		'action'     => 'index',
	));
		
