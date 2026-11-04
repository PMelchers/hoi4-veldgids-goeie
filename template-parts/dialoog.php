<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<dialog class="dialoog" id="dialoog" aria-labelledby="dialoog-titel">
	<form id="favoriet-formulier" novalidate>
		<h2 id="dialoog-titel">Nieuwe divisie</h2>

		<div class="veld">
			<label for="fav-naam">Geef uw eigen divisie een naam</label>
			<input class="veld-invoer" id="fav-naam" name="naam" type="text" maxlength="30" autocomplete="off">
		</div>
		<div class="veld">
			<label for="fav-type">Soort divisie</label>
			<select class="veld-invoer" id="fav-type" name="type">
				<option value="">Kies een soort</option>
				<?php foreach ( get_categories() as $categorie ) : ?>
					<option value="<?php echo esc_url( get_category_link( $categorie ) ); ?>"><?php echo esc_html( $categorie->name ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>

		<p>Of voeg een bestaande eenheid toe:</p>
		<div class="veld">
			<label for="fav-eenheid">Eenheid</label>
			<select class="veld-invoer" id="fav-eenheid" name="eenheid">
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
		</div>

		<p class="veldfout" id="fav-fout" role="alert" hidden><svg class="icoon" aria-hidden="true"><use href="#i-info"/></svg><span></span></p>

		<div class="dialoog__knoppen">
			<button class="knop knop--tekst" type="button" id="annuleren">Annuleren</button>
			<button class="knop knop--primair" type="submit">Toevoegen</button>
		</div>
	</form>
</dialog>
