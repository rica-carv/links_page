<?php
/**
 * @file
 * v2.x Standard  - Simple mod-rewrite module.
 */
if(!defined('e107_INIT'))
{
	exit;
}

/**
 * Class qna_url.
 *
 * plugin-folder + '_url'
 * there are no sef url fields for now, at future just replace name fields with sef_url 
 */
class links_page_url
{
	function config()
	{
  
		$config = array();

    $config['category'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/category/(.*)/(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/category/{link_category_id}/{link_category_name}',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?cat.$1'
		); 

    $config['manage'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/manager$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/manager',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?manage'
		);
 
    $config['submit'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/submit$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/submit',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?submit'
		);
    
    $config['cat'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/cat$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/cat',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?cat'
		);
        
    $config['all'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/all$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/all',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?cat.all'
		);
          
    $config['top'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/top$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/top',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?top'
		);
    
    $config['rated'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/rated$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/rated',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?rated'
		);
    
    $config['index'] = array(
		// Matched against url, and if true, redirected to 'redirect' below.
		'regex'    => '^links_page/links$',
		// Used by e107::url(); to create a url from the db table.
		'sef'      => 'links_page/links',
		// File-path of what to load when the regex returns true.
		'redirect' => '{e_PLUGIN}links_page/links.php'
	 );
 
  
  return $config;
	}
}