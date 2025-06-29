<?php
if (!defined('e107_INIT')) { exit; }

class plugin_links_page_menu_shortcodes extends e_shortcode
{

	/**
	 * Private variable to store plugin configurations.
	 *
	 * @var array
	 */
	private $plugPrefs = array();
  
	private $tp;
	private $sql;
	private $rs;
	private $bullet;
	/**
	 * Constructor.
	 */
	function __construct()
	{
		$this->plugPrefs = e107::getPlugConfig('links_page')->getPref();
    $this->tp = e107::getParser();
    $this->sql = e107::getDb();

//    require_once(e_HANDLER."form_handler.php");
    $this->rs = e107::getForm();

    if(defined('BULLET'))
    {
      $this->bullet = '<img src="'.THEME_ABS.'images/'.BULLET.'" alt="" style="vertical-align: middle;" />';
    }
    elseif(file_exists(THEME.'images/bullet2.gif'))
    {
      $this->bullet = '<img src="'.THEME_ABS.'images/bullet2.gif" alt="" style="vertical-align: middle;" />';
    }
	}

  
	function sc_link_menu_navigator($parm='')
	{ 
//    $this->plugPrefs = e107::pref('links_page');

//    var_dump($this->plugPrefs);
//    var_dump($this->plugPrefs);

    //new navigator -------------------------
    $mains = array();
//    $baseurl = e107::url('links_page', 'index');
      $cap = ($this->plugPrefs['link_menu_navigator_caption'] ??LCLAN_OPT_82);
      if($this->plugPrefs['link_menu_navigator_rendertype'] == "1"){
        if($this->plugPrefs['link_menu_navigator_frontpage']){
            $mains[e107::url('links_page', 'index')]= LAN_LINKS_14;
        }
        if($this->plugPrefs['link_menu_navigator_refer']){
            $mains[e107::url('links_page', 'top')]= LAN_LINKS_12;
        }
        if($this->plugPrefs['link_menu_navigator_rated']){
            $mains[e107::url('links_page', 'rated')]= LAN_LINKS_13;
        }
        if($this->plugPrefs['link_menu_navigator_category']){
            $mains[e107::url('links_page', 'allcats')]= LAN_LINKS_43;
        }
        if($this->plugPrefs['link_menu_navigator_links']){
            $mains[e107::url('links_page', 'alllinks')]= LCLAN_OPT_68;
        }
        if($this->plugPrefs['link_menu_navigator_submit'] && $this->plugPrefs['link_submit'] && check_class($this->plugPrefs['link_submit_class'])){
            $mains[e107::url('links_page', 'submit')]= LAN_LINKS_27;
        }
        if($this->plugPrefs['link_menu_navigator_manager'] && $this->plugPrefs['link_manager'] && check_class($this->plugPrefs['link_manager_class'])){
          $mains[e107::url('links_page', 'manage')]=LCLAN_ITEM_35;
        }  

        $options['other'] = "style='width:100%;' onchange=\"if(this.options[this.selectedIndex].value != ''){ return document.location=this.options[this.selectedIndex].value; }\" ";
        $text = $this->rs->select("navigator", $mains, false, $options, $cap)."<br />";
      }else{

        $text = $cap."<br />";
        if($this->plugPrefs['link_menu_navigator_frontpage']){
            $text .= $this->bullet." <a href='". e107::url('links_page', 'index')."'>".LAN_LINKS_14."</a><br />";
        }
        if($this->plugPrefs['link_menu_navigator_refer']){
            $text .= $this->bullet." <a href='".e107::url('links_page', 'top').">".LAN_LINKS_12."</a><br />";
        }
        if($this->plugPrefs['link_menu_navigator_rated']){
            $text .= $this->bullet." <a href='".e107::url('links_page', 'rated')."'>".LAN_LINKS_13."</a><br />";
        }
        if($this->plugPrefs['link_menu_navigator_category']){
            $text .= $this->bullet." <a href='".e107::url('links_page', 'allcats')."'>".LAN_LINKS_43."</a><br />";
        }
        if($this->plugPrefs['link_menu_navigator_links']){
            $text .= $this->bullet." <a href='".e107::url('links_page', 'alllinks')."'>".LCLAN_OPT_68."</a><br />";
        }
        if($this->plugPrefs['link_menu_navigator_submit'] && $this->plugPrefs['link_submit'] && check_class($this->plugPrefs['link_submit_class'])){
            $text .= $this->bullet." <a href='".e107::url('links_page', 'submit')."'>".LAN_LINKS_27."</a><br />";
        }
        if($this->plugPrefs['link_menu_navigator_manager'] && $this->plugPrefs['link_manager'] && check_class($this->plugPrefs['link_manager_class'])){
          $text .= $this->bullet." <a href='".e107::url('links_page', 'manage')."'>".LCLAN_ITEM_35."</a><br />";
        }  
        $text .= "<br />";
 //     }
      
    }
		return $text; 
}

