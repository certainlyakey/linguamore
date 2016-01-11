<!DOCTYPE HTML>
<!--[if IEMobile 7 ]><html class="no-js iem7" manifest="default.appcache?v=1"><![endif]--> 
<!--[if lt IE 7 ]><html class="no-js ie6" lang="ru"><![endif]--> 
<!--[if IE 7 ]><html class="no-js ie7" lang="ru"><![endif]--> 
<!--[if IE 8 ]><html class="no-js ie8" lang="ru"><![endif]--> 
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html class="no-js" lang="ru"><!--<![endif]-->
	<head>
		<title><?php bloginfo( 'name' ); ?><?php wp_title( '|' ); 
		if (isset($_GET['result'])) {
			echo " | Результаты тестирования";
		}
		 ?></title>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
	  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<meta name="viewport" content="width=1142">
		<?php 
		if (isset($_GET['result'])) {
			$test_results = show_test_results($post->ID);
			$user_level = $test_results['user_level'];
			$level_desc = $test_results['level_desc'];
			if (in_array($user_level,range(0, 5))) {
				echo '<meta property="og:image" content="http://linguamore.ru/wordpress/wp-content/uploads/';
				if ($user_level == 0 ) {
					echo '2015/06/share-beginner.jpg">';
				}
				if ($user_level == 1 ) {
					echo '2015/06/share-elementary.jpg">';
				}
				if ($user_level == 2 ) {
					echo '2015/06/share-preintermediate.jpg">';
				}
				if ($user_level == 3 ) {
					echo '2015/06/share-intermediate.jpg">';
				}
				if ($user_level == 4 ) {
					echo '2015/06/share-upperintermediate.jpg">';
				}
			}
			echo '<meta property="og:description" content="'.$level_desc.'" />';

		}
		?>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
		<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.png">
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/img/favicon.ico">
		<?php wp_head(); ?>
		<!-- for images in the facebook sharing dialog -->
		<link rel="canonical" href="<?php echo getCurrentUrl(); ?>">
		
		<?php if (is_singular('post')) { ?>
			<!-- Vkontakte like button -->
			<script type="text/javascript" src="//vk.com/js/api/openapi.js?116"></script>

			<script type="text/javascript">
				VK.init({apiId: 4985005, onlyWidgets: true});
			</script>
		<?php } ?>

	</head>
	<body <?php body_class(); ?>>

	<?php if (is_singular('post')) { ?>
		<!-- Facebook like button code -->
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.3&appId=687109921424158";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<?php } ?>