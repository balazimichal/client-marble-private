<?php
/**
 * Template used for single posts and other post-types
 * that don't have a specific template.
 *
 * @package Avada
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}
?>
<?php get_header(); ?>

<section id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>


	<?php while ( have_posts() ) : ?>
		<?php the_post(); ?>
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>

			
			<div class="post-content">
				<div class="our-work-titlebar mp-menu-space">
					<h1 class="mp-title"><?php echo get_the_title(); ?></h1>
					<p class="services"><?php echo get_field('services'); ?></p>
				</div>

				<div class="our-work-gallery mp-menu-space">
				</div>

				
				<div class="our-work-content">
					<?php the_content(); ?>
				</div>

				<div class="our-work-featured">
					<?php echo get_the_post_thumbnail( get_the_ID(), 'full' ); ?>
				</div>

				<div class="our-work-testimonial">
					<h3>Testimonials</h3>
					<blockquote>
						<p><?php echo get_field('testimonial'); ?></p>
						<p class="person"><?php echo get_field('testimonial_person'); ?></p>
					</blockquote>
				</div>

				<div class="our-work-social">
					<?php echo marble_social(); ?>
				</div>

				<div class="our-work-similar-projects">
					<h3>Similar Projects</h3>
					<div class="our-work-similar-project-list">
					</div>
				</div>

			</div>

			
		</article>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section>







<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
