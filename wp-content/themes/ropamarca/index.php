<?php
/**
 * The template for displaying pages
 */

get_header(); ?>

<?php
// Start the loop.
if(!is_front_page()):
    ?>
    <div class="row">
    <div class="col-md-12">

<?php endif;
// Start the loop.
while ( have_posts() ) : the_post();
    ?>
    <?php
    // Start the loop.
    if(is_front_page()):
        ?>
        <?php the_content(); ?>

    <?php endif;
    if (!is_front_page()):
        ?>
        <article <?php post_class(); ?>>

            <div class="entry-header">
                <h1 class="entry-title"><?php the_title(); ?></h1>
            </div>

            <div class="entry-content">
                <?php the_content(); ?>
            </div>

        </article>
        <?php
    endif;
    ?>

    <?php
    // End of the loop.
endwhile;
?>
<?php
// Start the loop.
if(!is_front_page()):
    ?>
    </div>
    </div>

<?php endif;get_footer(); ?>