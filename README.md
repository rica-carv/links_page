#Links page plugin for e107 V2

**WARNING. This plugin is under rewriting** 

- added issues to need be solved before continuing
- rewritten e_search.php
- working approving links
- working submitting links
- working personal manager
- working ordering with SEF URLs
- added sef url field for categories
- added active field for links  // not using tmp table anymore
- added e_notify.php 
- added e_list.php 
- added frontend media manager
- added rating system
- added comment system
- done new templating system
- done new language system
- rewritten navigation system on pages, new prefs


**09.01.2016 Version 2.0.0:** 

- replaced $linkspage_prefs with new way
- added Sort and Order functionality
- added e_url.php  (need to add new fields in database, after finished rewrite) 
- added e_rss.php  (legacy)
- added e_frontpage.php
- added e_dashboard.php (replace old e_latest.php and e_status.php )
- added e_libraries.php (support for Libraries plugin)
- updated plugin.xml and added linkspage_setup.php

**Initial commit from 08.01.2016:** 

*Admin area:*
written as new and it works. It uses old e_help, there are still missing some custom buttons (view link, view category). Are they needed?
~~Except submitted links. They use tmp table. Maybe better idea would be add field active?  ~~

*Frontend uses legacy code* 
(shortcodes rewritten but they use global variables). A lot of work in this area, but it works.
- added script for replacing selects in navigator to tabs

*Plugin installation*
~~Todo: add plugin_setup.php, plugin.xml is not enough.~~ 
 
*What is missing for now*
- ~~e_ functionality~~ (~~e_search~~, ~~e_latest~~, ~~e_frontpage~~,  ~~e_list~~, ~~e_notify~~, ~~e_rss~~, ~~e_status~~, ~~e_comment~~)
- ~~new way with images on frontend~~
- ~~personal manager~~
- ~~new languages files~~
- ~~direct submitting links~~
- ~~approving submitted links~~ 
- ~~sort and order functionality~~
- ~~new templating system~~
- ~~tabless templates / responsive tables are not enough~~
- next/prev 
- link menu
- top refer page display always first category - it's in 1.0.4 too
- to add test for active field to queries
- ~~check title for some pages, different position~~
- replace js_location

*What doesn't work for now:*
- ~~legacy rating system~~
- ~~ordering by date~~
- link menu






