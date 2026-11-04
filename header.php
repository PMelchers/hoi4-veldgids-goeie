<?php

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<svg width="0" height="0" style="position:absolute" aria-hidden="true" focusable="false">
	<symbol id="i-zoeken" viewBox="0 0 24 24"><circle cx="11" cy="11" r="7"/><path d="M20 20l-4-4"/></symbol>
	<symbol id="i-chevron" viewBox="0 0 24 24"><path d="M6 15l6-6 6 6"/></symbol>
</svg>

<a class="sla-over" href="#inhoud">Naar de inhoud</a>

<div class="container">
	<header class="kop">
		<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>, naar de voorpagina"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a>
	</header>

	<nav class="menu" aria-label="Hoofdmenu">
		<?php
		wp_nav_menu(
			array(
				'theme_location' => 'hoofdmenu',
				'container'      => false,
				'items_wrap'     => '<ul class="raster">%3$s</ul>',
				'fallback_cb'    => 'hoi4_menu_standaard',
			)
		);
		?>
	</nav>
