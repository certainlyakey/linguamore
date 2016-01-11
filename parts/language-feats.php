<?
$att_tax_term_id = 6;
// get attachments by tax
$attachments_args = array('post_type' => 'attachment', 'numberposts' => 6, 'post_status' => 'any', 'tax_query' => array(
		array(
			'taxonomy' => 'att_tax',
			'field'    => 'id',
			'terms'    => $att_tax_term_id
		)
	) );
$attachments_query = new WP_Query( $attachments_args );
if ( $attachments_query->have_posts() ) {
	echo '<ul class="feats-list">';
	while ( $attachments_query->have_posts() ) {
		$attachments_query->the_post();
		$url = wp_get_attachment_url($post->ID);
		echo '<li class="icon"><figure><img src="'.$url.'" alt="'.get_the_title().'"><figcaption>'.get_the_excerpt().'</figcaption></figure></li>';
	}
	echo '</ul>';
	wp_reset_postdata();
}

include(locate_template('parts/section-education.php'));

include(locate_template('parts/section-pricing.php'));

?>




<?php
$is_closed = get_post_meta($post->ID,'lmmb_languages_is_closed', true);
$start_month = get_post_meta($post->ID,'lmmb_languages_start_month',true);
$color_1 = get_post_meta($post->ID, 'lmmb_languages_color_1', true);
if ($is_closed) { ?>
	<section class="choice"> 
		<?php
		echo '<h1>Набор уже ';
		if ($start_month) {
			echo 'в '.$start_month;
		} else {
			echo 'скоро';
		}
		echo '</h1>';
		echo '<a class="button-big" data-color="'.$color_1.'" href="'.get_permalink(21).'">Оставить заявку</a>';
		?>
	</section>
<? } else {
	include(locate_template('parts/section-choice.php'));

}


// Find connected pages
$post_language = get_queried_object();
$connected = new WP_Query( array(
	'connected_type' => 'teachers_to_languages',
	'connected_items' => get_queried_object(),
	'nopaging' => true
) );

// Display connected pages
if ( $connected->have_posts() ) :
?>
<section class="related-teachers">
<h1>Преподаватели</h1>
<?php while ( $connected->have_posts() ) : $connected->the_post();
	include(locate_template('parts/post-teacher.php'));
endwhile; ?>
</ul>
</section>

<?php 
// Prevent weirdness
wp_reset_postdata();

endif;
?>

	