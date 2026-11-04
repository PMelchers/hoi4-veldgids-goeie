<?php

get_header();
?>

	<main id="inhoud" class="sectie overzicht">
		<header class="overzicht__kop">
			<h1>Eenheden van <?php echo esc_html( get_the_author_meta( 'display_name', get_queried_object_id() ) ); ?></h1>
		</header>

		<?php get_template_part( 'template-parts/filter' ); ?>

		<?php if ( have_posts() ) : ?>
			<div class="raster">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article <?php post_class( 'kaart kol-6' ); ?>>
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php hoi4_post_meta(); ?>
						<?php hoi4_rol(); ?>
						<div><?php the_excerpt(); ?></div>
					</article>
				<?php endwhile; ?>
			</div>
			<?php
			the_posts_pagination(
				array(
					'prev_text'          => 'Vorige',
					'next_text'          => 'Volgende',
					'screen_reader_text' => 'Meer eenheden',
				)
			);
			?>
		<?php else : ?>
			<p>Geen eenheden gevonden, commandant.</p>
		<?php endif; ?>
	</main>

<?php
get_footer();
