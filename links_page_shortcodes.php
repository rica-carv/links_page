<?php
if (!defined('e107_INIT')) { exit; }

class links_page_shortcodes extends e_shortcode
{

	/**
	 * Private variable to store plugin configurations.
	 *
	 * @var array
	 */
	private $plugPrefs = array();
  
	/**
	 * Constructor.
	 */
	function __construct()
	{
		$this->plugPrefs = e107::getPlugConfig('links_page')->getPref();
	}

  
  function sc_link_navigator($parm='')
	{ 
  global  $rs;

  $mains = "";   
                     
if(isset($this->plugPrefs['link_navigator_frontpage']) && $this->plugPrefs['link_navigator_frontpage']){
 
  $mains .= $rs -> form_option(LAN_LINKS_14, "0", e107::url('links_page', 'index'), "");
}
if(isset($this->plugPrefs['link_navigator_refer']) && $this->plugPrefs['link_navigator_refer']){
	$mains .= $rs -> form_option(LAN_LINKS_12, "0", e107::url('links_page', 'top'), "");
}
if(isset($this->plugPrefs['link_navigator_rated']) && $this->plugPrefs['link_navigator_rated']){
	$mains .= $rs -> form_option(LAN_LINKS_13, "0", e107::url('links_page', 'rated'), "");
}
if(isset($this->plugPrefs['link_navigator_category']) && $this->plugPrefs['link_navigator_category']){
	$mains .= $rs -> form_option(LAN_LINKS_43, "0", e107::url('links_page', 'allcats'), "");
}
if(isset($this->plugPrefs['link_navigator_links']) && $this->plugPrefs['link_navigator_links']){
	$mains .= $rs -> form_option(LAN_LINKS_51, "0", e107::url('links_page', 'alllinks'), "");
}
if(isset($this->plugPrefs['link_navigator_submit']) && $this->plugPrefs['link_navigator_submit'] && isset($this->plugPrefs['link_submit']) && $this->plugPrefs['link_submit'] && check_class($this->plugPrefs['link_submit_class'])){
	$mains .= $rs -> form_option(LAN_LINKS_27, "0", e107::url('links_page', 'submit'), "");
}
if(isset($this->plugPrefs['link_navigator_manager']) && $this->plugPrefs['link_navigator_manager'] && isset($this->plugPrefs['link_manager']) && $this->plugPrefs['link_manager'] && check_class($this->plugPrefs['link_manager_class'])){
	$mains .= $rs -> form_option(LCLAN_ITEM_35, "0", e107::url('links_page', 'manage'), "");
}


if($mains){
	$main = "";

	$selectjs = " onchange=\"if(this.options[this.selectedIndex].value.indexOf('-') &amp;&amp; this.options[this.selectedIndex].value != '' &amp;&amp; this.options[this.selectedIndex].value != '&nbsp;'){ return document.location=this.options[this.selectedIndex].value; }\" ";

//	$selectjs = " onchange=\"if(this.options[this.selectedIndex].value != '-- view category --' || this.options[this.selectedIndex].value != '&nbsp;'){ return document.location=this.options[this.selectedIndex].value; }\" ";
	$main .= $rs -> form_select_open("navigator", $selectjs);
	$main .= $rs -> form_option(LAN_LINKS_47, "0", "", "");
	$main .= $mains;
	$main .= $rs -> form_select_close();
	return $main;
}
 
}

  function sc_link_nav_allcats($parm='')
	{ 
    global  $rs;
    
    if(isset($this->plugPrefs['link_navigator_allcat']) && $this->plugPrefs['link_navigator_allcat']){     
    	$dbc = e107::getDb('dbc');
    	if ($dbc->select("links_page_cat", "link_category_id, link_category_name", "link_category_class REGEXP '".e_CLASS_REGEXP."' ORDER BY link_category_name")){
    		$mains .= $rs -> form_option("&nbsp;", "0", "", "");
    		$mains .= $rs -> form_option(LAN_LINKS_48, "0", "", "");
    		while ($rowc = $dbc->fetch()){
    			$mains .= $rs -> form_option($rowc['link_category_name'], "0", e107::url('links_page', 'category', $rowc, 'full'), "");
    		}
    	}
	$main = "";

	$selectjs = " onchange=\"if(this.options[this.selectedIndex].value.indexOf('-') &amp;&amp; this.options[this.selectedIndex].value != '' &amp;&amp; this.options[this.selectedIndex].value != '&nbsp;'){ return document.location=this.options[this.selectedIndex].value; }\" ";

    $main .= $rs -> form_select_open("link_navigator_allcat", $selectjs);
  	$main .= $rs -> form_option(LAN_LINKS_48, "0", "", "");
  	$main .= $mains;
  	$main .= $rs -> form_select_close();
  	return $main;
    }
}

