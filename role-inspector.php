<?php
/*
Plugin Name: Role Inspector
Author: ericlewis
Version: 0.1
*/

add_action( 'admin_menu', function() {
	add_submenu_page(
		'tools.php',
		'Role Inspector',
		'Role Inspector',
		'manage_options',
		'role-inspector',
		'ri_output_page'
	);
});

add_action( 'admin_enqueue_scripts', function($hook) {
	if ( $hook != 'tools_page_role-inspector' ) {
		return;
	}
	wp_enqueue_style( 'role-inspector', plugins_url('style.css', __FILE__ ) );
});

function ri_output_page() {
	echo '<div class="wrap"><div id="icon-tools" class="icon32"></div>';
	echo '<h2>Role Inspector</h2>';
	$roles = wp_roles()->roles;
	// var_dump( $roles );
	$all_capabilities = array();
	foreach ( $roles as $role ) {
		$all_capabilities = array_merge( array_keys( $role['capabilities'] ), $all_capabilities );
	}
	// var_dump( $all_capabilities );
	$all_capabilities = array_unique( $all_capabilities );
	// var_dump( $roles );
	echo '<table class="role-inspector-table">';
	echo '<thead>';
	echo '<tr>';
	echo '<th>Capability</th>';
	foreach ( $roles as $role ) {
		echo '<th>' . $role['name'] . '</th>';
	}
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	foreach ( $all_capabilities as $capability ) {
		echo '<tr>';
		echo '<td class="capability-name">' . $capability . '</td>';
		foreach ( $roles as $role ) {
			if ( array_key_exists( $capability, $role['capabilities'] ) ) {
				echo '<td class="has-capability"></td>';
			} else {
				echo '<td class="doesnt-have-capability"></td>';
			}
		}
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</div>';
}
