<?php
/**
 * Een enkele eenheid (bericht). WordPress kiest dit bestand voor elk bericht, dus voor type post.
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
				<header>
					<h1><?php the_title(); ?></h1>
					<?php hoi4_post_meta(); ?>
					<?php hoi4_rol(); ?>
				</header>

				<div class="artikel__tekst">
					<?php the_content(); ?>
				</div>

				<?php the_tags( '<p>Tags: ', ', ', '</p>' ); ?>
			</article>

			<?php
			// Links naar de vorige en de volgende eenheid.
			the_post_navigation(
				array(
					'prev_text' => 'Vorige eenheid: %title',
					'next_text' => 'Volgende eenheid: %title',
				)
			);
			?>
		<?php endwhile; ?>
	</main>

<?php
get_footer();
