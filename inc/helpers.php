<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function hoi4_alle_url() {
	$pagina = (int) get_option( 'page_for_posts' );
	return $pagina ? get_permalink( $pagina ) : home_url( '/' );
}

function hoi4_post_meta() {
	printf(
		'<p><time datetime="%1$s">%2$s</time> door <a href="%3$s">%4$s</a> in %5$s</p>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() ),
		get_the_category_list( ', ' )
	);
}

function hoi4_rol() {
	$rol = get_post_meta( get_the_ID(), 'rol', true );
	if ( $rol ) {
		printf( '<p>Rol: %s</p>', esc_html( $rol ) );
	}
}

function hoi4_tegel( $naam, $url ) {
	printf(
		'<li class="kol-2"><a class="tegel" href="%1$s"><span class="tegel__icoon" aria-hidden="true">%2$s</span>%3$s</a></li>',
		esc_url( $url ),
		esc_html( mb_substr( $naam, 0, 1 ) ),
		esc_html( $naam )
	);
}

function hoi4_toevoeg_tegel() {
	return '<li class="kol-2" id="toevoegen-item"><button class="tegel tegel--toevoegen" type="button" id="toevoegen"><span class="tegel__icoon" aria-hidden="true"><svg class="icoon"><use href="#i-plus"/></svg></span>Nieuwe divisie</button></li>';
}