  function sc_link_sortorder($parm='')
	{ 
    global $LINK_SORTORDER;
    return $LINK_SORTORDER;
  }


 
  
  function sc_link_nextprev($parm='')
	{ 
    global $LINK_NEXTPREV;
    return $LINK_NEXTPREV;
  } 
  
  function sc_link_manage_icon($parm='')
	{ 
    global $LINK_MANAGE_ICON, $row;
    $LINK_MANAGE_ICON = "";
    return $LINK_MANAGE_ICON;
  }  

  function sc_link_manage_name($parm='')
	{ 
    global $LINK_MANAGE_NAME, $row, $tp;
    return $tp->toHTML($row['link_name'], TRUE);
  } 

  function sc_link_manage_options($parm='')
	{ 
    global $LINK_MANAGE_OPTIONS, $row, $tp;
 
    $linkid = $row['link_id'];
   // $LINK_MANAGE_OPTIONS = "<a href='".e_SELF."?manage.edit.".$linkid."' title='".LCLAN_ITEM_31."'>".LINK_ICON_EDIT."</a>";
  
   $LINK_MANAGE_EDIT= e107::url('links_page', 'manageedit', $row, 'full');
   $LINK_MANAGE_OPTIONS = "<a href='".$LINK_MANAGE_EDIT."' title='".LCLAN_ITEM_31."'>".LINK_ICON_EDIT."</a>";
   
    if (isset($this->plugPrefs['link_directdelete']) && $this->plugPrefs['link_directdelete']){
    	$LINK_MANAGE_OPTIONS .= " <input type='image' title='delete' name='delete[main_{$linkid}]' alt='".LCLAN_ITEM_32."' src='".LINK_ICON_DELETE_BASE."' onclick=\"return jsconfirm('".$tp->toJS(LCLAN_ITEM_33." [ ".$row['link_name']." ]")."')\" style='vertical-align:top;' />";
    }
    return $LINK_MANAGE_OPTIONS;
  } 
  
  function sc_link_manage_cat($parm='')
	{ 
    global $LINK_MANAGE_CAT, $tp, $row;
    return $tp->toHTML($row['link_category_name'], TRUE);
  }  

  function sc_link_manage_newlink($parm='')
	{    
    //return "<a href='".e_SELF."?manage'>".LAN_LINKS_MANAGER_3."</a>";
    
    $LINK_MANAGE_CREATE= e107::url('links_page', 'managecreate', $row, 'full');   
    //return "<a href='".$LINK_MANAGE_CREATE."'>".LAN_LINKS_MANAGER_3."</a>";
    return  $LINK_MANAGE_CREATE;
  } 
  
  function sc_link_manage_active($parm='')
	{    
    global $LINK_MANAGE_ACTIVE, $tp, $row;
    if($row['link_category_active']) {  
      $LINK_MANAGE_ACTIVE = '<i class="S16 e-true-16"></i>';
    } else {
    $LINK_MANAGE_ACTIVE = 'noooo';
    };
    return  $LINK_MANAGE_CREATE;
  } 
    
    
  function sc_link_main_heading($parm='')
	{ 
    global $LINK_MAIN_HEADING, $rowl, $tp;
    return (!$rowl['total_links'] ? $rowl['link_category_name'] : "<a href='".e107::url('links_page', 'category', $rowl, 'full')."'>".$tp->toHTML($rowl['link_category_name'], TRUE)."</a>");
  }
  
  function sc_link_main_desc($parm='')
	{ 
    global $LINK_MAIN_DESC, $rowl,  $tp;
                         
    return (isset($this->plugPrefs['link_cat_desc']) && $this->plugPrefs['link_cat_desc'] ? $tp->toHTML($rowl['link_category_description'], TRUE,'description') : "");
  }
 
  function sc_link_main_number($parm='')
	{ 
    global $LINK_MAIN_NUMBER, $rowl;   
    if(isset($this->plugPrefs['link_cat_amount']) && $this->plugPrefs['link_cat_amount']){
    $LINK_MAIN_NUMBER = $rowl['total_links']." ".($rowl['total_links'] == 1 ? LAN_LINKS_17 : LAN_LINKS_18)." ".LAN_LINKS_16;
    }else{
    $LINK_MAIN_NUMBER = "";
    }
    return $LINK_MAIN_NUMBER;
  }


