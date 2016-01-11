<?php
/**
 * Template name: Стоимость
 */
include(locate_template('parts/html-header.php')); include(locate_template('parts/header.php')); ?>
<div class="central-col">
	<?php 
	if ( have_posts() ) while ( have_posts() ) : the_post();
		include(locate_template('parts/post.php'));
	endwhile; ?>

	<?php 
	include(locate_template('parts/section-pricing.php'));
	include(locate_template('parts/section-choice.php'));
	?>
	</article>
</div>
<?php include(locate_template('parts/footer.php')); include(locate_template('parts/html-footer.php')); ?>