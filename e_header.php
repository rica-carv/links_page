<?php
/**
 * @file
 * Load libraries and JS/CSS files.
 * If you want to use libraries plugin just upload quick-select folder to e107_web folder 
 * Libraries plugin:  https://github.com/lonalore/libraries 
 */
 
if(!defined('e107_INIT'))
{
	exit;
} 
 
if(USER_AREA)
{  
  if ((function_exists('libraries_load')) &&  ($library = libraries_load('quick-select')) && !empty($library['loaded'])) {}  
  else {
      /* if libraries plugin is not used */
     	e107::css('links_page','quick-select/css/quickselect.css','');
      e107::js('links_page','quick-select/js/jquery.quickselect.min.js');
  }  
     
  // Plugin settings for javascript.
  $settings = array(
    'activeButtonClass' => 'btn-primary active',
    'breakOutAll' => true,
    'buttonClass' => 'btn btn-default',
    'selectDefaultText' => 'Other', // Use constant for multi-language support.
    'wrapperClass' => 'btn-group',
  );
  
  
  e107::js('settings', array('links_page' => $settings));
  
  // Now load behavior.
  e107::js('footer', '{e_PLUGIN}links_page/quickselect.init.js');
} 
?>