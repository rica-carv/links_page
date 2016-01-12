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
|     $URL: https://e107.svn.sourceforge.net/svnroot/e107/trunk/e107_0.7/e107_plugins/links_page/link_defines.php $
|     $Revision: 11678 $
|     $Id: link_defines.php 11678 2010-08-22 00:43:45Z e107coders $
|     $Author: e107coders $         ADMIN_EDIT_ICON
+----------------------------------------------------------------------------+
*/

if (!defined('e107_INIT')) { exit; }
$imagenewcode = "<img class='linkspage_new' src='".THEME."images/new.png' alt='' style='vertical-align:middle' />";
$imagedir = e_IMAGE_ABS."admin_images/";
if (!defined("IMAGE_NEW")){ define("IMAGE_NEW", (file_exists(THEME."images/new.png") ? $imagenewcode : '<i class="fa fa-plus fa-2x"></i>')); }
if (!defined('LINK_ICON_EDIT'))        { define("LINK_ICON_EDIT", '<i class="fa fa-edit"></i>'); }

if (!defined('ADMIN_LINK_ICON_EDIT'))  { define("ADMIN_LINK_ICON_EDIT", ADMIN_EDIT_ICON); } 
if (!defined('ADMIN_LINK_ICON_DELETE')){ define("LINK_ICON_DELETE", ADMIN_DELETE_ICON); }
 

if (!defined('LINK_ICON_DELETE'))      { define("LINK_ICON_DELETE", $imagedir.'delete_32.png'); }
if (!defined('LINK_ICON_DELETE_BASE')) { define("LINK_ICON_DELETE_BASE", $imagedir.'delete_16.png'); }
if (!defined('LINK_ICON_LINK')) { define("LINK_ICON_LINK", ADMIN_VIEW_ICON); }
if (!defined('LINK_ICON_ORDER_UP_BASE')) { define("LINK_ICON_ORDER_UP_BASE", ADMIN_UP_ICON); }
if (!defined('LINK_ICON_ORDER_DOWN_BASE')) { define("LINK_ICON_ORDER_DOWN_BASE", ADMIN_DOWN_ICON); }
if (!defined('LINK_ICON_ORDER_UP')) { define("LINK_ICON_ORDER_UP", ADMIN_UP_ICON); }
if (!defined('LINK_ICON_ORDER_DOWN')) { define("LINK_ICON_ORDER_DOWN", ADMIN_DOWN_ICON); }

?>