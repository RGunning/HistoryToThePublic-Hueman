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

function http-hueman_enqueue_styles() {

    $parent_style = 'hueman-main-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'http-hueman-main-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
add_action( 'wp_enqueue_scripts', 'http-hueman_enqueue_styles' );



function hu_site_title() {
	// Text or image?
	if ( false != hu_get_img_src_from_option( 'custom-logo' ) ) {
		$logo = '<img src="'. hu_get_img_src_from_option( 'custom-logo' ) . '" alt="'.get_bloginfo('name').'">';
	} else {
		$logo = get_bloginfo('name');
	}

	if ( hu_is_checked('site-description') ) {
		$description= get_bloginfo('description');
	} else {
		$description= '';
	}

	$link = '<a href="'.home_url('/').'" rel="home">'.$logo.'</a>';
	$title = '<a href="'.home_url('/').'" rel="home">'.get_bloginfo('name').'</a>';

	if ( is_front_page() || is_home() ) {
		$sitename = '<div class="site-title">';
		$sitename .= $link;
		$sitename .= '<h1>'.$title.'</h1>';
		$sitename .= '<p class="site-description">'.$description.'</p></div>';
	} else {
		$sitename = '<div class="site-title">';
		$sitename .= $link;
		$sitename .= '<h1>'.$title.'</h1>';
		$sitename .= '<p class="site-description">'.$description.'</p></div>';
	}

	return $sitename;
}

// function add_facebook_app_id(){
//         echo '<meta property="fb:app_id" content="1575818135986208">';
// }
// add_action('wp_head', 'add_facebook_app_id');
//
//function msapplication(){
//	if (has_site_icon()) {
//		// User set a Site Icon, do something awesome!
//		get_site_icon_url()
//	}
//	else {
//		// User didn't set a Site Icon, do something else. But still awesome.
//	}
//	$logo = ot_get_option('custom-logo');
//	$output = '<meta name="msapplication-square70x70logo" content="small.jpg"/>';
//	$output .= '<meta name="msapplication-square150x150logo" content="medium.jpg"/>';
//	$output .= '<meta name="msapplication-wide310x150logo" content="wide.jpg"/>';
//	$output .= '<meta name="msapplication-square310x310logo" content="large.jpg"/>';
//	$output .= '<meta name="msapplication-TileColor" content="#2998d0"/>';
//	$output .= '<meta name="msapplication-notification" content="frequency=30;polling-uri=http://notifications.buildmypinnedsite.com/?feed=http://historytothepublic.org/feed/&amp;id=1;polling-uri2=http://notifications.buildmypinnedsite.com/?feed=http://historytothepublic.org/feed/&amp;id=2;polling-uri3=http://notifications.buildmypinnedsite.com/?feed=http://historytothepublic.org/feed/&amp;id=3;polling-uri4=http://notifications.buildmypinnedsite.com/?feed=http://historytothepublic.org/feed/&amp;id=4;polling-uri5=http://notifications.buildmypinnedsite.com/?feed=http://historytothepublic.org/feed/&amp;id=5; cycle=1"/>';
//echo $output;
//}
//add_action('wp_head', 'msapplication');






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
