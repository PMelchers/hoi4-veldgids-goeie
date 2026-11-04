<?php
/**
 * Het venster waarmee de bezoeker een eenheid toevoegt aan Mijn divisies.
 * De keuzelijst bevat alle eenheden, gegroepeerd per categorie. app.js bewaart de keuze in de browser.
 *
 * @package hoi4-veldgids
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<dialog class="dialoog" id="dialoog" aria-labelledby="dialoog-titel">
	<form id="favoriet-formulier" novalidate>
		<h2 id="dialoog-titel">Nieuwe divisie</h2>
		<div class="veld">
			<label for="fav-eenheid">Welke eenheid wilt u toevoegen?</label>
			<select class="veld-invoer" id="fav-eenheid" name="eenheid" aria-describedby="fav-fout">
				<option value="">Kies een eenheid</option>
				<?php foreach ( get_categories() as $categorie ) : ?>
					<?php $eenheden = get_posts( array( 'category' => $categorie->term_id, 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ); ?>
					<?php if ( $eenheden ) : ?>
						<optgroup label="<?php echo esc_attr( $categorie->name ); ?>">
							<?php foreach ( $eenheden as $eenheid ) : ?>
								<option value="<?php echo esc_url( get_permalink( $eenheid ) ); ?>"><?php echo esc_html( get_the_title( $eenheid ) ); ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
			<p class="veldfout" id="fav-fout" hidden><svg class="icoon" aria-hidden="true"><use href="#i-info"/></svg><span></span></p>
		</div>
		<div class="dialoog__knoppen">
			<button class="knop knop--tekst" type="button" id="annuleren">Annuleren</button>
			<button class="knop knop--primair" type="submit">Toevoegen</button>
		</div>
	</form>
</dialog>
