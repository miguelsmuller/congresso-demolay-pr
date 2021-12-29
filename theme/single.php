<?php get_header(); ?>

<main class="container" role="main">
    <div class="row">

        <section class="col-sm-12 col-md-9">
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header>
                        <h1><?php the_title(); ?></h1>
                    </header>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>

                <?php
                    if ( comments_open() || '0' != get_comments_number() )
                        comments_template();
                ?>

            <?php endwhile; ?>
        </section>

        <aside class="col-sm-12 col-md-3">
            <?php dynamic_sidebar('sidebar-principal'); ?>
        </aside>

    </div>
</main>

<?php get_footer(); ?>