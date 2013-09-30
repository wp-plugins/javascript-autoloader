=== Plugin Name ===
Contributors: smartware.cc
Tags: javascript, jquery, header, footer, wp_enqueue_script, load, autoload
Requires at least: 2.6
Tested up to: 3.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Load JavaScript files without changing files in the theme directory or installing several plugins to add all the desired functionality

== Description ==

This Plugin allows you to load additional JavaScript files without the need to change files in the theme directory or to install several plugins to add all the desired functionality.

To load additional JavaScript files just put them into a directory named jsautoload. 

This directory can be placed in three different locations that are loaded in the following order:

* Child Theme dependent (if using a Child Theme) : in the Child Theme's directory
* Theme dependent : in the Theme's directory
* Theme independent : in the wp-content directory

You can use as many subdirectories as you like. Only files with extension .js are added, all other files are ignored. 

To ignore a complete directory (including all subdirectories) name the directory beginning with an underscore (_). The files are added in alphabetical order. Directories allway are added after files. 

To load one ore more JavaScript files at the end of your HTML file just place them into a directory named footer. To add the files to the footer of your theme it is required to call wp_footer() in your footer.php.

[Plugin Homepage](http://smartware.cc/wp-js-autoloader)
[Demo](http://wp-js-autoloader.demo.smartware.cc)

== Installation ==

1. Upload the "js-autoloader" folder to your "/wp-content/plugins/" directory.
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Create "jsautoload" folder(s) and put you JavaScript files in there ( see Plugins / JS AutoLoader in WP Admin )

== Changelog ==

= 1.0 (2013-09-13) =
* Initial Release