<?php
class links_page_libraries
{
    function libraries_info()
    {   
 
        $libraries['frmediaman-modal'] = array(
            'name' => 'Frontend Media Manager Modal',
            'library path' => e_WEB.'frmediaman',
             'version callback' => 'simple_version_callback',
      		   'files'        => array(
                    'js'  => array('frmediaman-modal.js' => array(
                      'type' => 'footer', // If not set, the default: 'url'
                      'zone' => 5, // If not set, the default: 2
                    )),
      			),            
        ); 
        /* use this only if you don't add this in your theme */
        $libraries['frmediaman'] = array(
            'name' => 'Frontend Media Manager',
            'library path' => e_WEB.'frmediaman',
             'version callback' => 'simple_version_callback',
      		   'files'        => array(
                    'js'  => array('frmediaman.js' => array(
                      'type' => 'footer', // If not set, the default: 'url'
                      'zone' => 5, // If not set, the default: 2
                    )),   
      			),            
        );  
              
        return $libraries;
    }
     function simple_version_callback() {
        // Use some fancy magic to get the version number... or don't.
        return TRUE;
     }
}