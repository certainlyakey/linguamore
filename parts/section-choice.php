<section class="choice">
	<h1>C чего начать?</h1>
	<ul>
		<li class="zapis-link"><a href="<?php 
		if (is_singular('language')) {
			echo add_query_arg(array('test_language'=>$post->ID),get_permalink(21));
		} else {
			echo get_permalink(21);
		}
		?>">Записаться на бесплатное занятие</a></li>
		<li class="test-link"><a href="<?php 
		if (is_singular('language')) {
			echo add_query_arg(array('test_language'=>$post->ID),get_permalink(131));
		} else {
			echo get_permalink(131);
		}
		?>">Пройти тест на уровень языка</a></li>
	</ul>
</section>