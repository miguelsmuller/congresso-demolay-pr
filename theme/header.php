<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php wp_title( '|', true, 'right' ); ?></title>

    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

    <link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-72.png">
    <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory'); ?>/assets/images/icons/favicon-57.png">

    <?php wp_head();?>

    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/assets/components/superslides/dist/stylesheets/superslides.css">
</head>
<body <?php body_class(); ?>>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-51701964-1', 'cpodmaringa.com.br');
      ga('send', 'pageview');

    </script>
    <?php do_action( 'after_body' ); ?>

    <div id="slides">
        <div class="slides-container">
            <img src="<?php bloginfo('template_directory'); ?>/assets/images/background-cidade-1.jpg" alt="<?php bloginfo( 'name' ); ?>">
            <img src="<?php bloginfo('template_directory'); ?>/assets/images/background-cidade-2.jpg" alt="<?php bloginfo( 'name' ); ?>">
            <img src="<?php bloginfo('template_directory'); ?>/assets/images/background-cidade-3.jpg" alt="<?php bloginfo( 'name' ); ?>">
        </div>
    </div>

    <div id="wrap">
        <section id="top">
            <header>
                <div class="color-bar"></div>
                <div class="container">

                    <div class="row">
                        <div class="col-md-3 col-sm-2">
                            <a href="<?php bloginfo('url'); ?>"><img src="<?php bloginfo('template_directory'); ?>/assets/images/cpod-small.png"></a>
                        </div>
                        <div class="col-md-9 col-sm-10">
                            <nav class="navbar" role="navigation">
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse navbar-ex1-collapse">
                                    <ul id="menu-menu" class="nav navbar-nav">
                                        <li>
                                            <a title="O Evento" href="#about">O Evento</a>
                                        </li>
                                        <li>
                                            <a title="Programação" href="#schedule">Programação</a>
                                        </li>
                                        <li>
                                            <a title="Programação" href="#speakers">Presenças</a>
                                        </li>
                                        <li>
                                            <a title="Hotéis" href="#hotels">Hotéis</a>
                                        </li>
                                        <li>
                                            <a title="FAQ" href="#faq">Dúvidas</a>
                                        </li>
                                        <li>
                                            <a title="Contato" href="#contact">Contato</a>
                                        </li>
                                        <li>
                                            <a title="Contato" href="<?php echo get_permalink( get_theme_mod( 'pagina_inscricao', 'default_value' ) ); ?>">Inscrição</a>
                                        </li>
                                    </ul>
                                </div>
                            </nav>
                        </div>
                    </div>

                </div>
            </header>
        </section>