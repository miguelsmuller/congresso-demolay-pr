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

$Class_Post_Type_Parceiro = new Class_Post_Type_Parceiro();
class Class_Post_Type_Parceiro
{
    public function __construct(){
        //CREATE POST TYPE
        add_action('init', array( &$this, 'init_post_type'));
        add_filter('post_updated_messages', array( &$this, 'post_updated_messages'));

        //CHANGE PLACEHOLDER TITLE
        add_filter( 'enter_title_here', array( &$this, 'enter_title_here'));

        //INCLUDE CODE IN ADMIN MODE HEADER
        add_action('admin_head', array( &$this, 'admin_head'));

        //UPDATE COLUMNS IN LISTING IN ADMIN MODE
        add_filter('manage_edit-parceiro_columns', array( &$this, 'manage_edit_columns'));
        add_action('manage_parceiro_posts_custom_column', array( &$this, 'manage_posts_custom_column'));
    }

    /**
    * Runs after WordPress has finished loading but before any headers are sent
    * Registers arquivo post type
    *
    * @return void
    */
    function init_post_type() {

        //REGISTER ARQUIVO POST TYPE
        register_post_type( 'parceiro',
            array(
                'labels' => array(
                    'name'               => "Parceiros",
                    'singular_name'      => 'Parceiro',
                    'add_new'            => 'Adicionar parceiro',
                    'add_new_item'       => 'Adicionar parceiro',
                    'edit_item'          => 'Editar parceiro',
                    'new_item'           => 'Novo parceiro',
                    'view_item'          => 'Ver parceiro',
                    'search_items'       => 'Buscar parceiro',
                    'not_found'          => 'Nenhum parceiro encontrado',
                    'not_found_in_trash' => 'Nenhum parceiro encontrado na lixeira',
                    'parent'             => "Parceiros",
                    'menu_name'          => "Parceiros"
                ),

                'hierarchical'       => false,
                'public'             => false,
                'query_var'          => true,
                'supports'           => array('title','thumbnail'),
                'has_archive'        => false,
                'capability_type'    => 'post',
                'menu_icon'          => 'dashicons-awards',
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

        $messages['parceiro'] = array(
            1  => '<strong>PARCEIRO</strong> atualizado com sucesso',
            6  => '<strong>PARCEIRO</strong> publicado com sucesso',
            9  => sprintf('<strong>PARCEIRO</strong> agendando para <strong>%s</strong>', $postDate),
            10 => 'Rascunho do <strong>PARCEIRO</strong> atualizado'
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

        if ( $screen->post_type == 'parceiro' ){
            $title = 'Nome da empresa parceira';
        }

        return $title;
    }



    /**
    * include code in head page
    *
    * @return void
    */
    function admin_head() {
        global $post;

        //Apenas no modo de edição do Post Type
        if ( isset($post->post_type) && $post->post_type == 'parceiro' ){
        ?>
            <style type="text/css" media="screen">
                .column-featured_image { text-align: center; width:200px !important; overflow:hidden }
            </style>
        <?php
        }
        //Em qualquer página do painel administrativo
        ?>
    <?php
    }



    /**
    * Add extra columns to arquivo grid in admin list
    *
    * @param array $columns ----
    *
    * @return array $columns ----
    */
    function manage_edit_columns( $columns ) {
        global $post;

        $new = array();
        foreach($columns as $key => $title) {
            if ( $key=='title' )
                $new['featured_image'] = 'Logo da parceira';
            $new[$key] = $title;
        }
        $new['title'] = 'Nome';
        return $new;
    }



    /**
    * add value to the cell corresponding to the record
    *
    * @param array $column ----
    *
    * @return array $column ----
    */
    function manage_posts_custom_column( $column ) {
        global $post;

        switch( $column ) {
            case 'featured_image' :
                $post_featured_image = $this->get_thumbnail($post->ID);
                if ($post_featured_image) {
                    printf('<a href="%s"><img width="200px" height="100px" src="%s" /></a>',
                            get_bloginfo('wpurl') .'/wp-admin/post.php?post='.$post->ID.'&action=edit',
                            $post_featured_image
                        );
                }
                break;
        }
    }



    /**
    * Takes the url of the thumbnail of the specified post
    *
    * @param int $post_ID ID of post
    *
    * @return string $thumbnail URL thumbnail
    */
    function get_thumbnail( $post_ID ) {
        $post_thumbnail_id = get_post_thumbnail_id($post_ID);
        if ( $post_thumbnail_id ) {
            $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'image-slider');
            $thumbnail = $post_thumbnail_img[0];
            return $thumbnail;
        }
    }
}