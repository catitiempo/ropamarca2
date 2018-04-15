<?php
/**
 * The template for displaying posts
 */

get_header(); ?>

        <div class="row">
          <div class="col-md-12">

            <?php
              // Start the loop.
              while ( have_posts() ) : the_post();
              ?>

                <article <?php post_class(); ?>>

                  <div class="row">

                    <div class="col-sm-9">

                      <div class="post-thumbnail">
                        <?php if ( has_post_thumbnail() ) {
                          the_post_thumbnail();
                        } ?>
                      </div>

                      <div class="entry-header">
                        <h1 class="entry-title"><?php the_title(); ?></h1>
                      </div>

                      <div class="entry-content">
                        <?php the_content(); ?>
                      </div>

                      <?php
                        // If comments are open or we have at least one comment, load up the comment template.
                        if ( comments_open() || get_comments_number() ) :
                          comments_template();
                        endif;
                      ?>

                    </div>

                    <div class="col-sm-3">
                      <?php if ( is_active_sidebar( 'sidebar-posts' ) ) : ?>
                          <?php dynamic_sidebar( 'sidebar-posts' ); ?>
                      <?php endif; ?>
                    </div>

                  </div>

                </article>

              <?php
              // End of the loop.
              endwhile;
            ?>

          </div>
        </div>

<?php get_footer(); ?>