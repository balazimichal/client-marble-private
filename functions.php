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




// ADD OPTIONS PAGES (ACF PLUGIN MUST BE INSTALLED)
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> $THEME_GLOBALS['theme_name'].' Settings',
		'menu_title'	=> $THEME_GLOBALS['theme_name'].' Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
	/*
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
	*/
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





