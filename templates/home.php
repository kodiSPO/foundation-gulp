<?php
/* Template name: mayv2 Home */
get_header('mayv2');
?>


<div class="mayv2-home-hero">
	<div class="row align-middle">
		<div class="columns large-6 medium-12 small-12">
			<div class="mayv2-home-hero-text"><?php the_field('hero_text'); ?>
				<?php if ($hero_button_text = get_field('hero_button_text')) : ?>
					<a class="button" href="<?php the_field('hero_button_link'); ?>"><?php echo $hero_button_text; ?></a>
				<?php endif; ?>
			</div>
		</div>
		<div class="columns large-6 show-for-large">
			<?php if ($hero_img_src = get_field('hero_image')) : ?>
				<?php 
				$hero_img_url    = $hero_img_src['url'];
				$hero_img_width  = $hero_img_src['width'];
				$hero_img_height = $hero_img_src['height'];
				if (strpos($hero_img_url, '@2x') !== false) {
					$hero_img_width  = $hero_img_width / 2;
					$hero_img_height = $hero_img_height / 2;
				}
				?>
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=" 
					 data-src="<?php echo $hero_img_url; ?>" 
					 width="<?php echo $hero_img_width; ?>" 
					 height="<?php echo $hero_img_height; ?>" 
					 class="lazy lazy-hide-on-mobile">
			<?php endif; ?>
		</div>
	</div>
</div>


<?php 
/*
** vacancies headline
*/
if ($vac_headline = get_field('vac_headline')) : ?>
	<h2 class="section-title"><?php echo $vac_headline; ?></h2>
<?php endif; ?>


<?php 
/*
** vacancies
*/
$arg = array(
	'post_type'      => 'vacancies',
	'order'          => 'DESC',
	'posts_per_page' => 8,
	'meta_query' => array(
		array(
			'key'     => 'status',
			'value'   => 1,
			'compare' => '='
		)
	)
);

$the_query = new WP_Query( $arg );
if ( $the_query->have_posts() ) : ?>

	<div class="row mayv2-vacancy-list">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

			<?php echo get_template_part('parts/vacancy_loop_item'); ?>

		<?php endwhile; ?>

	</div>

<?php endif; wp_reset_query(); ?>


<?php 
/*
** more vacancies button
*/
if ($vac_button_text = get_field('vac_button_text')) : ?>
	<div class="row columns section-button">
		<a href="<?php the_field('vac_button_link'); ?>" class="button"><?php echo $vac_button_text; ?></a>
	</div>
<?php endif; ?>


<?php 
/*
** services image
*/
if ($services_img_src = get_field('services_image')) : ?>
	<?php 
	$services_img_url    = $services_img_src['url'];
	$services_img_width  = $services_img_src['width'];
	$services_img_height = $services_img_src['height'];
	if (strpos($services_img_url, '@2x') !== false) {
		$services_img_width  = $services_img_width / 2;
		$services_img_height = $services_img_height / 2;
	}
	?>
	<div class="row columns mayv2-home-services-img">
		<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=" 
			 data-src="<?php echo $services_img_url; ?>" 
			 width="<?php echo $services_img_width; ?>" 
			 height="<?php echo $services_img_height; ?>" 
			 class="lazy lazy-hide-on-mobile">
	</div>
<?php endif; ?>


<?php 
/*
** services columns
*/
if (have_rows('services_columns')) : ?>
	<div class="row mayv2-home-services">
		<?php while ( have_rows('services_columns') ) : the_row(); ?>

			<div class="columns large-4 medium-12 small-12">
				<?php if ($img_src = get_sub_field('image')) : ?>
					<?php 
					$img_url    = $img_src['url'];
					$img_width  = $img_src['width'];
					$img_height = $img_src['height'];
					if (strpos($img_url, '@2x') !== false) {
						$img_width  = $img_width / 2;
						$img_height = $img_height / 2;
					}
					?>
					<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=" 
						 data-src="<?php echo $img_url; ?>" 
						 width="<?php echo $img_width; ?>" 
						 height="<?php echo $img_height; ?>" 
						 class="lazy">
				<?php endif; ?>
				<p class="h3"><?php the_sub_field('headline'); ?></p>
				<div class="mayv2-home-services-divider"><span></span></div>
				<p><?php the_sub_field('text'); ?></p>
			</div>

		<?php endwhile; ?>
	</div>
<?php endif; ?>


<?php 
/*
** projects headline
*/
if ($projects_headline = get_field('projects_headline')) : ?>
	<h2 class="section-title"><?php echo $projects_headline; ?></h2>
<?php endif; ?>


<?php 
/*
** vacancies
*/
$arg = array(
	'post_type'      => 'projects_post_type',
	'order'          => 'DESC',
	'posts_per_page' => -1,
);

