<?php
/**
 * The template for displaying the header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
  <head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <?php wp_head(); ?>

  </head>
  <body <?php body_class(); ?>>
    <header>
      <div class="container">
        <div class="row">

          <div class="col-md-6 text-center text-md-left">
            <?php
            if ( is_front_page() != true ) {
                echo '<a href="'. esc_url( home_url( '/' ) ) .'" title="Ropa de marca">';
            }
            ?>

              <img src="<?php bloginfo('template_url'); ?>/img/logo.png" alt="Ropa de marca">
            <?php
            if ( is_front_page() != true) {
              echo '</a>';
            }
            ?>
          </div>
            <?php
                if(fastfood_is_woocommerce_activated()){
                    echo '

            <div class="col-sm-6 text-md-right">
                <ul>
                <li class="list-inline-item li-cart">
                    <a href="'.esc_url( wc_get_cart_url() ) . '" title="Ver tu carrito">
                        <i class="fa fa-shopping-cart fs-60" aria-hidden="true"></i>
                        <span class="count">'. WC()->cart->get_cart_contents_count().'</span>
                    </a>
                </li>
                    <li class="list-inline-item">
                        <a href="'.esc_url(fastfood_user_url()).'">
                            <i class="fa fa-user fs-60" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>
            </div>

                    ';
                }
            ?>


        </div>
      </div>

      <div class="menu-bar text-xs-right">
        <nav class="container navbar navbar-expand-sm navbar-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <?php
          wp_nav_menu( array(
              'theme_location' => 'top',
              'container' => 'div',
              'container_class' => 'collapse navbar-collapse',
              'container_id'    => 'navbarSupportedContent',
              'menu_class' => 'menu-list list-inline navbar-nav mr-auto'
          ) );
          ?>
        </nav>

      </div>

    </header>

    <div id="main">
        <?php
        if (!is_home()) : ?>
      <div class="container">
          <?php endif; ?>