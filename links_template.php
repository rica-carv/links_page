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
 


// RATED -----------------------------------------------------------------------------------
$sc_style['LINK_RATED_BUTTON']['pre'] = "<td rowspan='5'>";
$sc_style['LINK_RATED_BUTTON']['post'] = "</td>";

$sc_style['LINK_RATED_NAME']['pre'] = "";
$sc_style['LINK_RATED_NAME']['post'] = "";

$sc_style['LINK_RATED_URL']['pre'] = "<tr><td colspan='2'><i>";
$sc_style['LINK_RATED_URL']['post'] = "</i></td></tr>";

$sc_style['LINK_RATED_REFER']['pre'] = "<td style='white-space:nowrap;'>";
$sc_style['LINK_RATED_REFER']['post'] = "</td>";

$sc_style['LINK_RATED_DESC']['pre'] = "<tr><td colspan='2'style='line-height:130%;'>";
$sc_style['LINK_RATED_DESC']['post'] = "</td></tr>";

$sc_style['LINK_RATED_RATING']['pre'] = "<td colspan='2'  style='line-height:130%;  white-space:nowrap; text-align:right;'>";
$sc_style['LINK_RATED_RATING']['post'] = "</td>";

$sc_style['LINK_RATED_CATEGORY']['pre'] = "<tr><td colspan='2' style='line-height:130%;'><i>";
$sc_style['LINK_RATED_CATEGORY']['post'] = "</i></td></tr>";

$LINK_RATED_TABLE_START = "
	<div class='panel panel-default'>LINK_RATED_TABLE_START 
	";

$LINK_RATED_TABLE = "
	<table class='table  table-bordered  fborder' style='width:100%; margin-bottom:20px;' cellspacing='0' cellpadding='0'>
	<tr>
		{LINK_RATED_BUTTON}
		<td class='fcaption'  >
			{LINK_RATED_APPEND} {LINK_RATED_NAME} </a>
		</td>
		{LINK_RATED_RATING}
	</tr>
	{LINK_RATED_URL}
	{LINK_RATED_CATEGORY}
	{LINK_RATED_DESC}
	</table>";

$LINK_RATED_TABLE_END = "
	</div>";


$sc_style['LINK_SUBMIT_PRETEXT']['pre'] = "<tr><td colspan='2' style='text-align:center' class='forumheader2'>";
$sc_style['LINK_SUBMIT_PRETEXT']['post'] = "</td></tr>";

// SUBMIT -----------------------------------------------------------------------------------
$LINK_SUBMIT_TABLE = "
	<div class='panel panel-default'>xxxxxLINK_SUBMIT_TABLE
	<form method='post' action='".e_SELF.(e_QUERY ? "?".e_QUERY : "")."'>
	<table class='table  table-bordered  fborder' style='width:100%' cellspacing='0' cellpadding='0'>
	{LINK_SUBMIT_PRETEXT}
	<tr>
		<td class='forumheader3' style='width:30%'>".LCLAN_SL_10."xxx</td>
		<td class='forumheader3' style='width:70%'>{LINK_SUBMIT_CAT}</td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:30%'><u>".LCLAN_SL_11."</u></td>
		<td class='forumheader3' style='width:30%'><input class='tbox' type='text' name='link_name' size='60' value='' maxlength='100' /></td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:30%'><u>".LCLAN_SL_12."</u></td>
		<td class='forumheader3' style='width:30%'><input class='tbox' type='text' name='link_url' size='60' value='' maxlength='200' /></td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:30%'><u>".LCLAN_SL_13."</u></td>
		<td class='forumheader3' style='width:30%'><textarea class='tbox' name='link_description' cols='59' rows='3'></textarea></td>
	</tr>
	<tr>
		<td class='forumheader3' style='width:30%'>".LCLAN_SL_14."</td>
		<td class='forumheader3' style='width:30%'><input class='tbox' type='text' name='link_but' size='60' value='' maxlength='200' /></td>
	</tr>
	<tr>
		<td colspan='2' style='text-align:center' class='forumheader3'><span class='smalltext'>".LCLAN_SL_15."</span></td>
	</tr>
	<tr>
		<td colspan='2' style='text-align:center' class='forumheader'><input class='button' type='submit' name='add_link' value='".LCLAN_SL_16."' /></td>
	</tr>
	</table>
	</form>
	</div>
	";


?>