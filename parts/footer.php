	</div> <!-- /content-area -->
</div> <!-- /main -->
<footer class="footer">
	<div class="footer_inner">
		<ul class="widget-area footer_mailings">
			<?php if ( dynamic_sidebar('footer_mailings') ) : else : endif; ?> 
		</ul>
		<h1 class="sitename"><a href="<?php echo home_url(); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<ul class="widget-area footer_contacts">
			<li class="contacts_link"><a href="<?php echo get_permalink(23); ?>"><span class="hidden">Контакты</span></a></li>
			<?php if ( dynamic_sidebar('footer_contacts') ) : else : endif; ?> 
		</ul>
		<?php wp_nav_menu( array( 'theme_location' => 'socialmenu', 'container_class' => 'socialmenu' ) ); ?>
		<a href="https://www.behance.net/acherepanova" class="designer">дизайн сайта — 
		Ася Черепанова</a>
	</div>
</footer>
