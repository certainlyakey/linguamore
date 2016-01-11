<?php
/**
 * The Template for home  page
 *
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
//this allows to output a default post archive (?post_type=post) without need to use a separate custom template
$news_archive_displayed = false;
if (get_query_var('post_type') === 'post') {
	add_filter('body_class','add_bodyclass_newsarchive');
	include TEMPLATEPATH . '/index.php';
} else {

include(locate_template('parts/html-header.php')); include(locate_template('parts/header.php')); ?>

<div class="central-col">

	<?php 

	// get post by template
	echo '<article class="home_intro">';
		$homepages_args = array('post_type' => 'page', 'p' => 114 );
		$homepages_query = new WP_Query( $homepages_args );
		if ( $homepages_query->have_posts() ) {
			while ( $homepages_query->have_posts() ) {
				$homepages_query->the_post();
				the_content();
			}
			wp_reset_postdata();
		}
		// list 5 links pictured on intro image
		$introlangs_args = array('post_type' => 'language', 'post__in' => array(34,33,27,26,25) );
		$introlangs_query = new WP_Query( $introlangs_args );
		if ( $introlangs_query->have_posts() ) {
			echo '<section class="intro_links"><ul>';
			while ( $introlangs_query->have_posts() ) {
				$introlangs_query->the_post();
				echo '<li class="'.$post->post_name.'"><a href="'.get_permalink().'" title="'.get_the_title().'">'.get_the_title().'</a></li>';
			}
				echo '<li class="feats"><a href="'.get_permalink(16).'" title="'.get_the_title(16).'">'.get_the_title(16).'</a></li>';
				echo '<li class="test"><a href="'.get_permalink(131).'" title="'.get_the_title(131).'">'.get_the_title(131).'</a></li>';

			echo '</ul></section>';
			wp_reset_postdata();
		}
	echo '</article>';

	include(locate_template('parts/section-education.php'));

	
	$education_page_id = 118;
	$education_page = get_post($education_page_id);
	if ($education_page) {
		echo '<section class="education-process">';
			echo '<h1>'.$education_page->post_title.'</h1>';
			echo '<div class="content">';
				$education_page_content = $education_page->post_content;
				$education_page_content = apply_filters('the_content', $education_page_content);
				$education_page_content = str_replace(']]>', ']]&gt;', $education_page_content);
				echo $education_page_content;
			echo '</div>';

			$icons = rwmb_meta('lmmb_pages_settings_home_icons', array('type'=>'image_advanced'), $education_page_id);
			$icons = array_values($icons);
			if ($icons) {
				echo '<ul class="radial-icons">';
				foreach ($icons as $icon) {
					echo "<li class='icon'><figure><img src='{$icon['url']}' alt='{$icon['alt']}'><figcaption>{$icon['caption']}</figcaption></figure></li>";
				}
				echo '</ul>';
			}

		echo '</section>';
	}

	include(locate_template('parts/section-choice.php'));



	if ( have_posts() ) {
		echo '<section class="news-compact">';
		echo '<h1><a href="/?post_type=post">Наши новости</a></h1>';
		$isnewscompact = true;
		$custom_wp_query = true;
		echo '<ul>';
		while ( have_posts() ) : the_post();
			echo '<li>';
				include(locate_template('parts/post.php'));
			echo '</li>';
		endwhile; 


		echo '</ul>';
		echo '</section>';
	}


	?>

</div>

<?php include(locate_template('parts/footer.php')); include(locate_template('parts/html-footer.php'));

}
?>