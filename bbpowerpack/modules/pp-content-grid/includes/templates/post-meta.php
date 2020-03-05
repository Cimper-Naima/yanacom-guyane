<?php
$remove_child = false;
if ( $remove_child ) : // use this code to display only parent terms. ?>
<div class="pp-content-category-list pp-post-meta">
    <?php $terms_html = array();
	foreach ( $terms_list as $term ) :
		if ( isset( $term->parent ) && $term->parent > 0 ) {
			continue;
		}
		$terms_html[] = '<a href="' . get_term_link( $term ) . '" class="pp-post-meta-term term-' . $term->slug . '">' . $term->name . '</a>';
	endforeach;
    ?>
    <?php echo implode( ' / ', $terms_html ); ?>
</div>
<?php endif; ?>

<div class="pp-content-category-list pp-post-meta">
    <?php $i = 1;
	foreach ( $terms_list as $term ) :
		$class = ( isset( $term->parent ) && $term->parent > 0 ) ? ' child-term' : ' parent-term';
		?>
		<a href="<?php echo get_term_link( $term ); ?>" class="pp-post-meta-term term-<?php echo $term->slug; ?><?php echo $class; ?>"><?php echo $term->name; ?></a>
		<?php if ( $i != count( $terms_list ) ) { ?>
			<span class="pp-post-meta-separator"> / </span>
		<?php } ?>
    <?php $i++; endforeach; ?>
</div>
