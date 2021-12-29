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

$Class_Post_Type_Hotel = new Class_Post_Type_Hotel();
class Class_Post_Type_Hotel
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
        add_filter('manage_edit-hotel_columns', array( &$this, 'manage_edit_columns'));
        add_action('manage_hotel_posts_custom_column', array( &$this, 'manage_posts_custom_column'));
    }

    /**
    * Runs after WordPress has finished loading but before any headers are sent
    * Registers arquivo post type
    *
    * @return void
    */
    function init_post_type() {

        //REGISTER ARQUIVO POST TYPE
        register_post_type( 'hotel',
            array(
                'labels' => array(
                    'name'               => "Hotéis",
                    'singular_name'      => 'Hotel',
                    'add_new'            => 'Adicionar hotel',
                    'add_new_item'       => 'Adicionar hotel',
                    'edit_item'          => 'Editar hotel',
                    'new_item'           => 'Novo hotel',
                    'view_item'          => 'Ver hotel',
                    'search_items'       => 'Buscar hotel',
                    'not_found'          => 'Nenhum hotel encontrado',
                    'not_found_in_trash' => 'Nenhum hotel encontrado na lixeira',
                    'parent'             => "Hotéis",
                    'menu_name'          => "Hotéis"
                ),

                'hierarchical'       => false,
                'public'             => false,
                'query_var'          => true,
                'supports'           => array('title','thumbnail'),
                'has_archive'        => false,
                'capability_type'    => 'post',
                'menu_icon'          => 'dashicons-flag',
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
            1  => '<strong>HOTEL</strong> atualizado com sucesso',
            6  => '<strong>HOTEL</strong> publicado com sucesso',
            9  => sprintf('<strong>HOTEL</strong> agendando para <strong>%s</strong>', $postDate),
            10 => 'Rascunho do <strong>HOTEL</strong> atualizado'
        );
        return $messages;
    }



    /**
    * Add meta boxes to the administrative interface
    *
    * @return void
    */
    function add_meta_box() {
        add_meta_box( 'metaBox', 'Informações', array( &$this, 'show_html_meta_box' ), 'hotel', 'normal', 'high' );
    }



    /**
    * prints the HTML for editing the post type
    *
    * @return void
    */
    function show_html_meta_box( $post ) {
        wp_nonce_field('saveExtraFields','securityField');

        $site_hotel = get_post_meta( $post->ID, 'site_hotel', true );
        $details_hotel = get_post_meta( $post->ID, 'details_hotel', true );

    ?>
        <p>
            <label for="site_hotel">Site do Hotel: </label>
            <input type="text" name="site_hotel" id="cargo" value="<?php echo $site_hotel; ?>" class="widefat" />
        </p>
        <p>
            <label for="details_hotel">Detalhes extras: </label>
            <textarea name="details_hotel" id="cargo" rows="4" class="widefat"><?php echo $details_hotel; ?></textarea>
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
        if( get_post_type($postID) != 'hotel' )
        return $postID;

        // Antes de dar inicio ao salvamento precisamos verificar 3 coisas:
        // Verificar se a publicação é salva automaticamente
        if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        //Verificar o valor nonce criado anteriormente, e finalmente
        if( !isset( $_POST['securityField'] ) || !wp_verify_nonce( $_POST['securityField'], 'saveExtraFields' ) ) return;
        //Verificar se o usuário atual tem acesso para salvar a pulicação
        if( !current_user_can('edit_post') ) return;

        if( isset($_POST['site_hotel']) )
            update_post_meta( $postID, 'site_hotel', esc_url($_POST['site_hotel']) );
        if( isset($_POST['details_hotel']) )
            update_post_meta( $postID, 'details_hotel', $_POST['details_hotel'] );
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

        if ( $screen->post_type == 'hotel' ){
            $title = 'Nome do Hotel';
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
        if ( isset($post->post_type) && $post->post_type == 'hotel' ){
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
                $new['featured_image'] = 'Logo do hotel';
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