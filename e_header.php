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

  /* can be delete if theme use admin modal code*/                         
  if ((function_exists('libraries_load')) &&  ($library = libraries_load('frmediaman-modal')) && !empty($library['loaded'])) {
   e107::js('links_page','frmediaman/frmediaman-modal.js');
  }   
  
  /* script to get admin modal works */                        
  if ((function_exists('libraries_load')) &&  ($library = libraries_load('frmediaman')) && !empty($library['loaded'])) {
   e107::js('links_page','frmediaman/frmediaman.js');  
  } 
} 
?>