  function sc_link_main_icon($parm='')
	{ 
    global $LINK_MAIN_ICON, $rowl;
    
    $tp = e107::getParser();
    $LINK_MAIN_ICON = "";
    $bullet = '';
    if(defined('BULLET'))
    {
    	$bullet = '<img src="'.THEME.'images/'.BULLET.'" alt="" style="vertical-align: middle;" />';
    }
    elseif(file_exists(THEME.'images/bullet2.gif'))
    {
    	$bullet = '<img src="'.THEME.'images/bullet2.gif" alt="" style="vertical-align: middle;" />';
    }
    
    if(isset($this->plugPrefs['link_cat_icon']) && isset($this->plugPrefs['link_cat_icon']))
    {
    	if (isset($rowl['link_category_icon']) && $rowl['link_category_icon'])
    	{
    		$LINK_MAIN_ICON = $tp->toIcon($rowl['link_category_icon']);
    	}
    	if($rowl['total_links'] && $LINK_MAIN_ICON)
    	{
    		$LINK_MAIN_ICON = "<a href='".e107::url('links_page', 'category', $rowl, 'full')."'>".$LINK_MAIN_ICON."</a>";
    	}
    }
    return $LINK_MAIN_ICON;
  }

 
 
  function sc_link_main_total($parm='')
	{ 
    global $LINK_MAIN_TOTAL,  $category_total,  $alllinks;
    if(isset($this->plugPrefs['link_cat_total']) && $this->plugPrefs['link_cat_total']){
    $LINK_MAIN_TOTAL = LAN_LINKS_21." ".($alllinks == 1 ? LAN_LINKS_22 : LAN_LINKS_23)." ".$alllinks." ".($alllinks == 1 ? LAN_LINKS_17 : LAN_LINKS_18)." ".LAN_LINKS_24." ".$category_total." ".($category_total == 1 ? LAN_LINKS_20 : LAN_LINKS_19);
    }else{
    $LINK_MAIN_TOTAL = "";
    }
    return $LINK_MAIN_TOTAL;
  } 

 
  function sc_Link_Main_Showall($parm='')
	{ 
    global $LINK_MAIN_SHOWALL;
    return (isset($this->plugPrefs['link_cat_total']) && $this->plugPrefs['link_cat_total'] ? "<a href='".e107::url('links_page', 'all', $rowc, 'full')."'>".LAN_LINKS_25."</a>" : "");
  } 
 



// LINK_TABLE ------------------------------------------------

  function sc_link_button($parm='')
	{ 
  global $LINK_BUTTON, $rowl, $LINK_NAME, $LINK_APPEND;
  $tp = e107::getParser();
  if(!$this->plugPrefs['link_icon']){
  	return "";
  }
  $LINK_BUTTON = "&nbsp;";
  if(isset($this->plugPrefs['link_icon']) && $this->plugPrefs['link_icon']){
  	if ($rowl['link_button']) {    
       $att = 'aw=190&ah=190';
       $linkbutton = $tp->thumbUrl($rowl['link_button'],$att);
  			$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button img-responsive'   src='".$linkbutton."' alt='' /></a>";
  	} else {
  		if(isset($this->plugPrefs['link_icon_empty']) && $this->plugPrefs['link_icon_empty']){
  			$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button' style='width: 88px; height: 31px;' src='".e_PLUGIN_ABS."links_page/images/generic.png' alt='' /></a>";
  		}
  	}
  }else{
  	if(isset($this->plugPrefs['link_icon_empty']) && $this->plugPrefs['link_icon_empty']){
  		$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button' style='width: 88px; height: 31px;' src='".e_PLUGIN_ABS."links_page/images/generic.png' alt='' /></a>";
  	}
  }
  return $LINK_BUTTON;
}


  function sc_button_column($parm='')
	{ 
    global $linkbutton_count;
    return ($this->plugPrefs['link_icon']) ? 2 : 1;
  }
  
  function sc_link_append($parm='')
	{ 
    global $LINK_APPEND;
    return $LINK_APPEND;
  }  
  
  function sc_link_name($parm='')
	{ 
    global $LINK_NAME, $rowl;
    return $rowl['link_name'];
  } 
  
  
  function sc_link_url($parm='')
	{ 
    global $LINK_URL,  $rowl;
    if(!isset($this->plugPrefs['link_url']))
    {
    	return "";
    }
    return ($parm == "link") ? "<a class='linkspage_url' href=\"".$rowl['link_url']."\" rel='external' title=\"".$rowl['link_description']."\">".$rowl['link_url']."</a>" : $rowl['link_url'];

  } 
  
  function sc_link_refer($parm='')
	{ 
    global $LINK_REFER, $rowl;
    return (isset($this->plugPrefs['link_referal']) && $this->plugPrefs['link_referal'] ? $rowl['link_refer'] : "");
  }   
  
