<?php

$categorieen = get_categories( array( 'hide_empty' => true ) );
$tags        = get_tags( array( 'hide_empty' => true ) );
$auteurs     = get_users(
	array(
		'has_published_posts' => array( 'post' ),
		'orderby'             => 'display_name',
	)
);
?>
<nav class="filters" aria-label="Filter de eenheden">
	<div>
		<h2>Categorie</h2>
		<ul class="filters__lijst">
			<li><a class="chip" href="<?php echo esc_url( hoi4_alle_url() ); ?>"<?php echo is_home() ? ' aria-current="page"' : ''; ?>>Alles</a></li>
			<?php foreach ( $categorieen as $categorie ) : ?>
				<li><a class="chip" href="<?php echo esc_url( get_category_link( $categorie ) ); ?>"<?php echo is_category( $categorie->term_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $categorie->name ); ?></a></li>
			<?php endforeach; ?>
		</ul>
	</div>

	<?php if ( $tags ) : ?>
		<div>
			<h2>Tag</h2>
			<ul class="filters__lijst">
				<?php foreach ( $tags as $tag ) : ?>
					<li><a class="chip" href="<?php echo esc_url( get_tag_link( $tag ) ); ?>"<?php echo is_tag( $tag->term_id ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $tag->name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>

	<?php if ( count( $auteurs ) > 1 ) : ?>
		<div>
			<h2>Auteur</h2>
			<ul class="filters__lijst">
				<?php foreach ( $auteurs as $auteur ) : ?>
					<li><a class="chip" href="<?php echo esc_url( get_author_posts_url( $auteur->ID ) ); ?>"<?php echo is_author( $auteur->ID ) ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $auteur->display_name ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
</nav>
