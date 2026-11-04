<?php

require_once get_theme_file_path( 'inc/helpers.php' );
require_once get_theme_file_path( 'inc/menu.php' );
require_once get_theme_file_path( 'inc/metabox.php' );

function hoi4_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'hoofdmenu' => 'Hoofdmenu',
			'divisies'  => 'Divisies, de favorieten',
		)
	);
}
add_action( 'after_setup_theme', 'hoi4_setup' );

function hoi4_assets() {
	wp_enqueue_style( 'hoi4-stijl', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
}
add_action( 'wp_enqueue_scripts', 'hoi4_assets' );

function hoi4_taal() {
	return 'lang="nl-NL"';
}
add_filter( 'language_attributes', 'hoi4_taal' );

function hoi4_aantal_per_pagina( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_home() || $query->is_archive() || $query->is_search() ) {
		$query->set( 'posts_per_page', 6 );
	}
	if ( $query->is_search() ) {
		$query->set( 'post_type', 'post' );
	}
}
add_action( 'pre_get_posts', 'hoi4_aantal_per_pagina' );

function hoi4_geen_voorvoegsel() {
	return '';
}
add_filter( 'get_the_archive_title_prefix', 'hoi4_geen_voorvoegsel' );

function hoi4_lengte_fragment() {
	return 24;
}
add_filter( 'excerpt_length', 'hoi4_lengte_fragment' );
