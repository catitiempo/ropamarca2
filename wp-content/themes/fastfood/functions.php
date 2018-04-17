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
	'top_right'=> __( 'Top Right Menu', 'fastfood' ),
) );

/*
 * Add classes to main menu
 */
function fastfood_menu_classes($classes, $item, $args) {
  if($args->theme_location == 'top' || $args->theme_location == 'footer' || $args->theme_location == 'top_right') {
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
    wp_enqueue_style( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css' );
    wp_enqueue_style( 'fastfood-styles', get_stylesheet_uri() );

    // JAVASCRIPT
	wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/025d1f53df.js', array(), null);
    wp_enqueue_script( 'popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery'), '1.12.3', true );
    wp_enqueue_script( 'bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'), '4.0.0', true );
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

function get_brands( $display_as, $columns, $hide_empty ){

	$brands = get_terms( 'pwb-brand',array( 'hide_empty' => $hide_empty ) );
    $cadena = '';

	if(is_array($brands) && count($brands)>0){
		 $cadena.= '<ul class="row marcas">';
		foreach ($brands as $brand) {
			$brand_name = $brand->name;
			$brand_link = get_term_link( $brand->term_id );

			$attachment_id = get_term_meta( $brand->term_id, 'pwb_brand_image', 1 );
			$brand_logo = wp_get_attachment_image( $attachment_id, 'full' );

			$li_class = ( $display_as == 'brand_logo' ) ? "col-sm-4" : "";
			 $cadena.= '<li class="'. $li_class .'">';
			if( $display_as == 'brand_logo' && !empty( $brand_logo ) ){
				 $cadena.= '<a href="'.$brand_link.'" title="Ir a '.$brand->name.'">'.$brand_logo.'</a>';
			}else{
				 $cadena.= '<a href="'.$brand_link.'" title="Ir a '.$brand->name.'">'.$brand->name.'</a>';
			}
			 $cadena.= '</li>';
		}
		 $cadena.= '</ul>';
	}else{
		 $cadena.= 'No hay marcas disponibles';
	}
    return $cadena;

}

function fastfood_is_woocommerce_activated() {
	return class_exists( 'WooCommerce' ) ? true : false;
}

function fastfood_user_url(){
	$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
	if ( $myaccount_page_id ) {
		return get_permalink( $myaccount_page_id );
	}
	return "#";
}



// home elements
// slider

add_shortcode('home_slider','fasfood_home_slider');
/**
 * @return string
 */
function fasfood_home_slider(){
    $args = array(
        'post_type' => 'fastfood_slider',
        'posts_per_page' => 5
    );
    $loop = new WP_Query( $args );

    if ($loop->have_posts()) : ?>
    <div class="container-slider">
        <div id="fastfood-slider-home" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                $l = $loop->post_count;
                for ($i = 0; $i < $l; $i++) { ?>
                    <li data-target="#fastfood-slider-home"
                        data-slide-to="<?php echo $i; ?>"
                        <?php if ($i == 0) { ?> class="active"<?php } ?>>
                    </li>
                    <?php
                }
                ?>
            </ol>
            <div class="carousel-inner" role="listbox">
                <?php
                $n = 0;
                while ( $loop->have_posts() ) : $loop->the_post(); ?>
                    <div class="carousel-item <?php if($n == 0) { echo 'active'; } ?>">

                        <?php echo get_the_post_thumbnail( $loop->ID, 'fastfood-featured-image' ); ?>

                        <div class="carousel-caption">

                            <?php the_content(); ?>

                        </div>

                    </div>
                    <?php
                    $n++;
                endwhile;
                ?>
            </div>
        </div>
    </div>
    <div class="container">
        <?php
    endif;
}

add_shortcode('home_marcas','fastfood_home_marcas');

function fastfood_home_marcas(){
    return get_brands('brand_logo',5,false);
}







