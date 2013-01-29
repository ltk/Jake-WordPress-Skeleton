<footer id="content-info" class="footer sticky-footer" role="contentinfo">
	<div class="container relative">

		<p class="contact-info"><?php echo esc_html(get_option('yds_site_options_1')); ?> &bull; <?php echo esc_html(get_option('yds_site_options_2')); ?> &bull; <?php echo esc_html(get_option('yds_site_options_3')); ?></p>
		
		<div class="footer-bottom pull-left">
			<?php
				if (has_nav_menu('footer_navigation')) :
					wp_nav_menu(array('theme_location' => 'footer_navigation', 'menu_class' => 'menu footer-menu horizontal-list uppercase pull-left'));
				endif;
			?>
			<p class="copyright pull-left">&copy; <?php echo date('Y'); ?> <?php echo esc_html(get_option('yds_site_options_4')); ?></p>
		</div>

		<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer Social Nav')) : 
			//Default if No Widgets -->
		endif; ?>

		<div class="watermark">
			<img src="/assets/img/watermark.gif" alt="">
		</div>

	</div>
</footer>
<?php wp_footer(); ?>
