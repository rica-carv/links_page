<?php
 
if (!defined('e107_INIT')) { exit; }
 
  
if(USER_AREA /* AND strpos(e_REQUEST_URI,'links_page') */ )
{
  	e107::css('links_page','quick-select/css/quickselect.css','');
    e107::js('links_page','quick-select/js/jquery.quickselect.min.js');


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
e107::js('links_page', 'quickselect.init.js');
} 
?>