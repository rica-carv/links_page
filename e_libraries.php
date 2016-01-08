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
                    'js'  => array('js/jquery.quickselect.min.js' => array(
                      'type' => 'footer', // If not set, the default: 'url'
                      'zone' => 5, // If not set, the default: 2
                    )),
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