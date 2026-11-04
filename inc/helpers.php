<?php
/**
 * Kleine functies die meerdere templates gebruiken, zodat code niet herhaald wordt.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Het adres van het overzicht met alle eenheden.
 * Is er een pagina als berichtenpagina ingesteld, dan is dat het adres. Anders de voorpagina.
 *
 * @return string
 */
function hoi4_alle_url() {
	$pagina = (int) get_option( 'page_for_posts' );
	return $pagina ? get_permalink( $pagina ) : home_url( '/' );
}

/**
 * Datum, auteur en categorieën van het bericht in de loop.
 */
function hoi4_post_meta() {
	printf(
		'<p><time datetime="%1$s">%2$s</time> door <a href="%3$s">%4$s</a> in %5$s</p>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() ),
		get_the_category_list( ', ' ) // WordPress maakt zelf veilige links van de categorieën.
	);
}

/**
 * De rol van de eenheid in het spel, uit het extra veld bij het bericht. Niets als het veld leeg is.
 */
function hoi4_rol() {
	$rol = get_post_meta( get_the_ID(), 'rol', true );
	if ( $rol ) {
		printf( '<p>Rol: %s</p>', esc_html( $rol ) );
	}
}

/**
 * Een tegel voor een favoriet: een rechthoek met een letter en de naam.
 * De voorpagina gebruikt deze functie voor de standaard favorieten en voor de favorieten uit het menu.
 *
 * @param string $naam Naam van de favoriet.
 * @param string $url  Adres van de favoriet.
 */
function hoi4_tegel( $naam, $url ) {
	printf(
		'<li class="kol-2"><a class="tegel" href="%1$s"><span class="tegel__icoon" aria-hidden="true">%2$s</span>%3$s</a></li>',
		esc_url( $url ),
		esc_html( mb_substr( $naam, 0, 1 ) ),
		esc_html( $naam )
	);
}

/**
 * De tegel Nieuwe divisie, waarmee de bezoeker zelf een favoriet toevoegt.
 *
 * @return string
 */
function hoi4_toevoeg_tegel() {
	return '<li class="kol-2" id="toevoegen-item"><button class="tegel tegel--toevoegen" type="button" id="toevoegen"><span class="tegel__icoon" aria-hidden="true"><svg class="icoon"><use href="#i-plus"/></svg></span>Nieuwe divisie</button></li>';
}
