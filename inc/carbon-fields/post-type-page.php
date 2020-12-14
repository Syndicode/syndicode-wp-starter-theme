<?php

use Carbon_Fields\Container;

function crb_add_fields_post_type_page() {
	$fields = [];

	Container::make( 'post_meta', __( 'Page additional data', 'starter-theme' ) )
	         ->where( 'post_type', '=', 'page' )
	         ->add_fields( $fields );
}

add_action( 'carbon_fields_register_fields', 'crb_add_fields_post_type_page', 10 );