  function sc_link_menu_categories($parm='')
	{ 
  if(isset($this->plugPrefs['link_menu_category']) && $this->plugPrefs['link_menu_category']){
	$mains = array();
	$mainst = "";
	$cap = ($this->plugPrefs['link_menu_category_caption'] ?? LAN_LINKS_19);
	$sqlc = new db; $sql2 = new db;
	if ($sqlc->db_Select("links_page_cat", "link_category_id, link_category_name, link_category_sef", "link_category_class REGEXP '".e_CLASS_REGEXP."' ORDER BY link_category_order")){
		while ($rowc = $sqlc->fetch()){
			if($this->plugPrefs['link_menu_category_amount']){
				$amount = $sql2 -> count("links_page", "(*)", "WHERE link_category = '".$rowc['link_category_id']."' AND link_active = 1 AND link_class REGEXP '".e_CLASS_REGEXP."' ");
				$amount = "(".$amount.")";
			}else{
				$amount = "";
			}
			if($this->plugPrefs['link_menu_category_rendertype'] == "1"){
				$mains[e107::url('links_page', 'category', $rowc, 'full')] = $rowc['link_category_name']." ".$amount;
			}else{
				$mainst .= $this->bullet." <a href='".e107::url('links_page', 'category', $rowc, 'full')."'>".$rowc['link_category_name']."</a> ".$amount."<br />";
			}   
		}
		if($this->plugPrefs['link_menu_category_rendertype'] == "1"){
      $options['other'] = "style='width:100%;' onchange=\"if(this.options[this.selectedIndex].value != ''){ return document.location=this.options[this.selectedIndex].value; }\" ";
      $text = $this->rs->select("navigator", $mains, false, $options, $cap)."<br />";
    }else{
			$text = $cap."<br />";
			$text .= $mainst;
		}
	}
}
    return $text;
  }
  
