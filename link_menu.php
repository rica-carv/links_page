<?php
/**
 * Copyright (C) 2008-2011 e107 Inc (e107.org), Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
 * $Id$
 * 
 * Latest links_page menu
 */
if (!defined('e107_INIT'))  exit;

if (!e107::isInstalled('links_page')) 
{
  e107::redirect();
}

$menuPrefs = e107::getMenu()->pref();// ie. popup config details from within menu-manager.

if(is_string($menuPrefs))
{
  parse_str($menuPrefs, $menuPref);
}
else
{
  $menuPref = $menuPrefs;
}

if(is_string($parm))
{
  parse_str($parm, $lpparms);
}
else
{
  $lpparms = $parm;
  e107::getDebug()->log($lpparms);
}
//var_dump ($menuPref);
//var_dump ($lpparms);

if (empty($menuPref['layout'])) $menuPref['layout'] = $lpparms['layout']??'menu';

e107::lan('links_page');

if ($menuPref['limit']) {
  //var_dump($menuPref['layout']);
//var_dump(e107::pref('links_page')["link_menu_recent_number"]);
$temppref["link_menu_recent_number"] = e107::pref('links_page')["link_menu_recent_number"];
//var_dump($menuPref['limit']);
e107::getPlugConfig('links_page')->setPref("link_menu_recent_number", $menuPref['limit']);
//var_dump(e107::pref('links_page')["link_menu_recent_number"]);
}
//var_dump(e107::getPlugConfig('links_page')->getPref("link_menu_recent_number"));

$sc = e107::getScBatch('menu', 'links_page');
$sc->wrapper('links_page_menu');

$template = e107::getTemplate('links_page', 'links_page_menu', null, true, true);

//var_dump($menuPref['layout']);
//var_dump($menuPref['layout']<>'menu');
//var_dump($template['recent_caption']);

if ($menuPref['layout']<>'menu') {
  $template['recent_caption']=$template[$menuPref['layout'].'_recent_caption'];
  $template['recent_start']=$template[$menuPref['layout'].'_recent_start'];
  $template['recent_item']=$template[$menuPref['layout'].'_recent_item'];
  $template['recent_end']=$template[$menuPref['layout'].'_recent_end'];
}
//var_dump($template['recent_caption']);

$sc->addVars(array( 'template' => $template));

$text = e107::getParser()->parsetemplate($template[$menuPref['layout']], TRUE, $sc);

if ($menuPref['limit']) {
  e107::getPlugConfig('links_page')->setPref("link_menu_recent_number", $temppref["link_menu_recent_number"]);
}
//var_dump(e107::getPlugConfig('links_page')->getPref("link_menu_recent_number"));

$caption = (e107::pref('links_page')['link_menu_caption']??LCLAN_OPT_86);
e107::getRender()->tablerender($caption, $text);
//exit();