<?php
/**
 * The main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file 
 *
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php include(locate_template('parts/html-header.php')); include(locate_template('parts/header.php')); ?>

<div class="central-col">

	<?php if ( have_posts() ): ?>

		<h1 class="pagetitle">
			<?php 
			if (custom_is_teacher_archive()) {
				echo 'Команда преподавателей';
			} else {
				echo 'Новости школы';
			}
			?>
		</h1>

		<?php while ( have_posts() ) : the_post();
			if (custom_is_teacher_archive()) {
				p2p_type( 'teachers_to_languages' )->each_connected( $wp_query );
				include(locate_template('parts/post-teacher.php'));
			} else {
				include(locate_template('parts/post.php'));
			}
		endwhile; ?>

	<?php else: ?>

		<h1>Нечего показать, извините</h1>
	
	<?php endif; ?>

</div>

<?php include(locate_template('parts/footer.php')); include(locate_template('parts/html-footer.php')); ?>