<?php
/**
 * The template for displaying the footer
 */
?>
      </div>

    </div>

    <footer>
      <div class="container">
        <div class="row">
          <div class="col-sm-6">

            <strong>ropamarca.es</strong> &copy;<?php echo date("Y"); ?> - Todos los derechos reservados.

          </div>
          <div class="col-sm-6 text-md-right">

            <?php
              wp_nav_menu( array(
                'theme_location' => 'footer',
                'container' => 'div',
                'menu_class' => 'list-inline'
              ) );
            ?>

          </div>
        </div>
      </div>
    </footer>

    <?php wp_footer(); ?>
  </body>
</html>