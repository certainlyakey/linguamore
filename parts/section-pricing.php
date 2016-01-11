<section class="pricing">
	<?php 
	$pricing_page_id = 109;
	$pricing_page = get_post($pricing_page_id);
	if ($pricing_page) {
		echo '<h1>'.$pricing_page->post_title.'</h1>';
			$price_monthly = get_post_meta($pricing_page_id, 'lmmb_pages_price', true);
			if ($price_monthly) {echo '<h2>Месяц занятий &mdash; '.$price_monthly.' рублей</h2>';}
			
			$price_infoboxes = rwmb_meta('lmmb_pages_price_info-box', array('type' => 'key_value' ), $pricing_page_id);
			if ($price_infoboxes) {
				echo "<ul class='infoboxes'>";
				$i = 0;
				foreach ( $price_infoboxes as $infobox ) {
					$i++;
					echo "<li>";
						echo '<figure>';
							if ($i == 1) {
								$lang_img_small = rwmb_meta('lmmb_languages_image_small', array('type'=>'image_advanced'), $post->ID);
								if ($lang_img_small) {
									$lang_img_small = reset($lang_img_small);
									echo '<img src="'.$lang_img_small['full_url'].'" alt="'.$lang_img_small['title'].'">';
								} else {
									echo '<img src="'.get_stylesheet_directory_uri().'/img/rocket.svg" alt="Linguamore">';
								}
							}
							if ($i == 2) {
								echo '<img src="'.get_template_directory_uri().'/img/coffee-pricing.svg" alt="две чашки кофе">';
							}
							if ($i == 3) {
								$color_1 = get_post_meta($post->ID, 'lmmb_languages_color_1', true);
								echo '<div class="price_illustration_savings" data-color="'.$color_1.'">';
									$savings = get_post_meta($pricing_page_id, 'lmmb_pages_economy', true);
									if ($savings) {echo '-'.$savings.'%';}
								echo "</div>";
							}
							echo '<figcaption>';
								echo '<h3>'.$infobox[0].'</h3>'.$infobox[1];
							echo '</figcaption>';
						echo '</figure>';
					echo "</li>";
				}
				echo "</ul>";
			}

		echo '<div class="content">';
			$price_half = get_post_meta($pricing_page_id, 'lmmb_pages_price_half', true);
			$price_1day = get_post_meta($pricing_page_id, 'lmmb_pages_price_1day', true);
			echo 'Можно разделить платеж на два по '.$price_half.' или оплачивать по одному занятию.<br>При оплате по одному занятию – '.$price_1day.' рублей.';
			$pricing_page_content = $pricing_page->post_content;
			$pricing_page_content = apply_filters('the_content', $pricing_page_content);
			$pricing_page_content = str_replace(']]>', ']]&gt;', $pricing_page_content);
			echo $pricing_page_content;
		echo '</div>';
	}
	 ?>
</section>