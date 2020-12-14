<?php
define( 'TEMPLATE_DIR_URI', get_template_directory_uri() );
define ('ASSETS_DIR_URI', TEMPLATE_DIR_URI . '/assets');

/**
 * Template function.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Register new custom taxonomies
 */
require_once get_template_directory() . '/inc/register-taxonomies.php';

/**
 * Register new custom post types
 */
require_once get_template_directory() . '/inc/register-post-types.php';

/**
 * Helpers
 */
require_once get_template_directory() . '/inc/utils.php';

/**
 * Carbon fields - custom meta fields library
 */
require_once get_template_directory() . '/inc/carbon-fields.php';
