<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/links_page/link_class.php $
|     $Revision: 12570 $
|     $Id: link_class.php 12570 2012-01-21 16:42:48Z e107steved $
|     $Author: e107steved $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }


define('URL_SEPARATOR','X');		// Used in names of 'inc' and 'dec' fields

class linkclass 
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
  
   
	function ShowNextPrev($from='0', $number, $total)
	{
		global  $qs, $tp, $link_shortcodes, $LINK_NEXTPREV, $LINK_NP_TABLE, $pref;

		$number = (e_PAGE == 'admin_linkspage_config.php' ? '20' : $number);
		if($total<=$number)
		{
			return;
		}
		if(e_PAGE == 'admin_linkspage_config.php' || (isset($this->plugPrefs["link_nextprev"]) && $this->plugPrefs["link_nextprev"]))
		{
			$np_querystring = e_SELF."?[FROM]".(isset($qs[0]) ? ".".$qs[0] : "").(isset($qs[1]) ? ".".$qs[1] : "").(isset($qs[2]) ? ".".$qs[2] : "").(isset($qs[3]) ? ".".$qs[3] : "").(isset($qs[4]) ? ".".$qs[4] : "");
			$parms = $total.",".$number.",".$from.",".$np_querystring."";
			$LINK_NEXTPREV = $tp->parseTemplate("{NEXTPREV={$parms}}");

			if(!isset($LINK_NP_TABLE)){
				$template = (e_PAGE == 'admin_linkspage_config.php' ? e_THEME.$pref['sitetheme']."/" : THEME)."links_template.php";
				if(is_readable($template)){
					require_once($template);
				}else{
					require_once(e_PLUGIN."links_page/links_template.php");
				}
			}
			echo $tp -> parseTemplate($LINK_NP_TABLE, FALSE, $link_shortcodes);
		}
	}


    function setPageTitle()
	{
        global $sql, $qs;

        //show all categories
        if(!isset($qs[0]) && $this->plugPrefs['link_page_categories']){
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_2;
        }
        //show all categories
        if(isset($qs[0]) && $qs[0] == "cat" && !isset($qs[1]) ){
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_2;
        }
        //show all links in all categories
        if( (!isset($qs[0]) && !$this->plugPrefs['link_page_categories']) || (isset($qs[0]) && $qs[0] == "all") ){
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_3;
        }
        //show all links in one categories
        if(isset($qs[0]) && $qs[0] == "cat" && isset($qs[1]) && is_numeric($qs[1])){
            $sql -> db_Select("links_page_cat", "link_category_name", "link_category_id='".$qs[1]."' ");
            $row2 = $sql -> db_Fetch();
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_4." / ".$row2['link_category_name'];
        }
        //view top rated
        if(isset($qs[0]) && $qs[0] == "rated"){
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_5;
        }
        //view top refer
        if(isset($qs[0]) && $qs[0] == "top"){
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_6;
        }
        //personal link managers
        if (isset($qs[0]) && $qs[0] == "manage"){
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_7;
        }
        //comments on links
        if (isset($qs[0]) && $qs[0] == "comment" && isset($qs[1]) && is_numeric($qs[1]) ){
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_8;
        }
        //submit link
        if (isset($qs[0]) && $qs[0] == "submit" && check_class($this->plugPrefs['link_submit_class'])) {
            $page = LCLAN_PAGETITLE_1." / ".LCLAN_PAGETITLE_9;
        }
        //define("e_PAGETITLE", strtolower($page));
        define("e_PAGETITLE", $page);
    }




    function parse_link_append($rowl)
	{
        global $tp;
        if($this->plugPrefs['link_open_all'] && $this->plugPrefs['link_open_all'] == "5"){
            $link_open_type = $rowl['link_open'];
        }else{
            $link_open_type = $this->plugPrefs['link_open_all'];
        }

        switch ($link_open_type) {
            case 1:
            $lappend = "<a class='linkspage_url' href='".$rowl['link_url']."' onclick=\"open_window('".e_PLUGIN_ABS."links_page/links.php?view.".$rowl['link_id']."','full');return false;\" >"; // Googlebot won't see it any other way.
            break;
            case 2:
            $lappend = "<a class='linkspage_url' href='".$rowl['link_url']."' onclick=\"location.href='".e_PLUGIN_ABS."links_page/links.php?view.".$rowl['link_id']."';return false\" >";  // Googlebot won't see it any other way.
            break;
            case 3:
            $lappend = "<a class='linkspage_url' href='".$rowl['link_url']."' onclick=\"location.href='".e_PLUGIN_ABS."links_page/links.php?view.".$rowl['link_id']."';return false\" >";  // Googlebot won't see it any other way.
            break;
            case 4:
            $lappend = "<a class='linkspage_url' href='".$rowl['link_url']."' onclick=\"open_window('".e_PLUGIN_ABS."links_page/links.php?view.".$rowl['link_id']."');return false\">"; // Googlebot won't see it any other way.
            break;
            default:
            $lappend = "<a class='linkspage_url' href='".$rowl['link_url']."' onclick=\"location.href='".e_PLUGIN_ABS."links_page/links.php?view.".$rowl['link_id']."';return false\" >";  // Googlebot won't see it any other way.
        }
        return $lappend;
    }





    function showLinkSort($mode='')
	{
        global $rs, $ns, $qs;

        $check = "";
        if($qs){
            for($i=0;$i<count($qs);$i++){
                if($qs[$i] && substr($qs[$i],0,5) == "order"){
                    $check = $qs[$i];
                    break;
                }
            }
        }
        if($check){
            //string is like : order + a + heading
            $checks = substr($check,6);
            $checko = substr($check,5,1);
        }else{
            $checks = "";
            $checko = "";
        }
        $baseurl = e_PLUGIN_ABS."links_page/links.php";
        $qry = (isset($qs[0]) && substr($qs[0],0,5) != "order" ? $qs[0] : "").(isset($qs[1]) && substr($qs[1],0,5) != "order" ? ".".$qs[1] : "").(isset($qs[2]) && substr($qs[2],0,5) != "order" ? ".".$qs[2] : "").(isset($qs[3]) && substr($qs[3],0,5) != "order" ? ".".$qs[3] : "");

        $sotext = "
        ".$rs -> form_open("post", e_SELF, "linkorder", "", "enctype='multipart/form-data'")."
            ".LAN_LINKS_15."
            ".$rs -> form_select_open("link_sort");
            if($mode == "cat"){
                $sotext .= "
                ".$rs -> form_option(LAN_LINKS_4, ($checks == "heading" ? "1" : "0"), "heading", "")."
                ".$rs -> form_option(LAN_LINKS_44, ($checks == "id" ? "1" : "0"), "id", "")."
                ".$rs -> form_option(LAN_LINKS_6, ($checks == "order" ? "1" : "0"), "order", "");
            }else{
                $sotext .= "
                ".$rs -> form_option(LAN_LINKS_4, ($checks == "heading" ? "1" : "0"), "heading", "")."
                ".$rs -> form_option(LAN_LINKS_5, ($checks == "url" ? "1" : "0"), "url", "")."
                ".$rs -> form_option(LAN_LINKS_6, ($checks == "order" ? "1" : "0"), "order", "")."
                ".$rs -> form_option(LAN_LINKS_7, ($checks == "refer" ? "1" : "0"), "refer", "")."
                ".$rs -> form_option(LAN_LINKS_38, ($checks == "date" ? "1" : "0"), "date", "");
            }
            $sotext .= "
            ".$rs -> form_select_close()."
            ".LAN_LINKS_6."
            ".$rs -> form_select_open("link_order")."
            ".$rs -> form_option(LAN_LINKS_8, ($checko == "a" ? "1" : "0"), $baseurl."?".($qry ? $qry."." : "")."ordera", "")."
            ".$rs -> form_option(LAN_LINKS_9, ($checko == "d" ? "1" : "0"), $baseurl."?".($qry ? $qry."." : "")."orderd", "")."
            ".$rs -> form_select_close()."
            ".$rs -> form_button("button", "submit", LCLAN_ITEM_36, " onclick=\"document.location=link_order.options[link_order.selectedIndex].value+link_sort.options[link_sort.selectedIndex].value;\"", "", "")."
        ".$rs -> form_close();

        return $sotext;
    }


    function parseOrderCat($orderstring)
	{
        if(substr($orderstring,6) == "heading"){
            $orderby        = "link_category_name";
            $orderby2       = "";
        }elseif(substr($orderstring,6) == "id"){
            $orderby        = "link_category_id";
            $orderby2       = ", link_category_name ASC";
        }elseif(substr($orderstring,6) == "order"){
            $orderby        = "link_category_order";
            $orderby2       = ", link_category_name ASC";
        }else{
            $orderstring    = "orderdheading";
            $orderby        = "link_category_name";
            $orderby2       = ", link_category_name ASC";
        }
        return $orderby." ".(substr($orderstring,5,1) == "a" ? "ASC" : "DESC")." ".$orderby2;
    }

	function parseOrderLink($orderstring)
	{
        if(substr($orderstring,6) == "heading"){
            $orderby        = "link_name";
            $orderby2       = "";
        }elseif(substr($orderstring,6) == "url"){
            $orderby        = "link_url";
            $orderby2       = ", link_name ASC";
        }elseif(substr($orderstring,6) == "refer"){
            $orderby        = "link_refer";
            $orderby2       = ", link_name ASC";
        }elseif(substr($orderstring,6) == "date"){
            $orderby        = "link_datestamp";
            $orderby2       = ", link_name ASC";
        }elseif(substr($orderstring,6) == "order"){
            $orderby        = "link_order";
            $orderby2       = ", link_name ASC";
        }else{
            $orderstring    = "orderaorder";
            $orderby        = "link_order";
            $orderby2       = ", link_name ASC";
        }
        return $orderby." ".(substr($orderstring,5,1) == "a" ? "ASC" : "DESC")." ".$orderby2;
    }

	function getOrder($mode='')
	{
        global $qs;

        if(isset($qs[0]) && substr($qs[0],0,5) == "order"){
            $orderstring    = $qs[0];
        }elseif(isset($qs[1]) && substr($qs[1],0,5) == "order"){
            $orderstring    = $qs[1];
        }elseif(isset($qs[2]) && substr($qs[2],0,5) == "order"){
            $orderstring    = $qs[2];
        }elseif(isset($qs[3]) && substr($qs[3],0,5) == "order"){
            $orderstring    = $qs[3];
        }else{
            if($mode == "cat"){
                $orderstring    = "order".($this->plugPrefs["link_cat_order"] == "ASC" ? "a" : "d" ).($this->plugPrefs["link_cat_sort"] ? $this->plugPrefs["link_cat_sort"] : "date" );
            }else{
                $orderstringcat = "order".($this->plugPrefs["link_cat_order"] == "ASC" ? "a" : "d" ).($this->plugPrefs["link_cat_sort"] ? $$this->plugPrefs["link_cat_sort"] : "date" );

                $orderstring    = "order".($this->plugPrefs["link_order"] == "ASC" ? "a" : "d" ).($this->plugPrefs["link_sort"] ? $this->plugPrefs["link_sort"] : "date" );
            }
        }

        if($mode == "cat"){
            $str = $this -> parseOrderCat($orderstring);
        }else{
            if(isset($orderstringcat)){
                $str = $this -> parseOrderCat($orderstringcat);
                $str .= ", ".$this -> parseOrderLink($orderstring);
            }else{
                $str = $this -> parseOrderLink($orderstring);
            }
        }

        $order = " ORDER BY ".$str;
        return $order;
    }

    function show_message($message, $caption='') 
	{
        global $ns;
        $ns->tablerender($caption, "<div style='text-align:center'><b>".$message."</b></div>");
    }

    function uploadLinkIcon()
	{
        global $ns, $pref;
        $pref['upload_storagetype'] = "1";
        require_once(e_HANDLER."upload_handler.php");
        $pathicon = e_PLUGIN."links_page/link_images/";
        $uploaded = file_upload($pathicon);

        $icon = "";
        if($uploaded) 
		{
            $icon = $uploaded[0]['name'];
            if($_POST['link_resize_value'])
			{
                require_once(e_HANDLER."resize_handler.php");
                resize_image($pathicon.$icon, $pathicon.$icon, $_POST['link_resize_value'], "nocopy");
            }
        }
        $msg = ($icon ? LCLAN_ADMIN_7 : LCLAN_ADMIN_8);
        $this -> show_message($msg);
    }

	function uploadCatLinkIcon()
	{
        global $ns, $pref;
        $pref['upload_storagetype'] = "1";
        require_once(e_HANDLER."upload_handler.php");
        $pathicon = e_PLUGIN."links_page/cat_images/";
        $uploaded = file_upload($pathicon);

        $icon = "";
        if($uploaded) 
		{
            $icon = $uploaded[0]['name'];
            if($_POST['link_cat_resize_value'])
			{
                require_once(e_HANDLER."resize_handler.php");
                resize_image($pathicon.$icon, $pathicon.$icon, $_POST['link_cat_resize_value'], "nocopy");
            }
        }
        $msg = ($icon ? LCLAN_ADMIN_7 : LCLAN_ADMIN_8);
        $this -> show_message($msg);
    }


    function dbCategoryCreate() 
	{
        global $sql, $tp;
        $link_t = $sql->db_Count("links_page_cat", "(*)");
        $linkData = array();
		$linkData['link_category_name'] = $tp -> toDB($_POST['link_category_name']);
		$linkData['link_category_description'] = $tp -> toDB($_POST['link_category_description']);
		$linkData['link_category_icon'] = $tp -> toDB($_POST['link_category_icon']);
		$linkData['link_category_order'] = $link_t+1;
		$linkData['link_category_class'] = $tp -> toDB($_POST['link_category_class']);
		$linkData['link_category_datestamp'] = time();
		$sql->db_Insert('links_page_cat', $linkData);
        $this->show_message(LCLAN_ADMIN_4);
    }
	function dbCategoryUpdate() 
	{
        global $sql, $tp;
        $time = ($_POST['update_datestamp'] ? time() : ($_POST['link_category_datestamp'] != "0" ? $_POST['link_category_datestamp'] : time()) );
        $sql->db_Update("links_page_cat", "link_category_name ='".$tp -> toDB($_POST['link_category_name'])."', link_category_description='".$tp -> toDB($_POST['link_category_description'])."', link_category_icon='".$tp -> toDB($_POST['link_category_icon'])."', link_category_order='".$tp -> toDB($_POST['link_category_order'])."', link_category_class='".$tp -> toDB($_POST['link_category_class'])."', link_category_datestamp='".intval($time)."'   WHERE link_category_id='".intval($_POST['link_category_id'])."'");
        $this->show_message(LCLAN_ADMIN_5);
    }


    function dbOrderUpdate($order) 
	{
        global $sql;
		foreach ($order as $order_id) 
		{
            $tmp = explode(".", $order_id);
			$sql->db_Update("links_page", "link_order=".intval($tmp[1])." WHERE link_id=".intval($tmp[0]));
        }
        $this->show_message(LCLAN_ADMIN_9);
    }


	function dbOrderCatUpdate($order) 
	{
        global $sql;
		foreach ($order as $order_id) 
		{
            $tmp = explode(".", $order_id);
            $sql->db_Update("links_page_cat", "link_category_order=".intval($tmp[1])." WHERE link_category_id=".intval($tmp[0]));
        }
        $this->show_message(LCLAN_ADMIN_9);
    }


	function dbOrderUpdateInc($linkid, $link_order, $location) 
	{
        global $sql;
		//$tmp = explode(".", $inc);
        //$linkid = intval($tmp[0]);
        //$link_order = intval($tmp[1]);
        //$location = $tmp[2];
        if($location)
		{
            $sql->db_Update("links_page", "link_order=link_order+1 WHERE link_order='".($link_order-1)."' AND link_category=".$location);
            $sql->db_Update("links_page", "link_order=link_order-1 WHERE link_id='{$linkid}' AND link_category=".$location);
        }
		else
		{
            $sql->db_Update("links_page_cat", "link_category_order=link_category_order+1 WHERE link_category_order=".($link_order-1));
            $sql->db_Update("links_page_cat", "link_category_order=link_category_order-1 WHERE link_category_id=".$linkid);
        }
    }

	function dbOrderUpdateDec($linkid, $link_order, $location) 
	{
        global $sql;
        //$tmp = explode(".", $dec);
        //$linkid = intval($tmp[0]);
        //$link_order = intval($tmp[1]);
        //$location = $tmp[2];
        if($location)
		{
            $sql->db_Update("links_page", "link_order=link_order-1 WHERE link_order=".($link_order+1)." AND link_category=".$location);
            $sql->db_Update("links_page", "link_order=link_order+1 WHERE link_id='{$linkid}' AND link_category=".$location);
        }
		else
		{
            $sql->db_Update("links_page_cat", "link_category_order=link_category_order-1 WHERE link_category_order='".($link_order+1)."' ");
            $sql->db_Update("links_page_cat", "link_category_order=link_category_order+1 WHERE link_category_id=".$linkid);
        }
    }

	function verify_link_manage($id)
	{
		global $sql;

		if ($sql->db_Select("links_page", "link_author", "link_id='".intval($id)."' "))
		{
			$row = $sql->db_Fetch();
		}

		if(varset($row['link_author']) != USERID)
		{
			js_location(SITEURL);
		}
	}

	// Create a new link. If $mode == 'submit', link has to go through the approval process; else its admin entry
    function dbLinkCreate($mode='') 
	{
        global $ns, $tp, $qs, $sql, $e107cache, $e_event;

        $link_name          = $tp->toDB($_POST['link_name']);
        $link_url           = $tp->toDB($_POST['link_url']);
        $link_description   = $tp->toDB($_POST['link_description']);
        $link_button        = $tp->toDB($_POST['link_but']);

		if (!$link_name || !$link_url || !$link_description) 
		{
		  message_handler("ALERT", 5);
		  return;
		} 

        if ($link_url && !strstr($link_url, "http")) 
		{
          $link_url = "http://".$link_url;
        }

        //create link, submit area, tmp table
		if(isset($mode) && $mode == "submit")
		{
		  $username           = (defined('USERNAME')) ? USERNAME : LAN_LINKS_3;

		  $submitted_link     = intval($_POST['cat_id'])."^".$link_name."^".$link_url."^".$link_description."^".$link_button."^".$username;
		  $sql->db_Insert("tmp", "'submitted_link', '".time()."', '$submitted_link' ");

		  $edata_ls = array("link_category" => $_POST['cat_id'], "link_name" => $link_name, "link_url" => $link_url, "link_description" => $link_description, "link_button" => $link_button, "username" => $username, "submitted_link" => $submitted_link);
		  $e_event->trigger("linksub", $edata_ls);
		  //header("location:".e_SELF."?s");
		  js_location(e_SELF."?s");
        }
		else
		{
            $link_t = $sql->db_Count("links_page", "(*)", "WHERE link_category='".intval($_POST['cat_id'])."'");
            $time   = ($_POST['update_datestamp'] ? time() : ($_POST['link_datestamp'] != "0" ? $_POST['link_datestamp'] : time()) );

            //update link
			if (is_numeric($qs[2]) && $qs[1] != "sn") {
				$link_class = $_POST['link_class'];
				if($qs[1] == "manage"){
                    $link_author = USERID;
                }else{
                    $link_author = ($_POST['link_author'] && $_POST['link_author']!='' ? $tp -> toDB($_POST['link_author']) : USERID);
                }

                $sql->db_Update("links_page", "link_name='$link_name', link_url='$link_url', link_description='$link_description', link_button= '$link_button', link_category='".intval($_POST['cat_id'])."', link_open='".intval($_POST['linkopentype'])."', link_class='".intval($link_class)."', link_datestamp='".intval($time)."', link_author='".$link_author."' WHERE link_id='".intval($qs[2])."'");
                $e107cache->clear("sitelinks");
                $this->show_message(LCLAN_ADMIN_3);
            //create link
			} else {

                $sql->db_Insert("links_page", "0, '$link_name', '$link_url', '$link_description', '$link_button', '".intval($_POST['cat_id'])."', '".($link_t+1)."', '0', '".intval($_POST['linkopentype'])."', '".intval($_POST['link_class'])."', '".time()."', '".USERID."' ");
                $e107cache->clear("sitelinks");
                $this->show_message(LCLAN_ADMIN_2);
            }
            //delete from tmp table after approval
			if (is_numeric($qs[2]) && $qs[1] == "sn") {
                $sql->db_Delete("tmp", "tmp_time='".intval($qs[2])."' ");
            }
        }
    }

	function show_link_create()
	{
        global $sql, $rs, $qs, $ns, $fl;

        $row['link_category']       = "";
        $row['link_name']           = "";
        $row['link_url']            = "";
        $row['link_description']    = "";
        $row['link_button']         = "";
        $row['link_open']           = "";
        $row['link_class']          = "";
        $link_resize_value          = (isset($this->plugPrefs['link_resize_value']) && $this->plugPrefs['link_resize_value'] ? $this->plugPrefs['link_resize_value'] : "100");

        if (isset($qs[1]) && $qs[1] == 'edit' && !isset($_POST['submit'])) 
		{
            if ($sql->db_Select("links_page", "*", "link_id='".intval($qs[2])."' ")) 
			{
                $row = $sql->db_Fetch();
            }
        }

        if (isset($qs[1]) && $qs[1] == 'sn') 
		{
            if ($sql->db_Select("tmp", "*", "tmp_time='".intval($qs[2])."'")) {
                $row = $sql->db_Fetch();
                $submitted                  = explode("^", $row['tmp_info']);
                $row['link_category']       = $submitted[0];
                $row['link_name']           = $submitted[1];
                $row['link_url']            = $submitted[2];
                $row['link_description']    = $submitted[3]."\n[i]".LCLAN_ITEM_1." ".$submitted[5]."[/i]";
                $row['link_button']         = $submitted[4];

            }
        }

        if(isset($_POST['uploadlinkicon'])){
            $row['link_category']       = $_POST['cat_id'];
            $row['link_name']           = $_POST['link_name'];
            $row['link_url']            = $_POST['link_url'];
            $row['link_description']    = $_POST['link_description'];
            $row['link_button']         = $_POST['link_but'];
            $row['link_open']           = $_POST['linkopentype'];
            $row['link_class']          = $_POST['link_class'];
            $link_resize_value          = (isset($_POST['link_resize_value']) && $_POST['link_resize_value'] ? $_POST['link_resize_value'] : $link_resize_value);
        }
        $width = (e_PAGE == "admin_linkspage_config.php" ? ADMIN_WIDTH : "width:100%;");
        $text = "
        <div style='text-align:center'>
        ".$rs -> form_open("post", e_SELF."?".e_QUERY, "linkform", "", "enctype='multipart/form-data'", "")."
        <table style='".$width."' class='fborder' cellspacing='0' cellpadding='0'>
        <tr>
        <td style='width:30%' class='forumheader3'>".LCLAN_ITEM_2."</td>
        <td style='width:70%' class='forumheader3'>";

        if (!$link_cats = $sql->db_Select("links_page_cat")) {
            $text .= LCLAN_ITEM_3."<br />";
        } else {
            $text .= $rs -> form_select_open("cat_id", "");
            while (list($cat_id, $cat_name, $cat_description) = $sql->db_Fetch()) {
                if ( (isset($row['link_category']) && $row['link_category'] == $cat_id) || (isset($row['linkid']) && $cat_id == $row['linkid'] && $action == "add") ) {
                    $text .= $rs -> form_option($cat_name, "1", $cat_id, "");
                } else {
                    $text .= $rs -> form_option($cat_name, "0", $cat_id, "");
                }
            }
            $text .= $rs -> form_select_close();
        }
        $text .= "
        </td>
        </tr>
        <tr>
        <td style='width:30%' class='forumheader3'>".LCLAN_ITEM_4."</td>
        <td style='width:70%' class='forumheader3'>
            ".$rs -> form_text("link_name", 60, $row['link_name'], 100)."
        </td>
        </tr>
        <tr>
        <td style='width:30%' class='forumheader3'>".LCLAN_ITEM_5."</td>
        <td style='width:70%' class='forumheader3'>
            ".$rs -> form_text("link_url", 60, $row['link_url'], 200)."
        </td>
        </tr>
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_ITEM_6."</td>
        <td style='width:70%' class='forumheader3'>
            ".$rs -> form_textarea("link_description", '59', '3', $row['link_description'], "", "", "", "", "")."
        </td>
        </tr>
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_ITEM_7."</td>
        <td style='width:70%' class='forumheader3'>";
            if(!FILE_UPLOADS){
                $text .= "<b>".LCLAN_ITEM_9."</b>";
            }else{
                if(!is_writable(e_PLUGIN."links_page/link_images/")){
                    $text .= "<b>".LCLAN_ITEM_10." ".e_PLUGIN."links_page/link_images/ ".LCLAN_ITEM_11."</b><br />";
                }
                $text .= "
                <input class='tbox' type='file' name='file_userfile[]'  size='58' /><br />
                ".LCLAN_ITEM_8." ".$rs -> form_text("link_resize_value", 3, $link_resize_value, 3)."&nbsp;".LCLAN_ITEM_12."
                ".$rs -> form_button("submit", "uploadlinkicon", LCLAN_ITEM_13, "", "", "");
            }
        $text .= "
        </td>
        </tr>";

        $rejectlist = array('$.','$..','/','CVS','thumbs.db','Thumbs.db','*._$', 'index', 'null*', 'blank*');
        $iconpath = e_PLUGIN."links_page/link_images/";
        $iconlist = $fl->get_files($iconpath,"",$rejectlist);
        $iconpath = e_PLUGIN_ABS."links_page/link_images/";			// Absolute paths now we've got the files

        $text .= "
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_ITEM_14."</td>
        <td style='width:70%; vertical-align:top;' class='forumheader3'>
        <input class='tbox' type='text' name='link_but' id='link_but' size='60' value='".$row['link_button']."' maxlength='100' />
            <div id='linkbut' style='display:block; vertical-align:top;'><table style='text-align:left; width:100%;'><tr><td style='width:20%; padding-right:10px;'>";
            $selectjs   = " onchange=\"document.getElementById('link_but').value=this.options[this.selectedIndex].value; if(this.options[this.selectedIndex].value!=''){document.getElementById('iconview').src='".$iconpath."'+this.options[this.selectedIndex].value; document.getElementById('iconview').style.display='block';}else{document.getElementById('iconview').src='';document.getElementById('iconview').style.display='none';}\"";
            $text       .= $rs -> form_select_open("link_button", $selectjs);
            $text       .= $rs -> form_option(LCLAN_ITEM_34, ($row['link_button'] ? "0" : "1"), "");
            foreach($iconlist as $icon){
                $text   .= $rs -> form_option($icon['fname'], ($icon['fname'] == $row['link_button'] ? "1" : "0"), $icon['fname'] );
            }
            $text .= $rs -> form_select_close();
            if(isset($row['link_button']) && $row['link_button']){
                $img = $iconpath.$row['link_button'];
            }else{
                $blank_display = 'display: none';
                $img = e_PLUGIN_ABS."links_page/images/blank.gif";
            }
            $text .= "</td><td><img id='iconview' src='".$img."' style='width:".$link_resize_value."px; border:0; ".$blank_display."' /><br /><br /></td></tr></table>";
            $text .= "</div>
        </td>
        </tr>";

        //0=same window, 1=_blank, 2=_parent, 3=_top, 4=miniwindow
        $text .= "
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_ITEM_16."</td>
        <td style='width:70%' class='forumheader3'>
            ".$rs -> form_select_open("linkopentype")."
            ".$rs -> form_option(LCLAN_ITEM_17, ($row['link_open'] == "0" ? "1" : "0"), "0", "")."
            ".$rs -> form_option(LCLAN_ITEM_18, ($row['link_open'] == "1" ? "1" : "0"), "1", "")."
            ".$rs -> form_option(LCLAN_ITEM_19, ($row['link_open'] == "4" ? "1" : "0"), "4", "")."
            ".$rs -> form_select_close()."
        </td>
        </tr>
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_ITEM_20."</td>
        <td style='width:70%' class='forumheader3'>
            ".r_userclass("link_class", $row['link_class'], "off", "public,guest,nobody,member,admin,classes")."
        </td>
        </tr>
        <tr style='vertical-align:top'>
        <td colspan='2' style='text-align:center' class='forumheader'>";
        if (isset($qs[2]) && $qs[2] && $qs[1] == "edit") {
            $text .= $rs -> form_hidden("link_datestamp", $row['link_datestamp']);
            $text .= $rs -> form_checkbox("update_datestamp", 1, 0)." ".LCLAN_ITEM_21."<br /><br />";
            $text .= $rs -> form_button("submit", "add_link", LCLAN_ITEM_22, "", "", "").$rs -> form_hidden("link_id", $row['link_id']).$rs -> form_hidden("link_author", $row['link_author']);

        } else {
            $text .= $rs -> form_button("submit", "add_link", LCLAN_ITEM_23, "", "", "");
        }
        $text .= "</td>
        </tr>
        </table>
        ".$rs -> form_close()."
        </div>";

        $ns->tablerender(LCLAN_ITEM_24, $text);
    }



	/**
	 *		Display list of links within a particular category
	 */
    function show_links() 
	{
        global $sql, $qs, $rs, $ns, $tp, $from;
        $number = "20";
		$LINK_CAT_NAME = '';			// May be appropriate to add a shortcode later

        if($qs[2] == "all")
		{	// Show all categories
            $caption = LCLAN_ITEM_38;
            $qry = " link_id != '' ORDER BY link_category ASC, link_order ASC";
        }
		else
		{	// Show single category
            if ($sql->db_Select("links_page_cat", "link_category_name", "link_category_id='".intval($qs[2])."' " )) 
			{
                $row = $sql->db_Fetch();
                $caption = LCLAN_ITEM_2." ".$row['link_category_name'];
            }
            $qry = " link_category=".intval($qs[2])." ORDER BY link_order, link_id ASC";
        }

        $link_total = $sql->db_Select("links_page", "*", " ".$qry." ");
        if (!$sql->db_Select("links_page", "*", " ".$qry." LIMIT ".intval($from).",".intval($number)." ")) 
		{
          js_location(e_SELF."?link");
        }
		else
		{	// Display the individual links
            $text = $rs->form_open("post", e_SELF.(e_QUERY ? "?".e_QUERY : ""), "myform_{$row['link_id']}", "", "");
            $text .= "<div style='text-align:center'>
            <table class='fborder' style='".ADMIN_WIDTH."'>
            <tr>
            <td class='fcaption' style='width:5%'>".LCLAN_ITEM_25."</td>
            <td class='fcaption' style='width:65%'>".LCLAN_ITEM_26."</td>
            <td class='fcaption' style='width:10%'>".LCLAN_ITEM_27."</td>
            <td class='fcaption' style='width:10%'>".LCLAN_ITEM_28."</td>
            <td class='fcaption' style='width:10%'>".LCLAN_ITEM_29."</td>
            </tr>";
            while ($row = $sql->db_Fetch()) 
			{
                $linkid = $row['link_id'];
                $img = "";
                if ($row['link_button']) 
				{
                    if (strpos($row['link_button'], "http://") !== FALSE) 
					{
                        $img = "<img style='border:0;' src='".$row['link_button']."' alt='".$LINK_CAT_NAME."' />";
                    } 
					else 
					{
                        if(strstr($row['link_button'], "/"))
						{
                            $img = "<img style='border:0;' src='".e_BASE.$row['link_button']."' alt='".$LINK_CAT_NAME."' />";
                        }
						else
						{
                            $img = "<img style='border:0' src='".e_PLUGIN_ABS."links_page/link_images/".$row['link_button']."' alt='".$LINK_CAT_NAME."' />";
                        }
                    }
                }

				$name_suffix = URL_SEPARATOR.$linkid.URL_SEPARATOR.$row['link_order'].URL_SEPARATOR.$row['link_category'];
                if($row['link_order'] == "1")
				{
                    $up = "&nbsp;&nbsp;&nbsp;";
                }
				else
				{
					//$up = "<input type='image' src='".LINK_ICON_ORDER_UP_BASE."' value='".$linkid.".".$row['link_order'].".".$row['link_category']."' name='inc' />";
					$up = "<input type='image' src='".LINK_ICON_ORDER_UP_BASE."' name='inc".$name_suffix."' />";
                }
                if($row['link_order'] == $link_total)
				{
                    $down = "&nbsp;&nbsp;&nbsp;";
                }
				else
				{
                    //$down = "<input type='image' src='".LINK_ICON_ORDER_DOWN_BASE."' value='".$linkid.".".$row['link_order'].".".$row['link_category']."' name='dec' />";
					$down = "<input type='image' src='".LINK_ICON_ORDER_DOWN_BASE."' name='dec".$name_suffix."' />";
                }
                $text .= "
                <tr>
                <td class='forumheader3' style='width:5%; text-align: center; vertical-align: middle'>".$img."</td>
                <td style='width:65%' class='forumheader3'>
                    <a href='".e_PLUGIN_ABS."links_page/links.php?".$row['link_id']."' rel='external'>".LINK_ICON_LINK."</a> ".$row['link_name']."
                </td>
                <td style='width:10%; text-align:center; white-space: nowrap' class='forumheader3'>
                    <a href='".e_SELF."?link.edit.".$linkid."' title='".LCLAN_ITEM_31."'>".LINK_ICON_EDIT."</a>
                    <input type='image' title='delete' name='delete[main_{$linkid}]' alt='".LCLAN_ITEM_32."' src='".LINK_ICON_DELETE_BASE."' onclick=\"return jsconfirm('".$tp->toJS(LCLAN_ITEM_33." [ ".$row['link_name']." ]")."')\" />
                </td>
                <td style='width:10%; text-align:center; white-space: nowrap' class='forumheader3'>
                    ".$up."
                    ".$down."
                </td>
                <td style='width:10%; text-align:center' class='forumheader3'>
                    <select name='link_order[]' class='tbox'>";
                    //".$rs -> form_select_open("link_order[]");
                    for($a = 1; $a <= $link_total; $a++) {
                        $text .= $rs -> form_option($a, ($row['link_order'] == $a ? "1" : "0"), $linkid.".".$a, "");
                    }
                    $text .= $rs -> form_select_close()."
                </td>
                </tr>";
            }
            $text .= "
            <tr>
            <td class='forumheader' colspan='4'>&nbsp;</td>
            <td class='forumheader' style='width:5%; text-align:center'>
            ".$rs->form_button("submit", "update_order", LCLAN_ITEM_30)."
            </td>
            </tr>
            </table></div>
            ".$rs->form_close();
        }
        $ns->tablerender($caption, $text);
		$this->ShowNextPrev($from, $number, $link_total);
    }

    function show_cat_create() {
        global $qs, $sql, $rs, $ns, $tp, $fl;

        $row['link_category_name']          = "";
        $row['link_category_description']   = "";
        $row['link_category_icon']          = "";
        $link_cat_resize_value              = (isset($this->plugPrefs['link_cat_resize_value']) && $this->plugPrefs['link_cat_resize_value'] ? $this->plugPrefs['link_cat_resize_value'] : "50");

        if(isset($_POST['uploadcatlinkicon'])){
            $row['link_category_name']          = $_POST['link_category_name'];
            $row['link_category_description']   = $_POST['link_category_description'];
            $row['link_category_icon']          = $_POST['link_category_icon'];
            $link_cat_resize_value              = (isset($_POST['link_cat_resize_value']) && $_POST['link_cat_resize_value'] ? $_POST['link_cat_resize_value'] : $link_cat_resize_value);
        }
        if ($qs[1] == "edit") {
            if ($sql->db_Select("links_page_cat", "*", "link_category_id='".intval($qs[2])."' ")) {
                $row = $sql->db_Fetch();
            }
        }
        if(isset($_POST['category_clear'])){
            $row['link_category_name']          = "";
            $row['link_category_description']   = "";
            $row['link_category_icon']          = "";
        }
        $rejectlist = array('$.','$..','/','CVS','thumbs.db','Thumbs.db','*._$', 'index', 'null*');
        $iconlist = $fl->get_files(e_PLUGIN."links_page/cat_images/","",$rejectlist);

        $text = "<div style='text-align:center'>
        ".$rs->form_open("post", e_SELF.(e_QUERY ? "?".e_QUERY : ""), "linkform", "", "enctype='multipart/form-data'", "")."
        <table class='fborder' style='".ADMIN_WIDTH."'>
        <tr>
        <td class='forumheader3' style='width:30%'>".LCLAN_CAT_13."</td>
        <td class='forumheader3' style='width:70%'>".$rs->form_text("link_category_name", 50, $row['link_category_name'], 200)."</td>
        </tr>
        <tr>
        <td class='forumheader3' style='width:30%; vertical-align:top;'>".LCLAN_CAT_14."</td>
        <td class='forumheader3' style='width:70%'>".$rs->form_text("link_category_description", 60, $row['link_category_description'], 200)."</td>
        </tr>
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_CAT_15."</td>
        <td style='width:70%' class='forumheader3'>";
            if(!FILE_UPLOADS){
                $text .= "<b>".LCLAN_CAT_17."</b>";
            }else{
                if(!is_writable(e_PLUGIN."links_page/cat_images/")){
                    $text .= "<b>".LCLAN_CAT_18." ".e_PLUGIN."links_page/cat_images/ ".LCLAN_CAT_19."</b><br />";
                }
                $text .= "
                <input class='tbox' type='file' name='file_userfile[]'  size='58' /><br />
                ".LCLAN_CAT_16." ".$rs -> form_text("link_cat_resize_value", 3, $link_cat_resize_value, 3)."&nbsp;".LCLAN_CAT_20."
                ".$rs -> form_button("submit", "uploadcatlinkicon", LCLAN_CAT_21, "", "", "");
            }
        $text .= "
        </td>
        </tr>
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_CAT_22."</td>
        <td style='width:70%' class='forumheader3'>
            ".$rs -> form_text("link_category_icon", 60, $row['link_category_icon'], 100)."
            ".$rs -> form_button("button", '', LCLAN_CAT_23, "onclick=\"expandit('catico')\"")."
            <div id='catico' style='{head}; display:none'>";
            foreach($iconlist as $icon){
                $text .= "<a href=\"javascript:insertext('".$icon['fname']."','link_category_icon','catico')\"><img src='".$icon['path'].$icon['fname']."' style='border:0' alt='' /></a> ";
            }
            $text .= "</div>
        </td>
        </tr>
        <tr>
        <td style='width:30%; vertical-align:top;' class='forumheader3'>".LCLAN_CAT_24."</td>
        <td style='width:70%' class='forumheader3'>
            ".r_userclass("link_category_class", $row['link_category_class'], "off", "public,guest,nobody,member,admin,classes")."
        </td>
        </tr>
        <tr><td colspan='2' style='text-align:center' class='forumheader'>";
        if (is_numeric($qs[2])) {
            $text .= $rs -> form_hidden("link_category_order", $row['link_category_order']);
            $text .= $rs -> form_hidden("link_category_datestamp", $row['link_category_datestamp']);
            $text .= $rs -> form_checkbox("update_datestamp", 1, 0)." ".LCLAN_CAT_25."<br /><br />";
            $text .= $rs -> form_button("submit", "update_category", LCLAN_CAT_26, "", "", "");
            $text .= $rs -> form_button("submit", "category_clear", LCLAN_CAT_27). $rs->form_hidden("link_category_id", $qs[2]);

        } else {
            $text .= $rs -> form_button("submit", "create_category", LCLAN_CAT_28, "", "", "");
        }
        $text .= "</td></tr></table>
        ".$rs->form_close()."
        </div>";

        $ns->tablerender(LCLAN_CAT_29, $text);
        unset($row['link_category_name'], $row['link_category_description'], $row['link_category_icon']);
    }



	/**
	 *	Show a list of categories
	 *
	 *	@param string $mode = (cat)
	 */
	function show_categories($mode) 
	{
        global $sql, $rs, $ns, $tp, $fl;

        if ($category_total = $sql->db_Select("links_page_cat", "*", "ORDER BY link_category_order ASC", "mode=no_where")) {
            $text = "
            <div style='text-align: center'>
            ".$rs->form_open("post", e_SELF.(e_QUERY ? "?".e_QUERY : ""), "", "", "")."
            <table class='fborder' style='".ADMIN_WIDTH."'>
            <tr>
            <td style='width:5%' class='fcaption'>".LCLAN_CAT_1."</td>
            <td class='fcaption'>".LCLAN_CAT_2."</td>
            <td style='width:10%' class='fcaption'>".LCLAN_CAT_3."</td>";
            if($mode == "cat"){
                $text .= "
                <td class='fcaption' style='width:10%'>".LCLAN_CAT_4."</td>
                <td class='fcaption' style='width:10%'>".LCLAN_CAT_5."</td>";
            }
            $text .= "
            </tr>";
			while ($row = $sql->db_Fetch()) 
			{
                $linkcatid = $row['link_category_id'];
				if ($row['link_category_icon']) 
				{
                    $img = (strstr($row['link_category_icon'], "/") ? "<img src='".e_BASE.$row['link_category_icon']."' alt='' style='vertical-align:middle' />" : "<img src='".e_PLUGIN_ABS."links_page/cat_images/".$row['link_category_icon']."' alt='' style='vertical-align:middle' />");
                } 
				else 
				{
                    $img = "&nbsp;";
                }
                $text .= "
                <tr>
                <td style='width:5%; text-align:center' class='forumheader3'>".$img."</td>
                <td class='forumheader3'>
                    <a href='".e_PLUGIN_ABS."links_page/links.php?cat.".$linkcatid."' rel='external'>".LINK_ICON_LINK."</a>
                    ".$row['link_category_name']."<br /><span class='smalltext'>".$row['link_category_description']."</span>
                </td>";
				if($mode == "cat")
				{
					$name_suffix = URL_SEPARATOR.$linkcatid.URL_SEPARATOR.$row['link_category_order'].URL_SEPARATOR;
                    if($row['link_category_order'] == "1")
					{
                        $up = "&nbsp;&nbsp;&nbsp;";
                    }
					else
					{
						//$up = "<input type='image' src='".LINK_ICON_ORDER_UP_BASE."' value='".$linkcatid.".".$row['link_category_order']."' name='inc' />";
						$up = "<input type='image' src='".LINK_ICON_ORDER_UP_BASE."' name='inc".$name_suffix."' />";
                    }
                    if($row['link_category_order'] == $category_total)
					{
                        $down = "&nbsp;&nbsp;&nbsp;";
                    }
					else
					{
						//$down = "<input type='image' src='".LINK_ICON_ORDER_DOWN_BASE."' value='".$linkcatid.".".$row['link_category_order']."' name='dec' />";
						$down = "<input type='image' src='".LINK_ICON_ORDER_DOWN_BASE."' name='dec".$name_suffix."' />";
                    }
                    $text .= "
                    <td style='width:10%; text-align:center; white-space: nowrap' class='forumheader3'>
                        <a href='".e_SELF."?cat.edit.".$linkcatid."' title='".LCLAN_CAT_6."'>".LINK_ICON_EDIT."</a>
                        <input type='image' title='delete' name='delete[category_{$linkcatid}]' alt='".LCLAN_CAT_7."' src='".LINK_ICON_DELETE_BASE."' onclick=\"return jsconfirm('".$tp->toJS(LCLAN_CAT_8." [ ".$row['link_category_name']." ]")."')\"/>
                    </td>
                    <td style='width:10%; text-align:center; white-space: nowrap' class='forumheader3'>
                        ".$up."
                        ".$down."
                    </td>
                    <td style='width:10%; text-align:center' class='forumheader3'>
                        <select name='link_category_order[]' class='tbox'>";
                        for($a = 1; $a <= $category_total; $a++) 
						{
                            $text .= $rs -> form_option($a, ($row['link_category_order'] == $a ? "1" : "0"), $linkcatid.".".$a, "");
                        }
                        $text .= $rs -> form_select_close()."
                    </td>";
                }
				else
				{
                    $text .= "<td style='width:10%; text-align:center; white-space: nowrap' class='forumheader3'>
                    <a href='".e_SELF."?link.view.".$linkcatid."' title='".LCLAN_CAT_9."'>".LINK_ICON_EDIT."</a></td>";
                }
                $text .= "
                </tr>\n";
            }
            if($mode == "cat")
			{
                $text .= "
                <tr>
                <td class='forumheader' colspan='4'>&nbsp;</td>
                <td class='forumheader' style='width:5%; text-align:center'>
                ".$rs->form_button("submit", "update_category_order", LCLAN_CAT_10)."
                </td>
                </tr>";
            }else{
                $text .= "
                <tr>
                <td class='forumheader' colspan='2'>&nbsp;</td>
                <td class='forumheader' style='width:5%; text-align:center'>".$rs->form_button("button", "viewalllinks", LCLAN_ITEM_37, "onclick=\"document.location='".e_SELF."?link.view.all';\"")."
                </td>
                </tr>";
            }
            $text .= "
            </table>
            ".$rs->form_close()."
            </div>";
        } else {
            $text = "<div style='text-align:center'>".LCLAN_CAT_11."</div>";
        }
        $ns->tablerender(LCLAN_CAT_12, $text);
        unset($row['link_category_name'], $row['link_category_description'], $row['link_category_icon']);
    }

    function show_submitted() {
        global $sql, $rs, $qs, $ns, $tp;

        if (!$submitted_total = $sql->db_Select("tmp", "*", "tmp_ip='submitted_link' ")) {
            $text = "<div style='text-align:center'>".LCLAN_SL_2."</div>";
        }else{
            $text = "
            ".$rs->form_open("post", e_SELF."?sn", "submitted_links")."
            <table class='fborder' style='".ADMIN_WIDTH."'>
            <tr>
            <td style='width:60%' class='fcaption'>".LCLAN_SL_3."</td>
            <td style='width:30%' class='fcaption'>".LCLAN_SL_4."</td>
            <td style='width:10%; white-space:nowrap; text-align:center' class='fcaption'>".LCLAN_SL_5."</td>
            </tr>";
            while ($row = $sql->db_Fetch()) {
                $tmp_time = $row['tmp_time'];
                $submitted = explode("^", $row['tmp_info']);
                if (!strstr($submitted[2], "http")) {
                    $submitted[2] = "http://".$submitted[2];
                }
                $text .= "<tr>
                <td style='width:60%' class='forumheader3'><a href='".$submitted[2]."' rel='external'>".$submitted[2]."</a></td>
                <td style='width:30%' class='forumheader3'>".$submitted[5]."</td>
                <td style='width:10%; white-space:nowrap; text-align:center; vertical-align:top' class='forumheader3'>
                    <a href='".e_SELF."?link.sn.".$tmp_time."' title='".LCLAN_SL_6."'>".LINK_ICON_EDIT."</a>
                    <input type='image' title='delete' name='delete[sn_{$tmp_time}]' alt='".LCLAN_SL_7."' src='".LINK_ICON_DELETE_BASE."' onclick=\"return jsconfirm('".$tp->toJS(LCLAN_SL_8." [ ".$tmp_time." ]")."')\" />
                </td>
                </tr>\n";
            }
            $text .= "</table>".$rs->form_close();
        }
        $ns->tablerender(LCLAN_SL_1, $text);
    }

 



}

?>