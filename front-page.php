<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="inhoud">
		<section class="zoeken" aria-labelledby="titel">
			<h1 id="titel">Commandant, welke eenheid zoekt u?</h1>
			<form id="zoekformulier" class="raster" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>" novalidate>
				<div class="kol-10">
					<label class="alleen-schermlezer" for="zoekveld">Zoek een eenheid</label>
					<input class="veld-invoer" id="zoekveld" name="s" type="search" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Zoek een eenheid, bijvoorbeeld slagschip" autocomplete="off" aria-describedby="zoek-fout">
					<p class="veldfout" id="zoek-fout" role="alert" hidden><svg class="icoon" aria-hidden="true"><use href="#i-info"/></svg><span>Typ eerst iets in, commandant, dan kan ik zoeken.</span></p>
				</div>
				<div class="kol-2">
					<button class="knop knop--primair" type="submit" id="zoekknop"><svg class="icoon" aria-hidden="true"><use href="#i-zoeken"/></svg><span>Zoeken</span></button>
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
					'menu_id'        => 'favorieten',
					'items_wrap'     => '<ul id="%1$s" class="raster">%3$s</ul>',
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
						'sleutel'   => 'schepen',
						'titel'     => 'Schepen',
						'categorie' => 'schepen',
					)
				);
				get_template_part(
					'template-parts/blok',
					null,
					array(
						'sleutel'   => 'tanks',
						'titel'     => 'Tanks',
						'categorie' => 'tanks',
					)
				);
				get_template_part(
					'template-parts/blok',
					null,
					array(
						'sleutel'   => 'troepen',
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
get_template_part( 'template-parts/dialoog' );
get_footer();
