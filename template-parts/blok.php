<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$titel     = isset( $args['titel'] ) ? $args['titel'] : '';
$categorie = isset( $args['categorie'] ) ? $args['categorie'] : '';

$eenheden = new WP_Query(
	array(
		'category_name'       => $categorie,
		'posts_per_page'      => 4,
		'ignore_sticky_posts' => true,
		'no_found_rows'       => true,
	)
);
$term     = get_category_by_slug( $categorie );
?>
<details class="blok kol-4" open>
	<summary><h3><?php echo esc_html( $titel ); ?></h3><svg class="icoon" aria-hidden="true"><use href="#i-chevron"/></svg></summary>
	<ul class="lijst">
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
	</ul>
</details>
