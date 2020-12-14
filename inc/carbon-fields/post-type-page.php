<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function crb_add_fields_post_type_page() {
	$fields = [];

	Container::make( 'post_meta', __( 'Topic information', 'safetyinaction' ) )
	         ->where( 'post_type', '=', 'topic' )
	         ->add_fields( [
		         Field::make( 'rich_text', 'crb_topic_description', __( 'Topic description', 'safetyinaction' ) ),
		         Field::make( 'complex', 'crb_topic_schedule', __( 'Time and speaker' ) )
		              ->set_layout( 'tabbed-vertical' )
		              ->setup_labels( [
			              'plural_name'   => 'Times and speakers',
			              'singular_name' => 'Time and speaker',
		              ] )
		              ->add_fields( [
			              Field::make( 'time', 'crb_topic_time_from', __( 'Time from', 'safetyinaction' ) )->set_width( 50 ),
			              Field::make( 'time', 'crb_topic_time_to', __( 'Time to', 'safetyinaction' ) )->set_width( 50 ),
			              Field::make( 'association', 'crb_topic_speaker', __( 'Speaker', 'safetyinaction' ) )
			                   ->set_types( [
				                   [
					                   'type'      => 'post',
					                   'post_type' => 'speaker',
				                   ]
			                   ] )
			                   ->set_max( 1 ),
		              ] )
		              ->set_header_template(
			              '<% if (crb_topic_time_from && crb_topic_time_to) { %>
						    <%- crb_topic_time_from %> - <%- crb_topic_time_to %>
						  <% } %>'
		              )
	         ] );
};

add_action( 'carbon_fields_register_fields', 'crb_add_fields_post_type_page', 10 );
