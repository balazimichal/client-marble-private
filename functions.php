<?php


/********** THEME VARIABLES *************/

$THEME_GLOBALS['theme_name'] = 'Marble Private';  // set up theme name

/****************************************/





// ENQUEUE AVADA STYLES
function theme_enqueue_styles() {
    wp_enqueue_style( 'avada-parent-stylesheet', get_template_directory_uri() . '/custom-styles.css' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function avada_lang_setup() {
	$lang = get_stylesheet_directory() . '/languages';
	load_child_theme_textdomain( 'Avada', $lang );
}
add_action( 'after_setup_theme', 'avada_lang_setup' );




// ENQUEUE CUSTOM SCRIPT
function toggle_scripts() {
    wp_enqueue_script( 'custom-script', get_stylesheet_directory_uri() . '/js/custom-scripts.js', array( 'jquery' )  );
}
add_action( 'wp_enqueue_scripts', 'toggle_scripts' );



// ENQUEUE TITLEBAR STYLES
function custom_css() {
	wp_enqueue_style('custom-style', get_stylesheet_directory_uri() . '/css/custom-script.css');
		$r = 0;
		$g = 0;
		$b = 0;
		$a = 0;
        $custom_css = "
                .sdfair-titlebar-overlay{
                        background: rgba($r,$g,$b,$a);
                }";
        wp_add_inline_style( 'custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'custom_css' );






// REMOVE POST AND PORTFOLIO FROM AVADA INSTALL
function belton_remove_menus(){
  remove_menu_page( 'edit.php' );                               //Posts
  remove_menu_page( 'edit.php?post_type=avada_portfolio' );     //Portfolio
  remove_menu_page( 'edit.php?post_type=avada_faq' );           //FAQs
  remove_menu_page( 'edit.php?post_type=essential_grid' );      //Essential Grid Posts
}
add_action( 'admin_menu', 'belton_remove_menus' );






// AUTO YEAR
function auto_year() { return date("Y"); }
add_shortcode('auto-year', 'auto_year');




// MARBLE CTA JOURNAL
function mp_cta_journal() { 

	$mp_cta_journal = null;
	$mp_cta_journal .= '<div class="mp-cta-journal">';
	$mp_cta_journal .= '<h3>' . get_field('cta_title','option') . '</h3>';
	$mp_cta_journal .= '<p><a href="' . get_field('cta_url','option') . '" target="_blank">' . get_field('cta_link_text','option') . '</a></p>';
	$mp_cta_journal .= '</div>';
	$mp_cta_journal .= '<style>
	.mp-cta-journal{text-align:center;border-top:1px solid #ddd;padding:100px 0 50px;}
	.mp-cta-journal h3{font-size:62px;line-height:70px;font-family:"spectral-light";margin-bottom:70px;font-weight:normal;padding:0 30px;}
	.mp-cta-journal a{text-decoration:underline;}
	@media (max-width: 800px) {
		.mp-cta-journal h3{font-size:32px;line-height:42px;}
	}
	</style>';

	return $mp_cta_journal; 
}
add_shortcode('mp-cta-journal', 'mp_cta_journal');













// MARBLE SOCIAL
function marble_social() { 
	$marble_social = null;
	$marble_social =  do_shortcode('[fusion_social_links icons_boxed="" icons_boxed_radius="" color_type="" icon_colors="" box_colors="" tooltip_placement="" blogger="" deviantart="" digg="" dribbble="" dropbox="" facebook="https://www.facebook.com/MarbleLDN/?ref=br_rs&hc_ref=ARTGEN5r2OzEiuxRd5Z_5VeP3idDX4DlHAmzdxGoZuM_U9kWsSn3EtaAfEpcxYAvTbk" flickr="" forrst="" googleplus="" instagram="https://www.instagram.com/marble_ldn/" linkedin="https://www.linkedin.com/company/11149903/" myspace="" paypal="" pinterest="" reddit="" rss="" skype="" soundcloud="" spotify="" tumblr="" twitter="" vimeo="" vk="" xing="" yahoo="" yelp="" youtube="https://www.youtube.com/channel/UCjzzZNhepFtiZl3b4fa0SjQ" email="" show_custom="no" alignment="" hide_on_mobile="small-visibility,medium-visibility,large-visibility" class="" id="" /]'); 
	return $marble_social;
}
add_shortcode('marble-social', 'marble_social');


// REGISTER THE GRID SKIN - MARBLE THOUGHTS + MARBLE OUR WORK
add_filter('tg_register_item_skin', function($skins) {

    // just push your skin slugs (file name) inside the registered skin array
    $skins = array_merge($skins,
        array(
            'marble-work' => array(
                'filter'   => 'Marble filters', // filter name used in slider skin preview
                'name'     => 'Marble Case Studies', // Skin name used in skin preview label
                'col'      => 1, // col number in preview skin mode
                'row'      => 1  // row number in preview skin mode
            ),
            'marble-thoughts' => array(
                'filter'   => 'Marble filters', // filter name used in slider skin preview
                'name'     => 'Marble Thoughts', // Skin name used in skin preview label
                'col'      => 1, // col number in preview skin mode
                'row'      => 1  // row number in preview skin mode
            )
        )
    );

    // return all skins + the new one we added (my-skin1)
    return $skins;

});





// ADD SUPPORT FOR THEME THUMBNAIL
add_theme_support( 'post-thumbnails' );
add_image_size( 'thumb-grid', 640, 640, true );
add_image_size( 'rectangle-grid', 1280, 640, true );
add_image_size( 'our-thought', 1200, 800, true );
add_image_size( 'mp-rectangle', 800, 600, true );




// ADD OPTIONS PAGES (ACF PLUGIN MUST BE INSTALLED)
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> $THEME_GLOBALS['theme_name'].' Settings',
		'menu_title'	=> $THEME_GLOBALS['theme_name'].' Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));

    acf_add_options_sub_page(array(
		'page_title' 	=> $THEME_GLOBALS['theme_name'].' Services',
		'menu_title'	=> $THEME_GLOBALS['theme_name'].' Services',
		'parent_slug'	=> 'theme-general-settings',
	));

    acf_add_options_sub_page(array(
		'page_title' 	=> $THEME_GLOBALS['theme_name'].' Music',
		'menu_title'	=> $THEME_GLOBALS['theme_name'].' Music',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> $THEME_GLOBALS['theme_name'].' Team',
		'menu_title'	=> $THEME_GLOBALS['theme_name'].' Team',
		'parent_slug'	=> 'theme-general-settings',
	));
	
	acf_add_options_sub_page(array(
		'page_title' 	=> $THEME_GLOBALS['theme_name'].' Collective',
		'menu_title'	=> $THEME_GLOBALS['theme_name'].' Collective',
		'parent_slug'	=> 'theme-general-settings',
	));
	
}





// MARBLE MUSIC
function marble_music() {
    $marble_music = null;
    $i = 0;
    if( have_rows('music', 'option') ):
        $marble_music .= '<div class="marble-services">';
        while ( have_rows('music', 'option') ) : the_row();
            $i++;
            $service_image = get_sub_field('service_image');
            $image_size = 'thumb-grid';
            $image_url = $service_image['sizes'][$image_size];
            $marble_music .= '<div class="marble-service box'.$i.'">';
            $marble_music .= '<div class="marble-service-image marble-grid-item" style="background: #226C80 url('.$image_url.') no-repeat center center;background-size:cover">';
            $marble_music .= '<div class="marble-service-overlay">';
            $marble_music .= '<div class="marble-service-content">';
            $marble_music .= '<h3>'.get_sub_field('service_title').'</h3>';
            $marble_music .= '<p>'.get_sub_field('service_excerpt').'</p>';
            $marble_music .= '<a href="" class="marble-button">READ MORE</a>';
            $marble_music .= '</div>';
            $marble_music .= '</div>';
            $marble_music .= '<div class="marble-service-main-content" id="box'.$i.'" next-title="'.get_sub_field('service_title').'">';
            $marble_music .= '<div class="marble-service-main-content-left">';
            $marble_music .= '<h3>'.get_sub_field('service_title').'</h3>';
            $marble_music .= get_sub_field('service_description');
            if(get_sub_field('service_work_link')){
            $marble_music .= '<div><a href="'.get_sub_field('service_work_link').'" class="marble-button">'.get_sub_field('service_work_link_title').'</a></div>';
            }
            $marble_music .= '</div>';
            $marble_music .= '<div class="marble-service-main-content-right">';
            $marble_music .= '<div class="marble-service-main-content-close">Close</div>';
            $marble_music .= '<div class="marble-service-main-content-next">Next</div>';
            $marble_music .= '<div class="marble-service-main-content-next-title">Music</div>';
            if(get_sub_field('service_hire_link')){
            $marble_music .= '<div class="button-hire"><a href="'.get_sub_field('service_hire_link').'" class="marble-button">'.get_sub_field('service_hire_link_title').'</a></div>';
            }
            $marble_music .= '</div>';
            $marble_music .= '</div>';
            $marble_music .= '</div>';
            $marble_music .= '</div>';
            $marble_music .= '<div class="marble-service-content-hook box'.$i.'">';
            $marble_music .= '</div>';
        endwhile;
		$marble_music .= '</div>';



    endif;
    return $marble_music;
}
add_shortcode('marble-music', 'marble_music');





// MARBLE SERVICES
function marble_services() {
    $marble_services = null;
    $i = 0;
    if( have_rows('services', 'option') ):
        $marble_services .= '<div class="marble-services">';
        while ( have_rows('services', 'option') ) : the_row();
            $i++;
            $service_image = get_sub_field('service_image');
            $image_size = 'thumb-grid';
            $image_url = $service_image['sizes'][$image_size];
            $marble_services .= '<div class="marble-service box'.$i.'">';
            $marble_services .= '<div class="marble-service-image marble-grid-item" style="background: #226C80 url('.$image_url.') no-repeat center center;background-size:cover">';
            $marble_services .= '<div class="marble-service-overlay">';
            $marble_services .= '<div class="marble-service-content">';
            $marble_services .= '<h3>'.get_sub_field('service_title').'</h3>';
            $marble_services .= '<p>'.get_sub_field('service_excerpt').'</p>';
            $marble_services .= '<a href="" class="marble-button">'.get_sub_field('expand_button_title').'</a>';
            $marble_services .= '</div>';
            $marble_services .= '</div>';
            $marble_services .= '<div class="marble-service-main-content" id="box'.$i.'" next-title="'.get_sub_field('service_title').'">';
            $marble_services .= '<div class="marble-service-main-content-left">';
            $marble_services .= '<h3>'.get_sub_field('service_title').'</h3>';
            $marble_services .= get_sub_field('service_description');
            if(get_sub_field('service_work_link')){
            $marble_services .= '<div><a href="'.get_sub_field('service_work_link').'" class="marble-button">'.get_sub_field('service_work_link_title').'</a></div>';
            }
            $marble_services .= '</div>';
            $marble_services .= '<div class="marble-service-main-content-right">';
            $marble_services .= '<div class="marble-service-main-content-close">Close</div>';
            $marble_services .= '<div class="marble-service-main-content-next">Next</div>';
            $marble_services .= '<div class="marble-service-main-content-next-title">Music</div>';
            if(get_sub_field('service_hire_link')){
            $marble_services .= '<div class="button-hire"><a href="'.get_sub_field('service_hire_link').'" class="marble-button">'.get_sub_field('service_hire_link_title').'</a></div>';
            }
            $marble_services .= '</div>';
            $marble_services .= '</div>';
            $marble_services .= '</div>';
            $marble_services .= '</div>';
            $marble_services .= '<div class="marble-service-content-hook box'.$i.'">';
            $marble_services .= '</div>';
        endwhile;
        $marble_services .= '</div>';
    endif;
    return $marble_services;
}
add_shortcode('marble-services', 'marble_services');







// MARBLE TEAM
function marble_team() {

	$marble_team = null;
	if( class_exists('acf') ) {
    $x = 0;
    $count = count( get_field('team', 'option'));
    $center_last_box = false;
    if($count % 3 == 1) {$center_last_box = true;}
    if( have_rows('team', 'option') ):
        $marble_team .= '<div class="marble-team">';
        while ( have_rows('team', 'option') ) : the_row();
            $x++;
            $member_image = get_sub_field('team_member_image');
            $image_size = 'thumb-grid';
            $image_url = $member_image['sizes'][$image_size];
            $member_headshot = get_sub_field('team_member_headshot');
            $image_size = 'thumb-grid';
            $headshot_url = $member_headshot['sizes'][$image_size];
            if($center_last_box && $count == $x){
                $marble_team .= '<div class="marble-team-member empty-block">';
                $marble_team .= 'x';
                $marble_team .= '</div>';
            }
            $marble_team .= '<div class="marble-team-member">';
            $marble_team .= '<div class="marble-team-headshot marble-grid-item" style="background: #f8f8f8;background-image:url(\''.$headshot_url.'\');background-repat:no-repeat;background-position:center top;background-size:cover" url="'.$headshot_url.'">';
            $marble_team .= '<div class="marble-team-image marble-grid-item" style="background: #f8f8f8 url('.$image_url.') no-repeat center center;background-size:cover">';
            $marble_team .= '<div class="hidden-content marble-grid-item">';
            $marble_team .= '<div class="hidden-content-wrap">';
            $marble_team .= get_sub_field('team_member_bio');
            $marble_team .= '</div>';
            $marble_team .= '</div>';
            $marble_team .= '</div>';
            $marble_team .= '</div>';
            $marble_team .= '<div class="marble-team-title">';
            $marble_team .= '<h3>'.get_sub_field('team_member_name').'</h3>';
            $marble_team .= '<span class="marble-team-role">'.get_sub_field('team_member_role').'</span>';
            $marble_team .= '</div>';
            $marble_team .= '</div>';
        endwhile;
        $marble_team .= '</div>';
	endif;
	}


	$marble_team .= '<style>
		.marble-team{position:relative;margin-left:-3.33%}
		.marble-team-member{width:30%;float:left;overflow:hidden !important;margin-left:3.33%;}
		.marble-team-member.empty-block{display:block;color:#fff !important;}
		.marble-team-member h3{font-size:30px;line-height:46px;text-transform:uppercase;text-align:center;margin-bottom:10px;}
		.marble-team-headshot{overflow:hidden;background:rgba(216,216,216,0.16);min-height:320px;width:100%;display:block;position:relative;}
		.marble-team-image{opacity:1;min-height:320px;width:100%;display:block;  -webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;-o-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;}
		.marble-team-member:hover .marble-team-image{background:transparent !important;}
		.marble-team-title{padding-top:40px;padding-bottom:70px;}
		.marble-team-role{text-align:center;font-size:16px;display:block;color:#767676;}
		.hidden-content{background:transparent;position:absolute;top:0;left:0;height:100%;width:100%;opacity:0;  -webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;-o-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;}
		.marble-team-member:hover .hidden-content{opacity:1;}
		.hidden-content-wrap{background:rgba(0,0,0,0.7);width:105%;height:200%;display:block;overflow:scroll;padding:40px;}
		.marble-team-member .hidden-content h3{color:#F47E76;text-align:left !important;text-transform:none;font-size:36px;margin-bottom:30px;}
		.marble-team-member .hidden-content p{margin-bottom:20px;color:#fff;}
		.marble-team-member .hidden-content ul{margin:0;padding:0 30px;}
		.marble-team-member .hidden-content ul li{color:#fff !important;margin-bottom:10px;}

		.team-member-mobile-wrap{background:rgba(0,0,0,0.9);padding:30px;position:absolute;left:0;display:none;color:#fff;width:100%;}
		.team-member-mobile-wrap h3{color:#F47E76;margin-bottom:20px;}
		.team-member-mobile-wrap img{margin-bottom:30px;}
		.member-close-button{display:block;width:60px;height:30px;position:absolute;top:46px;right:30px;cursor:pointer;font-size:14px;letter-spacing:1px;}


		@media only screen and (max-width: 1600px) {
			.marble-team-member .hidden-content h3{margin-bottom:20px;}
			.marble-team-member .hidden-content p{font-size:17px;}
			.marble-team-member .hidden-content li{font-size:17px;}
		}

		@media only screen and (max-width: 1200px) {
			.marble-team{margin-left:-5%}
			.marble-team-member{width:45%;float:left;margin-left:5%}
			.hidden-content-wrap{padding:30px;}
			.marble-team-member.empty-block{width:25% !important;}
		}

		@media only screen and (max-width: 800px) {
			.marble-team-title{padding:10px 10px 30px;overflow:hidden;height:140px;}
			.hidden-content-wrap{display:none;}
			#main .post-content .marble-team-title h3{font-size:22px;margin:0;}
			#main .post-content .marble-team-role{font-size:16px;line-height:18px;}
			.marble-team-headshot{min-height:auto;}
		}

		@media only screen and (max-width: 600px) {
			.marble-team{margin-left:0%}
			.marble-team-member{width:100%;float:left;margin-left:0%}
			.marble-team-title{padding:10px;}
			.hidden-content-wrap{padding:40px;}
		}

		@media only screen and (max-width: 400px) {
			.hidden-content-wrap{padding:30px;}
		}

	</style>';



	$marble_team .= '<script>
	jQuery(function() {
		jQuery( ".marble-team" ).append( \'<div class="team-member-mobile-wrap"></div>\' );
		jQuery( ".marble-team-member" ).click(function(e) {
			if (jQuery("body").width() < 800 ){
				e.preventDefault();
				var memberImage = jQuery( this ).find(".marble-team-headshot").attr("url");
				//var memberImage = bg.replace("url(","").replace(")","").replace(/\"/gi, "");
				var memberDesc = jQuery( this ).find(".hidden-content-wrap ul").html();
				var memberTitle = jQuery(this).find(".marble-team-title h3").html();
				var relativeY =  jQuery(this).offset().top - jQuery(".marble-team").offset().top;
				console.log(relativeY);
				jQuery( ".team-member-mobile-wrap" ).css("top", relativeY);

				var tempContent = \'<h3>\' + memberTitle + \'</h3><img src="\' + memberImage + \'" alt="" /><ul>\' + memberDesc + \'</ul><div class="member-close-button">CLOSE</div>\';

				jQuery(".team-member-mobile-wrap").html(tempContent).fadeIn();
				jQuery( ".member-close-button" ).click(function(e) {
					jQuery(".team-member-mobile-wrap").fadeOut();
				});

			}
		});
	});
	</script>';


    return $marble_team;
}
add_shortcode('marble-team', 'marble_team');








// MARBLE COLLECTIVE
function marble_collective() {
    $marble_collective = null;
    $x = 0;
    $count = count( get_field('collective', 'option'));
    $center_last_box = false;
    if($count % 3 == 1) {$center_last_box = true;}
    if( have_rows('collective', 'option') ):
        $marble_collective .= '<div class="marble-collective">';
        while ( have_rows('collective', 'option') ) : the_row();
            $x++;
            $member_image = get_sub_field('member_image');
            $image_size = 'thumb-grid';
            $image_url = $member_image['sizes'][$image_size];
            $member_headshot = get_sub_field('member_headshot');
            $image_size = 'thumb-grid';
            $headshot_url = $member_headshot['sizes'][$image_size];
            if($center_last_box && $count == $x){
                $marble_collective .= '<div class="marble-collective-member empty-block">';
                $marble_collective .= 'x';
                $marble_collective .= '</div>';
            }
            $marble_collective .= '<div class="marble-collective-member">';
            $marble_collective .= '<div class="marble-collective-headshot marble-grid-item" style="background: #f8f8f8 url(\''.$image_url.'\') no-repeat center top;background-size:cover">';
            $marble_collective .= '<div class="marble-collective-image marble-grid-item" style="background: #f8f8f8 url(\''.$image_url.'\') no-repeat center center;background-size:cover">';
            $marble_collective .= '<div class="hidden-content marble-grid-item">';
            $marble_collective .= '<div class="hidden-content-wrap">';
            $marble_collective .= '<p>'.get_sub_field('member_bio').'</p>';

            $marble_collective .= '</div>';
            $marble_collective .= '</div>';
            $marble_collective .= '</div>';
            $marble_collective .= '</div>';
            $marble_collective .= '<div class="marble-collective-title">';
			$marble_collective .= '<h3>'.get_sub_field('member_title').'</h3>';
			if(get_sub_field('member_link')){
			$marble_collective .= '<span class="visit-website"><a href="'.get_sub_field('member_link').'" target="_blank">Visit website</a></span>';
			}
            $marble_collective .= '</div>';
            if(get_sub_field('member_link')){
            }
            $marble_collective .= '</div>';
        endwhile;
		$marble_collective .= '</div>';
		$marble_collective .= '<style>
		.marble-collective{margin-left:-3.33%}
		.marble-collective-member{width:30%;float:left;overflow:hidden;margin-left:3.33%}
		.marble-collective-member.empty-block{display:block;color:#fff !important;}
		.marble-collective-member h3{font-size:20px;line-height:46px;text-transform:uppercase;text-align:center;margin-bottom:10px;}
		.marble-collective-member .visit-website{text-decoration:underline;}
		.marble-collective-member .visit-website a{text-align:center;display:block;font-size:16px;color:#767676;}
		.marble-collective-headshot{overflow:hidden;background:rgba(216,216,216,0.16);min-height:320px;width:100%;display:block;position:relative;}
		.marble-collective-image{opacity:1;min-height:320px;width:100%;display:block;  -webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;-o-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;}
		.marble-collective-member:hover .marble-team-image{background:transparent !important;}
		.marble-collective-title{padding-top:20px;height:150px;padding-bottom:30px;}
		.marble-collective-role{text-transform:uppercase;text-align:center;font-size:14px;display:block;color:#B3B3B3;}
		.hidden-content{background:transparent;position:absolute;top:0;left:0;height:100%;width:100%;opacity:0;  -webkit-transition: all 0.5s ease-in-out;
		-moz-transition: all 0.5s ease-in-out;-o-transition: all 0.5s ease-in-out;transition: all 0.5s ease-in-out;}
		.marble-collective-member:hover .hidden-content{opacity:1;}
		.hidden-content-wrap{background:rgba(0,0,0,0.7);width:105%;height:200%;display:block;overflow:scroll;padding:40px;color:#fff;}
		.marble-collective-member .hidden-content h3{color:#F47E76;text-align:left !important;text-transform:none;font-size:36px;margin-bottom:30px;}
		.marble-collective-member .hidden-content ul{margin:0;padding:0 30px;}
		.marble-collective-member .hidden-content ul li{color:#fff !important;margin-bottom:10px;}
		@media only screen and (max-width: 1200px) {
		.marble-collective{margin-left:-5%}
		.marble-collective-member{width:45%;margin-left:5%}
		.hidden-content-wrap{padding:30px;}
		.marble-collective-member.empty-block{display:none;}
		}
		@media only screen and (max-width: 800px) {
		.marble-collective{margin-left:0%}
		.marble-collective-member{width:100%;float:lnone;margin-left:0%}
		.marble-collective-title{padding-top:20px;padding-bottom:70px;}
		.hidden-content-wrap{padding:80px;}
		}
		@media only screen and (max-width: 600px) {
			.hidden-content-wrap{padding:40px;}
		}
		@media only screen and (max-width: 400px) {
				.hidden-content-wrap{padding:30px;}
		}
		</style>';
    endif;
    return $marble_collective;
}
add_shortcode('marble-collective', 'marble_collective');






// MARBLE SOCIAL BAR
function marble_socialbar() { 
	$marble_socialbar = null;
	$marble_socialbar .= '<div class="marble-socialbar">';
	$marble_socialbar .= '[marble-social]';
	$marble_socialbar .= '</div>';
	$marble_socialbar .= '<style>
	.marble-socialbar{height:130px;line-height:130px;padding:0 30px;text-align:right;}
	.marble-socialbar .fusion-social-networks .fusion-social-network-icon:before{color:#1a5869}
	@media (max-width: 800px) {
		.marble-socialbar{display:none;}
	}
	</style>';
	echo do_shortcode($marble_socialbar); 
}
add_action( 'avada_before_header_wrapper', 'marble_socialbar' );



// CUSTOM EXCERPT LENGTH
function get_excerpt($limit, $source = null){

    if($source == "content" ? ($excerpt = get_the_content()) : ($excerpt = get_the_excerpt()));
    $excerpt = preg_replace(" (\[.*?\])",'',$excerpt);
    $excerpt = strip_shortcodes($excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = substr($excerpt, 0, $limit);
    $excerpt = substr($excerpt, 0, strripos($excerpt, " "));
    $excerpt = trim(preg_replace( '/\s+/', ' ', $excerpt));
    //$excerpt = $excerpt.'... <a href="'.get_permalink($post->ID).'">more</a>';
    return $excerpt;
}




// OUR THOUGHTS
function mp_our_thoughts() { 
	$mp_our_thoughts = null;

	$current_term_arguments = '';
	if(is_category() || is_tax() || is_tag() )  {
			$current_term = get_queried_object_id();
			$current_term_arguments = array(
											array(
												'taxonomy' => 'our_thoughts_category',
												'field' => 'term_id',
												'terms' => $current_term
											)
										);
	}

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args = array(
	'post_type' => 'our_thoughts',
	'post_status' => 'publish',
	'orderby' => 'date',
	'order'   => 'DESC',
	'posts_per_page' => 9,
	'paged' => $paged,
	'tax_query' => $current_term_arguments,
	);
	// The Query
	$the_query = new WP_Query( $args );    
	// The Loop
	if ( $the_query->have_posts() ) {
	$mp_our_thoughts .= '<div class="mp-blog">';
	while ( $the_query->have_posts() ) {
	$the_query->the_post();

		
	if( $the_query->current_post == 0 && !is_paged() ) {
		$mp_our_thoughts .= '<div class="mp-post first-post">';
		$mp_our_thoughts .= '<div class="mp-post-image"><a href="' . get_permalink() . '">'.get_the_post_thumbnail(get_the_ID(),array( 1200, 600)).'</a></div>';
	} else {
		$mp_our_thoughts .= '<div class="mp-post">';
		$mp_our_thoughts .= '<div class="mp-post-image"><a href="' . get_permalink() . '">'.get_the_post_thumbnail(get_the_ID(),array( 800, 600)).'</a></div>';
	}

	
	$mp_our_thoughts .= '<div class="mp-post-content">';
	$mp_our_thoughts .= '<div class="mp-post-date">'.get_the_date();
	$mp_our_thoughts .= '<span class="fancy-date rotate">'.get_the_date().'</span>';
	$mp_our_thoughts .= '</div>';
	$mp_our_thoughts .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
	$mp_our_thoughts .= '<div class="mp-post-excerpt">'.get_excerpt(120).'</div>';
	$mp_our_thoughts .= '<div class="mp-read-more"><a href="' . get_permalink() . '">Read more</a></div>';
	$mp_our_thoughts .= '</div>';
	$mp_our_thoughts .= '</div>';
	}
	$mp_our_thoughts .= '</div>';



	$mp_our_thoughts .= '<div class="clear"></div>';
    $mp_our_thoughts .= '<div class="mp-pagination">';
    $mp_our_thoughts .= paginate_links( array(
                'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
                'total'        => $the_query->max_num_pages,
                'current'      => max( 1, get_query_var( 'paged' ) ),
                'format'       => '?paged=%#%',
                'show_all'     => false,
                'type'         => 'plain',
                'end_size'     => 2,
                'mid_size'     => 1,
                'prev_next'    => true,
                'prev_text'    => sprintf( '<i></i> %1$s', __( 'First', 'text-domain' ) ),
                'next_text'    => sprintf( '%1$s <i></i>', __( 'Last', 'text-domain' ) ),
                'add_args'     => false,
                'add_fragment' => '',
				'add_args' =>  true,
            ) );
    $mp_our_thoughts .= '</div>';
	$mp_our_thoughts .= '<style>
	.mp-blog{margin-left:-10%;}
	.mp-post{width:40%;margin-left:10%;float:left;margin-bottom:65px;}
	.mp-post.first-post{width:90%;margin-left:10%;float:none;}
	#wrapper .post-content .mp-post h2{font-size:38px;line-height:68px;}
	.mp-read-more{font-size:18px;font-family:"spectra-light";text-decoration:underline;}
	.mp-post .fancy-date{position:absolute;margin-left:-175px;margin-top:-100px;color:#BFBFBF;font-size:16px;}
	.mp-post.first-post .mp-post-image{max-height:600px;overflow:hidden;}
	.mp-post .mp-post-image{margin-bottom:50px;max-width:800px;max-height:600px;overflow:hidden;}
	.mp-post .mp-post-date{margin-bottom:10px;}
	.mp-post h2{margin-bottom:10px;}
	.mp-post .mp-post-excerpt{margin-bottom:20px;}
	.mp-post .mp-post-content{height:250px;overflow:hidden;}
	.mp-pagination span, .mp-pagination a{margin-right:15px;padding:0 20px;height:50px;line-height:50px;text-align:center;display:inline-block;background:#f5f5f5}
	.mp-pagination .current{background:#86D2DA;}
	@media (max-width: 1440px) {
		.mp-post .fancy-date{margin-left:-130px;margin-top:-100px;}
	}
	@media (max-width: 1024px) {
		.mp-post.first-post{margin-left:0;width:100%;}
		.mp-blog{margin-left:0%;}
		.mp-post{width:100%;margin-left:0%;float:none;margin-bottom:100px;}
		.mp-post .fancy-date{display:none}
	}
	
	</style>';



	wp_reset_postdata();
	} 
		
	return $mp_our_thoughts;
}
add_shortcode('mp-our-thoughts', 'mp_our_thoughts');
















// MARBLE CATEGORIES
function marble_blog_categories() { 




// List terms in a given taxonomy using wp_list_categories (also useful as a widget if using a PHP Code plugin)
$marble_cat = null;
$orderby      = 'name'; 
$show_count   = false;
$pad_counts   = false;
$hierarchical = true;
$title        = '';
 
$args = array(
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  	'taxonomy' => 'our_thoughts_category',
    'echo'       => false
);
$current_cat = null;
if(is_page('marbled-thoughts')) $current_cat = 'current-cat';
$marble_cat .= '<div class="marble-blog-categories">';
$marble_cat .= '<span class="mp-cat-about">Have a look at what inspires us and what we are thinking about.</span>';
$marble_cat .= '<ul>';
$marble_cat .= '<li class="'.$current_cat.'"><a href="/marble-private/marbled-thoughts/">All</a></li>';
$marble_cat .= wp_list_categories($args);
$marble_cat .= '</ul>';
$marble_cat .= '</div>';

$marble_cat .= '<style>
.marble-blog-categories{margin-bottom:45px;}
.marble-blog-categories:after{content: "";display: block;clear: both;}
.marble-blog-categories ul{margin:0;padding:0;float:right;}
.marble-blog-categories li{display:inline-block;padding-left:30px;}
.marble-blog-categories li.current-cat a{font-weight:bold;}
@media (max-width: 1080px) {
	.mp-cat-about{display:block;margin-bottom:45px;}
	.marble-blog-categories ul{display:block;margin-bottom:45px;float:none;}
	.marble-blog-categories ul li{padding-left:0;}
	.marble-blog-categories ul li a{padding:0 20px;margin-right:15px;margin-bottom:15px;height:50px;line-height:50px;text-align:center;background:#f5f5f5;display:inline-block;}
}
</style>';
return $marble_cat;
}
add_shortcode('marble-blog-categories', 'marble_blog_categories');







// MARBLE RELATED
function marble_similar_projects() {

	$similar_project_id_1 = get_field('related_project_1');
	$similar_project_id_2 = get_field('related_project_2');
	$similar_project_id_3 = get_field('related_project_3');
	$featured_img_url_1 = get_the_post_thumbnail_url($similar_project_id_1,'mp-rectangle'); 
	$featured_img_url_2 = get_the_post_thumbnail_url($similar_project_id_2,'mp-rectangle'); 
	$featured_img_url_3 = get_the_post_thumbnail_url($similar_project_id_3,'mp-rectangle'); 

	$marble_similar_projects = null;
	
	$marble_similar_projects = '<div class="mp-similar-projects">';

	$marble_similar_projects .= '<div class="mp-similar-project">';
	$marble_similar_projects .= '<img src="'.$featured_img_url_1.'" alt="" />';
	$marble_similar_projects .= '<h4>'.get_the_title($similar_project_id_1).'<h4>';
	$marble_similar_projects .= '<h5>'.get_field('client', $similar_project_id_1).'</h5>';
	$marble_similar_projects .= '</div>';

	$marble_similar_projects .= '<div class="mp-similar-project">';
	$marble_similar_projects .= '<img src="'.$featured_img_url_2.'" alt="" />';
	$marble_similar_projects .= '<h4>'.get_the_title($similar_project_id_2).'</h4>';
	$marble_similar_projects .= '<h5>'.get_field('client', $similar_project_id_2).'</h5>';
	$marble_similar_projects .= '</div>';

	$marble_similar_projects .= '<div class="mp-similar-project">';
	$marble_similar_projects .= '<img src="'.$featured_img_url_3.'" alt="" />';
	$marble_similar_projects .= '<h4>'.get_the_title($similar_project_id_3).'<h4>';
	$marble_similar_projects .= '<h5>'.get_field('client', $similar_project_id_3).'</h5>';
	$marble_similar_projects .= '</div>';

	$marble_similar_projects .= '</div>';

	$marble_similar_projects .= '<style>
	.mp-similar-projects{margin-left:-3.33%;border-top:1px solid #ddd;padding:100px 0 50px;}
	.mp-similar-projects:after{content: "";display: block;clear: both;}
	.mp-similar-project{float:left;width:30%;margin-left:3.33%;margin-bottom:50px;}
	.mp-similar-project img{margin-bottom:40px;}
	@media (max-width: 800px) {
		.mp-similar-projects{margin-left:0;}
		.mp-similar-project{float:none;width:100%;margin-left:0;}
	}
	</style>';

	echo $marble_similar_projects;
}





// CUSTOM POST TYPE HIGHLIGHT MENU ITEM
/*
  add_action('nav_menu_css_class', 'add_current_nav_class', 10, 2 );


	
	function add_current_nav_class($classes, $item) {
		
		// Getting the current post details
		$taxonomy = get_query_var('taxonomy');
		if($taxonomy=='our_thoughts_category') {$current_post_type_slug = 'marbled-thoughts';}
			
		// Getting the URL of the menu item
		$menu_slug = strtolower(trim($item->url));
		
		// If the menu item URL contains the current post types slug add the current-menu-item class
		if (strpos($menu_slug,$current_post_type_slug) !== false) {
		
		   $classes[] = 'current-menu-item';
		
		}
		
		// Return the corrected set of classes to be added to the menu item
		return $classes;
	
	}
*/







// SOCIAL ON THOUGHTS
function mp_thoughts_social() { 
	$mp_thoughts_social = null;
	$mp_thoughts_social .= '<div class="marble-thoughts-social">';
	$mp_thoughts_social .= '[marble-social]';
	$mp_thoughts_social .= '<a href="#">Share this article</a>';
	$mp_thoughts_social .= '</div>';
	$mp_thoughts_social .= '<style>
	.marble-thoughts-social{text-align:center;}
	.marble-thoughts-social a{text-decoration:underline;font-size:18px;font-family:"spectral-light"}
	</style>';
	$mp_thoughts_social = do_shortcode($mp_thoughts_social); 
	return $mp_thoughts_social;
}
add_shortcode('mp-thoughts-social', 'mp_thoughts_social');







// REGISTER MARBLE MENU
add_action( 'after_setup_theme', 'register_marble_menu' );
function register_marble_menu() {
  register_nav_menu( 'marble_custom_menu', __( 'Marble Private Menu', 'marble' ) );
}



// MARBLE NAVIGATION
function marble_navigation() { 

	$marble_menu = wp_nav_menu(
								array(
									'echo' => false
									)
							);


	
	$marble_navigation = null;
	$marble_navigation .= '<div class="marble-navigation">';
	$marble_navigation .= '<a href="'.get_home_url().'"><img class="marble-logo" src="http://happyrobot.eu/marble-private/wp-content/uploads/2018/05/mp-logo-retina.png" alt="" /></a>';
	$marble_navigation .= $marble_menu;
	$marble_navigation .= '</div>';

	$marble_navigation .= '<style>
	.marble-navigation{position:absolute;top:0;left:0;padding:60px 50px;z-index:100;background:#fff;overflow:hidden;}
	.marble-navigation .marble-logo{max-width:136px;margin-bottom:100px;}
	.admin-bar .marble-navigation{top:28px;}
	.marble-navigation ul{margin:0;padding:0;}
	.marble-navigation li{list-style:none;}
	.marble-navigation li a{list-style:none;text-transform:uppercase;font-size:15px;color:#000;font-weight:100;}
	.marble-navigation li.current_page_item a{font-weight:600;}
	.marble-navigation li.current_page_item a:before{content:"•";color:#86D2DA;padding-right:10px;}
	@media (max-width: 800px) {
		.marble-navigation{display:none;}
	}
	</style>';

	echo do_shortcode($marble_navigation); 


}
add_action( 'avada_before_header_wrapper', 'marble_navigation' );





// MARBLE MOBILE NAVIGATION
function marble_mobile_navigation() { 

	$marble_menu = wp_nav_menu(
								array(
									'echo' => false
									)
							);


	
	$marble_navigation = null;
	$marble_navigation .= '<div class="marble-mobile-navigation">';
	$marble_navigation .= '<div class="marble-mobile-navigation-bar">';
	$marble_navigation .= 'MARBLE LDN';
	$marble_navigation .= '<a id="marble-mobile-nav-trigger" href="#"><img class="open-menu" src="http://happyrobot.eu/marble-private/wp-content/uploads/2018/05/mp-menu-retina.png" alt="MENU" /><img class="close-menu" src="http://happyrobot.eu/marble-private/wp-content/uploads/2018/05/mp-close-menu.png" alt="CLOSE" /></a>';
	$marble_navigation .= '</div>';
	$marble_navigation .= '<div class="marble-mobile-navigation-dropdown">';
	$marble_navigation .= $marble_menu;
	$marble_navigation .= '[marble-social]';
	$marble_navigation .= '</div>';
	$marble_navigation .= '</div>';

	$marble_navigation .= '<style>
	.marble-mobile-navigation{display:none;}

	@media (max-width: 800px) {
		.marble-mobile-navigation{display:block;background:#fff;}
		.marble-mobile-navigation .open-menu{display:block;}
		.marble-mobile-navigation .close-menu{display:none;}
		.marble-mobile-navigation.active{background:#000;color:#fff;}
		.marble-mobile-navigation.active .open-menu{display:none;}
		.marble-mobile-navigation.active .close-menu{display:block;}
		.marble-mobile-navigation-bar{height:80px;line-height:80px;padding:0 30px;font-size:15px;}
		#marble-mobile-nav-trigger{float:right;max-width:21px;margin-top:28px;}
		.marble-mobile-navigation-dropdown{background:#000;width:100%;position:absolute;z-index:100;}
		.marble-mobile-navigation-dropdown ul{margin:0;padding:30px;}
		.marble-mobile-navigation-dropdown ul li{list-style:none;}
		.marble-mobile-navigation-dropdown ul li a{color:#fff !important;text-transform:uppercase;font-size:24px;line-height:72px;}
		.marble-mobile-navigation-dropdown .fusion-social-networks-wrapper{padding:30px;}
		.marble-mobile-navigation-dropdown .fusion-social-networks-wrapper a{color:#fff !important;}
	}
	</style>';

	$marble_navigation .= '<script>
	jQuery(function() {	
		// TOGGLE MOBILE MENU
		jQuery(".marble-mobile-navigation-dropdown").hide();
		jQuery(".marble-mobile-navigation-dropdown .close").hide();
		jQuery("#marble-mobile-nav-trigger").click(function(e) {
			e.preventDefault();
			console.log("clicked");
			jQuery(".marble-mobile-navigation-dropdown").slideToggle(300);
			jQuery(".marble-mobile-navigation").toggleClass("active");
		});
	});
	</script>';

	echo do_shortcode($marble_navigation); 


}
add_action( 'avada_before_header_wrapper', 'marble_mobile_navigation' );














// MARBLE FOOTER
function marble_footer() {
	
	$marble_footer = null;

	$marble_footer .= '<div class="marble-footer">';

	// DESKTOP WIDGETS
	$marble_footer .= '<div class="marble-footer-widgets desktop">';
	$marble_footer .= '<div class="marble-footer-widgets-container">';

	$marble_footer .= '<div class="footer-col-1">';
	$marble_footer .= '<h6>Marble Studio</h6>';
	$marble_footer .= '<ul>';
	$marble_footer .= '<li>Studio 55</li>';
	$marble_footer .= '<li>Great Western Studios</li>';
	$marble_footer .= '<li>Alfred Road</li>';
	$marble_footer .= '<li>London</li>';
	$marble_footer .= '<li>W2 5EU</li>';
	$marble_footer .= '</ul>';	
	$marble_footer .= '<ul>';
	$marble_footer .= '<li><a href="tel:07985215746">07985 215746</a></li>';
	$marble_footer .= '<li><a href="mailto:info@marbleldn.com">info@marbleldn.com</a></li>';
	$marble_footer .= '</ul>';	
	$marble_footer .= '</div>';

	$marble_footer .= '<div class="footer-col-2">';
	$marble_footer .= '<h6>Marble Warehouse</h6>';
	$marble_footer .= '<ul>';
	$marble_footer .= '<li>19 Osiers Road</li>';
	$marble_footer .= '<li>Unit 2</li>';
	$marble_footer .= '<li>Building 5</li>';
	$marble_footer .= '<li>London</li>';
	$marble_footer .= '<li>SW18 1NL</li>';
	$marble_footer .= '</ul>';
	$marble_footer .= '<ul>';
	$marble_footer .= '<li><a href="tel:02030115388">02030115388</a></li>';
	$marble_footer .= '<li><a href="mailto:info@marbleldn.com">info@marbleldn.com</a></li>';
	$marble_footer .= '</ul>';
	$marble_footer .= '</div>';

	$marble_footer .= '<div class="footer-col-3">';
	$marble_footer .= '[marble-social]';	
	$marble_footer .= '<img class="marble-footer-logo" src="http://happyrobot.eu/marble-private/wp-content/uploads/2018/05/mp-logo-footer.png" alt="" />';
	$marble_footer .= '</div>';

	$marble_footer .= '</div>';
	$marble_footer .= '</div>';


	// MOBILE WIDGETS
	$marble_footer .= '<div class="marble-footer-widgets mobile">';
	$marble_footer .= '<div class="marble-footer-widgets-container">';


	$marble_footer .= '<div class="footer-col-3">';
	$marble_footer .= '<img class="marble-footer-logo" src="http://happyrobot.eu/marble-private/wp-content/uploads/2018/05/mp-logo-footer.png" alt="" />';
	$marble_footer .= '[marble-social]';
	$marble_footer .= '</div>';

	$marble_footer .= '<div class="footer-col-1">';
	$marble_footer .= '<h6>Marble Studio</h6>';
	$marble_footer .= '<ul>';
	$marble_footer .= '<li>Studio 55</li>';
	$marble_footer .= '<li>Great Western Studios</li>';
	$marble_footer .= '<li>Alfred Road</li>';
	$marble_footer .= '<li>London</li>';
	$marble_footer .= '<li>W2 5EU</li>';
	$marble_footer .= '</ul>';	
	$marble_footer .= '<ul>';
	$marble_footer .= '<li><a href="tel:07985215746">07985 215746</a></li>';
	$marble_footer .= '<li><a href="mailto:info@marbleldn.com">info@marbleldn.com</a></li>';
	$marble_footer .= '</ul>';	
	$marble_footer .= '</div>';

	$marble_footer .= '<div class="footer-col-2">';
	$marble_footer .= '<h6>Marble Warehouse</h6>';
	$marble_footer .= '<ul>';
	$marble_footer .= '<li>19 Osiers Road</li>';
	$marble_footer .= '<li>Unit 2</li>';
	$marble_footer .= '<li>Building 5</li>';
	$marble_footer .= '<li>London</li>';
	$marble_footer .= '<li>SW18 1NL</li>';
	$marble_footer .= '</ul>';
	$marble_footer .= '<ul>';
	$marble_footer .= '<li><a href="tel:02030115388">02030115388</a></li>';
	$marble_footer .= '<li><a href="mailto:info@marbleldn.com">info@marbleldn.com</a></li>';
	$marble_footer .= '</ul>';
	$marble_footer .= '</div>';



	$marble_footer .= '</div>';
	$marble_footer .= '</div>';


	$marble_footer .= '<div class="marble-footer-copyright">';
	$marble_footer .= 'COPYRIGHT [auto-year] MARBLE LDN. ALL RIGHTS RESERVED.';
	$marble_footer .= '</div>';
	$marble_footer .= '</div>';

	$marble_footer .= '<style>
	.marble-footer-widgets.desktop{display:block;}
	.marble-footer-widgets.mobile{display:none;}
	.marble-footer-widgets{color:#000;font-size:16px;line-height:24px;}
	.marble-footer-widgets-container{border-top:1px solid #ddd;padding:100px 0 50px;}
	.marble-footer-widgets-container:after{content: "";display: block;clear: both;}
	.marble-footer-widgets .footer-col-1{float:left;width:20%;}
	.marble-footer-widgets .footer-col-2{float:left;width:20%;}
	.marble-footer-widgets .footer-col-3{float:right;width:20%;text-align:right;}
	.marble-footer-widgets h6{font-size:16px;margin-bottom:30px;font-weight:600}
	.marble-footer-widgets ul{padding:0;margin:0;margin-bottom:50px;}
	.marble-footer-widgets ul:last-child{margin-bottom:0px;}
	.marble-footer-widgets ul li{list-style:none;}
	.marble-footer-logo{margin-top:70px;width:140px;}
	.marble-footer-copyright{color:#BFBFBF;font-size:13px;padding:50px 0;}
	@media (max-width: 1400px) {
		.marble-footer-widgets .footer-col-1{width:33.33%;}
		.marble-footer-widgets .footer-col-2{width:33.33%;}
		.marble-footer-widgets .footer-col-3{width:33.33%;}
	}
	@media (max-width: 800px) {
		.marble-footer-widgets.desktop{display:none;}
		.marble-footer-widgets.mobile{display:block;}
		.marble-footer-widgets .footer-col-1{width:60%;text-align:left;}
		.marble-footer-widgets .footer-col-2{width:40%;text-align:left;float:right;}
		.marble-footer-widgets .footer-col-3{float:none;width:100%;text-align:center;margin-bottom:70px;}
		.marble-footer-widgets ul li{display:block;}
		.marble-footer-logo{margin-top:0;margin-bottom:70px;}
	}
	@media (max-width: 500px) {
		.marble-footer-widgets .footer-col-1{width:100%;float:none;text-align:center;margin-bottom:70px;}
		.marble-footer-widgets .footer-col-2{width:100%;float:none;text-align:center;}
	}
	</style>';

	$marble_footer = do_shortcode($marble_footer);
	return $marble_footer;

}
add_shortcode('marble-footer', 'marble_footer');







// CASE STUDY GALLERY
function case_study_gallery() {
    if(is_singular('our_work')){
	$case_study_gallery = null;
	






	/*
    $image1 = get_field('gallery_image1');
    $image2 = get_field('gallery_image2');
    $image3 = get_field('gallery_image3');
    $image4 = get_field('gallery_image4');
    $image5 = get_field('gallery_image5');
    $image6 = get_field('gallery_image6');
    $image7 = get_field('gallery_image7');
    $image8 = get_field('gallery_image8');
    $image9 = get_field('gallery_image9');
    $image_square = 'thumb-grid';
    $image_rectangle = 'rectangle-grid';
    $image1_url_square = $image1['sizes'][$image_square];
    $image1_url_rectangle = $image1['sizes'][$image_rectangle];
    $image2_url_square = $image2['sizes'][$image_square];
    $image2_url_rectangle = $image2['sizes'][$image_rectangle];
    $image3_url_square = $image3['sizes'][$image_square];
    $image3_url_rectangle = $image3['sizes'][$image_rectangle];
    $image4_url_square = $image4['sizes'][$image_square];
    $image4_url_rectangle = $image4['sizes'][$image_rectangle];
    $image5_url_square = $image5['sizes'][$image_square];
    $image5_url_rectangle = $image5['sizes'][$image_rectangle];
    $image6_url_square = $image6['sizes'][$image_square];
    $image6_url_rectangle = $image6['sizes'][$image_rectangle];
    $image7_url_square = $image7['sizes'][$image_square];
    $image7_url_rectangle = $image7['sizes'][$image_rectangle];
    $image8_url_square = $image8['sizes'][$image_square];
    $image8_url_rectangle = $image8['sizes'][$image_rectangle];
    $image9_url_square = $image9['sizes'][$image_square];
    $image9_url_rectangle = $image9['sizes'][$image_rectangle];
        if(get_field('gallery_rows') == 'video'){
            $case_study_gallery .= '<div class="case-study-gallery video-row">';
            $case_study_gallery .= '<div class="square one">';
            $case_study_gallery .= '<h1>'.get_the_title().'</h1>';
            if(get_field('client')){
            $case_study_gallery .= '<div class="client"><strong>Client:</strong> '.get_field('client').'</div>';
            }
            if(get_field('services')){
            $case_study_gallery .= '<div class="services"><strong>Services:</strong> '.get_field('services').'</div>';
            }
            $case_study_gallery .= '</div>';
                $case_study_gallery .= '<div class="video-large video-item" id="case-study-video" style="background:rgba(216,216,216,0.1) url(\''.$image6_url_rectangle.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image6_url_rectangle.'">';
                if(get_field('add_video')){
                $case_study_gallery .= '<video width="100%" height="auto" preload="auto">
				<source src="'.get_field('webm').'" type="video/webm">
                <source src="'.get_field('mp4').'" type="video/mp4">
																	</video>';
                $case_study_gallery .= '<div class="gallery-video-play-button">PLAY<br/>VIDEO</div>';
                }
                $case_study_gallery .= '</div>';
            $case_study_gallery .= '</div>';
        }
        if(get_field('gallery_rows') == 'one'){
            $case_study_gallery .= '<div class="case-study-gallery one-row">';
            $case_study_gallery .= '<div class="case-study-gallery-row first-row">';
            // first box
            $case_study_gallery .= '<div class="square one">';
            $case_study_gallery .= '<h1>'.get_the_title().'</h1>';
            if(get_field('client')){
            $case_study_gallery .= '<div class="client"><strong>Client:</strong> '.get_field('client').'</div>';
            }
            if(get_field('services')){
            $case_study_gallery .= '<div class="services"><strong>Services:</strong> '.get_field('services').'</div>';
            }
            $case_study_gallery .= '</div>';
            // second box
            $case_study_gallery .= '<div class="square two gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image1_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image1_url_rectangle.'">';
            $case_study_gallery .= '</div>';
            // third box
            $case_study_gallery .= '<div class="square three gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image2_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image2_url_rectangle.'">';
            $case_study_gallery .= '</div>';
            // fourth box
            $case_study_gallery .= '<div class="square four gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image3_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image3_url_rectangle.'">';
            $case_study_gallery .= '</div>';
            // fifth box
            $case_study_gallery .= '<div class="square five gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image4_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image4_url_rectangle.'">';
            $case_study_gallery .= '</div>';
            $case_study_gallery .= '</div>';
            $case_study_gallery .= '</div>';
        }
        if(get_field('gallery_rows') == 'two'){
            if(get_field('gallery_layout') == 'small'){
                $case_study_gallery .= '<div class="case-study-gallery two-rows">';
                $case_study_gallery .= '<div class="case-study-gallery-row first-row">';
                // first box
                $case_study_gallery .= '<div class="square one">';
                $case_study_gallery .= '<h1>'.get_the_title().'</h1>';
                if(get_field('client')){
                $case_study_gallery .= '<div class="client"><strong>Client:</strong> '.get_field('client').'</div>';
                }
                if(get_field('services')){
                $case_study_gallery .= '<div class="services"><strong>Services:</strong> '.get_field('services').'</div>';
                }
                $case_study_gallery .= '</div>';
                // second box
                $case_study_gallery .= '<div class="square two gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image1_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image1_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // third box
                $case_study_gallery .= '<div class="square three gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image2_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image2_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // fourth box
                $case_study_gallery .= '<div class="square four gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image3_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image3_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // fifth box
                $case_study_gallery .= '<div class="square five gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image4_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image4_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '<div class="case-study-gallery-row second-row">';
                // sixth box
                $case_study_gallery .= '<div class="square six gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image5_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image5_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // seventh box
                $case_study_gallery .= '<div class="square seven gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image6_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image6_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // eight box
                $case_study_gallery .= '<div class="square eight gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image7_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image7_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // ninth box
                $case_study_gallery .= '<div class="square nine gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image8_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image8_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // tenth box
                $case_study_gallery .= '<div class="square ten desktop gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image9_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image9_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '<div class="rectangle ten mobile gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image9_url_rectangle.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image9_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
            }
            if(get_field('gallery_layout') == 'large'){
                $case_study_gallery .= '<div class="case-study-gallery two-rows ';
                if(get_field('add_video')) {
                $case_study_gallery .= 'video-added';
                }
                $case_study_gallery .= '">';
                $case_study_gallery .= '<div class="case-study-gallery-row first-row">';
                // first box
                $case_study_gallery .= '<div class="square one">';
                $case_study_gallery .= '<h1>'.get_the_title().'</h1>';
                if(get_field('client')){
                $case_study_gallery .= '<div class="client"><strong>Client:</strong> '.get_field('client').'</div>';
                }
                if(get_field('services')){
                $case_study_gallery .= '<div class="services"><strong>Services:</strong> '.get_field('services').'</div>';
                }
                $case_study_gallery .= '</div>';
                // second box
                $case_study_gallery .= '<div class="square two desktop gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image1_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image1_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '<div class="rectangle two mobile gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image1_url_rectangle.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image1_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // third box
                $case_study_gallery .= '<div class="rectangle three desktop gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image2_url_rectangle.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image2_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // third box
                $case_study_gallery .= '<div class="square three mobile gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image2_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image2_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // fourth box
                $case_study_gallery .= '<div class="square four gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image3_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image3_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '<div class="case-study-gallery-row second-row">';
                // fifth box
                $case_study_gallery .= '<div class="square five desktop gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image4_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image4_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '<div class="rectangle five mobile gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image4_url_rectangle.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image4_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // sixth box
                $case_study_gallery .= '<div class="square six gallery-item ';
                if(get_field('add_video')) {
                    $case_study_gallery .= 'desktop';
                }
                $case_study_gallery .= '" style="background:rgba(216,216,216,0.1) url(\''.$image5_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image5_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // seventh box
                $case_study_gallery .= '<div class="rectangle seven ';
                if(get_field('add_video')) {
                    $case_study_gallery .= 'video-item';
                } else {
                    $case_study_gallery .= 'gallery-item desktop';
                }
                $case_study_gallery .= '" id="case-study-video" style="background:rgba(216,216,216,0.1) url(\''.$image6_url_rectangle.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image6_url_rectangle.'">';
                if(get_field('add_video')){
                $case_study_gallery .= '<video width="100%" height="auto" preload="auto">
				<source src="'.get_field('webm').'" type="video/webm">
                <source src="'.get_field('mp4').'" type="video/mp4"></video>';
                $case_study_gallery .= '<div class="gallery-video-play-button">PLAY<br/>VIDEO</div>';
                }
                $case_study_gallery .= '</div>';
                if(!get_field('add_video')) {
                $case_study_gallery .= '<div class="square seven mobile gallery-item ';
                $case_study_gallery .= '" style="background:rgba(216,216,216,0.1) url(\''.$image6_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image6_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                }
                // eight box
                $case_study_gallery .= '<div class="square eight desktop gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image7_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image7_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '<div class="rectangle eight mobile gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image7_url_rectangle.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image7_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
            }
		}
		*/


		$image1 = get_field('gallery_image1');
		$image2 = get_field('gallery_image2');
		$image3 = get_field('gallery_image3');
		$image4 = get_field('gallery_image4');
		$image5 = get_field('gallery_image5');
		$image6 = get_field('gallery_image6');
		$video_image = get_field('video_image');
		$image_square = 'thumb-grid';
		$image_rectangle = 'rectangle-grid';
		$image1_url_square = $image1['sizes'][$image_square];
		$image1_url_rectangle = $image1['sizes'][$image_rectangle];
		$image2_url_square = $image2['sizes'][$image_square];
		$image2_url_rectangle = $image2['sizes'][$image_rectangle];
		$image3_url_square = $image3['sizes'][$image_square];
		$image3_url_rectangle = $image3['sizes'][$image_rectangle];
		$image4_url_square = $image4['sizes'][$image_square];
		$image4_url_rectangle = $image4['sizes'][$image_rectangle];
		$image5_url_square = $image5['sizes'][$image_square];
		$image5_url_rectangle = $image5['sizes'][$image_rectangle];
		$image6_url_square = $image6['sizes'][$image_square];
		$image6_url_rectangle = $image6['sizes'][$image_rectangle];

        if(get_field('gallery_rows') == 'one'){

			    $case_study_gallery .= '<div class="case-study-gallery one-rows">';
                $case_study_gallery .= '<div class="case-study-gallery-row first-row">';
                // first box
                $case_study_gallery .= '<div class="square one gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image1_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image1_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // second box
                $case_study_gallery .= '<div class="square two gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image2_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image2_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // third box
                $case_study_gallery .= '<div class="rectangle three gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image3_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image3_url_rectangle.'">';
                $case_study_gallery .= '</div>';
				
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
			
		}

		if(get_field('gallery_rows') == 'two'){
            if(get_field('gallery_layout') == 'small'){

                $case_study_gallery .= '<div class="case-study-gallery two-rows">';
                $case_study_gallery .= '<div class="case-study-gallery-row first-row">';
                // first box
                $case_study_gallery .= '<div class="square one gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image1_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image1_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // second box
                $case_study_gallery .= '<div class="square two gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image2_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image2_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // third box
                $case_study_gallery .= '<div class="rectangle three gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image3_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image3_url_rectangle.'">';
                $case_study_gallery .= '</div>';
				$case_study_gallery .= '</div>';
				
                $case_study_gallery .= '<div class="case-study-gallery-row second-row">';
                // four box
                $case_study_gallery .= '<div class="rectangle desktop four gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image4_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image4_url_rectangle.'">';
				$case_study_gallery .= '</div>';
				$case_study_gallery .= '<div class="square mobile four gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image4_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image4_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // five box
                $case_study_gallery .= '<div class="square five gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image5_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image5_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                // six box
                $case_study_gallery .= '<div class="square desktop six gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image6_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image6_url_rectangle.'">';
				$case_study_gallery .= '</div>';
				$case_study_gallery .= '<div class="rectangle mobile six gallery-item" style="background:rgba(216,216,216,0.1) url(\''.$image6_url_square.'\') no-repeat center center;background-size:cover" data-thumbnail-src="'.$image6_url_rectangle.'">';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
                $case_study_gallery .= '</div>';
            }
		}

		if(get_field('gallery_rows') == 'video'){

				$case_study_gallery .= '<div class="case-study-gallery one-rows">';

                $case_study_gallery .= '<div class="video-item" id="case-study-video">';

                $case_study_gallery .= '<video width="100%" height="auto" preload="auto" poster="'.$video_image.'">
				<source src="'.get_field('webm').'" type="video/webm">
                <source src="'.get_field('mp4').'" type="video/mp4"></video>';
                $case_study_gallery .= '<div class="gallery-video-play-button">PLAY<br/>VIDEO</div>';

				$case_study_gallery .= '</div>';
				
				$case_study_gallery .= '</div>';
		}












		$case_study_gallery .= '<style>
		/* CASE STUDY GALLER - GENERAL STYLES */
		.case-study-gallery .mobile{display:none;}
		.case-study-gallery .desktop{display:block;}
		.case-study-gallery h1{font-size:46px;line-height:54px;margin-bottom:30px;margin-top:30px;}
		.case-study-gallery .client{margin-bottom:30px;}
		.case-study-gallery .square{width:25%;height:260px;float:left;background:rgba(216,216,216,0.1);overflow:hidden;}
		.case-study-gallery .rectangle{width:50%;height:260px;float:left;background:rgba(216,216,216,0.1);overflow:hidden;}
		.case-study-gallery .square.one{padding:0 30px;overflow:hidden;}
		.case-study-gallery .video-large{width:75%;min-height:400px;float:left;}
		.case-study-gallery.video-row{overflow:hidden;}
		.case-study-gallery .video-item{position:relative;}
		.gallery-video-play-button{display:block;width:120px;height:120px;background:#F47E76;color:#fff;position:absolute;top:50%;left:50%;margin-top:-60px;margin-left:-60px;z-index:99;font-size:14px;text-align:center;-webkit-border-radius: 50%;
		-moz-border-radius: 50%;border-radius: 50%;cursor:pointer;display:table-cell;padding-top:35px;}
		.case-study-gallery:after{content: "";display: block;clear: both;}


		@media only screen and (max-width: 1023px) {
		.case-study-gallery .mobile{display:block;}
		.case-study-gallery .desktop{display:none;}
		.case-study-gallery .square{width:50%;}
		.case-study-gallery .rectangle{width:100%;}
		.case-study-gallery .video-large{width:100%;min-height:auto;}
		}
		</style>';








        return $case_study_gallery;
    }
}
add_shortcode('case-study-gallery', 'case_study_gallery');


