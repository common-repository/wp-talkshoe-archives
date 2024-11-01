=== WP Talkshoe Archives ===
Contributors: Dr. Robert White
Donate link: <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=UKU4GLYTP2JD8">Donate</a>
Tags: talkshoe,widget,past,episode,archive,mp3
Requires at least: 3.0.0
Tested up to: 3.0.4
Stable tag: 1.1

This is a plugin that will display archived MP3 files for specified Talkshoe calls and shows.

== Description == 

This plugin is a will display archived MP3 files from a Talkshoe RSS feed allowing the user to easily listen to past recordings from your Wordpress powered blog.

To use this plugin once installed and activated, simply go to your Widgets page in your Admin area and you will find the WP Talkshoe Archives widget there, drag it to your sidebar and you will have the option to set various settings from within the widget itself.

= When your widget is installed, it will display: =
* Your show logo
* Show name
* Title of archived episode with a direct link to the MP3 file
* The production date of the MP3 file
* A direct link to the Talkshoe Show Page of the specified Call ID

= Your options include: =
* The title for your widget
* Your Talkshoe Show or Call ID
* How many archives to display (up to 20)
* Whether or not to show the production date
* If you have a Blubrry Stats account for tracking, an optional area to add this code.

This plugin has been tested on version 3.0 of Wordpress, but may work on previous versions too.

This plugin is released on a GPL 2.0 license.

== Installation ==

1. Upload `wp_tsarchives.php` to the `/wp-content/plugins/` directory or install via New Plugins section.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Find the widget called WP Talkshoe Archives and drag it to your sidebar and set various options within the widget.
4. To use in posts or pages, use the shortcode of '[wpta]' without the quotes.

== Frequently Asked Questions ==

= Do I have to have Wordpress in order to use this plugin? =

Yes, to use this plugin you do have to be running the Wordpress.org self hosted script.

= Can I use this plugin on other blog sites? =

Nope, must be Wordpress, sorry!

= I get an error when running the widget =

For errors regarding SimplePie, go to line 96 in the wp-tsarchives.php code and remark out this line (with a // at the beginning of the line) or remove the remark, depending on which error you receive.  Some plugins are already using the SimplePie include and this cannot be loaded again, so reamrking out this line will correct the error and allow the widget to function.  If SimplePie is not already installed and being used, then this line must be unremarked.

== Screenshots ==

1. Talkshoe Archive Displayed screenshot-1.jpg
2. The option settings in the widget area screenshot-2.jpg

== Changelog ==

= 1.1 [2011-02-05] =
* Added shortcode '[wpta]' for posts and pages displays.
* Cleaned up the code for quicker loading.
* The shortcode may not work on some themes that already do not allow shortcode usage.

= 1.0 [2011-01-22] =
* Our debut of this version with no Talkshoe API code being used at this time.
* Requires an active Talkshoe Call ID with an RSS feed.
* Uses SimplePie to read the RSS feed for quicker and smoother loading.

= Support =
To report bugs, issues, features, etc., please use my Support Request Form at <a href="http://newmediaanswers.com/bbpress" target="_blank">Support Forum</a>