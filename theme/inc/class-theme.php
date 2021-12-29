<?php
if ( ! defined( 'ABSPATH' ) ) exit;

include dirname(__FILE__).'/../assets/components/Aqua-Resizer/aq_resizer.php';
include 'class-post-type-faq.php';
include 'class-post-type-persoalidade.php';
include 'class-post-type-parceiro.php';
include 'class-post-type-hotel.php';

/**
*
* START THE EDIT HERE
*
*/
add_action( 'after_setup_theme', 'after_setup_theme' );
function after_setup_theme() {
    //THEME MENUS
    register_nav_menus( array(
        'menu-principal'       => 'Menu Principal'
    ));

    //set_post_thumbnail_size( 300, 300, false );

    //'image', 'video', 'aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio' e 'chat'
    //add_theme_support( 'post-formats', array() );
}

add_action( 'widgets_init', 'widgets_init' );
function widgets_init() {
    //REGISTER SIDEBAR
    /*register_sidebar( array(
        'name'          => 'Sidebar Principal',
        'id'            => 'sidebar-principal',
        'description'   => 'Sidebar principal',
        'before_widget' => '<div class="panel panel-default">',
        'before_title'  => '<div class="panel-heading">',
        'after_title'   => '</div><div class="panel-body">',
        'after_widget'  => '</div></div>'
    ));*/

    // UNREGISTER DEFAULTS WIDGETS
    unregister_widget( 'WP_Widget_Pages' );
    unregister_widget( 'WP_Widget_Calendar' );
    unregister_widget( 'WP_Widget_Archives' );
    unregister_widget( 'WP_Widget_Links' );
    unregister_widget( 'WP_Widget_Meta' );
    unregister_widget( 'WP_Widget_Categories' );
    unregister_widget( 'WP_Widget_Recent_Posts' );
    unregister_widget( 'WP_Widget_Recent_Comments' );
    unregister_widget( 'WP_Widget_RSS' );
    unregister_widget( 'WP_Widget_Tag_Cloud' );
    unregister_widget( 'WP_Widget_Nav_Menu' );
    unregister_widget( 'WP_Widget_Text' );
}

/*public function getSlides(){
    return new WP_Query(array(
        'post_type' => 'slide',
        'meta_query' => array(
            array(
            'key' => 'status',
            'value' => 'FALSE',
            'compare' => '=',
            ),
        ),
        'posts_per_page' => -1,
        'orderby'=> 'date',
        'order'=> 'DESC'
    ));
}*/

function customize_theme( $wp_customize ) {
    $wp_customize->add_setting('pagina_inscricao', array('default' => '1'));
    $wp_customize->add_control('pagina_inscricao', array(
        'label'    => 'Página de Inscrição',
        'section'  => 'theme_config',
        'settings' => 'pagina_inscricao',
        'type'     => 'text'
    ));

    $wp_customize->add_setting('form_contact', array('default' => ''));
    $wp_customize->add_control('form_contact', array(
        'label'    => 'Shortcode Form contato',
        'section'  => 'theme_config',
        'settings' => 'form_contact',
        'type'     => 'text'
    ));

    $wp_customize->add_section('theme_config' , array(
        'title' => 'Configuração do Tema',
    ));
}
add_action( 'customize_register', 'customize_theme' );





//MOSTRA MESMO INVÁLIDO
add_filter( 'camptix_hide_empty_tickets', '__return_false' );

//LIBERA O GERENCIAMENTO PARA O EDITOR
add_filter( 'camptix_capabilities', 'my_camptix_caps' );
function my_camptix_caps( $caps ) {
    $caps['manage_tickets']   = 'edit_pages';
    $caps['manage_attendees'] = 'edit_pages';

    //exit(print_r($caps));
    return $caps;
}

//NÃO MOSTRA A QUANTIDADE DE TICKETS RESTANTES
add_filter( 'camptix_show_remaining_tickets', '__return_false' );
add_filter( 'camptix_form_start_tix_remaining', 'camptix_form_start_tix_remaining', 10, 3 );
function camptix_form_start_tix_remaining( $remaining, $ticket ) {
    //if ( $ticket->ID == 812 )
        return '-';
    //return $remaining;
}



