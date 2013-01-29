<?php
$login_link = is_user_logged_in() ? '<a href="' . wp_logout_url() . '" title="Logout">Logout</a>' : '<a href="/login" title="Login">Login</a>';
?>
<header id="banner" class="header" role="banner">
	<div class="container">
		<a class="brand primary-logo pull-left" href="<?php echo home_url(); ?>/">
			<?php bloginfo('name'); ?>
		</a>

		<div class="primary-navbar navbar pull-right cleared-right">
			<nav id="nav-main" class="nav-collapse" role="navigation">
				<?php
					if (has_nav_menu('primary_navigation')) :
						wp_nav_menu(array('theme_location' => 'primary_navigation', 'menu_class' => 'nav'));
					endif;
				?>
			</nav>
		</div>
	</div>
</header>