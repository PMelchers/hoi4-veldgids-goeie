<?php
/**
 * Een kaart voor een eenheid in een overzicht: titel, meta, rol en fragment.
 * Wordt gebruikt in de loop van het berichtenoverzicht, de archieven en de zoekresultaten.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<article <?php post_class( 'kaart kol-6' ); ?>>
	<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
	<?php hoi4_post_meta(); ?>
	<?php hoi4_rol(); ?>
	<div><?php the_excerpt(); ?></div>
</article>
