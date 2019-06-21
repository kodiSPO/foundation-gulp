<?php get_header(); ?>

<?php if (have_posts()) : ?>
	<?php while (have_posts()) : the_post(); ?>

		<div class="row">
			<div class="columns">
				<h3>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
						<?php the_title(); ?>
					</a>
				</h3>
				<?php if (has_post_thumbnail()) : ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
						<?php the_post_thumbnail(); ?>
					</a>
				<?php endif; ?>
				<?php the_excerpt(); ?> 
			</div>
		</div>

	<?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>