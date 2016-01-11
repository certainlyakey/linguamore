<?php
/**
 * Template name: Преимущества
 */
include(locate_template('parts/html-header.php')); include(locate_template('parts/header.php')); ?>
<div class="central-col">
	<?php 
	if ( have_posts() ) while ( have_posts() ) : the_post();
		include(locate_template('parts/post.php'));
	endwhile; ?>

	<?php 
	// get specific subpage
	$educates_args = array( 'name' => 'how-we-educate', 'post_type' => 'page', 'numberposts' => 1 );
	$educates_query = new WP_Query( $educates_args );
	if ( $educates_query->have_posts() ) {
		while ( $educates_query->have_posts() ) {
			$educates_query->the_post(); ?>
			<section class="how-we-educate">
				<h1 class="pagetitle"><?=get_the_title();?></h1>
				<?php 
				echo '<div class="section-lead">';
					the_content(); 
				echo '</div>';

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
					echo '<ol class="modules_vertical">';
					while ( $modules_query->have_posts() ) {
						$modules_query->the_post();
						$module_vert_color = get_post_meta($post->ID, 'lmmb_pages_modules_color', true);
						echo '<li data-color="'.$module_vert_color.'">';
							echo '<h2>'.get_the_title();
								$months = get_post_meta($post->ID, 'lmmb_pages_modules_duration', true);
								if ($months) {echo ' ('.$months.' месяца)';}
							echo '</h2>';
							$module_image = rwmb_meta('lmmb_pages_modules_image', array('type'=>'file_advanced'), $post->ID);
							$module_image = reset($module_image);
							echo '<img class="symbol_small" src="'.$module_image['url'].'" alt="'.$module_image['title'].'">';
							echo '<div class="excerpt">'; 
								the_excerpt();
							echo '</div>';
						echo '</li>';
					}
					echo '<li class="final_item"><h2>Свободный разговорный язык и никаких языковых барьеров</h2></li>';
					echo '</ol>';

					echo '<ol class="modules_detailed">';
					while ( $modules_query->have_posts() ) {
						$modules_query->the_post();
						$module_det_color = get_post_meta($post->ID, 'lmmb_pages_modules_color', true);
						echo '<li data-color="'.$module_det_color.'">';
						$module_image = rwmb_meta('lmmb_pages_modules_image', array('type'=>'file_advanced'), $post->ID);
						$module_image = reset($module_image);
						echo '<img class="symbol_small" src="'.$module_image['url'].'" alt="'.$module_image['title'].'">';
						echo '<h2>'.get_the_title().'</h2>';
						echo '<div class="text" data-color="'.$module_det_color.'">';
						$exploded = explode("<!--more-->",$post->post_content);
						$posttext_beginning = apply_filters('the_content',$exploded[0]);
						$posttext_end = apply_filters('the_content',$exploded[1]);
						echo $posttext_beginning;
						if ($exploded) {
							echo '<a data-color="'.$module_det_color.'" class="more-link" href="'.get_permalink($post->ID).'">подробно: чему учим, какие будут результаты</a>';
						}
						echo $posttext_end;
						echo '</div></li>';
					}
					wp_reset_postdata();
				}
				?>

			</section>
			<?php
		}
		wp_reset_postdata();

		if (is_active_sidebar('homepage_education-feats')) {
			echo '<section class="education-feats">';
			global $wp_registered_sidebars;
			$sidebar_title = $wp_registered_sidebars['homepage_education-feats']['name'];
			echo '<h1>'.$sidebar_title.'</h1>';
			echo '<ul>';
				dynamic_sidebar('homepage_education-feats');
			echo '</ul></section>';
		}


	}
	?>
	</article>
</div>
<?php include(locate_template('parts/footer.php')); include(locate_template('parts/html-footer.php')); ?>