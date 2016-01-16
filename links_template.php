<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     Copyright (C) 2001-2002 Steve Dunstan (jalist@e107.org)
|     Copyright (C) 2008-2010 e107 Inc (e107.org)
|
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
|
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/links_page/links_template.php $
|     $Revision: 11678 $
|     $Id: links_template.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }

global $sc_style, $link_shortcodes;
if(!defined("USER_WIDTH")){ define("USER_WIDTH","width:97%"); }

// ##### NEXT PREV --------------------------------------------------
if(!isset($LINK_NP_TABLE)){
	$LINK_NP_TABLE = "<div class='nextprev'>{LINK_NEXTPREV}</div>";
}
// ##### ----------------------------------------------------------------------
 
//general : order menu
$sc_style['LINK_SORTORDER']['pre'] = "<td style='text-align:left;'>";
$sc_style['LINK_SORTORDER']['post'] = "</td>";

$sc_style['LINK_CATMENU']['pre'] = "<td style='text-align:left;'>";
$sc_style['LINK_CATMENU']['post'] = "</td>";
 
 
$sc_style['LINK_NAVIGATOR']['pre'] = '<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">'.LAN_LINKS_47.'</h3>
  </div>
  <div class="panel-body">';
$sc_style['LINK_NAVIGATOR']['post'] = "</div></div>";

$sc_style['LINK_NAV_ALLCATS']['pre'] = '<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">'.LAN_LINKS_48.'</h3>
  </div>
  <div class="panel-body">';
$sc_style['LINK_NAV_ALLCATS']['post'] = "</div></div>";


 
$LINK_NAVIGATOR_TABLE = "{LINK_NAVIGATOR} {LINK_NAV_ALLCATS} {LINK_SORTORDER} ";
 

 



?>