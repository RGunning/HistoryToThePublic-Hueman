<?php
/*
* Generated By Orbisius Child Theme Creator - your favorite plugin for Child Theme creation :)
* https://wordpress.org/plugins/orbisius-child-theme-creator/
*
* Unlike style.css, the functions.php of a child theme does not override its counterpart from the parent.
* Instead, it is loaded in addition to the parent’s functions.php. (Specifically, it is loaded right before the parent theme's functions.php).
* Source: http://codex.wordpress.org/Child_Themes#Using_functions.php
*
* Be sure not to define functions, that already exist in the parent theme!
* A common pattern is to prefix function names with the (child) theme name.
* Also if the parent theme supports pluggable functions you can use function_exists( 'put_the_function_name_here' ) checks.
*/

/*  Site name/logo and tagline callbacks
/* ------------------------------------ */
//@utility used on front end and partial refresh
//@return string, either a textual or a logo imr src
function hu_get_logo_title_HTTP( $is_mobile_menu = false ) {
    // Text or image?
    // Since v3.2.4, uses the WP 'custom_logo' theme mod option. Set with a filter.
    $logo_src = false;
    $is_logo_src_set = false;
    $logo_or_title = hu_is_checked( 'display-header-title' ) ? get_bloginfo( 'name' ) : '';
    // Do we have to display a logo ?
    // Then, let's display the relevant one ( desktop or mobile ), if set
    if ( apply_filters( 'hu_display_header_logo', hu_is_checked( 'display-header-logo' ) ) ) {
        //if $is_mobile_menu, let's check if we have a specific logo for mobile set
        if ( $is_mobile_menu ) {
            $logo_src = hu_get_img_src_from_option( 'mobile-header-logo' );
            $is_logo_src_set = false !== $logo_src && ! empty( $logo_src );
        }
        if ( ( $is_mobile_menu && ! $is_logo_src_set ) || ! $is_mobile_menu ) {
            $logo_src = hu_get_img_src_from_option( 'custom-logo' );
            $is_logo_src_set = false !== $logo_src && ! empty( $logo_src );
        }
        if ( $is_logo_src_set ) {
            $logo_src = apply_filters( 'hu_header_logo_src' , $logo_src, $is_mobile_menu );
            if( strpos($logo_src, '.svg') !== false ){
                $logo_or_title = '<object type="image/svg+xml" data="'. $logo_src . '">' . get_bloginfo('name') . '</object>';
            } else {
                $logo_or_title = '<img src="'. $logo_src . '" alt="' . get_bloginfo('name'). '">';
            }
        }
    }//if apply_filters( 'hu_display_header_logo', hu_is_checked( 'display-header-logo' )
    return $logo_or_title;
}

function hu_print_logo_or_title( $echo = true, $is_mobile_menu = false ) {
    $logo_or_title = hu_get_logo_title_HTTP( $is_mobile_menu );
    // => If no logo is set and  ! hu_is_checked( 'display-header-title' ), the logo title is empty.
    ob_start();
        do_action( '__before_logo_or_site_title', $logo_or_title );
        if ( ! empty( $logo_or_title ) ) {
            ?>
                <p class="site-title"><?php hu_do_render_logo_site_tite( $logo_or_title ) ?></p>
            <?php
        }
        do_action( '__after_logo_or_site_title', $logo_or_title );
    $html = ob_get_contents();
    if ($html) ob_end_clean();
    if ( $echo )
        echo apply_filters('hu_logo_title', $html );
    else
        return apply_filters('hu_logo_title', $html );
}

function hu_do_render_logo_site_tite( $logo_or_title = null, $echo = true ) {
    //typically, logo_or_title is not provided when partially refreshed from the customizer
    if ( is_null( $logo_or_title ) || hu_is_ajax() ) {
        $logo_or_title = hu_get_logo_title_HTTP();
    }
    // => If no logo is set and  ! hu_is_checked( 'display-header-title' ), the logo title is empty.
    if ( ! empty( $logo_or_title ) ) {
        $logoTitle = sprintf( '<a class="custom-logo-link" href="%1$s" rel="home" title="%3$s">%2$s</a>',
                home_url('/'),
                $logo_or_title,
                sprintf( '%1$s | %2$s', get_bloginfo('name') , __('Home page', 'hueman') )
            );

        if ( $echo ) {
           echo $logoTitle;
        } else {
            return $logoTitle;
        }
    }
}

 function hu_render_blog_description() {
     printf( '<a class="site-description--link" href="%1$s" rel="home" title="%3$s"><h1 class="site-description--title">%2$s</h1></a>',
                home_url('/'),
                get_bloginfo('name'),
                sprintf( '%1$s | %2$s', get_bloginfo('name') , __('Home page', 'hueman') )
            );
    echo '<p class="site-description--description">'.get_bloginfo( 'description' ).'</p>';
}

