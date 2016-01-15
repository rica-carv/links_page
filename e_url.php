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

    $config['catorder'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/category/(.*)/(.*)/(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/category/{link_category_id}/{link_category_sef}',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?cat.$1.$3'
		); 
    
    $config['category'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/category/(.*)/(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/category/{link_category_id}/{link_category_sef}',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?cat.$1'
		); 

    $config['managecreate'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/manager/create/(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/manager/create/{link_id}',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?manage'
		);
    
    $config['manageedit'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/manager/edit/(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/manager/edit/{link_id}',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?manage.edit.$1'
		);

    $config['submitted'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/link-submitted$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/link-submitted',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?s$1'
		);
    
    $config['submit'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/submit$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/submit',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?submit'
		);
    
    $config['manage'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/manager(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/manager',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?manage$1'
		);

    $config['allcatsorder'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/(.*)/(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/cat',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?$1.$2'
		);
     
    $config['allcats'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/cat(.*)$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/cat',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?cat$1'      
		);   
        
    $config['alllinks'] = array(
			// Matched against url, and if true, redirected to 'redirect' below.
			'regex'    => '^links_page/links/all$',
			// Used by e107::url(); to create a url from the db table.
			'sef'      => 'links_page/links/all',
			// File-path of what to load when the regex returns true.
			'redirect' => '{e_PLUGIN}links_page/links.php?all'
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
    $config['ordering'] = array(
		// Matched against url, and if true, redirected to 'redirect' below.
		'regex'    => '^links_page/links/(.*)$',
		// Used by e107::url(); to create a url from the db table.   Not used
		// 'sef'      => 'links_page/links/orderaheading',
		// File-path of what to load when the regex returns true.
		'redirect' => '{e_PLUGIN}links_page/links.php?$1'
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