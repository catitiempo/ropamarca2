<?php
/**
 * The main template file
 */

get_header();
?>

        <?php
        $args = array(
          'post_type' => 'fastfood_slider',
          'posts_per_page' => 3
          );
        $loop = new WP_Query( $args );

        if ($loop->have_posts()) : ?>
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
        <?php
        endif;
        ?>
        
        <div class="row mar-top-80">
          <div class="col-md-6">
            <h3>El restaurante <strong>fastfood</strong> <i class="fa fa-spoon pull-right hidden-xs-down" aria-hidden="true"></i></h3>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eleifend in mauris in suscipit. Aliquam mollis dolor vel nisl posuere, in venenatis nibh ultricies. Etiam condimentum vel nulla id volutpat. Etiam et egestas purus. Maecenas porttitor, erat quis lobortis feugiat, elit sapien tempus ante, nec egestas nisl tortor sit amet nunc.</p>

            <p>Vestibulum leo ligula, malesuada et risus at, euismod iaculis quam. Cras ac velit fringilla, vestibulum dolor in, tempus massa. Sed sed euismod libero. Ut vitae suscipit tortor. Mauris augue est, convallis sed felis ac, auctor rhoncus lorem. Proin tincidunt justo ac vestibulum tincidunt.</p>

          </div>
          <div class="col-md-6">
            <h3>Dónde encontrar <strong>fastfood</strong> <i class="fa fa-map-marker pull-right hidden-xs-down" aria-hidden="true"></i></h3>

            <p>Estamos en la Calle de las lechugas, nº 24. Mallorca, España.</p>

            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d49208.66213840587!2d2.6457357819800222!3d39.56994739486192!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12979259c61ac757%3A0xc40d5406c3d058c6!2sPalma+de+Mallorca%2C+Islas+Baleares!5e0!3m2!1ses!2ses!4v1480101923451" width="100%" height="205" frameborder="0" style="border:0" allowfullscreen></iframe>
          </div>

        </div>

        <div class="row mar-top-80">

          <div class="col-md-12">

            <h3>El restaurante <strong>fastfood</strong> por dentro <i class="fa fa-camera pull-right hidden-xs-down" aria-hidden="true"></i></h3>

            <div class="row">
              <div class="col-sm-4">
                <img src="<?php bloginfo('template_url'); ?>/img/gallery01.jpg" alt="Imagen 1" class="img-fluid">
              </div>
              <div class="col-sm-4">
                <img src="<?php bloginfo('template_url'); ?>/img/gallery02.jpg" alt="Imagen 2" class="img-fluid">
              </div>
              <div class="col-sm-4">
                <img src="<?php bloginfo('template_url'); ?>/img/gallery03.jpg" alt="Imagen 3" class="img-fluid">
              </div>
            </div>

          </div>

        </div>

        <div class="row mar-top-80 sidebars-zone">
          <div class="col-sm-4">
            <h4>Visita <strong>fastfood</strong></h4>

            <p>Estamos abiertos de martes a domingo de las 12h del mediodía hasta las 24h de la noche.</p>

            <p>Podrás encontrarnos en la calle de las lechugas número 24, Mallorca, España.</p>

            <p>Para reservas puedes consultar nuestro <strong>apartado de contacto</strong> o llamarnos al 612 345 678.</p>
          </div>
          <div class="col-sm-4">
            <h4>Ofertas recomendadas</h4>

            <ul class="list-unstyled">
              <li>
                <a href="#">Menú de fin de semana 2x1 en hamburguesas</a>
              </li>
              <li>
                <a href="#">Cena para parejas los martes</a>
              </li>
              <li>
                <a href="#">Menú "come hasta explotar"</a>
              </li>
              <li>
                <a href="#">La mega hamburguesa</a>
              </li>
            </ul>

          </div>
          <div class="col-sm-4">
            <h4>Síguenos en las redes sociales</h4>

            <ul class="list-unstyled">
              <li>
                <a href="#">Facebook</a>
              </li>
              <li>
                <a href="#">Twitter</a>
              </li>
              <li>
                <a href="#">Youtube</a>
              </li>
              <li>
                <a href="#">Instagram</a>
              </li>
            </ul>

          </div>
        </div>

<?php
get_footer();
?>