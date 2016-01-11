<?php
/**
 * The Template for displaying all single posts (pages do not count)
 *
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
if (isset($_GET['testing'])) {
	add_filter('body_class','add_bodyclass_testing');
}
if (isset($_GET['result'])) {
	session_start();
	add_filter('body_class','add_bodyclass_testing_result');
}
include(locate_template('parts/html-header.php')); include(locate_template('parts/header.php'));
?>

<div class="central-col">

	<?php if ( have_posts() ) while ( have_posts() ) : the_post();
		if (isset($_GET['testing'])) {
			include(locate_template('parts/lang-testing.php'));
		} else if (is_singular('teacher')) {
			p2p_type( 'teachers_to_languages' )->each_connected( $wp_query );
			include(locate_template('parts/post-teacher.php'));
		} else {
			include(locate_template('parts/post.php'));
		}
	endwhile; ?>

</div>

<?php include(locate_template('parts/footer.php')); include(locate_template('parts/html-footer.php')); ?>