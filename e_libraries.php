<?php
class links_page_libraries
{
    function libraries_info()
    {
        $libraries['quick-select'] = array(
            'name' => 'QuickSelect',
           // 'vendor url' => 'http://quick-select.eggbox.io/',
           // 'download url' => 'https://github.com/eggboxio/quick-select',
            'library path' => e_WEB.'quick-select',
             'version callback' => 'simple_version_callback',
      			'files'        => array(
      				'js'  => array('js/jquery.quickselect.min.js'),
      				'css' => array('css/quickselect.css'),
      			),            
        ); 
        return $libraries;
    }
     function simple_version_callback() {
        // Use some fancy magic to get the version number... or don't.
        return TRUE;
     }
}