<a href="<?php the_permalink(); ?>">

    <div class="jumbotron">
        <?php
        if (has_post_thumbnail()) {

            ?>
            <div class="jumbotron-photo">
                <?php
                the_post_thumbnail( 'full', array( 'class' => 'img-rounded img-responsive' ) );
                ?>
            </div>
            <?php
        }
        ?>
        <div class="jumbotron-contents">
            <h2><?php the_title(); ?></h2>
            <i><?php get_template_part( 'templates/entry-meta' ); ?></i>
            <?php the_excerpt(); ?>
        </div>
    </div>
</a>
<hr />