<?php
/**
 * Het overzicht met alle eenheden. WordPress kiest dit bestand voor de berichtenpagina,
 * de pagina die je bij Instellingen, Lezen als pagina voor je berichten kiest.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/overzicht' );
get_footer();
