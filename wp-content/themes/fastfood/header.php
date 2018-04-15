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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>

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