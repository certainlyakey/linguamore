<article class="<?php 
	if (is_singular()) {
		echo " single-content";
	}
	if (custom_is_archive() || custom_is_newsarchive()) {
		echo " post-item";
	}
	?>">
	<?php 
	if (isset($isnewscompact)) {
		echo '<a href="'.get_permalink().'" rel="bookmark">';
	}
	 ?>
	<header>
		<?php if (custom_is_news()) {?>
			<time datetime="<?php the_time( 'Y-m-d' ); ?>">
			<?php if (isset($isnewscompact)) {
				the_time('d.m.Y'); 
			} else {
				the_time('d/m'); 
			}
			?>
			</time>
		<?php } ?>
		<h1>
		<?php 
			if (!isset($isnewscompact)) {
				echo '<a href="'.get_permalink().'" rel="bookmark">';
			} 
			echo get_the_title();
			if (!isset($isnewscompact)) {
				echo '</a>';
			} 
		?>
		</h1>
	</header>
	<div class="post-content">
		<?php 

		if (is_page_template('template-choice.php')) {
			// get all languages
			$langs_args = array('post_type' => 'language', 'numberposts' => -1 );
			$langs_query = new WP_Query( $langs_args );
			if ( $langs_query->have_posts() ) {
				echo '<ul class="lang_test_choice">';
				$isadvanced_q = 0;
				while ( $langs_query->have_posts() ) {
					$langs_query->the_post();
					$questions = get_post_meta(get_the_ID(),'test_questions',false);
					if ($questions) {
						$questions = reset($questions);
						foreach ($questions as $question) {
							if (array_key_exists('is_advanced', $question)) {
								$isadvanced_q++;
							}
						}
						echo '<li>';
						$lang_image_small = rwmb_meta('lmmb_languages_image_small', array('type' => 'image_advanced'));
						if ($lang_image_small) {
							$lang_image_small = reset($lang_image_small);
							$language_is_preselected = 'false';
							if (isset($_GET['test_language']) && $_GET['test_language'] == get_the_ID()) {
								$language_is_preselected = 'true';
							}
							echo '<figure><a class="post-image-intro-round" href="'.get_permalink().'" data-preselected="'.$language_is_preselected.'"><img class="wp-post-image" data-test-url="'.get_permalink(21).'" data-isadvanced-q="'.$isadvanced_q.'" title="Простая версия теста" src="'.$lang_image_small['full_url'].'" alt="'.$lang_image_small['title'].'">';
						}
						echo '<figcaption>'.get_the_title().'</figcaption></a></figure></li>';
					}
				}
				echo '</ul>';

				wp_reset_postdata();
			}
		}


		if (is_page_template('template-contacts.php')) {
			$map_code = get_post_meta($post->ID, 'lmmb_pages_contactmap_code', true);
			$map_pics = rwmb_meta('lmmb_languages_contact_map_photos', array('type'=>'image_advanced', 'size'=>'large'), $post->ID);

			echo '
			<div class="route">
				<div id="map">'.$map_code.'</div>';
			echo '</div>';
		}

		$lang_image_big = rwmb_meta('lmmb_languages_image_big',array('type' => 'image_advanced'));
		if (is_singular('language')) {
			echo '<div class="language_intro_image">';
		}
		if ($lang_image_big) {
			$lang_image_big = reset($lang_image_big);
			echo '<img class="wp-post-image post-image-intro" src="'.$lang_image_big['full_url'].'" alt="'.$lang_image_big['title'].'">';
		}
		if (has_post_thumbnail()) {
			if (custom_is_news()) {
				if (is_singular('post')) {
					echo get_the_post_thumbnail($post->ID,'large');
				} else {
					echo get_the_post_thumbnail($post->ID,'thumbnail');
				}
			}
			if (custom_is_teachers()) {
				echo get_the_post_thumbnail($post->ID,'medium');
			}
			if (is_page()) {
				echo get_the_post_thumbnail($post->ID,'full', array( 'class' => 'page-image-intro' ));
			}
		} else {
			if (isset($isnewscompact) || custom_is_news()) {
				$src = wp_get_attachment_image_src(147,'thumbnail');
				echo '<img src="'.$src[0].'" class="wp-post-image" alt="No muzak today">';
			}
		}

		if (custom_is_news()) {
			if (!has_excerpt() && !is_singular() && !isset($isnewscompact)) {
				echo '<div class="excerpt">'.content(18,$post->ID,false).'</div>'; 
			} else if (has_excerpt()) {
				echo '<div class="excerpt">';
				if (isset($isnewscompact)) {
					echo wp_trim_words(get_the_excerpt(),16);
				} else {
					echo get_the_excerpt();
				}
				echo '</div>';
			}
		}
		if (is_singular('language')) {
				echo '<div class="excerpt">'.get_the_excerpt().'</div>';
			echo '</div>';
		}
		if (is_singular()) {
			the_content();
		} else {
			$more_text = 'Читать далее';
			if (custom_is_teacher_archive()) {$more_text = 'Подробнее';}
			if (!isset($isnewscompact)) {
				echo '<a class="more-link" href="'.get_permalink($post->ID).'">'.$more_text.'</a>';
			}
		}
		
		if (is_singular('post')) { ?>
			<div class="fb-like floated" data-href="http://linguamore.ru" data-width="100" data-layout="standard" data-action="like" data-show-faces="true" data-share="true"></div>
			<div id="vk_like" class="inlined"></div>
			<script type="text/javascript">
			VK.Widgets.Like("vk_like", {type: "button"},<?=$post->ID?>);
			</script>
		<?php }

		if (is_page_template('template-contacts.php')) {

			if (is_active_sidebar('header_top')) {
					echo '<ul class="widget_contacts">';
						dynamic_sidebar('header_top');
					echo '</ul>';
			}

			wp_nav_menu( array( 'theme_location' => 'socialmenu', 'container_class' => 'socialmenu' ) ); 
			if ($map_pics) {
				echo "<div class='gallery'><ul>";
				foreach ( $map_pics as $image ) {
					echo "<figure><a href='{$image['full_url']}' title='{$image['title']}'><img src='{$image['url']}' alt='{$image['alt']}' /><figcaption>{$image['title']}</figcaption></a></figure>";
				}
				echo "</ul></div>";
			}
		}
		?>
	</div>
<?php 

	if (is_singular('language')) {
		include(locate_template('parts/language-feats.php'));
	}


//do not close article yet if custom page template is shown
if (!get_page_template_slug($post->ID)) {
	if (isset($isnewscompact)) {
		echo '</a>';
	}
	 ?>
	</article>
	
<?php }
if (is_singular('post')) {
	echo '<div class="pagination">';
	previous_post_link( '%link', 'Предыдущая новость' );
	next_post_link( '%link', 'Следующая новость' );
	echo '</div>';
}

 ?>