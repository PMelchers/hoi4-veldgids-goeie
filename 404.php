<?php

get_header();
?>

	<main id="inhoud" class="sectie">
		<article class="artikel">
			<h1>Dit gebied is niet in kaart gebracht</h1>
			<p>Op dit adres staat niets, commandant. Misschien is de pagina verplaatst of bestaat hij niet meer. Zoek hieronder verder of ga terug naar het hoofdkwartier.</p>

			<form class="zoek404" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
				<label class="alleen-schermlezer" for="zoek404">Zoek een eenheid</label>
				<input class="veld-invoer" id="zoek404" name="s" type="search" placeholder="Zoek een eenheid">
				<button class="knop knop--primair" type="submit">Zoeken</button>
			</form>

			<p><a class="knop" href="<?php echo esc_url( home_url( '/' ) ); ?>">Terug naar het hoofdkwartier</a></p>
		</article>
	</main>

<?php
get_footer();
