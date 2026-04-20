<?php
/**
 * Kadence Child theme bootstrap.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register front-end assets for the child theme.
 */
function dhf_kadence_child_enqueue_styles() {
	$theme         = wp_get_theme();
	$parent_theme  = $theme->parent();
	$child_css_rel = '/assets/css/custom.css';
	$child_css_abs = get_stylesheet_directory() . $child_css_rel;
	$font_query    = array(
		'family'  => 'Bricolage+Grotesque:wght@400;500;700;800|Inter:wght@400;500;600;700;800',
		'display' => 'swap',
	);

	wp_enqueue_style(
		'kadence-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		$parent_theme ? $parent_theme->get( 'Version' ) : null
	);

	wp_enqueue_style(
		'dhf-google-fonts',
		add_query_arg( $font_query, 'https://fonts.googleapis.com/css' ),
		array(),
		null
	);

	wp_enqueue_style(
		'kadence-child-style',
		get_stylesheet_directory_uri() . $child_css_rel,
		array( 'kadence-parent-style', 'dhf-google-fonts' ),
		file_exists( $child_css_abs ) ? filemtime( $child_css_abs ) : $theme->get( 'Version' )
	);

	if ( is_front_page() ) {
		wp_enqueue_script(
			'dhf-homepage-cards',
			get_stylesheet_directory_uri() . '/assets/js/homepage-cards.js',
			array(),
			file_exists( get_stylesheet_directory() . '/assets/js/homepage-cards.js' )
				? filemtime( get_stylesheet_directory() . '/assets/js/homepage-cards.js' )
				: $theme->get( 'Version' ),
			true
		);
	}
}
add_action( 'wp_enqueue_scripts', 'dhf_kadence_child_enqueue_styles' );
