<?php
/*
Plugin Name: My Plugin Info
Plugin URI: http://www.dreamsonline.net/wordpress-plugins/my-plugin-info/
Description: Communicate with WordPress.org Plugins API to retrive your Plugin Information
Version: 0.1
Author: Dreams Online Themes
Author Email: hello@dreamsmedia.in
License:

  Copyright 2013 Dreams Online Themes (hello@dreamsmedia.in)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 3, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'DOT_MyPluginInfo' ) )
{

	class DOT_MyPluginInfo {


		/**
		 * Constructor
		 */
		function __construct() {
			//Hook up to the init action
			add_action( 'init', array( &$this, 'init_my_plugin_info' ) );
		}

		/**
		 * Runs when the plugin is activated
		 */
		function install_my_plugin_info() {
			// do not generate any output here
		}

		/**
		 * Runs when the plugin is initialized
		 */
		function init_my_plugin_info() {

			// Register the shortcode [mpi slug='my-plugin-info' field='version']
			add_shortcode( 'mpi', array( &$this, 'render_mpi' ) );
		}


		function render_mpi($atts) {

			// get our variable from $atts
			extract(shortcode_atts(array(
				'slug' => '', //foo is a default value
				'field' => ''
				), $atts));

			/**
			 * Check if slug exists
			 */
			if ( !$slug ) {
				return false;
			}


			// Sanitize slug attribute
			$slug = sanitize_title( $slug );


			// Create a empty array with variable name different based on plugin slug
			$mpi_transient_name = 'mpi' . $slug;


			/**
			 * Check if transient with the plugin data exists
			 */
			$mpi_info = get_transient( $mpi_transient_name );

			if ( empty( $mpi_info ) ) {

				/**
				 * Connect to WordPress.org using plugins_api
				 * About plugins_api -
				 * http://wp.tutsplus.com/tutorials/plugins/communicating-with-the-wordpress-org-plugin-api/
				 */
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
				$mpi_info = plugins_api( 'plugin_information', array( 'slug' => $slug ) );


				// Check for errors with the data returned from WordPress.org
				if ( !$mpi_info or is_wp_error( $mpi_info ) ) {
					return false;
				}


				// Set a transient with the plugin data
				// Use Options API with auto update cron job in next version.
				set_transient($mpi_transient_name, $mpi_info, 1 * HOUR_IN_SECONDS );


			} else {

				$mpi_info = get_transient( $mpi_transient_name );

			}
			//return $plugin_data[$slug];


			/**
			 * Check if field exists
			 * Return value based on the field attribute
			 */

			if ( !$field ) {

				return false;

			} else {

				// Sanitize field attribute
				$field = sanitize_title( $field );


				if ( $field == "downloaded" ) {
		        	return $mpi_info->downloaded;
		    	}

				if ( $field == "name" ) {
		        	return $mpi_info->name;
		    	}

				if ( $field == "slug" ) {
		        	return $mpi_info->slug;
		    	}

				if ( $field == "version" ) {
		        	return $mpi_info->version;
		    	}

				if ( $field == "author" ) {
		        	return $mpi_info->author;
		    	}

				if ( $field == "author_profile" ) {
		        	return $mpi_info->author_profile;
		    	}

				if ( $field == "last_updated" ) {
		        	return $mpi_info->last_updated;
		    	}

				if ( $field == "download_link" ) {
		        	return $mpi_info->download_link;
		    	}

		    }

		}


	} // end class
	new DOT_MyPluginInfo();

}

?>