  function sc_link_comment($parm='')
	{ 
    global $LINK_COMMENT, $rowl;
    return (isset($this->plugPrefs['link_comment']) && $this->plugPrefs['link_comment'] ? "<a href='".e_SELF."?comment.".$rowl['link_id']."'>".($rowl['link_comment'] ? $rowl['link_comment'] : "0")."</a>" : "");
  }   
 
  function sc_link_desc($parm='')
	{ 
    global $LINK_DESC, $tp, $rowl;
    return (isset($this->plugPrefs['link_desc']) && $this->plugPrefs['link_desc'] ? $tp->toHTML($rowl['link_description'], TRUE,'BODY') : "");
  }   
  
  function sc_link_rating($parm='')
	{ 
    global $LINK_RATING,  $rowl, $qs; 
        
    if(isset($this->plugPrefs['link_rating']) && $this->plugPrefs['link_rating']){
      $frm = e107::getForm();
      $options = array('label'=>' ','template'=>'RATE|VOTES|STATUS');
      $LINK_RATING = $frm->rate("links_page", $rowl['link_id'], $options);
    }
    return $LINK_RATING;
  }     
  
  function sc_link_new($parm='')
	{ 
    global $LINK_NEW,  $qs, $rowl;
    $LINK_NEW = "";
    if(USER && $rowl['link_datestamp'] > USERLV){
   // $LINK_NEW = "<img class='linkspage_new' src='".IMAGE_NEW."' alt='' style='vertical-align:middle' />";
   $LINK_NEW = IMAGE_NEW;
    }
    return $LINK_NEW;
  }   
  
  function sc_link_cat_name($parm='')
	{ 
    global $rowl;
    return $rowl['link_category_name'];
  } 


  function sc_link_cat_desc($parm='')
	{ 
    global $rowl;
    return $rowl['link_category_description'];
  }   
  
  function sc_link_cat_total($parm='')
	{ 
    global $link_category_total;
    return " (<span title='".(ADMIN ? LAN_LINKS_2 : LAN_LINKS_1)."' >".$link_category_total."</span>".(ADMIN ? "/<span title='".(ADMIN ? LAN_LINKS_1 : "" )."' >".$link_category_total."</span>" : "").") ";
  }
  
  function sc_link_refer_lan($parm='')
	{ 
    return (isset($this->plugPrefs['link_referal']) && $this->plugPrefs['link_referal'] ? LAN_LINKS_26 : "");
  }  
  
  function sc_link_comment_lan($parm='')
	{ 
    return (isset($this->plugPrefs['link_comment']) && $this->plugPrefs['link_comment'] ? LAN_LINKS_37 : "");
  } 
  
  function sc_link_rating_lan($parm='')
	{ 
    if(isset($this->plugPrefs['link_rating']) && $this->plugPrefs['link_rating']){
        return LCLAN_ITEM_39;
    }
    return "";
  }  
  
  function sc_navigator($parm='')
	{ 
      return displayNavigator('');
  } 
  
  // LINK_RATED_TABLE ------------------------------------------------
  function sc_link_rated_rating($parm='')
	{ 
    global $LINK_RATED_RATING, $rowl;
    if(isset($this->plugPrefs['link_rating']) && $this->plugPrefs['link_rating']){
      $frm = e107::getForm();
      $options = array('label'=>' ','template'=>'RATE|VOTES|STATUS');
      $LINK_RATED_RATING = $frm->rate("links_page", $rowl['link_id'], $options);
    }
    return $LINK_RATED_RATING;
  } 
  