  function sc_link_menu_recent($parms='')
	{ 
//recent ----------------------------

if($this->plugPrefs["link_menu_recent"]){
  $caption = ($this->var['template']['recent_caption']?$this->tp->parseTemplate($this->var['template']['recent_caption'], true, $this):($this->plugPrefs['link_menu_recent_caption'] ?? LCLAN_OPT_84)."<br />");
  if($parms["caption"]){
    return $caption;
  }

	$qry = "
	SELECT l.*, c.link_category_id, c.link_category_name
	FROM #links_page AS l
	LEFT JOIN #links_page_cat AS c ON c.link_category_id = l.link_category
	WHERE l.link_active = 1 AND l.link_class REGEXP '".e_CLASS_REGEXP."' AND c.link_category_class REGEXP '".e_CLASS_REGEXP."'
	ORDER BY l.link_datestamp DESC LIMIT 0,".intval($this->plugPrefs["link_menu_recent_number"] ?? "5")." 
	";

  if($this->sql->gen($qry)){
    require_once(e_PLUGIN.'links_page/includes/link_class.php');
    $lc = new linkclass();
    while($row = $this->sql->fetch()){
      $menulinkvars['LINK_MENU_BULLET']=$this->bullet;
      $menulinkvars['LINK_MENU_LINK']=$lc->parse_link_append($row).$this->tp->toHTML($row['link_name'],TRUE,"")."</a>";
      $menulinkvars['LINK_MENU_LINKCAT']=($this->plugPrefs['link_menu_recent_category'] ? "<br /><a href='".e_PLUGIN."links_page/links.php?cat.".$row['link_category_id']."'>".$row['link_category_name']."</a>" : "");
      $menulinkvars['LINK_MENU_LINKDESC']=($this->plugPrefs['link_menu_recent_description'] && $row['link_description'] ? "<br />".$this->tp->toHTML($row['link_description'],TRUE,"") : "");
      $menulinkvars['LINK_MENU_LINKREFER']=$this->tp->toHTML($row['link_refer'],TRUE,"");
      $menulinkvars['LINK_MENU_LINKDATESTAMP']=$this->tp->toDate($row['link_datestamp'], "short");      

      $text .= $this->tp->parseTemplate($this->var['template']['recent_item'], true, $menulinkvars);
    }
    $text = $this->tp->parseTemplate($this->var['template']['recent_start'].$text.$this->var['template']['recent_end'], true, $this);
	}
  if($parms["links"]){
    return $text;
  }
  return $caption.$text;
}

} 

/*
**********************************************
Isto estava no antigo e_shortcode do elinks_page.....


class elinks_page_shortcodes extends e_shortcode// must match the plugin's folder name. ie. [PLUGIN_FOLDER]_shortcodes
{	
	public $override = true; // when set to true, existing core/plugin shortcodes matching methods below will be overridden. 
/*
	protected $forumObj;
	protected $viewforum_sc;
*/
//protected $news_sc;
/*---------------
protected $tp;
//protected $sql_elinks;

	function __construct(){
		/*
			parent::__construct();
				$this->e107 = e107::getInstance();
		*/
/*			include_once(e_PLUGIN . "forum/forum_class.php");
			$this->forumObj = new e107forum();
*/

//			$this->viewforum_sc = e107::getScBatch('view', 'forum');   // Isto não funciona aqui, estoura....

//      $this->init();
		//    $this->scf = e107::getScBatch('forum');
/*-----------------------------
			$this->tp = e107::getParser();
		//    $this->forumsc = e107::getScBatch('forum',TRUE);
		//    $this->menu['foruminfo'] = e107::getmenu()->isLoaded("foruminfo");
//    $this->sql_elinks = e107::getDb();

		// O breadcrumb passou para o e_parse do eforum
		  }
		

// ###########################################
// ##### LINKS_PAGE PLUGIN OVERRIDE SHORTCODES #####
// ###########################################

function sc_link_menu_navigator($parm='')
{ 
//    $this->plugPrefs = e107::pref('links_page');
$linksplugPrefs = e107::getPlugConfig('links_page')->getPref();
//    var_dump($this->plugPrefs);
//    var_dump($this->plugPrefs);

  //new navigator -------------------------
  $mains = array();
//    $baseurl = e107::url('links_page', 'index');
    $cap = ($linksplugPrefs['link_menu_navigator_caption'] ??LCLAN_OPT_82);
    if($linksplugPrefs['link_menu_navigator_rendertype'] == "1"){
      if($linksplugPrefs['link_menu_navigator_frontpage']){
          $mains[e107::url('links_page', 'index')]= LAN_LINKS_14;
      }
      if($linksplugPrefs['link_menu_navigator_refer']){
          $mains[e107::url('links_page', 'top')]= LAN_LINKS_12;
      }
      if($linksplugPrefs['link_menu_navigator_rated']){
          $mains[e107::url('links_page', 'rated')]= LAN_LINKS_13;
      }
      if($linksplugPrefs['link_menu_navigator_category']){
          $mains[e107::url('links_page', 'allcats')]= LAN_LINKS_43;
      }
      if($linksplugPrefs['link_menu_navigator_links']){
          $mains[e107::url('links_page', 'alllinks')]= LCLAN_OPT_68;
      }
      if($linksplugPrefs['link_menu_navigator_submit'] && $linksplugPrefs['link_submit'] && check_class($linksplugPrefs['link_submit_class'])){
          $mains[e107::url('links_page', 'submit')]= LAN_LINKS_27;
      }
      if($linksplugPrefs['link_menu_navigator_manager'] && $linksplugPrefs['link_manager'] && check_class($linksplugPrefs['link_manager_class'])){
        $mains[e107::url('links_page', 'manage')]=LCLAN_ITEM_35;
      }  

//      $options['other'] = "style='width:100%;' onchange=\"if(this.options[this.selectedIndex].value != ''){ return document.location=this.options[this.selectedIndex].value; }\" ";
//      $text = $this->rs->select("navigator", $mains, false, $options, $cap)."<br />";
      $text = $this->elinks_button("navigator", $mains, "dropdown", $cap)."<br />";
  }else{

      $text = $cap."<br />";
      if($linksplugPrefs['link_menu_navigator_frontpage']){
          $text .= $this->bullet." <a href='". e107::url('links_page', 'index')."'>".LAN_LINKS_14."</a><br />";
      }
      if($linksplugPrefs['link_menu_navigator_refer']){
          $text .= $this->bullet." <a href='".e107::url('links_page', 'top').">".LAN_LINKS_12."</a><br />";
      }
      if($linksplugPrefs['link_menu_navigator_rated']){
          $text .= $this->bullet." <a href='".e107::url('links_page', 'rated')."'>".LAN_LINKS_13."</a><br />";
      }
      if($linksplugPrefs['link_menu_navigator_category']){
          $text .= $this->bullet." <a href='".e107::url('links_page', 'allcats')."'>".LAN_LINKS_43."</a><br />";
      }
      if($linksplugPrefs['link_menu_navigator_links']){
          $text .= $this->bullet." <a href='".e107::url('links_page', 'alllinks')."'>".LCLAN_OPT_68."</a><br />";
      }
      if($linksplugPrefs['link_menu_navigator_submit'] && $linksplugPrefs['link_submit'] && check_class($linksplugPrefs['link_submit_class'])){
          $text .= $this->bullet." <a href='".e107::url('links_page', 'submit')."'>".LAN_LINKS_27."</a><br />";
      }
      if($linksplugPrefs['link_menu_navigator_manager'] && $linksplugPrefs['link_manager'] && check_class($linksplugPrefs['link_manager_class'])){
        $text .= $this->bullet." <a href='".e107::url('links_page', 'manage')."'>".LCLAN_ITEM_35."</a><br />";
      }  
      $text .= "<br />";
//     }
    
  }
  return $text; 
}

function sc_link_menu_categories($parm='')
{ 
  $linksplugPrefs = e107::getPlugConfig('links_page')->getPref();
//  var_dump($linksplugPrefs);
  if($linksplugPrefs['link_menu_category']){
$mains = array();
$mainst = "";
$cap = ($linksplugPrefs['link_menu_category_caption'] ?? LAN_LINKS_19);
$sqlc = new db; $sql2 = new db;
if ($sqlc->db_Select("links_page_cat", "link_category_id, link_category_name, link_category_sef", "link_category_class REGEXP '".e_CLASS_REGEXP."' ORDER BY link_category_order")){
  while ($rowc = $sqlc->fetch()){
    if($linksplugPrefs['link_menu_category_amount']){
      $amount = $sql2 -> count("links_page", "(*)", "WHERE link_category = '".$rowc['link_category_id']."' AND link_active = 1 AND link_class REGEXP '".e_CLASS_REGEXP."' ");
      $amount = "(".$amount.")";
    }else{
      $amount = "";
    }
    if($linksplugPrefs['link_menu_category_rendertype'] == "1"){
      $mains[e107::url('links_page', 'category', $rowc, 'full')] = $rowc['link_category_name']." ".$amount;
    }else{
      $mainst .= $this->bullet." <a href='".e107::url('links_page', 'category', $rowc, 'full')."'>".$rowc['link_category_name']."</a> ".$amount."<br />";
    }   
  }
//  VAR_dump("##");
  if($linksplugPrefs['link_menu_category_rendertype'] == "1"){
//    VAR_dump("##");
//        $options['other'] = "style='width:100%;' onchange=\"if(this.options[this.selectedIndex].value != ''){ return document.location=this.options[this.selectedIndex].value; }\" ";
/////    $text = $this->rs->select("navigator", $mains, false, $options, $cap)."<br />";
    $text = $this->elinks_button("navigator", $mains, "dropdown", $cap)."<br />";
}else{
    $text = $cap."<br />";
    $text .= $mainst;
  }
}
}
  return $text;
}


// ########## END OF REWRITEN ORIGINAL LINKS_PAGE SHORTCODES ##############
// ####################################
// ##### PLUGIN GLOBAL SHORTCODES #####
// ####################################

	/**
	 * Generic Button Element. 
	 * @param string $name
	 * @param string|array $value
	 * @param string $action [optional] default is submit - use 'dropdown' for a bootstrap dropdown button. 
	 * @param string $label [optional]
	 * @param string|array $options [optional]
	 * @return string
	 */
/*-----------------------------
	private function elinks_button($name, $value, $action = 'submit', $label = '', $options = array())
	{
		if($action === 'dropdown' && is_array($value))
		{
		//	$options = $this->format_options('admin_button', $name, $options);
			$options['class'] = vartrue($options['class']);
			
			$align = vartrue($options['align'],'left');
					
			$text = '<div class="btn-group pull-'.$align.'">
			    <a class="btn dropdown-toggle '.$options['class'].'" data-toggle="dropdown" data-bs-toggle="dropdown" href="#">
			    '.($label ?: LAN_NO_LABEL_PROVIDED).'
			    <span class="caret"></span>
			    </a>
			    <ul class="dropdown-menu dropdown-menu-lg-end">
			    ';
			
			foreach($value as $k=>$v)
			{
				$text .= '<li class="dropdown-item"><a href="'.$k.'">'.$v.'</a></li>';
			}
			
			$text .= '
			    </ul>
			    </div>';
			
			return $text;	
		}
  }



*/
}