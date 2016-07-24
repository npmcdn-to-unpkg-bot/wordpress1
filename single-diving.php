<?php
/**
 * The template for displaying diving posts
 */
?>

<?php
get_header();
// start loop
while (have_posts()) : the_post();
    ?>
    <!-- post content section-->
    <div class="upper-wrapper">
        <div class="content-template">
            <div class="wrapper">
                <div class="left-content">
                    <h1><?php the_title(); ?></h1>
                    <?php
                    add_filter('the_content', 'wpautop');
                    the_content();
                    edit_post_link(__('Edit','mantaray'),'<span class="edit-link">', '</span>');
                    ?>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </div>
    <?php
    endwhile;
    ?>
</main>
<?php
get_footer();
