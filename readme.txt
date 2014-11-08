=== Plugin Name ===
Contributors: smartware.cc
Tags: javascript, jquery, header, footer, wp_enqueue_script, load, autoload
Requires at least: 2.6
Tested up to: 4.0
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Load JavaScript files without changing files in the theme directory or installing several plugins to add all the desired functionality

== Description ==

> This Plugin allows you to load additional JavaScript files without the need to change files in the theme directory or to install several plugins to add all the desired functionality.

**Update Notice: The JS AutoLoader Menu Item is now located in Tools Menu and no longer in Plugins Menu**

To load additional JavaScript files just put them into a directory named jsautoload. 

This directory can be placed in three different locations that are loaded in the following order:

* Child Theme dependent (if using a Child Theme) : in the Child Theme's directory
* Theme dependent : in the Theme's directory
* Theme independent : in the wp-content directory

You can use as many subdirectories as you like. Only files with extension .js are added, all other files are ignored. 

To ignore a complete directory (including all subdirectories) name the directory beginning with an underscore (_). The files are added in alphabetical order. Directories allway are added after files. 

To load one ore more JavaScript files at the end of your HTML file just place them into a directory named footer. To add the files to the footer of your theme it is required to call wp_footer() in your footer.php.

= Languages =

* English
* German

**Translators welcome!** The languages directory contains POT files to start new translations. Please [contact Author](http://smartware.cc/) if you would like to do a translation.

= More Information =

Visit the [Plugin Homepage](http://smartware.cc/free-wordpress-plugins/javascript-autoloader/)

= Do you like the JavaScript AutoLoader Plugin? =

Thanks, I appreciate that. You don’t need to make a donation. No money, no beer, no coffee. Please, just [tell the world that you like what I’m doing](http://smartware.cc/make-a-donation/)! And that’s all.

== Installation ==

= From your WordPress dashboard =

1. Visit 'Plugins' -> 'Add New'
1. Search for 'JavaScript AutoLoader'
1. Activate the plugin through the 'Plugins' menu in WordPress

= Manually from wordpress.org =

1. Download JavaScript AutoLoader from wordpress.org and unzip the archive
1. Upload the `javascript-autoloader` folder to your `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

== Screenshots ==

1. Go to 'Tools' -> 'JS AutoLoader' in your WordPress dashboard to see the possible paths where to store your JavaScript files and the currently loaded files

== Changelog ==

= 1.1 (2014-11-08) =
* Technical Improvements
* WP 4.0 Style
* German translation

= 1.0 (2013-09-13) =
* Initial Release