<?php
/*
Plugin Name: My Plugin Information
Plugin URI: http://themeist.co/plugins/wordpress/my-plugin-information/
Description: Communicate with WordPress.org Plugins API to retrive your Plugin Information
Version: 0.3
Author: Harish Chouhan, Themeist.co
Author URI: http://themeist.co
License: GPL v3

MailChimp for WordPress
Copyright (C) 2013-2015, Themeist, hello@dreamsmedia.in

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// do nothing if class is already defined
if( class_exists( 'DOT_MyPluginInfo' ) ) {
	return;
}

// require includes
require_once dirname( __FILE__ ) . '/includes/class-my-plugin-info.php';
require_once dirname( __FILE__ ) . '/includes/functions.php';

// create instance of plugin class
global $my_plugin_information;
$my_plugin_information = new DOT_MyPluginInfo();
$my_plugin_information->add_hooks();
