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
				<h3 class="mp-title">Our Thoughts</h3>
				<p>Have a look at what inspires us and what we are thinking about.</p>

				<?php
				$featured_img_url = get_the_post_thumbnail_url('full'); 
				echo '<img src="'.$featured_img_url.'" alt="" />';
				?>
				<?php the_content(); ?>
			</div>

			
		</article>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section>


<?php $post_pagination = get_post_meta( $post->ID, 'pyre_post_pagination', true ); ?>

<div class="mp-navigation">
	<?php // previous_post_link( '%link', esc_attr__( 'Previous', 'Avada' ) ); ?>
	<a href="/our-thoughts/">Back to Journal</a>
	<?php next_post_link( '%link', esc_attr__( 'Next Atticle', 'Avada' ) ); ?>
</div>




<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
