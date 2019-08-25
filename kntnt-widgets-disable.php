<?php

/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Widget Disable
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Disables all widgets by default (but allows exceptions via a filter hook), and deactivates the widget menu item if all widgets are disabled.
 * Version:           1.0.0
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */

// Add action that removes all widgets. The left column of
// /wp-admin/widgets.php is built by an action with priority 101,
// thus priority 100 for this action.
add_action( 'widgets_init', function () {
	global $wp_widget_factory;
	foreach ( array_keys( $wp_widget_factory->widgets ) as $widget ) {
		if ( apply_filters( 'kntnt-widget-disable', true, $widget ) ) {
			$wp_widget_factory->unregister( $widget );
		}
	}
}, 100 );

// Add action that removes the Widgets menu item.
add_action( 'admin_menu', function () {
	global $wp_widget_factory;
	if ( empty( $wp_widget_factory->widgets ) ) {
		remove_submenu_page( 'themes.php', 'widgets.php' );
	}
} );