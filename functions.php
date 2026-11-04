<?php
/**
 * HOI4 Veldgids: instellingen van het thema.
 *
 * Dit bestand regelt wat het hele thema nodig heeft: de ondersteuning van WordPress, de menu's,
 * de stijl en het script, de teksten en hoeveel berichten er op een overzicht staan.
 * Grotere onderdelen staan in de map inc, zodat dit bestand overzichtelijk blijft.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once get_theme_file_path( 'inc/helpers.php' );
require_once get_theme_file_path( 'inc/menu.php' );
require_once get_theme_file_path( 'inc/metabox.php' );

/**
 * Wat WordPress voor dit thema moet doen.
 */
function hoi4_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );

	// Twee plekken voor een menu. Beide staan onder Weergave, Menu's.
	register_nav_menus(
		array(
			'hoofdmenu' => 'Hoofdmenu',
			'divisies'  => 'Divisies, de favorieten',
		)
	);
}
add_action( 'after_setup_theme', 'hoi4_setup' );

/**
 * Laad de stijl en het script. Alle opmaak staat in style.css, het bestand in de hoofdmap van het thema.
 */
function hoi4_assets() {
	$versie = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'hoi4-stijl', get_stylesheet_uri(), array(), $versie );
	wp_enqueue_script( 'hoi4-app', get_theme_file_uri( 'assets/js/app.js' ), array(), $versie, true );
}
add_action( 'wp_enqueue_scripts', 'hoi4_assets' );

/**
 * De teksten in dit thema zijn Nederlands, ook als de site op Engels staat.
 *
 * @return string
 */
function hoi4_taal() {
	return 'lang="nl-NL"';
}
add_filter( 'language_attributes', 'hoi4_taal' );

/**
 * Overzichten, zoekresultaten en het berichtenoverzicht krijgen 6 berichten per pagina.
 * De hoofdquery is de query die WordPress zelf maakt voor de pagina die je bezoekt.
 *
 * @param WP_Query $query De hoofdquery.
 */
function hoi4_aantal_per_pagina( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}
	if ( $query->is_home() || $query->is_archive() || $query->is_search() ) {
		$query->set( 'posts_per_page', 6 );
	}
	if ( $query->is_search() ) {
		// Zoeken gaat alleen over de eenheden, niet over pagina's.
		$query->set( 'post_type', 'post' );
	}
}
add_action( 'pre_get_posts', 'hoi4_aantal_per_pagina' );

/**
 * Een archieftitel zonder het voorvoegsel Categorie: of Auteur:.
 * Het voorvoegsel zetten we er zelf bij waar dat past.
 *
 * @return string
 */
function hoi4_geen_voorvoegsel() {
	return '';
}
add_filter( 'get_the_archive_title_prefix', 'hoi4_geen_voorvoegsel' );

/**
 * Een korter fragment van een bericht, passend bij de kaarten.
 *
 * @return int
 */
function hoi4_lengte_fragment() {
	return 24;
}
add_filter( 'excerpt_length', 'hoi4_lengte_fragment' );
