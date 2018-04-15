<?php
/**
 * The main template file
 */

get_header();
?>

        <?php
        $args = array(
          'post_type' => 'fastfood_slider',
          'posts_per_page' => 5
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
          <div class="container">
        <?php
        endif;
        ?>
        
        <div class="row mar-top-20">
          <div class="col-md-12">
            <h1>Ropa de marca</h1>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eleifend in mauris in suscipit. Aliquam mollis dolor vel nisl posuere, in venenatis nibh ultricies. Etiam condimentum vel nulla id volutpat. Etiam et egestas purus. Maecenas porttitor, erat quis lobortis feugiat, elit sapien tempus ante, nec egestas nisl tortor sit amet nunc.</p>

          </div>
          <div class="col-md-12">
            <h2>Las mejores marcas de ropa españolas</h2>
            <p>ropamarca.es cuenta con las mejores marcas Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eleifend in mauris in s</p>
            <?php
            get_brands('brand_logo',5,false);
            ?>
            </div>

        </div>

        <div class="row mar-top-80 sidebars-zone">
          <div class="col-sm-12">
            <h3>Venta de ropa de marca online</h3>
            Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum
            <h3>Compra de ropa de marca barata</h3>
            Lorem Ipsum es simplemente el texto de relleno de las imprentas y archivos de texto. Lorem Ipsum ha sido el texto de relleno estándar de las industrias desde el año 1500, cuando un impresor (N. del T. persona que se dedica a la imprenta) desconocido usó una galería de textos y los mezcló de tal manera que logró hacer un libro de textos especimen. No sólo sobrevivió 500 años, sino que tambien ingresó como texto de relleno en documentos electrónicos, quedando esencialmente igual al original. Fue popularizado en los 60s con la creación de las hojas "Letraset", las cuales contenian pasajes de Lorem Ipsum, y más recientemente con software de autoedición, como por ejemplo Aldus PageMaker, el cual incluye versiones de Lorem Ipsum
          </div>
        </div>

<?php
get_footer();
?>