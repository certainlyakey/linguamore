<article class="single-content">
	<header>
		<h1 class="pagetitle"><a href="<?php esc_url( the_permalink() ); ?>" rel="bookmark">
		<?php 
		if (isset($_GET['result'])) {
			echo 'Мой результат — ';
			echo mb_strtolower(get_the_title()); 
		} else {
			echo 'Тест: ';
			the_title(); 
		}
		?>
		</a></h1>
	</header>
	<div class="post-content">
		<?php 

		if (isset($_GET['result'])) {
			// show_test_results() function call made in header already
			echo $test_results['test_results'];
		} else {
			echo show_test_form($post->ID);
		}
		?>
	</div>
</article>