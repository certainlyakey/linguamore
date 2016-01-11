<?php 
// global $post_language;
if (!isset($post_language) || custom_is_teacher_archive()) {
	$post_language = $post->connected[0];
}
?>
<article id="<?php echo $post->post_name; ?>">
	<div class="photo">
		<?php 
		if (has_post_thumbnail()) {
			echo get_the_post_thumbnail(get_the_ID(),'medium');
		}
		// Starkers_Utilities::print_a($post_language);
		$call = get_post_meta($post_language->ID, 'lmmb_languages_calltoaction', true);
		$color_2 = get_post_meta($post_language->ID, 'lmmb_languages_color_2', true);
		if ($call) {
			echo '<a class="letsgo"';
			if ($color_2) {
				echo ' data-color="'.$color_2.'"';
			}
			echo  ' href="'.get_permalink(21).'">'.$call.' ('.$post_language->post_name.') / '.get_theme_mod('languages_letsgo_russian','Поехали!').'</a>';
		}
		?>
		
	</div>
	<div class="teacher-desc">
		<h1><a href="<?php echo get_post_type_archive_link('teacher').'#'.$post->post_name; ?>"><?php the_title(); ?></a></h1>
		<?php 
		if (has_excerpt()) {
			echo '<p>';
			the_excerpt();
			echo '</p>';
		}
		$teacher_education = get_post_meta($post->ID, 'lmmb_teachers_education', true);
		if ($teacher_education) {echo '<h2>Образование</h2>'.$teacher_education;}
		$teacher_bio = get_post_meta($post->ID, 'lmmb_teachers_bio', true);
		if ($teacher_bio) {
			if (is_singular('teacher')) {
				$teacher_bio = apply_filters('the_content',$teacher_bio);
				echo '<h2>О себе</h2>'.$teacher_bio;
			} else {
				$exploded = explode("<!--more-->",$teacher_bio);
				$teacher_bio_beginning = apply_filters('the_content',$exploded[0]);
				$teacher_bio_end = apply_filters('the_content',$exploded[1]);
				echo '<h2>О себе</h2>'.$teacher_bio_beginning;
				if ($exploded) {
					echo '<a class="more-link" href="'.get_post_type_archive_link('teacher').'#'.$post->post_name.'">Подробнее</a>';
				}
				if (custom_is_teacher_archive()) {
					echo $teacher_bio_end;
				}
			}
		}
		?>
	</div>
</article>