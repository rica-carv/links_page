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
  $baseurl = e_PLUGIN_ABS."links_page/links.php";
if(isset($this->plugPrefs['link_navigator_frontpage']) && $this->plugPrefs['link_navigator_frontpage']){
 
  $mains .= $rs -> form_option(LAN_LINKS_14, "0", $baseurl, "");
}
if(isset($this->plugPrefs['link_navigator_refer']) && $this->plugPrefs['link_navigator_refer']){
	$mains .= $rs -> form_option(LAN_LINKS_12, "0", $baseurl."?top", "");
}
if(isset($this->plugPrefs['link_navigator_rated']) && $this->plugPrefs['link_navigator_rated']){
	$mains .= $rs -> form_option(LAN_LINKS_13, "0", $baseurl."?rated", "");
}
if(isset($this->plugPrefs['link_navigator_category']) && $this->plugPrefs['link_navigator_category']){
	$mains .= $rs -> form_option(LAN_LINKS_43, "0", $baseurl."?cat", "");
}
if(isset($this->plugPrefs['link_navigator_links']) && $this->plugPrefs['link_navigator_links']){
	$mains .= $rs -> form_option(LAN_LINKS_51, "0", $baseurl."?all", "");
}
if(isset($this->plugPrefs['link_navigator_submit']) && $this->plugPrefs['link_navigator_submit'] && isset($this->plugPrefs['link_submit']) && $this->plugPrefs['link_submit'] && check_class($this->plugPrefs['link_submit_class'])){
	$mains .= $rs -> form_option(LAN_LINKS_27, "0", $baseurl."?submit", "");
}
if(isset($this->plugPrefs['link_navigator_manager']) && $this->plugPrefs['link_navigator_manager'] && isset($this->plugPrefs['link_manager']) && $this->plugPrefs['link_manager'] && check_class($this->plugPrefs['link_manager_class'])){
	$mains .= $rs -> form_option(LCLAN_ITEM_35, "0", $baseurl."?manage", "");
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
 
    $baseurl = e_PLUGIN_ABS."links_page/links.php";
    if(isset($this->plugPrefs['link_navigator_allcat']) && $this->plugPrefs['link_navigator_allcat']){     
    	$sqlc = new db;
    	if ($sqlc->db_Select("links_page_cat", "link_category_id, link_category_name", "link_category_class REGEXP '".e_CLASS_REGEXP."' ORDER BY link_category_name")){
    		$mains .= $rs -> form_option("&nbsp;", "0", "", "");
    		$mains .= $rs -> form_option(LAN_LINKS_48, "0", "", "");
    		while ($rowc = $sqlc->db_Fetch()){
    			$mains .= $rs -> form_option($rowc['link_category_name'], "0", $baseurl."?cat.".$rowc['link_category_id'], "");
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
    $LINK_MANAGE_OPTIONS = "<a href='".e_SELF."?manage.edit.".$linkid."' title='".LCLAN_ITEM_31."'>".LINK_ICON_EDIT."</a>";
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
    global $LINK_MANAGE_NEWLINK;
    return "<a href='".e_SELF."?manage'>".LAN_LINKS_MANAGER_3."</a>";
  } 
  
  function sc_link_main_heading($parm='')
	{ 
    global $LINK_MAIN_HEADING, $rowl, $tp;
    return (!$rowl['total_links'] ? $rowl['link_category_name'] : "<a href='".e_PLUGIN_ABS."links_page/links.php?cat.".$rowl['link_category_id']."'>".$tp->toHTML($rowl['link_category_name'], TRUE)."</a>");
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
		if(strstr($rowl['link_category_icon'], "/"))
		{
			if(file_exists(e_BASE.$rowl['link_category_icon']))
			{
				$LINK_MAIN_ICON = "<img src='".e_BASE.$rowl['link_category_icon']."' alt='' style='border:0; vertical-align:middle' />";
			}
			else
			{
				if(isset($this->plugPrefs['link_cat_icon_empty']) && $this->plugPrefs['link_cat_icon_empty'])
				{
					$LINK_MAIN_ICON = $bullet;
				}
			}
		}
		else
		{
			if(file_exists(e_PLUGIN."links_page/cat_images/".$rowl['link_category_icon']))
			{
			$LINK_MAIN_ICON = "<img src='".e_PLUGIN_ABS."links_page/cat_images/".$rowl['link_category_icon']."' alt='' style='border:0; vertical-align:middle' />";
			}
			else
			{
				if(isset($this->plugPrefs['link_cat_icon_empty']) && $this->plugPrefs['link_cat_icon_empty'])
				{
					$LINK_MAIN_ICON = $bullet;
				}
			}
		}
	}
	else
	{
		if(isset($this->plugPrefs['link_cat_icon_empty']) && $this->plugPrefs['link_cat_icon_empty'])
		{
			$LINK_MAIN_ICON = $bullet;
		}
	}
	if($rowl['total_links'] && $LINK_MAIN_ICON)
	{
		$LINK_MAIN_ICON = "<a href='".e_PLUGIN_ABS."links_page/links.php?cat.".$rowl['link_category_id']."'>".$LINK_MAIN_ICON."</a>";
	}
}
return $LINK_MAIN_ICON;
  }

 
 
  function sc_link_main_total($parm='')
	{ 
    global $LINK_MAIN_TOTAL, $sql, $category_total,  $alllinks;
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
    return (isset($this->plugPrefs['link_cat_total']) && $this->plugPrefs['link_cat_total'] ? "<a href='".e_PLUGIN_ABS."links_page/links.php?cat.all'>".LAN_LINKS_25."</a>" : "");
  } 
 



// LINK_TABLE ------------------------------------------------

  function sc_link_button($parm='')
	{ 
    global $LINK_MAIN_SHOWALL;
    return (isset($this->plugPrefs['link_cat_total']) && $this->plugPrefs['link_cat_total'] ? "<a href='".e_PLUGIN_ABS."links_page/links.php?cat.all'>".LAN_LINKS_25."</a>" : "");
 
global $LINK_BUTTON, $rowl, $LINK_NAME, $LINK_APPEND;

if(!$this->plugPrefs['link_icon']){
	return "";
}
$LINK_BUTTON = "&nbsp;";
if(isset($this->plugPrefs['link_icon']) && $this->plugPrefs['link_icon']){
	if ($rowl['link_button']) {
		if (strpos($rowl['link_button'], "http://") !== FALSE) {
			$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button' src='".$rowl['link_button']."' alt='' /></a>";
		} else {
			if(strstr($rowl['link_button'], "/")){
				if(file_exists(e_BASE.$rowl['link_button'])){
					$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button' src='".e_BASE.$rowl['link_button']."' alt='' /></a>";
				} else {
					if(isset($this->plugPrefs['link_icon_empty']) && $this->plugPrefs['link_icon_empty']){
						$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button' style='width: 88px; height: 31px;' src='".e_PLUGIN_ABS."links_page/images/generic.png' alt='' /></a>";
					}
				}
			}else{
				if(file_exists(e_PLUGIN."links_page/link_images/".$rowl['link_button'])){
					$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button' src='".e_PLUGIN_ABS."links_page/link_images/".$rowl['link_button']."' alt='' /></a>";
				}else{
					if(isset($this->plugPrefs['link_icon_empty']) && $this->plugPrefs['link_icon_empty']){
					$LINK_BUTTON = $LINK_APPEND."\n<img class='linkspage_button' style='width: 88px; height: 31px;' src='".e_PLUGIN_ABS."links_page/images/generic.png' alt='' /></a>";
					}
				}
			}
		}
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
    global $LINK_RATING, $LINK_RATED_RATING, $rater, $rowl, $qs;
    $LINK_RATING = "";
    if(isset($this->plugPrefs['link_rating']) && $this->plugPrefs['link_rating']){
    $LINK_RATING = $rater->composerating("links_page", $rowl['link_id'], $enter=TRUE, $userid=FALSE);
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
    $tmp = explode(".", $rowl['rate_avg']);
    $one = $tmp[0];
    $two = round($tmp[1],1);
    $rating = $one.".".$two." ";
    for($c=1; $c<= $one; $c++){
    	$rating .= "<img src='".e_IMAGE_ABS."rate/box.png' alt='' style='height:8px; vertical-align:middle' />";
    }
    if($one < 10){
    	for($c=9; $c>=$one; $c--){
    		$rating .= "<img src='".e_IMAGE_ABS."rate/empty.png' alt='' style='height:8px; vertical-align:middle' />";
    	}
    }
    $rating .= "<img src='".e_IMAGE_ABS."rate/boxend.png' alt='' style='height:8px; vertical-align:middle' />";
    return $rating;
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
    global $LINK_SUBMIT_CAT;
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
}
 
?>
