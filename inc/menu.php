<?php

function hoi4_menu_klasse( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && in_array( $args->theme_location, array( 'hoofdmenu', 'divisies' ), true ) ) {
		$classes[] = 'kol-2';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'hoi4_menu_klasse', 10, 3 );

function hoi4_menu_link( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'hoofdmenu' === $args->theme_location && ! empty( $item->current ) ) {
		$atts['aria-current'] = 'page';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'hoi4_menu_link', 10, 3 );

function hoi4_menu_standaard() {
	$items = array(
		'Schepen'       => home_url( '/category/schepen/' ),
		'Tanks'         => home_url( '/category/tanks/' ),
		'Troepen'       => home_url( '/category/troepen/' ),
		'Alle eenheden' => hoi4_alle_url(),
	);
	echo '<ul class="raster">';
	foreach ( $items as $naam => $url ) {
		printf( '<li class="kol-2"><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $naam ) );
	}
	echo '</ul>';
}

function hoi4_divisies_standaard() {
	$standaard = array(
		'Schepen' => home_url( '/category/schepen/' ),
		'Tanks'   => home_url( '/category/tanks/' ),
		'Troepen' => home_url( '/category/troepen/' ),
	);
	echo '<ul class="raster">';
	foreach ( $standaard as $naam => $url ) {
		echo hoi4_tegel( $naam, $url );
	}
	echo '</ul>';
}

class Hoi4_Divisie_Walker extends Walker_Nav_Menu {

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$output .= hoi4_tegel( $item->title, $item->url );
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '';
	}
}