/**
 * Carrega os arquivos JS's e CSS's do tema
 */
add_action('wp_enqueue_scripts', 'enqueue_scripts' );
function enqueue_scripts(){
	$template_dir = get_bloginfo('template_directory');



	// COMMON STYLE AND SCRIPT
	wp_register_script( 'common-js', $template_dir .'/assets/js/javascript.min.js', array('jquery'), null, true );
	wp_localize_script(
		'common-js',
		'common_params',
		array(
			'site_url'  => esc_url( site_url() ),
			'first_vist' => $first_vist
		)
	);
	wp_enqueue_script( 'common-js' );
	wp_enqueue_style( 'common-css', $template_dir .'/assets/css/style.css' );
}







add_action('init', 'my_setcookie');
function my_setcookie(){
  if ( !isset($_COOKIE['_first_visit']) ) {
		setcookie('_first_visit', 'yes', time() + 3600*24*5);
		$first_vist = "yes";
	}else{
		$first_vist = "no";
	}
}







/**
 * Blackhole Payment Method for CampTix
 *
 * The blackhole payment method is not a real-world method. You shouldn't use this in
 * your projects. It was designed to test payments and give a little example of how
 * real payment methods should be written. PayPal, however, is a better example.
 *
 * @since CampTix 1.2
 */
class CampTix_Payment_Method_Direto extends CampTix_Payment_Method {

    /**
     * The following variables have to be defined for each payment method.
     */
    public $id = 'direto';
    public $name = 'Fechar inscrições';
    public $description = 'Will always result in a successful or failed payment.';
    public $supported_currencies = array( 'BRL' );

    /**
     * You can store options in a class locally, use
     * $this->get_payment_options() to retrieve them from CampTix.
     */
    protected $options;

    function camptix_init() {
        $this->options = array_merge( array(
            'always_succeed' => true,
        ), $this->get_payment_options() );
    }

    /**
     * Optionally, a payment method can have one ore more options.
     * Use the helper function to add fields. See the CampTix_Payment_Method
     * class for more info.
     */
    function payment_settings_fields() {
        $this->add_settings_field_helper( 'always_succeed', __( 'Always Succeed', 'camptix' ), array( $this, 'field_yesno' ) );
    }

    /**
     * If your payment method has options, CampTix will call your
     * validate_options() method when saving them. Make sure you grab
     * the $input and produce an $output.
     */
    function validate_options( $input ) {
        $output = $this->options;

        if ( isset( $input['always_succeed'] ) )
            $output['always_succeed'] = (bool) $input['always_succeed'];

        return $output;
    }

    /**
     * This is the main method of your class. It is fired as soon as a user
     * initiates the checkout process with your payment method selected. At any
     * point in time, you can use $this->payment_result to return a payment result
     * back to CampTix. This does not necessarily have to happen in this function.
     * See the PayPal example for details.
     */
    function payment_checkout( $payment_token ) {
        global $camptix;

        // Process $order and do something.
        $order = $this->get_order( $payment_token );
        do_action( 'camptix_before_payment', $payment_token );

        $payment_data = array(
            'transaction_id' => 'tix-direto-' . md5( sprintf( 'tix-direto-%s-%s-%s', print_r( $order, true ), time(), rand( 1, 9999 ) ) ),
            'transaction_details' => array(
                // @todo maybe add more info about the payment
                'raw' => array( 'payment_method' => 'direto' ),
            ),
        );

        if ( $this->options['always_succeed'] )
            return $this->payment_result( $payment_token, $camptix::PAYMENT_STATUS_PENDING, $payment_data );
        else
            return $this->payment_result( $payment_token, $camptix::PAYMENT_STATUS_FAILED );
    }
}
camptix_register_addon( 'CampTix_Payment_Method_Direto' );
