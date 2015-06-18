<?php
/*
Plugin Name: My Plugin Info
Plugin URI: http://www.dreamsonline.net/wordpress-plugins/my-plugin-info/
Description: Communicate with WordPress.org Plugins API to retrive your Plugin Information
Version: 0.2
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


if ( ! class_exists( 'DOT_MyPluginInfo' ) ) {

	class DOT_MyPluginInfo {


		/**
		 * Constructor
		 */
		public function __construct() {
			//Hook up to the init action
			add_action( 'init', array( $this, 'init' ) );
		}

		/**
		 * Runs when the plugin is initialized
		 */
		public function init() {

			// Register the shortcode [mpi slug='my-plugin-info' field='version']
			add_shortcode( 'mpi', array( $this, 'output' ) );
		}


		public function output( $atts = array() ) {

			// get our variable from $atts
			$atts = shortcode_atts( array(
				'slug' => '', //foo is a default value
				'field' => ''
				), $atts );

			/**
			 * Slug & field must both be givens
			 */
			if ( '' === $atts['slug'] || '' === $atts['field'] ) {
				return false;
			}

			// Sanitize slug attribute
			$slug = sanitize_title( $atts['slug'] );

			// Create a empty array with variable name different based on plugin slug
			$transient_name = 'mpi' . $slug;

			/**
			 * Check if transient with the plugin data exists
			 */
			$info = get_transient( $transient_name );

			if ( empty( $info ) ) {

				/**
				 * Connect to WordPress.org using plugins_api
				 * About plugins_api -
				 * http://wp.tutsplus.com/tutorials/plugins/communicating-with-the-wordpress-org-plugin-api/
				 */
				require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
				$info = plugins_api( 'plugin_information', array( 'slug' => $slug ) );


				// Check for errors with the data returned from WordPress.org
				if ( ! $info or is_wp_error( $info ) ) {
					return false;
				}


				// Set a transient with the plugin data
				// Use Options API with auto update cron job in next version.
				set_transient( $transient_name, $info, 1 * HOUR_IN_SECONDS );
			}


			/**
			 * Check if field exists
			 * Return value based on the field attribute
			 */


			// Sanitize field attribute
			$field = sanitize_title( $atts['field'] );


			if ( $field == "downloaded" ) {
	            return $info->downloaded;
	        }

			if ( $field == "name" ) {
	            return $info->name;
	        }

			if ( $field == "slug" ) {
	            return $info->slug;
	        }

			if ( $field == "version" ) {
	            return $info->version;
	        }

			if ( $field == "author" ) {
	            return $info->author;
	        }

			if ( $field == "author_profile" ) {
	            return $info->author_profile;
	        }

			if ( $field == "last_updated" ) {
	            return $info->last_updated;
	        }

			if ( $field == "download_link" ) {
	            return $info->download_link;
	        }

			if ( $field == "requires" ) {
				return $info->requires;
			}

			if ( $field == "tested" ) {
				return $info->tested;
			}

            /**
             * rating outputs a percentage, to get a number of stars like in the WP Plugin Repository, you need to divide the output by 20:
             *
             * $percentage = do_shortcode( '[mpi slug="' . $slug . '" field="rating"]' );
             * $stars = $percentage / 20;
             * printf( __( 'Rating: %s out of 5 stars', 'textdomain' ), $stars );
             *
             */
            if ( $field == "rating" ) {
                return $info->rating;
            }

		}


	}

	// create instance of class
	global $my_plugin_information;
	$my_plugin_information = new DOT_MyPluginInfo();
}