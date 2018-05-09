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
				<div class="our-thoughts-titlebar">
					<h3 class="mp-title"><?php echo get_field('single_post_title','option'); ?></h3>
					<p class="intro"><?php echo get_field('single_post_subtitle','option'); ?></p>
				</div>

				<div class="our-thoughts-featured">
					<?php
					echo get_the_post_thumbnail( get_the_ID(), 'full' );
					?>
				</div>

				<div class="our-thoughts-date">
					<span class="entry-date"><?php echo get_the_date(); ?></span>
					<span class="fancy-date rotate">THOUGHTS <?php echo get_the_date(); ?></span>
				</div>

				<?php the_content(); ?>
			</div>

			
		</article>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section>


<?php $post_pagination = get_post_meta( $post->ID, 'pyre_post_pagination', true ); ?>

<div class="mp-navigation">
	<?php // previous_post_link( '%link', esc_attr__( 'Previous', 'Avada' ) ); ?>
	<a href="<?php echo get_field('back_link_url','option'); ?>"><?php echo get_field('back_link_text','option'); ?></a>
	<?php next_post_link( '%link', esc_attr__( 'Next Atticle', 'Avada' ) ); ?>
</div>

<?php echo do_shortcode('[mp-cta-journal]'); ?>




<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
