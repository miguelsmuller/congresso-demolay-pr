<li>
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

        <header class="content-title">
            <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
        </header>

        <div class="content-entry">
            <?php the_excerpt(); ?>
            <p><a class="btn btn-primary" href="<?php the_permalink() ?>">Leia mais</a></p>
        </div>

        <footer class="content-footer">
            <ul class="list-inline list-unstyled">
                <li>
                    <i class="icon-user"></i> <a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta( 'nickname' ); ?></a>
                </li>
                <li>
                    <i class="icon-calendar"></i> <?php the_time('d/m/Y'); ?>
                </li>
                <li>
                    <i class="icon-comment"></i> <a href="<?php comments_link(); ?>"><?php comments_number(); ?></a>
                </li>
                <li>
                    <i class="icon-tags"></i> Tags :
                    <?php
                    $posttags = get_the_tags();
                    if ($posttags) :
                        foreach($posttags as $tag) {
                            echo '<a href="'.get_tag_link($tag->term_id).'"><span class="label label-primary">'.$tag->name.'</span></a> ';
                        }
                    endif;
                    ?>
                </li>
            </ul>
        </footer>

        <hr>

    </article>
</li>