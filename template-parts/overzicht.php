<?php
/**
 * Het overzicht met titel, filters, kaarten en paginering.
 * home.php, archive.php, author.php en search.php gebruiken allemaal dit bestand,
 * zodat het uiterlijk van alle overzichten hetzelfde is en de code maar op een plek staat.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// De titel hangt af van het soort overzicht.
if ( is_search() ) {
	$titel = 'Zoekresultaten voor ' . get_search_query();
} elseif ( is_author() ) {
	$titel = 'Eenheden van ' . get_the_author_meta( 'display_name', get_queried_object_id() );
} elseif ( is_home() ) {
	$pagina = (int) get_option( 'page_for_posts' );
	$titel  = $pagina ? get_the_title( $pagina ) : 'Alle eenheden';
} else {
	$titel = get_the_archive_title();
}
$beschrijving = is_archive() ? get_the_archive_description() : '';
?>
	<main id="inhoud" class="sectie overzicht">
		<header class="overzicht__kop">
			<h1><?php echo esc_html( $titel ); ?></h1>
			<?php if ( $beschrijving ) : ?>
				<div><?php echo wp_kses_post( $beschrijving ); ?></div>
			<?php endif; ?>
		</header>

		<?php get_template_part( 'template-parts/filter' ); ?>

		<?php if ( have_posts() ) : ?>
			<div class="raster">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/kaart' );
				endwhile;
				?>
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
			<p>Geen eenheden gevonden, commandant. Probeer een ander filter of een andere zoekopdracht.</p>
		<?php endif; ?>
	</main>
