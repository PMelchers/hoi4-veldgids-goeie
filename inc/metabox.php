<?php
/**
 * Een extra veld bij elk bericht: de rol van de eenheid in het spel, bijvoorbeeld Verdediging.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Maak het veld bekend bij WordPress, met schoonmaken van wat de bezoeker invult.
 */
function hoi4_registreer_rol_veld() {
	register_post_meta(
		'post',
		'rol',
		array(
			'type'              => 'string',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'sanitize_text_field',
			'auth_callback'     => function () {
				return current_user_can( 'edit_posts' );
			},
		)
	);
}
add_action( 'init', 'hoi4_registreer_rol_veld' );

/**
 * Het vak bij het bewerken van een bericht.
 */
function hoi4_voeg_metabox_toe() {
	add_meta_box( 'hoi4-rol', 'Rol in het spel', 'hoi4_toon_metabox', 'post', 'side', 'default' );
}
add_action( 'add_meta_boxes', 'hoi4_voeg_metabox_toe' );

/**
 * Toon het invoerveld.
 *
 * @param WP_Post $post Het bericht dat bewerkt wordt.
 */
function hoi4_toon_metabox( $post ) {
	wp_nonce_field( 'hoi4_rol_opslaan', 'hoi4_rol_nonce' );
	$waarde = get_post_meta( $post->ID, 'rol', true );
	?>
	<p>
		<label for="hoi4-rol-veld">Waar is deze eenheid goed in? Bijvoorbeeld Verdediging.</label>
		<input type="text" class="widefat" id="hoi4-rol-veld" name="hoi4_rol" value="<?php echo esc_attr( $waarde ); ?>">
	</p>
	<?php
}

/**
 * Sla het veld op als het bericht wordt opgeslagen.
 *
 * @param int $post_id Het bericht dat opgeslagen wordt.
 */
function hoi4_bewaar_rol_veld( $post_id ) {
	if ( ! isset( $_POST['hoi4_rol_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hoi4_rol_nonce'] ) ), 'hoi4_rol_opslaan' ) ) {
		return;
	}
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$rol = isset( $_POST['hoi4_rol'] ) ? sanitize_text_field( wp_unslash( $_POST['hoi4_rol'] ) ) : '';
	if ( $rol ) {
		update_post_meta( $post_id, 'rol', $rol );
	} else {
		delete_post_meta( $post_id, 'rol' );
	}
}
add_action( 'save_post', 'hoi4_bewaar_rol_veld' );
