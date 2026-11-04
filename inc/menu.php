<?php
/**
 * De menu's: het hoofdmenu en de favorieten.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Elk menu item krijgt een plek van 2 kolommen in het raster.
 *
 * @param string[]  $classes Classes van het item.
 * @param WP_Post   $item    Menu item.
 * @param \stdClass $args    Instellingen van het menu.
 * @return string[]
 */
function hoi4_menu_klasse( $classes, $item, $args ) {
	if ( isset( $args->theme_location ) && in_array( $args->theme_location, array( 'hoofdmenu', 'divisies' ), true ) ) {
		$classes[] = 'kol-2';
	}
	return $classes;
}
add_filter( 'nav_menu_css_class', 'hoi4_menu_klasse', 10, 3 );

/**
 * De link van de huidige pagina krijgt aria-current.
 *
 * @param string[]  $atts Attributen van de link.
 * @param WP_Post   $item Menu item.
 * @param \stdClass $args Instellingen van het menu.
 * @return string[]
 */
function hoi4_menu_link( $atts, $item, $args ) {
	if ( isset( $args->theme_location ) && 'hoofdmenu' === $args->theme_location && ! empty( $item->current ) ) {
		$atts['aria-current'] = 'page';
	}
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'hoi4_menu_link', 10, 3 );

/**
 * Menu dat getoond wordt zolang er nog geen hoofdmenu is toegewezen.
 */
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

/**
 * Favorieten die getoond worden zolang er nog geen menu voor de divisies is toegewezen.
 */
function hoi4_divisies_standaard() {
	$standaard = array(
		'Schepen' => home_url( '/category/schepen/' ),
		'Tanks'   => home_url( '/category/tanks/' ),
		'Troepen' => home_url( '/category/troepen/' ),
	);
	echo '<ul class="raster" id="favorieten">';
	foreach ( $standaard as $naam => $url ) {
		hoi4_tegel( $naam, $url );
	}
	echo hoi4_toevoeg_tegel(); // Vaste tekst uit ons eigen thema.
	echo '</ul>';
}

/**
 * Een menu voor de favorieten wordt getoond als tegels in plaats van als gewone lijst.
 */
class Hoi4_Divisie_Walker extends Walker_Nav_Menu {

	/**
	 * Tekent een menu item als tegel.
	 *
	 * @param string   $output Wat er al getekend is.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Diepte in het menu.
	 * @param stdClass $args   Instellingen van het menu.
	 * @param int      $id     Nummer van het item.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		ob_start();
		hoi4_tegel( $item->title, $item->url );
		$output .= ob_get_clean();
	}

	/**
	 * Het item sluit zichzelf al af in start_el.
	 *
	 * @param string   $output Wat er al getekend is.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Diepte in het menu.
	 * @param stdClass $args   Instellingen van het menu.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= '';
	}
}

/**
 * Achter de favorieten uit het menu komt altijd de tegel Nieuwe divisie.
 *
 * @param string    $items Wat het menu tot nu toe heeft.
 * @param \stdClass $args  Instellingen van het menu.
 * @return string
 */
function hoi4_voeg_toevoegtegel_toe( $items, $args ) {
	if ( isset( $args->theme_location ) && 'divisies' === $args->theme_location ) {
		$items .= hoi4_toevoeg_tegel();
	}
	return $items;
}
add_filter( 'wp_nav_menu_items', 'hoi4_voeg_toevoegtegel_toe', 10, 2 );
