<?php

if ( ! function_exists( 'starter_theme_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 * @since 1.0.0
	 *
	 */
	function starter_theme_setup() {
		/*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         */
		load_theme_textdomain( 'starter-theme', TEMPLATE_DIR_URI . '/languages' );

		/*
		 * Let WordPress manage the document title.
		 * This theme does not use a hard-coded <title> tag in the document head,
		 * WordPress will provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add post-formats support.
		 */
		add_theme_support(
			'post-formats',
			[
				'link',
				'aside',
				'gallery',
				'image',
				'quote',
				'status',
				'video',
				'audio',
				'chat',
			]
		);

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
		add_theme_support(
			'html5',
			[
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'navigation-widgets',
			]
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for full and wide align images.
		add_theme_support( 'align-wide' );

		// Add support for responsive embedded content.
		add_theme_support( 'responsive-embeds' );

		// Add support for custom line height controls.
		add_theme_support( 'custom-line-height' );

		// Add support for experimental link color control.
		add_theme_support( 'experimental-link-color' );

		// Add support for experimental cover block spacing.
		add_theme_support( 'custom-spacing' );

		/**
		 * Register custom nav menus
		 */
		register_nav_menus(
			[
				'primary'  => esc_html__( 'Primary menu', 'starter-theme' ),
				'footer'   => esc_html__( 'Footer menu', 'starter-theme' ),
			]
		);

	}
}
add_action( 'after_setup_theme', 'starter_theme_setup' );

/**
 * Enqueue scripts and styles.
 *
 * @return void
 * @since 1.0.0
 *
 */
function starter_theme_scripts() {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'starter-theme-styles', TEMPLATE_DIR_URI . '/assets/styles/main.min.css', [], $theme_version, 'all' );
	wp_enqueue_script( 'starter-theme-scripts', TEMPLATE_DIR_URI . '/assets/scripts/main.min.js', [], $theme_version, true );
}

add_action( 'wp_enqueue_scripts', 'starter_theme_scripts' );

/**
 * Add "is-IE" class to body if the user is on Internet Explorer.
 *
 * @return void
 * @since 1.0.0
 *
 */
function starter_theme_add_ie_class() {
	?>
	<script>
      if (-1 !== navigator.userAgent.indexOf('MSIE') || -1 !== navigator.appVersion.indexOf('Trident/')) {
        document.body.classList.add('is-IE');
      }
	</script>
	<?php
}

add_action( 'wp_footer', 'starter_theme_add_ie_class' );

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0.0
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function starter_theme_body_classes( $classes ) {

	// Helps detect if JS is enabled or not.
	$classes[] = 'no-js';

	return $classes;
}

add_filter( 'body_class', 'starter_theme_body_classes' );

/**
 * Adds custom class to the array of posts classes.
 *
 * @since 1.0.0
 *
 * @param array $classes An array of CSS classes.
 *
 * @return array
 */
function starter_theme_post_classes( $classes ) {
	$classes[] = 'entry';

	return $classes;
}
add_filter( 'post_class', 'starter_theme_post_classes', 10, 3 );

/**
 * Remove the `no-js` class from body if JS is supported.
 *
 * @since 1.0.0
 *
 * @return void
 */
function starter_theme_supports_js() {
	echo '<script>document.body.classList.remove("no-js");</script>';
}
add_action( 'wp_footer', 'starter_theme_supports_js' );
