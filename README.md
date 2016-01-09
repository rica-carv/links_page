# links_page
Links page plugin for e107 V2

**WARNING. This plugin is under rewriting** 
 
**09.01.2016 Version 2.0.1:** 

*replaced $linkspage_prefs with new way
*added Sort and Order functionality
*added e_url.php  (need to add new fields in database, after finished rewrite) 
*added e_rss.php  (legacy)
*added e_frontpage.php
*added e_dashboard.php (replace old e_latest.php and e_status.php )
*added e_libraries.php (support for Libraries plugin)

Initial commit from 08.01.2016: 

*Admin area:*
complet rewritten and it works. It uses old e_help, there are still missing some custom buttons (view link, view category). 

*Frontend uses legacy code* 
(shortcodes rewritten but they use global variables). A lot of work in this area, but it works.
- added script for replacing selects in navigator to tabs

*Plugin installation*
~~Todo: add plugin_setup.php, plugin.xml is not enough.~~ 
 
*What is missing for now*
- e_ functionality (e_search, ~~e_latest~~, ~~e_frontpage~~,  e_list, e_notify, ~~e_rss~~, ~~e_status~~, e_comment)
- ~~new way with images on frontend~~
- personal manager
- new languages files
- ~~sort and order functionality~~

*What doesn't work for now: legacy rating system* 

With rating enabled page is displayed but immediately url is changed and result is 404 page. 


