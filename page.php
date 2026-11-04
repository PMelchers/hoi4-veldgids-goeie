<?php
/**
 * Een gewone pagina, zoals Over deze site. WordPress kiest dit bestand voor elk bericht van het type page.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="inhoud" class="sectie">
		<?php
		while ( have_posts() ) :
			the_post();
			?>
			<article <?php post_class( 'artikel' ); ?>>
				<h1><?php the_title(); ?></h1>
				<div class="artikel__tekst">
					<?php
					the_content();
					wp_link_pages(); // Alleen zichtbaar als de pagina is opgedeeld.
					?>
				</div>
			</article>
		<?php endwhile; ?>
	</main>

<?php
get_footer();
