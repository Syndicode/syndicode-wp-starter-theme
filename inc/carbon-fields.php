<?php
function crb_load() {
	require_once( get_template_directory() . '/vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}

add_action( 'after_setup_theme', 'crb_load' );
add_filter( 'carbon_fields_user_meta_container_admin_only_access', '__return_false' );
