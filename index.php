<?php
/**
 * Het laatste vangnet van de templatehiërarchie. Als geen ander bestand past, gebruikt WordPress dit.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/overzicht' );
get_footer();
