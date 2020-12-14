<?php

function register_post_types() {
	$post_types       = [];
	$post_types_files = glob( get_template_directory() . '/inc/post-types/*.php' );

	foreach ( $post_types_files as $file ) {
		$post_types[] = require( $file );
	}

	foreach ( $post_types as $post_type ) {
		if ( isset( $post_type['post_type'] ) && isset( $post_type['args'] ) ) {
			register_post_type( $post_type['post_type'], $post_type['args'] );
		}
	}
}

add_action( 'init', 'register_post_types' );

