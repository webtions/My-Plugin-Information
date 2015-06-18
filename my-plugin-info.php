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
