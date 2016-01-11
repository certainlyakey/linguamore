<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package 	WordPress
 * @subpackage 	Starkers
 * @since 		Starkers 4.0
 */
?>
<?php include(locate_template('parts/html-header.php')); include(locate_template('parts/header.php')); ?>

<a href="<?php echo home_url(); ?>">
<div class="central-col">
	<article class="single-content">
		<header>
			<h1>Page 404</h1>
		</header>
		<div class="post-content">
		
		</div>
	</article>
</div>
</a>

<?php include(locate_template('parts/html-footer.php')); include(locate_template('parts/footer.php')); ?>