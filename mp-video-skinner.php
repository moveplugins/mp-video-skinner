<?php
/*
Plugin Name: MP Video Skinner
Plugin URI: http://moveplugins.com
Description: Display YouTube videos with your own custom player skins!
Version: beta1.0.0.2
Author: Move Plugins
Author URI: http://moveplugins.com
Text Domain: mp_video_skinner
Domain Path: languages
License: GPL2
*/

/*  Copyright 2014  Phil Johnston  (email : phil@moveplugins.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Move Plugins Core.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Move Plugins Core, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
|--------------------------------------------------------------------------
| CONSTANTS
|--------------------------------------------------------------------------
*/
// Plugin version
if( !defined( 'MP_VIDEO_SKINNER_VERSION' ) )
	define( 'MP_VIDEO_SKINNER_VERSION', '1.0.0.0' );

// Plugin Folder URL
if( !defined( 'MP_VIDEO_SKINNER_PLUGIN_URL' ) )
	define( 'MP_VIDEO_SKINNER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Plugin Folder Path
if( !defined( 'MP_VIDEO_SKINNER_PLUGIN_DIR' ) )
	define( 'MP_VIDEO_SKINNER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

// Plugin Root File
if( !defined( 'MP_VIDEO_SKINNER_PLUGIN_FILE' ) )
	define( 'MP_VIDEO_SKINNER_PLUGIN_FILE', __FILE__ );

/*
|--------------------------------------------------------------------------
| GLOBALS
|--------------------------------------------------------------------------
*/



/*
|--------------------------------------------------------------------------
| INTERNATIONALIZATION
|--------------------------------------------------------------------------
*/

function mp_video_skinner_textdomain() {

	// Set filter for plugin's languages directory
	$mp_video_skinner_lang_dir = dirname( plugin_basename( MP_VIDEO_SKINNER_PLUGIN_FILE ) ) . '/languages/';
	$mp_video_skinner_lang_dir = apply_filters( 'mp_video_skinner_languages_directory', $mp_video_skinner_lang_dir );


	// Traditional WordPress plugin locale filter
	$locale        = apply_filters( 'plugin_locale',  get_locale(), 'mp-video-skinner' );
	$mofile        = sprintf( '%1$s-%2$s.mo', 'mp-video-skinner', $locale );

	// Setup paths to current locale file
	$mofile_local  = $mp_video_skinner_lang_dir . $mofile;
	$mofile_global = WP_LANG_DIR . '/mp-video-skinner/' . $mofile;

	if ( file_exists( $mofile_global ) ) {
		// Look in global /wp-content/languages/mp_video_skinner folder
		load_textdomain( 'mp_video_skinner', $mofile_global );
	} elseif ( file_exists( $mofile_local ) ) {
		// Look in local /wp-content/plugins/message_bar/languages/ folder
		load_textdomain( 'mp_video_skinner', $mofile_local );
	} else {
		// Load the default language files
		load_plugin_textdomain( 'mp_video_skinner', false, $mp_video_skinner_lang_dir );
	}

}
add_action( 'init', 'mp_video_skinner_textdomain', 1 );

/*
|--------------------------------------------------------------------------
| INCLUDES
|--------------------------------------------------------------------------
*/
function mp_video_skinner_include_files(){
	/**
	 * If mp_core isn't active, stop and install it now
	 */
	if (!function_exists('mp_core_textdomain')){
		
		/**
		 * Include Plugin Checker
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . '/includes/plugin-checker/class-plugin-checker.php' );
		
		/**
		 * Include Plugin Installer
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . '/includes/plugin-checker/class-plugin-installer.php' );
		
		/**
		 * Check if wp_core in installed
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . 'includes/plugin-checker/included-plugins/mp-core-check.php' );
		
	}
	/**
	 * Otherwise, if mp_core is active, carry out the plugin's functions
	 */
	else{
		
		/**
		 * Update script - keeps this plugin up to date
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . 'includes/updater/mp-video-skinner-update.php' );
		
		/**
		 * Enqueue Scripts
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . 'includes/misc-functions/enqueue-scripts.php' );
		
		/**
		 * Misc Functions
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . 'includes/misc-functions/misc-functions.php' );
		
		/**
		 * Custom Skins Custom Post Type
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . 'includes/custom-post-types/custom-skins.php' );
		
		/**
		 * Shortcode
		 */
		require( MP_VIDEO_SKINNER_PLUGIN_DIR . 'includes/misc-functions/shortcode.php' );
	
	}
}
add_action('plugins_loaded', 'mp_video_skinner_include_files', 9);