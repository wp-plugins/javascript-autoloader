<?php
/*
Plugin Name: JavaScript AutoLoader
Plugin URI: http://smartware.cc/wp-js-autoloader
Description: This Plugin allows you to load additional JavaScript files without the need to change files in the Theme directory. To load additional JavaScript files just put them into a directory named jsautoload.
Version: 1.0
Author: smartware.cc
Author URI: http://smartware.cc
License: GPL2
*/

/*  Copyright 2013  smartware.cc  (email : sw@smartware.cc)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// returns an array of files to add
function swcc_js_autoloader_getFiles( $dir, $suffix='', $urlprefix='', $prefix='', $depth=0, $footer=0, $source ) {
  $dir = rtrim( $dir, '\\/' );
  $files = array();
  $result = array();
  if( $urlprefix != '' && substr( $urlprefix, -1 ) != '/' ) {
    $urlprefix .= '/';
  }
  $suffix = strtolower( $suffix );
  if ( file_exists( $dir ) ) {
    foreach ( scandir( $dir ) as $f ) {
      if ( $f !== '.' && $f !== '..' ) {
        if ( is_dir( "$dir/$f" ) && substr( $f, 0, 1 ) != '_' ) {
          if( $f == 'footer' || $footer == 1 ) {
            $ft = 1;
          } else {
            $ft = 0;
          }
          $result = array_merge( $result, swcc_js_autoloader_getFiles( "$dir/$f", "$suffix", "$urlprefix", "$prefix$f/", $depth+1, $ft, $source ) );
        } else {
          if ( $suffix=='' || ( $suffix != '' && strtolower( substr( $f, -strlen( $suffix ) ) ) == $suffix ) ) {
            $file['name'] = $urlprefix.$prefix.$f;
            $file['depth'] = $depth;
            $file['footer'] = $footer;
            $file['source'] = $source;
            $result[] = $file;
          }
        }
      }
    }
  }
  return $result;
}

// get an sorted array of all *.js files in all possible loactions 
function swcc_autoloader_getAllFiles() {
  $dir = 'jsautoload';
  $filesarray = array();
  if ( is_child_theme() ) { $filesarray = swcc_js_autoloader_getFiles( get_stylesheet_directory() . '/' . $dir, '.js', get_stylesheet_directory_uri() . '/' . $dir, '', 0, 0, 1 ); }
  $filesarray = array_merge( $filesarray, swcc_js_autoloader_getFiles( get_template_directory() . '/' . $dir, '.js', get_template_directory_uri(). '/' . $dir, '', 0, 0, 2 ) );
  $filesarray = array_merge( $filesarray, swcc_js_autoloader_getFiles( WP_CONTENT_DIR . '/' . $dir, '.js', content_url() . '/' . $dir, '', 0, 0, 3 ) );
  $files = array();
  $depth = array();
  $source = array();
  $footer = array();
  foreach ( $filesarray as $file ) {
    $files[] = $file['name'];
    $depth[] = $file['depth'];
    $source[] = $file['source'];
    $footer[] = $file['footer'];
  }
  array_multisort( $footer, SORT_NUMERIC, $source, SORT_NUMERIC, $depth, SORT_NUMERIC, $files, SORT_ASC, $filesarray );
  return $filesarray;
}

// adds an js file to header
function swcc_js_autoloader_add( $jsfile, $footer ) {
  wp_enqueue_script( 'swcc-js-autoloader-' . basename($jsfile), $jsfile, array(), false, ( $footer==1 ) );
}

// show admin page
function swcc_js_autoloader_admin() {
	if ( !current_user_can( 'activate_plugins' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
  $dir = 'jsautoload';
	echo '<div class="wrap">';
  echo '<div id="icon-tools" class="icon32"></div>';
  echo '<h2>JavaScript AutoLoader</h2>';
  echo '<h3>Possible paths to store your JavaScript files</h3>';
  echo '<p><strong>Child Theme Directory</strong></p>';
  if ( is_child_theme() ) {
    echo '<p>current path: ' . get_stylesheet_directory() . '/' . $dir;
  } else {
    echo '<p>you are not using a Child Theme</p>';
  }
	echo '<p><strong>Theme Directory</strong></p>';
  echo '<p>current path: ' . get_template_directory() . '/' . $dir;
  echo '<p><strong>General Directory</strong></p>';
  echo '<p>current path: ' . WP_CONTENT_DIR . '/' . $dir;
  echo '<h3>Currently loaded (in that order) JavaScript files</h3>';
  swcc_js_autoloader_adminshowcurrent();
  echo '<h3>More Information</h3>';
  echo '<p>Visit the <a href="http://smartware.cc/wp-js-autoloader/">WordPress JavaScript AutoLoader Plugin Homepage</a>';
	echo '</div>';
}

// list cuurently loaded js files on admin page
function swcc_js_autoloader_adminshowcurrent() {
  $filesarray = swcc_autoloader_getAllFiles();  
  if ( empty( $filesarray ) ) {
    echo '<p>no files loaded currently</p>';
  } else {
  $loc = -1;
    foreach ( $filesarray as $file ) {
      if ( $file['footer'] != $loc) {
        if ( $file['footer'] == 0) {
          echo '<p><strong>in Header</strong></p>';
          echo '<ul>';
        } else {
          if ( $loc != -1 ) {
            echo '</ul>';
          }
          echo '<ul>';
          echo '<p><strong>in Footer (be sure to call wp_footer() in your footer template!)</strong></p>';
        }
        $loc = $file['footer'];
      }
      echo '<li>' . $file['name'] . '</li>';
    }
    echo '</ul>';
  }
}

// init frontend
function swcc_js_autoloader() {
  $filesarray = swcc_autoloader_getAllFiles();  
  foreach ( $filesarray as $file ) {
    swcc_js_autoloader_add( $file['name'], $file['footer'] );
  }
}

// init backend
function swcc_js_autoloader_adminmenu() {
  add_submenu_page( 'plugins.php', 'WP JS AutoLoader', 'JS AutoLoader', 'activate_plugins', 'wpjsautoloader', 'swcc_js_autoloader_admin' );
}

add_action( 'wp_enqueue_scripts', 'swcc_js_autoloader', 999 );
add_action( 'admin_menu', 'swcc_js_autoloader_adminmenu' );
?>