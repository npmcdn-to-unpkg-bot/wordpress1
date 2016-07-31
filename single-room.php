
<?php
get_header();
// start loop
while (have_posts()) : the_post();

    $terms = wp_get_post_terms($post->ID, 'floors');
    ?>
    <!-- post content section-->
    <div class="upper-wrapper">
        <div class="content-template">
            <div class="wrapper">
                <div class="left-content">
                    <div class="fb-like" data-href="<?php the_permalink(); ?>" data-layout="button" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
                    <h1><?php the_title(); ?></h1>
                    <?php if (get_field('room_heading')) : ?>
                        <h2><?php the_field('room_heading'); ?></h2>
                    <?php endif; ?>
                    <div class="room-content">
                        <?php if (get_field('features')) : ?>
                            <aside class="room-features">
                                <h3>This Room Features</h3>
                                <?php the_field('features'); ?>
                            </aside>
                        <?php endif; ?>
                        <div class="room-details">
                            <?php
                            add_filter('the_content', 'wpautop');
                            the_content();
                            ?>
                        </div>

                    </div>
                    <div class="virtual">
                        <h4>Take a Virtual Tour</h4>
                        <?php
                        if (get_field('room_images')) :
                            the_field('room_images');
                        endif;
                        ?>
                    </div>
                    <?php edit_post_link(__('Edit', 'mantaray'), '<span class="edit-link">', '</span>'); ?>
                </div>
                <?php
            endwhile;
            get_sidebar();
            ?>
        </div>
    </div>
</div>
<div class="room-floor">
    <div class="wrapper">
        <div class="floor-left">
            <div class="head-logo">
                <img alt="" src="<?php bloginfo('template_url') ?>/images/logo2.png">
                <h2>Special Events &amp; Packages</h2>
            </div>
            <img src="<?php bloginfo('template_url') ?>/images/block1.png" usemap="#1st_floor">
        </div>
        <div class="floor-right">
            <span><a href="<?php echo $url; ?>/room/308/"><img alt="" src="<?php bloginfo('template_url') ?>/images/floor2.png"></a></span>
            <span><a href="<?php echo $url; ?>/room/200/"><img alt="" src="<?php bloginfo('template_url') ?>/images/floor3.png"></a></span>
            <span><a href="<?php echo $url; ?>/room/101/"><img alt="" src="<?php bloginfo('template_url') ?>/images/floor4.png"></a></span>
        </div>
    </div>
   <map name="1st_floor">
        <area target="_self" coords="190,180,250,270" shape="rect" href="<?php echo $url; ?>/room/101/">
        <area target="_self" coords="250,160,300,250" shape="rect" href=" <?php echo $url; ?>/room/102/">
        <area target="_self" coords="300,160,360,230" shape="rect" href=" <?php echo $url; ?>/room/103/">
        <area target="_self" coords="260,10,320,150" shape="rect" href=" <?php echo $url; ?>/room/104/">
        <area target="_self" coords="190,70,260,150" shape="rect" href=" <?php echo $url; ?>/room/105/">
        <area target="_self" coords="0,190,55,280" shape="rect" href=" <?php echo $url; ?>/room/107/">
        <area target="_self" coords="55,190,120,290" shape="rect" href=" <?php echo $url; ?>/room/106/">
<!--    <area target="_self" style="outline:none;" coords="495,102,514,174,548,166,528,95" shape="poly" href=" /room/104/" title="" alt="">-->
    </map>
</div>
</main>
<?php get_footer(); ?>







