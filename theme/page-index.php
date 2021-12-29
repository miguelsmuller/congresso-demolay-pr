<?php
/*
Template Name: Página Inicial
*/
?>
<?php get_header(); ?>
<section id="presentation">
    <div class="container">
        <div class="presentation-content">
            <img src="<?php bloginfo('template_directory'); ?>/assets/images/cpod-big.png" class="logo-presentation-content">
            <div id="countdown" class="countdown"></div>
            <a class="btn btn-lg btn-theme btn-registry" href="<?php echo get_permalink( get_theme_mod( 'pagina_inscricao', 'default_value' ) ); ?>" role="button">FAÇA SUA INSCRIÇÃO AGORA</a>
        </div>
    </div>
</section>

<section id="about">
    <div class="container">
        <div class="panel panel-theme">
            <div class="color-bar"></div>
            <div class="panel-heading">
                <h3 class="panel-title">CPOD - Maringá</h3>
                <p class="text-muted">Congresso Paranaense da Ordem DeMolay</p>
            </div>
            <div class="panel-body">
                <?php the_field('txt_sobre'); ?>
            </div>
        </div>
    </div>
</section>

<section id="schedule">
    <div class="container">
        <div class="panel panel-theme">
            <div class="color-bar"></div>
            <div class="panel-heading">
                <h3 class="panel-title">Programação</h3>
            </div>
            <div class="panel-body panel-body-nospace">
                <ul class="nav nav-justified nav-tabs nav-theme">
                    <li class="active"><a href="#manha" data-toggle="tab">Manhã</a></li>
                    <li><a href="#tarde" data-toggle="tab">Tarde</a></li>
                    <li><a href="#jantar" data-toggle="tab">Jantar de gala</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="manha">
                        <?php the_field('txt_programacao_manha'); ?>
                    </div>
                    <div class="tab-pane" id="tarde">
                        <?php the_field('txt_programacao_tarde'); ?>
                    </div>
                    <div class="tab-pane" id="jantar">
                        <?php the_field('txt_programacao_jantar'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="speakers">
    <div class="container">
        <div class="panel panel-theme">
            <div class="color-bar"></div>
            <div class="panel-heading">
                <h3 class="panel-title">Presenças confirmadas</h3>
            </div>
            <div class="panel-body">
                <?php the_field('txt_presencas'); ?>
            </div>
        </div>
        <div class="speakers-list">
            <?php
                $pesonalidades = new WP_Query( array(
                    'post_type' => 'pesonalidade',
                    'orderby'=> 'date',
                    'order'=> 'DESC'
                ) );
            ?>
            <?php
            while ( $pesonalidades->have_posts() ) : $pesonalidades->the_post();
            ?>
                <?php
                    $thumb      = get_post_thumbnail_id();
                    $img_url    = wp_get_attachment_url( $thumb,'full' );
                    $image      = aq_resize( $img_url, 500, 500, true );
                ?>
                <div class="speaker">
                    <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="img-responsive">
                </div>
            <?php
            endwhile;
            ?>
        </div>
    </div>
</section>

<section id="hotels">
    <div class="container">
        <div class="panel panel-theme">
            <div class="color-bar"></div>
            <div class="panel-heading">
                <h3 class="panel-title">Hotéis</h3>
            </div>
            <div class="panel-body">
                <article>
                    <?php the_field('txt_parceiros'); ?>
                </article>
                <div class="hotels-list">
                    <?php
                        $parceiros = new WP_Query( array(
                            'post_type' => 'hotel',
                            'orderby'=> 'date',
                            'order'=> 'DESC'
                        ) );
                    ?>
                    <?php
                    while ( $parceiros->have_posts() ) : $parceiros->the_post();
                    ?>
                        <?php
                            $thumb      = get_post_thumbnail_id();
                            $img_url    = wp_get_attachment_url( $thumb,'full' );
                            $image      = aq_resize( $img_url, 350, 175, true );
                        ?>
                        <div class="hotel">
                            <a href="<?php echo get_post_meta( $post->ID, 'site_hotel', true ); ?>" target="_blank">
                                <img src="<?php echo $image ?>" alt="<?php the_title(); ?>" class="img-responsive" data-container="body" data-toggle="popover" data-placement="top" data-content="<?php echo get_post_meta( $post->ID, 'details_hotel', true ); ?>" data-original-title="Informações do hotel">
                            </a>
                        </div>
                    <?php
                    endwhile;
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="faq">
    <div class="container">
        <div class="panel panel-theme">
            <div class="color-bar"></div>
            <div class="panel-heading">
                <h3 class="panel-title">Dúvidas</h3>
            </div>
            <div class="panel-body">
                <?php
                    $duvidas = new WP_Query( array(
                        'post_type' => 'faq',
                        'orderby'=> 'date',
                        'order'=> 'DESC'
                    ) );

                    $duvidas_halt = ceil($duvidas->post_count / 2);
                    $duvidas_count = 1;
                ?>
                <?php
                while ( $duvidas->have_posts() ) : $duvidas->the_post();
                ?>
                    <?php if ($duvidas_count == 1){ ?>
                        <div class="col-md-6 col-sm-12">
                        <div class="panel-group" id="accordion">
                    <?php } ?>

                        <div class="panel panel-accordion">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#accordion-<?php the_ID(); ?>">
                                    <?php the_title(); ?>
                                    </a>
                                </h4>
                            </div>
                            <div id="accordion-<?php the_ID(); ?>" class="panel-collapse collapse">
                                <div class="panel-body">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>

                    <?php if ($duvidas_count == 1){ ?>
                        <?php $duvidas_count = $duvidas_count + 1; ?>
                    <?php }elseif ($duvidas_count >= $duvidas_halt){?>
                        </div>
                        </div>
                        <?php $duvidas_count = 1 ?>
                    <?php } ?>
                <?php
                endwhile;
                ?>
            </div>
        </div>
    </div>
</section>

<section id="contact">
    <div class="container">
        <div class="panel panel-theme">
            <div class="color-bar"></div>
            <div class="panel-heading">
                <h3 class="panel-title">Contato</h3>
            </div>
            <div class="panel-body">
                <div class="mapa">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29287.458342230042!2d-51.93099602228586!3d-23.42681286997036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ecd732b9b29325%3A0xd630b8b8d3898d8e!2sC%C3%A2mara+Municipal+de+Maringa!5e0!3m2!1spt-BR!2s!4v1401980510821" width="100%" height="250" frameborder="0" style="border:0" scrolling="no"></iframe>
                </div>
                <div class="form-contact">
                    <?php echo do_shortcode( get_theme_mod( 'form_contact', 'default_value' ) ) ?>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php get_footer(); ?>
