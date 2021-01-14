<?php
define( 'TEMPLATE_DIR', get_template_directory() );
define( 'TEMPLATE_DIR_URI', get_template_directory_uri() );
define ('ASSETS_DIR_URI', TEMPLATE_DIR_URI . '/assets');

/**
 * Template function.
 */
require TEMPLATE_DIR . '/inc/template-functions.php';

/**
 * Register new custom taxonomies
 */
require_once TEMPLATE_DIR . '/inc/register-taxonomies.php';

/**
 * Register new custom post types
 */
require_once TEMPLATE_DIR . '/inc/register-post-types.php';

/**
 * Utils
 */
require_once TEMPLATE_DIR . '/inc/utils.php';

/**
 * Carbon fields - custom meta fields library
 */
require_once TEMPLATE_DIR . '/inc/carbon-fields.php';
