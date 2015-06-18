<?php

/**
 * @param string $slug The WordPress.org slug of the plugin
 *
 * @return StdClass
 */
function mpi_get_plugin_info( $slug ) {
	global $my_plugin_information;
	return $my_plugin_information->get_plugin_info( $slug );
}

/**
 * @param string $slug The WordPress.org slug of the plugin
 * @param string $field
 *
 * @return string
 */
function mpi_get_plugin_field( $slug, $field ) {
	global $my_plugin_information;
	return $my_plugin_information->get_plugin_field( $slug, $field );
}