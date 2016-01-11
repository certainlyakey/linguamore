<header class="header">
	<div class="header_top">
		<ul class="widget-area">
		<?php if ( dynamic_sidebar('header_top') ) : else : endif; ?> 
		</ul>
	</div>
	<div class="header_middle">
		<?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'container_class' => 'mainmenu', 'container' => 'nav' ) ); ?>
		<h1 class="sitename"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<h2 class="sitedesc"><?php bloginfo( 'description' ); ?></h2>
	</div>
</header>
<div class="main">
	<div class="content-area">