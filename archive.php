<?php
/**
 * Archieven: eenheden van een categorie, een tag of een datum.
 * WordPress zoekt eerst category.php of tag.php. Die zijn er niet, dus gebruikt het dit bestand.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
get_template_part( 'template-parts/overzicht' );
get_footer();
