<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
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
	<symbol id="i-plus" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></symbol>
	<symbol id="i-info" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 11v5M12 8h.01"/></symbol>
	<symbol id="i-vinkje" viewBox="0 0 24 24"><path d="M5 12l5 5 9-10"/></symbol>
	<symbol id="i-oog" viewBox="0 0 24 24"><path d="M3 12s3.5-6 9-6 9 6 9 6-3.5 6-9 6-9-6-9-6z"/><circle cx="12" cy="12" r="2.5"/></symbol>
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
