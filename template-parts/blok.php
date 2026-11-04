<?php
/**
 * Een blok van de voorpagina met de nieuwste eenheden uit een categorie.
 * De voorpagina roept dit bestand drie keer aan, met een andere categorie.
 *
 * Verwacht in $args: sleutel (voor de id's en de opslag), titel en categorie (de slug).
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sleutel   = isset( $args['sleutel'] ) ? $args['sleutel'] : 'blok';
$titel     = isset( $args['titel'] ) ? $args['titel'] : '';
$categorie = isset( $args['categorie'] ) ? $args['categorie'] : '';

// De query haalt de nieuwste vier eenheden uit de categorie.
$eenheden = new WP_Query(
	array(
		'category_name'       => $categorie,
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true, // We tellen geen pagina's, dus dat scheelt een databasevraag.
	)
);
$term      = get_category_by_slug( $categorie );
?>
<article class="blok kol-4" data-blok="<?php echo esc_attr( $sleutel ); ?>">
	<h3><button class="blok__knop" type="button" aria-expanded="true" aria-controls="inhoud-<?php echo esc_attr( $sleutel ); ?>"><span><?php echo esc_html( $titel ); ?></span><svg class="icoon" aria-hidden="true"><use href="#i-chevron"/></svg></button></h3>
	<div class="blok__inhoud" id="inhoud-<?php echo esc_attr( $sleutel ); ?>"><div class="blok__binnen"><ul class="lijst">
		<?php if ( $eenheden->have_posts() ) : ?>
			<?php
			while ( $eenheden->have_posts() ) :
				$eenheden->the_post();
				?>
				<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
			<?php endwhile; ?>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<li><span class="lijst__leeg">Nog geen eenheden in deze categorie.</span></li>
		<?php endif; ?>
		<?php if ( $term && ! is_wp_error( $term ) ) : ?>
			<li><a href="<?php echo esc_url( get_category_link( $term ) ); ?>">Alle eenheden</a></li>
		<?php endif; ?>
	</ul></div></div>
	<div class="blok__strook" hidden><svg class="icoon" aria-hidden="true"><use href="#i-oog"/></svg><span><?php echo esc_html( $titel ); ?> is verborgen.</span><button class="knop knop--tekst" type="button" data-toon>Weer tonen</button></div>
</article>
