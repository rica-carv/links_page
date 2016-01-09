# links_page
Links page plugin for e107 V2

**WARNING. This plugin is under rewriting** 
 
 
 
Added e_frontpage.php
Added e_dashboard.php (replace old e_latest.php and e_status.php )
Added e_libraries.php (support for Libraries plugin)

Initial commit from 08.01.2016: 

*Admin area:*
complet rewritten and it works. It uses old e_help, there are still missing some custom buttons (view link, view category). 

*Frontend uses legacy code* 
(shortcodes rewritten but they use global variables). A lot of work in this area, but it works.
- added script for replacing selects in navigator to tabs

*Plugin installation*
Todo: add plugin_setup.php, plugin.xml is not enough. 
 
*What is missing for now*
- e_ functionality (e_search, ~~e_latest~~, ~~e_frontpage~~,  e_list, e_notify, e_rss, ~~e_status~~, e_comment)
- new way with images on frontend
- personal manager

*What doesn't work for now: legacy rating system* 

With rating enabled page is displayed but immediately url is changed and result is 404 page. 


