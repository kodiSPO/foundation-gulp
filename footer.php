		<div class="footer">
			<div class="row">
				<div class="columns shrink footer-logo">
					<?php echo (is_front_page()) ? '' : '<a href="' . get_site_url() . '">'; ?>
						<!-- <img src="<?php //the_field('opt_primary_logo', 'option'); ?>" alt="<?php //echo bloginfo('name'); ?>" height="52"> -->
						<span class="logo" style="display: inline-block; padding: 12px; background-color: #eee; color: #000">LOGO</span>
					<?php echo (is_front_page()) ? '' : '</a>'; ?>
				</div>

				<div class="columns">
					<?php //if (have_rows('opt_socials', 'option')) : ?>
<!-- 						<ul class="socials"> -->
							<?php //while ( have_rows('opt_socials', 'option') ) : the_row(); ?>
<!-- 								<li> -->
<!-- 									<a href="<?php //the_sub_field('link'); ?>" target="_blank"> -->
										<?php //the_sub_field('icon'); ?>
<!-- 									</a> -->
<!-- 								</li> -->
							<?php //endwhile; ?>
<!-- 						</ul> -->
					<?php //endif; ?>
				</div>
			</div>
		</div>

	</div><!-- main-wrapper -->


<?php wp_footer(); ?>
</body>
</html>
