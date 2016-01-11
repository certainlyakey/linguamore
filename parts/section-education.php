<section class="about_education">
	<?php 
	$education_page_id = 86;
	$education_page = get_post($education_page_id);
	if ($education_page) {
		echo '<h1>'.$education_page->post_title.'</h1>';
		echo '<div class="content">'.$education_page->post_excerpt.'</div>';
		echo '<a href="'.get_permalink(16).'" class="more-link-big">Подробнее об обучении</a>';
	}

	// get all modules pages
	$modules_args = array(
		'post_type' => 'page', 
		'post_parent' => 86, 
		'numberposts' => -1,
		'orderby'   => 'meta_value_num',
		'order'   => 'ASC',
		'meta_key'  => 'lmmb_pages_modules_number'
		);
	$modules_query = new WP_Query( $modules_args );
	if ( $modules_query->have_posts() ) {
		echo '<ol class="modules_horizontal">';
		while ( $modules_query->have_posts() ) {
			$modules_query->the_post();
			$module_color = get_post_meta($post->ID, 'lmmb_pages_modules_color', true);
			echo '<li data-color="'.$module_color.'"><h2>'.get_the_title();
			$module_duration = get_post_meta($post->ID, 'lmmb_pages_modules_duration', true);
			if ($module_duration) {echo '<br>'.$module_duration.' месяца';}
			echo '</h2>';
			the_excerpt();
			echo '</li>';
		}
		echo '</ol>';
		wp_reset_postdata();
	}
	?>
</section>
