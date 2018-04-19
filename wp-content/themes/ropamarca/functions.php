<?php

function my_theme_setup() {
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'my_theme_setup' );

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

function my_before_main_content() {
    echo '<!-- Starting content wrapper for your theme -->';
    echo '<div class="container"><div class="row"><div class="col-sm-12">';
}
add_action( 'woocommerce_before_main_content', 'my_before_main_content' );

function my_after_main_content() {
    echo '</div></div></div>';
    echo '<!-- Ending content wrapper for your theme -->';
}
add_action( 'woocommerce_after_main_content', 'my_after_main_content' );

// remove category-product from slug
//add_filter('term_link', 'term_link_filter', 10, 3);
//function term_link_filter( $url, $term, $taxonomy ) {
//    $url=str_replace("/./","/",$url);
//    return $url;
//}

//add_filter('request', function( $vars ) {
  //  print_r($vars);
    //global $wpdb;
    //if( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
    //    $slug = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( !empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
    //    $exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s" ,array( $slug )));
    //    if( $exists ){
    //        $old_vars = $vars;
    //        $vars = array('product_cat' => $slug );
    //        if ( !empty( $old_vars['paged'] ) || !empty( $old_vars['page'] ) )
    //            $vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
    //        if ( !empty( $old_vars['orderby'] ) )
    //            $vars['orderby'] = $old_vars['orderby'];
    //        if ( !empty( $old_vars['order'] ) )
    //            $vars['order'] = $old_vars['order'];
    //    }
    //}
  //  return $vars;
//});

add_filter( 'term_link', function($termlink){ return str_replace('/./', '/', $termlink); }, 10, 1 );

// Eliminar los CSS de WooCommerce uno por uno
//add_filter( 'woocommerce_enqueue_styles', 'woocommerce_dequeue_styles' );
//function woocommerce_dequeue_styles( $enqueue_styles ) {
  //  unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
   // unset( $enqueue_styles['woocommerce-layout'] ); // Remove the layout
   // unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
   // return $enqueue_styles;
//}

// Eliminar todos los CSS de WooCommerce de golpe
//add_filter( 'woocommerce_enqueue_styles', '__return_false' );
function load_ropamarca_scripts()
{
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Roboto:400,500,700');
    wp_enqueue_style('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css');
    wp_enqueue_style('ropamarca-styles', get_stylesheet_uri());

// JAVASCRIPT
    wp_enqueue_script('fontawesome', 'https://use.fontawesome.com/025d1f53df.js', array(), null);
    wp_enqueue_script('popper', 'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js', array('jquery'), '1.12.3', true);
    wp_enqueue_script('bootstrap', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js', array('jquery'), '4.0.0', true);
//wp_enqueue_script( 'ropamarca-scripts', get_template_directory_uri() . '/js/general.js', array('jquery'), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'load_ropamarca_scripts' );

// header

function ropamarca_is_woocommerce_activated() {
    return class_exists( 'WooCommerce' ) ? true : false;
}

function ropamarca_user_url(){
    $myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
    if ( $myaccount_page_id ) {
        return get_permalink( $myaccount_page_id );
    }
    return "#";
}

// menús
/*
 * Enable support for Post Thumbnails on posts and pages.
 */
add_theme_support( 'post-thumbnails' );

add_image_size( 'ropamarca-featured-image', 2000, 1200, true );

add_image_size( 'ropamarca-thumbnail-avatar', 100, 100, true );

// This theme uses wp_nav_menu() in two locations.
register_nav_menus( array(
    'top'    => __( 'Top Menu', 'ropamarca' ),
    'top_right'=> __( 'Top Right Menu', 'ropamarca' ),
    'footer' => __( 'Footer Menu', 'ropamarca' ),
) );

/*
 * Add classes to main menu
 */
function ropamarca_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'top' || $args->theme_location == 'footer' || $args->theme_location == 'top_right') {
        $classes[] = 'list-inline-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class','ropamarca_menu_classes',1,3);


// slider home

/*
 * Define custom post type
 * Register post types: https://codex.wordpress.org/Function_Reference/register_post_type
 * Icons: https://developer.wordpress.org/resource/dashicons/
 */
function ropamarca_post_type() {
    register_post_type( 'ropamarca_slider',
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
add_action( 'init', 'ropamarca_post_type' );

/*
* Define shortcodes
* https://codex.wordpress.org/Shortcode_API
*/

// Create the new shortcode [ropamarca_head] with the callback ropamarcaBtnFunc
add_shortcode("ropamarca_headings", "ropamarcaHeadingsFunc");

// Add parameters to function
function ropamarcaHeadingsFunc($atts, $content = null) {
    return "<" . $atts['type'] . " class='" . $atts['class'] . "'>" . $content . "</" . $atts['type'] . ">";
}

// Create the new shortcode [ropamarca_btn] with the callback ropamarcaBtnFunc
add_shortcode("ropamarca_btn", "ropamarcaBtnFunc");

// Add parameters to function
function ropamarcaBtnFunc($atts, $content = null) {
    return "<" . $atts['type'] . " class='" . $atts['class'] . "' href='" . $atts['link'] . "'>" . $content . "</" . $atts['type'] . ">";
}


// home elements
// slider

add_shortcode('home_slider','fasfood_home_slider');
/**
 * @return string
 */
function fasfood_home_slider(){
    $args = array(
        'post_type' => 'ropamarca_slider',
        'posts_per_page' => 5
    );
    $loop = new WP_Query( $args );

    if ($loop->have_posts()) : ?>
        <div class="container-slider">
            <div id="ropamarca-slider-home" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $l = $loop->post_count;
                    for ($i = 0; $i < $l; $i++) { ?>
                        <li data-target="#ropamarca-slider-home"
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

                            <?php echo get_the_post_thumbnail( $loop->ID, 'ropamarca-featured-image' ); ?>

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

function ropamarca_print_custom_breadcrumb($breadcrumb){
    //$breadcrumb = $breadcrumb[0];
    print_r('<nav class="woocommerce-breadcrumb">');
    foreach($breadcrumb as $bc){
        if($bc[1]!='')
            print_r('<a href="'.$bc[1].'">'.$bc[0].'</a>&nbsp;/&nbsp;');
        else
            print_r($bc[0]);
    }
    print_r('</nav>');

//    <a href="https://localhost/ropamarca">Inicio</a>&nbsp;/&nbsp;
//    <a href="https://localhost/ropamarca/mujer/">Mujer</a>&nbsp;/&nbsp;
//    Camisetas

}