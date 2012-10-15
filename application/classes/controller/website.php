<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Website extends Controller_Template {

	/**
	 * Set SEO metatags
	 * @param Array $metanames
	 */
	protected function setMetatags($metanames = null)
	{
		// Default metanames
		$default_metanames = array(
			'title' 		=> 'CumulusCMS',
			'keywords'		=> 'cumulus, cms',
			'description' 	=> '',
		);
	
		if (is_array($metanames))
		{
			if (array_key_exists('title', $metanames))
			{
				$default_metanames['title'] = $metanames['title']. ' | '.$default_metanames['title'];
			}
			if (array_key_exists('keywords', $metanames))
			{
				$default_metanames['keywords'] = $metanames['keywords'];
			}
			if (array_key_exists('description', $metanames))
			{
				$default_metanames['description'] = $metanames['description'];
			}
		}
		
		// Send params to view
		foreach ($default_metanames as $key => $value)
		{
			$this->template->$key = $value;
		}
	}

}