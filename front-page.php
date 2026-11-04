<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="inhoud">
		<section class="zoeken" aria-labelledby="titel">
			<h1 id="titel">Commandant, welke eenheid zoekt u?</h1>
			<form class="raster" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<div class="kol-10">
					<label class="alleen-schermlezer" for="zoekveld">Zoek een eenheid</label>
					<input class="veld-invoer" id="zoekveld" name="s" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Zoek een eenheid, bijvoorbeeld slagschip" autocomplete="off" required>
				</div>
				<div class="kol-2">
					<button class="knop knop--primair" type="submit"><svg class="icoon" aria-hidden="true"><use href="#i-zoeken"/></svg><span>Zoeken</span></button>
				</div>
			</form>
		</section>

		<section class="sectie" aria-labelledby="favorieten-kop">
			<h2 id="favorieten-kop">Mijn divisies</h2>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'divisies',
					'container'      => false,
					'items_wrap'     => '<ul class="raster">%3$s</ul>',
					'walker'         => new Hoi4_Divisie_Walker(),
					'fallback_cb'    => 'hoi4_divisies_standaard',
				)
			);
			?>
		</section>

		<section class="sectie" aria-labelledby="ontdek-kop">
			<h2 id="ontdek-kop">Eenheden in het veld</h2>
			<div class="raster">
				<?php
				get_template_part(
					'template-parts/blok',
					null,
					array(
						'titel'     => 'Schepen',
						'categorie' => 'schepen',
					)
				);
				get_template_part(
					'template-parts/blok',
					null,
					array(
						'titel'     => 'Tanks',
						'categorie' => 'tanks',
					)
				);
				get_template_part(
					'template-parts/blok',
					null,
					array(
						'titel'     => 'Troepen',
						'categorie' => 'troepen',
					)
				);
				?>
			</div>
		</section>

		<?php
		$tip = new WP_Query(
			array(
				'posts_per_page'      => 1,
				'orderby'             => 'rand',
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
		?>
		<?php if ( $tip->have_posts() ) : ?>
			<?php $tip->the_post(); ?>
			<aside class="uitgelicht" aria-labelledby="tip-label">
				<p id="tip-label">Tip van de generaal</p>
				<a class="uitgelicht__kaart" href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong><span><?php echo esc_html( get_the_excerpt() ); ?></span></a>
			</aside>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>
	</main>

<?php
get_footer();
