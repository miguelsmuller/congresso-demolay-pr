<?php
/**
* PostType slide class
*
* Builds the base system of post type slide
*
* @package  wordpress-init-theme
* @category PostType
* @author   Miguel Müller (miguel.sneto[at]devim.com.br)
* @version  1.0
*/

$Class_Post_Type_faq = new Class_Post_Type_faq();
class Class_Post_Type_faq
{
    public function __construct(){
        //CREATE POST TYPE
        add_action('init', array( &$this, 'init_post_type'));
        add_filter('post_updated_messages', array( &$this, 'post_updated_messages'));

        //CHANGE PLACEHOLDER TITLE
        add_filter( 'enter_title_here', array( &$this, 'enter_title_here'));
    }

    /**
    * Runs after WordPress has finished loading but before any headers are sent
    * Registers arquivo post type
    *
    * @return void
    */
    function init_post_type() {

        //REGISTER ARQUIVO POST TYPE
        register_post_type( 'faq',
            array(
                'labels' => array(
                    'name'               => "Dúvidas",
                    'singular_name'      => 'Dúvida',
                    'add_new'            => 'Adicionar dúvida',
                    'add_new_item'       => 'Adicionar dúvida',
                    'edit_item'          => 'Editar dúvida',
                    'new_item'           => 'Novo dúvida',
                    'view_item'          => 'Ver dúvida',
                    'search_items'       => 'Buscar dúvida',
                    'not_found'          => 'Nenhuma dúvida encontrado',
                    'not_found_in_trash' => 'Nenhuma dúvida encontrado na lixeira',
                    'parent'             => "Dúvidas",
                    'menu_name'          => "Dúvidas"
                ),

                'hierarchical'       => false,
                'public'             => false,
                'query_var'          => true,
                'supports'           => array('title','editor'),
                'has_archive'        => false,
                'capability_type'    => 'post',
                'menu_icon'          => 'dashicons-lightbulb',
                'show_ui'            => true,
                'show_in_menu'       => true,
            )
        );
    }



    /**
    * customizes the messages of post type
    *
    * @param array $messages ----
    *
    * @return array $messages ----
    */
    function post_updated_messages( $messages ) {
        global $post;
        $postDate = date_i18n(get_option('date_format'), strtotime( $post->post_date ));

        $messages['faq'] = array(
            1  => '<strong>DÚVIDA</strong> atualizado com sucesso',
            6  => '<strong>DÚVIDA</strong> publicado com sucesso',
            9  => sprintf('<strong>DÚVIDA</strong> agendando para <strong>%s</strong>', $postDate),
            10 => 'Rascunho do <strong>DÚVIDA</strong> atualizado'
        );
        return $messages;
    }


    /**
    * include code in head page
    *
    * @param string $title actual placeholder
    *
    * @return void
    */
    function enter_title_here( $title ){
        $screen = get_current_screen();

        if ( $screen->post_type == 'faq' ){
            $title = 'Título da Dúvida';
        }

        return $title;
    }
}