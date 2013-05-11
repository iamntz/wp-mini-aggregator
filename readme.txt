=== WordPress Mini Agregator  ===
Tags: rss, reader
Contributors: Ionuț Staicu
Tested up to: 3.5
Requires at least: 3.5
tag: trunk
License: GPLv2

== Description ==
Allows you to easily embed a list of blogs RSS so you can display a list of recent posts for all blogs.


== Changelog ==
= 0.1 =
* Initial Release


== Installation ==
1. Upload to your plugins folder, usually `wp-content/plugins/`
2. Activate the plugin on the plugin screen.


== Usage ==
1. Create a new page
2. Add this shortcode:
[mini-agregator max_items_to_fetch=2]
http://iamntz.com/feed
http://another.feed.url
[/mini-agregator]
3. Enjoy!

max_items_to_fetch is optional (default is 2) and it is used to set up how many items will be displayed on each blog