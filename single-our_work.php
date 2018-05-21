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
				<div class="mp-menu-space">
					<div class="our-work-titlebar">
						<h1 class="mp-title mp-mobile-center"><?php echo get_the_title(); ?></h1>
						<h3 class="mp-mobile-center only-mobile">Services</h3>
						<p class="services mp-mobile-center"><?php echo get_field('services'); ?></p>
						<?php if(get_field('turn_on_gallery')){ ?>
							<?php echo do_shortcode('[case-study-gallery]'); ?>
						<?php } ?>
					</div>
				</div>


					


				
				<?php if(get_field('turn_on_section')){ ?>
					<div class="our-work-content">
						<?php the_content(); ?>
					</div>
				<?php } ?>




				<?php if(get_field('turn_on_bottom_banner')){
					echo '<section class="our-work-featured" style="background:#226C80 url('. get_field('bottom_banner') .') no-repeat center center;background-size:cover;"><div class="case-study-banner-overlay"></div></section>';
				} ?>





				<?php if(get_field('turn_on_testimonials')){ ?>
				<div class="our-work-testimonial">
						<h3 class="mp-mobile-center">Testimonials</h3>
                        <div class="flexslider">
                          <ul class="slides">
                                <?php      
                                if( have_rows('testimonials') ):
                                while ( have_rows('testimonials') ) : the_row();  
                                ?> 
                                    <li>
                                        <blockquote>
											<p>“<?php echo get_sub_field('testimonial'); ?>”</p>
											<p class="person"><?php echo get_sub_field('testimonial_name'); ?></p>
										</blockquote>
                                    </li>
                                <?php
                                    endwhile;
                                    endif;
                                ?>

                          </ul>
						</div>
						<script>
							// TESTIMONIAL - FLEX SLIDER SETTINGS
							jQuery( document ).ready(function() {
								jQuery(".our-work-testimonial .flexslider").flexslider({
									animation: Modernizr.touch ? "slide" : "fade",
									controlNav: false,
									directionNav: false
								});
							});
						</script>
                    </div>
                <?php } ?>







				<div class="our-work-social">
					<?php echo marble_social(); ?>
				</div>

				
				<?php if(get_field('turn_on_similar_projects')){ ?>
				<div class="our-work-similar-projects">
					<h3>Similar Projects</h3>
					<?php marble_similar_projects(); ?>
				</div>
			    <?php } ?>

			</div>

			
		</article>
	<?php endwhile; ?>
	<?php wp_reset_postdata(); ?>
</section>







<?php do_action( 'avada_after_content' ); ?>
<?php
get_footer();

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
