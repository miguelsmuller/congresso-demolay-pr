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

$Class_Post_Type_Personalidade = new Class_Post_Type_Personalidade();
class Class_Post_Type_Personalidade
{
    public function __construct(){
        //CREATE POST TYPE
        add_action('init', array( &$this, 'init_post_type'));
        add_filter('post_updated_messages', array( &$this, 'post_updated_messages'));

        //ADD EXTRA FIELDS
        add_action('add_meta_boxes', array( &$this, 'add_meta_box'));
        add_action('save_post', array( &$this, 'save_post'));

        //CHANGE PLACEHOLDER TITLE
        add_filter( 'enter_title_here', array( &$this, 'enter_title_here'));

        //INCLUDE CODE IN ADMIN MODE HEADER
        add_action('admin_head', array( &$this, 'admin_head'));

        //UPDATE COLUMNS IN LISTING IN ADMIN MODE
        add_filter('manage_edit-pesonalidade_columns', array( &$this, 'manage_edit_columns'));
        add_action('manage_pesonalidade_posts_custom_column', array( &$this, 'manage_posts_custom_column'));
    }

    /**
    * Runs after WordPress has finished loading but before any headers are sent
    * Registers arquivo post type
    *
    * @return void
    */
    function init_post_type() {

        //REGISTER ARQUIVO POST TYPE
        register_post_type( 'pesonalidade',
            array(
                'labels' => array(
                    'name'               => "Personalidades",
                    'singular_name'      => 'Personalidade',
                    'add_new'            => 'Adicionar pesonalidade',
                    'add_new_item'       => 'Adicionar pesonalidade',
                    'edit_item'          => 'Editar pesonalidade',
                    'new_item'           => 'Novo pesonalidade',
                    'view_item'          => 'Ver pesonalidade',
                    'search_items'       => 'Buscar pesonalidade',
                    'not_found'          => 'Nenhuma pesonalidade encontrado',
                    'not_found_in_trash' => 'Nenhuma pesonalidade encontrado na lixeira',
                    'parent'             => "Personalidades",
                    'menu_name'          => "Personalidades"
                ),

                'hierarchical'       => false,
                'public'             => false,
                'query_var'          => true,
                'supports'           => array('title','thumbnail'),
                'has_archive'        => false,
                'capability_type'    => 'post',
                'menu_icon'          => 'dashicons-groups',
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

        $messages['pesonalidade'] = array(
            1  => '<strong>PERSONALIDADE</strong> atualizado com sucesso',
            6  => '<strong>PERSONALIDADE</strong> publicado com sucesso',
            9  => sprintf('<strong>PERSONALIDADE</strong> agendando para <strong>%s</strong>', $postDate),
            10 => 'Rascunho do <strong>PERSONALIDADE</strong> atualizado'
        );
        return $messages;
    }


    /**
    * Add meta boxes to the administrative interface
    *
    * @return void
    */
    function add_meta_box() {
        add_meta_box( 'metaBox', 'Informações', array( &$this, 'show_html_meta_box' ), 'pesonalidade', 'normal', 'high' );
    }



    /**
    * prints the HTML for editing the post type
    *
    * @return void
    */
    function show_html_meta_box( $post ) {
        wp_nonce_field('saveExtraFields','securityField');

        $cargo = get_post_meta( $post->ID, 'cargo', true );

    ?>
        <p>
            <label for="cargo">Cargo/Posição: </label>
            <input type="text" name="cargo" id="cargo" value="<?php echo $cargo; ?>" class="widefat" />
        </p>
    <?php
    }



    /**
    * Save post metadata when a post is saved
    *
    * @param int $postId ID of post
    *
    * @return void
    */
    function save_post( $postID ) {
        if( get_post_type($postID) != 'pesonalidade' )
        return $postID;

        // Antes de dar inicio ao salvamento precisamos verificar 3 coisas:
        // Verificar se a publicação é salva automaticamente
        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        //Verificar o valor nonce criado anteriormente, e finalmente
        if( !isset( $_POST['securityField'] ) || !wp_verify_nonce( $_POST['securityField'], 'saveExtraFields' ) ) return;
        //Verificar se o usuário atual tem acesso para salvar a pulicação
        if( !current_user_can('edit_post') ) return;

        if( isset($_POST['cargo']) )
            update_post_meta( $postID, 'cargo', $_POST['cargo'] );
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

        if ( $screen->post_type == 'pesonalidade' ){
            $title = 'Nome da Personalidade';
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
        if ( isset($post->post_type) && $post->post_type == 'pesonalidade' ){
        ?>
            <style type="text/css" media="screen">
                .column-featured_image { text-align: center; width:100px !important; overflow:hidden }
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
                $new['featured_image'] = 'Foto de Perfil';
            if ( $key=='date' ){
                $new['cargo'] = 'Cargo/Posição';
            }
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
        $postOptions = get_post_custom( $post->ID );
        $cargo         = $postOptions['cargo'][0];

        switch( $column ) {
            case 'featured_image' :
                $post_featured_image = $this->get_thumbnail($post->ID);
                if ($post_featured_image) {
                    printf('<a href="%s"><img width="100px" height="100px" src="%s" /></a>',
                            get_bloginfo('wpurl') .'/wp-admin/post.php?post='.$post->ID.'&action=edit',
                            $post_featured_image
                        );
                }
                break;

            case 'cargo' :
                printf('<a target"_blank" href="%s">%s</a>', $cargo, $cargo);
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