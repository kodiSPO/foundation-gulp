<!doctype html>
<html class="no-js" lang="en" dir="ltr">

<head>

	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div class="main-wrapper">

		<div class="header">
			<div class="row">

				<div class="columns title-bar shrink">
					<div class="title-bar-title">
						<?php echo (is_front_page()) ? '' : '<a href="' . get_site_url() . '">'; ?>
							<img src="<?php //the_field('opt_primary_logo', 'option'); ?>" alt="<?php echo bloginfo('name'); ?>" height="50" class="primary-logo">
						<?php echo (is_front_page()) ? '' : '</a>'; ?>
					</div>

					<div data-responsive-toggle="responsive-menu" data-hide-for="large" class="menu-toggle">
						<button class="menu-icon" type="button" data-toggle="responsive-menu"></button>
					</div>
				</div>

				<div class="columns top-bar" id="responsive-menu">
					<?php
					wp_nav_menu(array(
						'container'      => false,
						'menu'           => __( 'Top Bar Menu', 'textdomain' ),
						'menu_class'     => 'menu',
						'theme_location' => 'main-nav',
						'items_wrap'     => '<ul id="%1$s" class="vertical large-horizontal menu" data-responsive-menu="drilldown large-dropdown" data-parent-link="true">%3$s</ul>',
						'walker'         => new Foundation_6_Walker(),
					));
					?>
				</div>

			</div>

		</div>

		<div class="header-placeholder"></div>





