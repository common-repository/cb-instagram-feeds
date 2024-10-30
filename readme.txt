=== Instagram Feeds ===
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_xclick&business=afroz92@gmail.com&item_name=Instagram+Feeds
Tags: Instagram, Instagram group, Instagram Page, Instagram posts, Instagram wall, Instagram feed
Contributors: cynob
Author: cynob
Tested up to: 4.9.1
License: GPLv2
Requires at least: 3.5.0
Stable tag: 1.0

== Description ==
This plugin helps to display latest feeds from your Instagram on your site.


<strong>Features</strong>

* Backend settings to put Instagram User Id and Access Token
* Grid view mode to display Instagram feeds.
* List view mode to display Instagram feeds.
* Number of photos to display
* Easy to customize
* Clicking on feed will take you to the feed details.

== Screenshots ==

1. WP-admin setting Page.
2. Grid view mode of posts
3. List view mode of posts

== Frequently Asked Questions ==
1. No technical skills needed.

== Changelog ==
This is first version and no known errors found

== Upgrade Notice == 
This is first version and no known notices yet

== Installation ==
1. Upload the folder "cb-instagram-feeds" to "/wp-content/plugins/"
2. Activate the plugin through the "Plugins" menu in WordPress back end.
3. Go to "Instagram Feeds" and put 'Instagram User Id' and 'Access Token'.
4. Use below shortcode to display Instagram feeds in your page or post editor.

For grid view mode:
`
[instagram-feeds-grid] 
`

For list view mode:
`
[instagram-feeds-list] 
`

4. use below shortcode to display Instagram feeds in your template file.

For grid view mode:
`
<?php  echo do_shortcode('[instagram-feeds-grid]'); ?>
`

For list view mode:
` 
<?php echo do_shortcode('[instagram-feeds-list]'); ?>
`