  function sc_link_rated_button($parm='')
	{ 
    global $LINK_RATED_BUTTON,  $rowl, $LINK_RATED_NAME, $LINK_RATED_APPEND;
    if(isset($this->plugPrefs['link_icon']) && $this->plugPrefs['link_icon']){
    	if ($rowl['link_button']) {
    		if (strpos($rowl['link_button'], "http://") !== FALSE) {
    			$LINK_RATED_BUTTON = $LINK_RATED_APPEND."\n<img style='border:0;' src='".$rowl['link_button']."' alt='".$LINK_RATED_NAME."' /></a>";
    		} else {
    			if(strstr($rowl['link_button'], "/")){
    				$LINK_RATED_BUTTON = $LINK_RATED_APPEND."\n<img style='border:0;' src='".e_BASE.$rowl['link_button']."' alt='".$LINK_RATED_NAME."' /></a>";
    			}else{
    				$LINK_RATED_BUTTON = $LINK_RATED_APPEND."\n<img style='border:0' src='".e_PLUGIN_ABS."links_page/link_images/".$rowl['link_button']."' alt='".$LINK_RATED_NAME."' /></a>";
    			}
    		}
    	} else {
    		if(isset($this->plugPrefs['link_icon_empty']) && $this->plugPrefs['link_icon_empty']){
    			$LINK_RATED_BUTTON = $LINK_RATED_APPEND."\n<img style='border:0; width: 88px; height: 31px;' src='".e_PLUGIN_ABS."links_page/images/generic.png' alt='".$LINK_RATED_NAME."' /></a>";
    		}else{
    			$LINK_RATED_BUTTON = "";
    		}
    	}
    }else{
    	if(isset($this->plugPrefs['link_icon_empty']) && $this->plugPrefs['link_icon_empty']){
    		$LINK_RATED_BUTTON = $LINK_RATED_APPEND."\n<img style='border:0; width: 88px; height: 31px;' src='".e_PLUGIN_ABS."links_page/images/generic.png' alt='".$LINK_RATED_NAME."' /></a>";
    	}else{
    		$LINK_RATED_BUTTON = "";
    	}
    }
    return $LINK_RATED_BUTTON;
  } 
  
  function sc_link_rated_append($parm='')
	{ 
    global $LINK_RATED_APPEND;
    return $LINK_RATED_APPEND;
  } 
  
  function sc_link_rated_category($parm='')
	{ 
    global $LINK_RATED_CATEGORY, $rowl, $qs, $tp;
    if(!isset($qs[1])){
    $LINK_RATED_CATEGORY = "<a href='".e_SELF."?cat.".$rowl['link_category_id']."'>".$tp->toHTML($rowl['link_category_name'], TRUE)."</a>";
    }
    return $LINK_RATED_CATEGORY;
  } 
  
  function sc_link_rated_name($parm='')
	{ 
    global $LINK_RATED_NAME, $rowl;
    return $rowl['link_name'];
  } 
  
  function sc_link_rated_url($parm='')
	{ 
    global $LINK_RATED_URL, $rowl;
    return (isset($this->plugPrefs['link_url']) && $this->plugPrefs['link_url'] ? $rowl['link_url'] : "");
  } 
  
  function sc_link_rated_refer($parm='')
	{ 
    global $LINK_RATED_REFER, $rowl;
    return (isset($this->plugPrefs['link_referal']) && $this->plugPrefs['link_referal'] ? LAN_LINKS_26." ".$rowl['link_refer'] : "");
  } 
  
  function sc_nk_rated_desc($parm='')
	{ 
global $LINK_RATED_DESC,  $tp, $rowl;
return (isset($this->plugPrefs['link_desc']) && $this->plugPrefs['link_desc'] ? $tp->toHTML($rowl['link_description'], TRUE) : "");
  } 
    
  // LINK_SUBMIT_TABLE ------------------------------------------------    
  function sc_link_submit_cat($parm='')
	{ 
    $db  = e107::getDb();
    $frm = e107::getForm();
    
    if($allRows = $db->retrieve("links_page_cat", "*", " link_category_class REGEXP '".e_CLASS_REGEXP."' ", TRUE))
    {
    	foreach($allRows as $catrow)
    	{                                
    		$id =  $catrow['link_category_id']; $name = $catrow['link_category_name']; 
        $catlist[$id] = $name;
    	}
    } 
    $LINK_SUBMIT_CAT .= $frm->select('cat_id',$catlist,$row['link_category']);         
    return $LINK_SUBMIT_CAT;
  }    
  
  function sc_link_submit_pretext($parm='')
	{ 
    global $LINK_SUBMIT_PRETEXT;
    if(isset($this->plugPrefs['link_submit_directpost']) && $this->plugPrefs['link_submit_directpost']){
    return "";
    }else{
    return LCLAN_SL_9;
  }     
 }
 
  function sc_link_submit_name($parm='')
	{ 
    $frm = e107::getForm();
    return $frm->text('link_name',$this->var['link_name'],100,array('required'=>'1'));
  } 
  
  function sc_link_submit_url($parm='')
	{ 
    $frm = e107::getForm();
    return $frm->text('link_url',$this->var['link_url'],100,array('required'=>'1'));
  } 
      
  function sc_link_submit_description($parm='')
	{ 
    $frm = e107::getForm();
    return $frm->textarea('link_description',$this->var['link_description'],3,59,array('size'=>'xxlarge','required'=>'1'));
  }   
  
  function sc_link_submit_image($parm='')
	{ 
    $frm = e107::getForm();
    return $frm->imagepicker("link_button",  $this->var['link_button'] , LCLAN_ITEM_7, "media=linkspage");
  }
  

}
 
?>
