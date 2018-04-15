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

          <div class="col-md-6">

            <ul class="social-header list-inline text-center text-md-right">
              <li class="list-inline-item">
                <a href="#">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                      </span>
                  </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                      </span>
                  </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
                      </span>
                  </a>
              </li>
              <li class="list-inline-item">
                <a href="#">
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                      </span>
                  </a>
              </li>
            </ul>

          </div>
        </div>
      </div>

      <div class="menu-bar text-xs-right">
        <nav class="navbar navbar-expand-sm navbar-light">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <?php
          wp_nav_menu( array(
              'theme_location' => 'top',
              'container' => 'div',
              'container_class' => 'collapse navbar-collapse',
              'menu_class' => 'menu-list list-inline navbar-nav mr-auto'
          ) );
          ?>
        </nav>

      </div>

    </header>

    <div id="main">
      <div class="container">