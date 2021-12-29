<?php
/*
Template Name: Página de Inscrição
*/
?>
<?php get_header(); ?>
<section id="page">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>

        <div class="panel panel-theme">
            <div class="color-bar"></div>
            <div class="panel-heading">
                <h3 class="panel-title"><?php the_title(); ?></h3>
                <p class="text-muted">Formulário de Inscrição</p>
            </div>
            <div class="panel-body">
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <?php the_content(); ?>
                </article>
            </div>
        </div>

        <?php endwhile; ?>
    </div>
</section>
<?php get_footer(); ?>
