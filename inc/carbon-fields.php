<?php
function crb_load() {
	require_once( get_template_directory() . '/vendor/autoload.php' );
	\Carbon_Fields\Carbon_Fields::boot();
}

add_action( 'after_setup_theme', 'crb_load' );

require_once get_template_directory() . '/inc/carbon-fields/post-type-page.php';