function my_new_contactmethods( $contactmethods ) {
    // Add Degree
    $contactmethods['degree'] = 'Degrees';
    //add Research
    $contactmethods['research'] = 'Research Topic';
    //add Research Interests
    $contactmethods['interests'] = 'Interests';
    //add Title
    $contactmethods['dissertation'] = 'Dissertation Title';
    //add Blog Role
    $contactmethods['blogrole'] = 'Blog Role';
    //add Current degree
    $contactmethods['currdegree'] = 'Current Degree';
   //add LinkedIn
    $contactmethods['linkedin'] = 'LinkedIn';
    //add Academia.edu
    $contactmethods['academia'] = 'Accademia.edu';
    //add Display personal email
    $contactmethods['displayemail'] = 'Display personal email? leave blank if no';
    //add other email
    $contactmethods['otheremail'] = 'Other email address';
    //add HTTPer Profile Link
    $contactmethods['httper'] = 'HTTPer Profile link';

    // remove unwanted
    unset($contactmethods['aim']);
    unset($contactmethods['jabber']);
    unset($contactmethods['yim']);

    return $contactmethods;
}
add_filter('user_contactmethods','my_new_contactmethods',10,1);

/* Author List */
function contributors() {
	global $wpdb;

	$authors = $wpdb->get_results("SELECT ID, user_nicename from $wpdb->users ORDER BY display_name");
	foreach($authors as $author) {
		if ( !((get_the_author_meta('user_level', $author->ID) <= 7 ) && (get_the_author_meta('user_level', $author->ID) >= 2 )) ) {
			continue;
		}
		echo '<div class="img">';
		echo '<div class="desc">';
		echo "<a href=\"".get_author_posts_url($author->ID)."\">";
		the_author_meta('display_name', $author->ID);
		echo "</a></div>";
		echo "<a href=\"".get_author_posts_url($author->ID)."\">";
		echo get_avatar($author->ID);
		echo "</a>";
		echo '</div>';
	}
}

/**
 * Add a "Twitter" field to Co-Authors Plus Guest Author
 */
add_filter( 'coauthors_guest_author_fields', 'capx_filter_guest_author_fields', 10, 2 );
function capx_filter_guest_author_fields( $fields_to_return, $groups ) {
	if ( in_array( 'all', $groups ) || in_array( 'contact-info', $groups ) ) {
		$fields_to_return[] = array(
					'key'      => 'twitter',
					'label'    => 'Twitter',
					'group'    => 'contact-info',
				);
	} 
	return $fields_to_return;
}

/*  Excerpt ending
/* ------------------------------------ */
if ( ! function_exists( 'alx_excerpt_more' ) ) {

	function alx_excerpt_more( $more ) {
		return '&#46;&#46;&#46;';
	}

}

/* forum */
function add_bbp_display_forum_description() {
    echo '<div class="bbp-forum-content">' ;
    bbp_forum_content() ;
    echo '</div>';
    }
add_action( 'bbp_template_before_single_forum' , 'add_bbp_display_forum_description' );

function mycustom_breadcrumb_options() {
    // Home - default = true
    $args['include_home']    = false;
    // Forum root - default = true
    $args['include_root']    = true;
    // Current - default = true
    $args['include_current'] = true;

    return $args;
}

add_filter('bbp_before_get_breadcrumb_parse_args', 'mycustom_breadcrumb_options');

function remove_counts() {
$args['show_topic_count'] = false;
$args['show_reply_count'] = false;
$args['count_sep'] = '';
 return $args;
}
add_filter('bbp_before_list_forums_parse_args', 'remove_counts' );

add_filter('tiny_mce_before_init','configure_tinymce');

/**
 * Customize TinyMCE's configuration
 *
 * @param   array
 * @return  array
 */
function configure_tinymce($in) {
  $in['paste_preprocess'] = "function(plugin, args){
    // Strip all HTML tags except those we have whitelisted
    var whitelist = 'p,span,b,strong,i,em,h1,h2,h3,h4,h5,h6,ul,li,ol,a';
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
      var e = els[i];
      jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class').removeAttr('style');
    // Return the clean HTML
    args.content = stripped.html();
  }";
  return $in;
}

if (!function_exists('write_log')) {
    function write_log ( $log )  {
        if ( true === WP_DEBUG ) {
            if ( is_array( $log ) || is_object( $log ) ) {
                error_log( print_r( $log, true ) );
            } else {
                error_log( $log );
            }
        }
    }
}

add_action( 'rest_api_init', 'slug_register_bitly' );
function slug_register_bitly() {
            register_rest_field( 'post',
                'bitly',
            array(
                'get_callback' => 'slug_get_bitly',
                'update_callback' => null,
                'schema' => null,
            )
        );
    }

    function slug_get_bitly($post, $field_name, $request) {
        return get_post_meta($post['id'], '_wpbitly' );
    }

