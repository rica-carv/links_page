<?php
if (!defined('e107_INIT')) { exit; }

$LINKS_PAGE_MENU_TEMPLATE['caption'] = "{LAN=LINKS_PAGE_1} - {LAN=PHILCAT_01}"; //Ex - $LINKS_PAGE_MENU_TITLE

$LINKS_PAGE_MENU_TEMPLATE['menu'] = "
    {LINK_MENU_NAVIGATOR}
    {LINK_MENU_CATEGORIES}
    {LINK_MENU_RECENT}
    ";

$LINKS_PAGE_MENU_TEMPLATE['recent_caption'] = "{LAN=LCLAN_OPT_88}";

$LINKS_PAGE_MENU_TEMPLATE['recent_start'] = "
<table style='width:100%; text-align:left; border:0;' cellpadding='0' cellspacing='0'>
    ";

$LINKS_PAGE_MENU_TEMPLATE['recent_item'] = "
<tr>
	<td style='width:1%; white-space:nowrap; vertical-align:top; padding-right:5px;'>{LINK_MENU_BULLET}</td>
	<td>
    	{LINK_MENU_LINK}
        {LINK_MENU_LINKCAT}
        {LINK_MENU_LINKDESC}
	</td>
</tr>
";

$LINKS_PAGE_MENU_TEMPLATE['recent_end'] = "
</table>
";