$the_query = new WP_Query( $arg );
if ( $the_query->have_posts() ) : ?>

	<?php 
	/*
	** save projects image to the variable
	*/
	$projects_image_src = get_field('projects_image');
	?>

	<div class="row mayv2-project-list">
		<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

			<div class="columns small-12 medium-6 large-4 mayv2-project-preview">
				<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">

					<div class="mayv2-project-preview-logo">
						<?php if ($project_logo_src = get_field('preview_logo')) : ?>
							<?php 
							$project_logo_url    = $project_logo_src['url'];
							$project_logo_width  = $project_logo_src['width'];
							$project_logo_height = $project_logo_src['height'];
							?>
							<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=" 
								 data-src="<?php echo $project_logo_url; ?>" 
								 width="<?php echo $project_logo_width; ?>" 
								 height="<?php echo $project_logo_height; ?>" 
								 class="lazy lazy-hide-on-mobile">
						<?php endif; ?>
					</div>

					<h3><?php the_title(); ?></h3>
					<p><?php the_field('preview_description'); ?></p>

					<span class="button-strip">Подробнее</span>

				</a>
			</div>

		<?php endwhile; ?>

		<?php 
		/*
		** image at the end
		*/
		if (($the_query->post_count + 1) % 3 == 0 && $projects_image_src) : ?>
			<div class="columns small-12 medium-6 large-4 mayv2-project-preview mayv2-project-preview-img">
				<?php 
				$projects_image_url    = $projects_image_src['url'];
				$projects_image_width  = $projects_image_src['width'];
				$projects_image_height = $projects_image_src['height'];
				if (strpos($projects_image_url, '@2x') !== false) {
					$projects_image_width  = $projects_image_width / 2;
					$projects_image_height = $projects_image_height / 2;
				}
				?>
				<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=" 
					 data-src="<?php echo $projects_image_url; ?>" 
					 width="<?php echo $projects_image_width; ?>" 
					 height="<?php echo $projects_image_height; ?>" 
					 class="lazy lazy-hide-on-mobile">
			</div>
		<?php endif; ?>

	</div>

<?php endif; wp_reset_query(); ?>


<?php 
/*
** locations headline
*/
if ($locations_headline = get_field('locations_headline')) : ?>
	<h2 class="section-title"><?php echo $locations_headline; ?></h2>
<?php endif; ?>


<?php 
/*
** locations
*/
if (have_rows('locations')) : ?>
	<div class="row mayv2-home-locations">
		<?php while ( have_rows('locations') ) : the_row(); ?>

			<div class="columns">
				<div class="mayv2-home-location-img">
					<?php if ($img_src = get_sub_field('image')) : ?>
						<?php 
						$img_url    = $img_src['url'];
						$img_width  = $img_src['width'];
						$img_height = $img_src['height'];
						?>
						<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=" 
							 data-src="<?php echo $img_url; ?>" 
							 width="<?php echo $img_width; ?>" 
							 height="<?php echo $img_height; ?>" 
							 class="lazy">
					<?php endif; ?>
				</div>
				<p><?php the_sub_field('text'); ?></p>
			</div>

		<?php endwhile; ?>
	</div>
<?php endif; ?>


<?php 
/*
** Events
*/
?>
<div class="mayv2-events-wrapper">

	<?php 
	/*
	** events headline
	*/
	if ($events_headline = get_field('events_headline')) : ?>
		<h2 class="section-title"><?php echo $events_headline; ?></h2>
	<?php endif; ?>

	<div class="mayv2-events row columns">

	</div>

	<?php 
	/*
	** more events button
	*/
	if ($events_button_text = get_field('events_button_text')) : ?>
		<div class="row columns section-button">
			<a href="<?php the_field('events_button_link'); ?>" class="button" <?php echo (get_field('events_new_tab')) ? 'target="_blank"' : ''; ?>><?php echo $events_button_text; ?></a>
		</div>
	<?php endif; ?>

</div>


<?php if (isset($_GET['dev']) && $_GET['dev'] == 1) : ?>

<?php 
/*
** Blog
*/
?>
<div class="mayv2-home-blog">

	<?php 
	/*
	** blog headline
	*/
	if ($blog_headline = get_field('blog_headline')) : ?>
		<h2 class="section-title"><?php echo $blog_headline; ?></h2>
	<?php endif; ?>

	<?php 
	/*
	** vacancies
	*/
	$arg = array(
		'post_type'      => 'post',
		'order'          => 'DESC',
		'posts_per_page' => 3,
	);

	$the_query = new WP_Query( $arg );
	if ( $the_query->have_posts() ) : ?>

		<div class="row posts">
			<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

				<?php echo get_template_part('parts/post_loop_item'); ?>

			<?php endwhile; ?>

		</div>

	<?php endif; wp_reset_query(); ?>

</div>

<?php endif;/*if (isset($_GET['dev']) && $_GET['dev'] == 1) */ ?>







<?php get_footer('mayv2'); ?>