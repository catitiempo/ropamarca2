<?php
/**
 * Fastfood functions and definitions
 */

/*
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support( 'post-thumbnails' );

add_image_size( 'fastfood-featured-image', 2000, 1200, true );

add_image_size( 'fastfood-thumbnail-avatar', 100, 100, true );

// This theme uses wp_nav_menu() in two locations.
register_nav_menus( array(
	'top'    => __( 'Top Menu', 'fastfood' ),
	'footer' => __( 'Footer Menu', 'fastfood' ),
) );

/*
 * Add classes to main menu
 */
function fastfood_menu_classes($classes, $item, $args) {
  if($args->theme_location == 'top' || $args->theme_location == 'footer') {
    $classes[] = 'list-inline-item';
  }
  return $classes;
}
add_filter('nav_menu_css_class','fastfood_menu_classes',1,3);

/*
 * Define custom post type
 * Register post types: https://codex.wordpress.org/Function_Reference/register_post_type
 * Icons: https://developer.wordpress.org/resource/dashicons/
 */
 function fastfood_post_type() {
 	register_post_type( 'fastfood_slider',
 		array(
	      'labels' => array(
	        'name' => __( 'Carousel' ),
	        'singular_name' => __( 'Item' ),
	        'add_new' => __( 'Nuevo item' ),
	        'add_new_item' => __( 'Añadir nuevo item' ),
	        'edit_item' => __( 'Editar item' ),
	        'featured_image' => __( 'Imagen del slide' )
	      ),
	      'public' => true,
	      'exclude_from_search' => true,
	      'has_archive' => false,
	      'show_in_nav_menus' => false,
	      'menu_icon' => 'dashicons-slides',
	      //'rewrite' => array('slug' => 'carousel'),
	      'supports' => array('title', 'editor', 'thumbnail')

    	)
  	);
 }
 add_action( 'init', 'fastfood_post_type' );

 /*
 * Define shortcodes
 * https://codex.wordpress.org/Shortcode_API
 */

// Create the new shortcode [fastfood_head] with the callback fastfoodBtnFunc
add_shortcode("fastfood_headings", "fastfoodHeadingsFunc");

// Add parameters to function
function fastfoodHeadingsFunc($atts, $content = null) {
	return "<" . $atts['type'] . " class='" . $atts['class'] . "'>" . $content . "</" . $atts['type'] . ">";
}

// Create the new shortcode [fastfood_btn] with the callback fastfoodBtnFunc
add_shortcode("fastfood_btn", "fastfoodBtnFunc");

// Add parameters to function
function fastfoodBtnFunc($atts, $content = null) {
	return "<" . $atts['type'] . " class='" . $atts['class'] . "' href='" . $atts['link'] . "'>" . $content . "</" . $atts['type'] . ">";
}

// Register sidebars
add_action( 'widgets_init', 'fastfoodWidgetsInit' );

function fastfoodWidgetsInit() {
    register_sidebar( array(
        'name' => __( 'Posts sidebar', 'fastfood' ),
        'id' => 'sidebar-posts',
        'description' => __( 'Widgets in this area will be shown on all posts.', 'fastfood' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget'  => '</div>',
	'before_title'  => '<h2 class="widgettitle">',
	'after_title'   => '</h2>',
    ) );
}

// Load scripts
function load_fastfood_scripts() {
	// CSS
	wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700' );
    //wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' );
    wp_enqueue_style( 'fastfood-styles', get_stylesheet_uri() );

    // JAVASCRIPT
    //wp_deregister_script('jquery');
	//wp_enqueue_script('jquery', 'https://code.jquery.com/jquery-3.2.1.slim.min.js', array(), '3.2.1');
	wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/025d1f53df.js', array(), null);
    //wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js', array('jquery'), '1.12.3', true );
   // wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js', array('jquery'), '4.0.0', true );
    wp_enqueue_script( 'fastfood-scripts', get_template_directory_uri() . '/js/general.js', array('jquery'), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'load_fastfood_scripts' );

// Comments

function move_comment_field( $fields ) {
    $comment_field = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;
    return $fields;
}

add_filter( 'comment_form_fields', 'move_comment_field' );

function fastfood_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
			?>
		    <li class="comment">
		        <p><?php _e( 'Pingback:', 'fastfood' ); ?> <?php comment_author_link(); ?>
		        	<?php edit_comment_link( __( '(Edit)', 'fastfood' ), ' ' ); ?></p>
		    	<?php
		    break;

		default : ?>
			<li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID(); ?>">
				<article id="comment-<?php comment_ID(); ?>">
					<div class="comment-meta">
		                <div class="comment-author vcard">

		                	<?php $args = [
		                        "class" => "avatar avatar-60 photo"
		                    ];
		                    echo get_avatar( $comment, 60 ); ?>

		                    <?php
		                    printf( __( '<b class="fn">%s</b> <span class="says hide">says:</span>', 'fastfood' ),
	                    	sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) );
	                    	?>

	                    	<div class="comment-content">
	                    		<?php comment_text(); ?>
	                    	</div>

	                    	<div class="comment-metadata">
                    			<a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
		                            <time pubdate datetime="<?php comment_time( 'c' ); ?>">
		                                <?php
		                                /* translators: 1: date, 2: time */
		                                printf(
		                                	__( '%1$s at %2$s', 'fastfood' ),
		                                	get_comment_date(),
		                                	get_comment_time() );
		                                ?>
		                            </time>
		                        </a>
		                        <?php edit_comment_link( __( '(Edit)', 'fastfood' ), ' ' ); ?>
	                    	</div>

	                    	<div class="reply">
                    			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth ) ) ); ?>
	                    	</div>

	                    	<?php if ( $comment->comment_approved == '0' ) : ?>
	                    		<em><?php _e( 'Your comment is awaiting moderation.', 'fastfood' ); ?></em>
	                    	<?php endif; ?>

		                </div>
		            </div>
				</article>
			</li>
			<?php
			break;
	endswitch;
}
















