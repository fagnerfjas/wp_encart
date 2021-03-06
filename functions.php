<?php

/**
 * INCLUDES PHP 
 */
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
add_theme_support('post-thumbnails');

/**
 * INCLUSÃO DE SCRIPTS
 */
function encart_enqueue_styles() {
    wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css' );
    wp_enqueue_style( 'core', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'start_bootstrap', get_template_directory_uri() . '/css/start_bootstrap.css', array(), '1.0', 'all');
    wp_enqueue_style( 'fontes-1', 'https://fonts.googleapis.com/css?family=Montserrat:400,700', array(), '1.0', 'all');
    wp_enqueue_style( 'fontes-2', 'https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700', array(), '1.0', 'all');
}
add_action( 'wp_enqueue_scripts', 'encart_enqueue_styles');

function encart_enqueue_scripts() {
    wp_enqueue_script( 'scripts-fonte', 'https://use.fontawesome.com/releases/v6.1.0/js/all.js', array('jquery'), null, false);
    wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js' );
    wp_enqueue_script( 'start_bootstrap', get_template_directory_uri() . '/js/start_bootstrap.js', array('jquery'), null, true);    

        
}
add_action( 'wp_enqueue_scripts', 'encart_enqueue_scripts');






/**
 * REGISTRO DE MENUS
 */
add_action('after_setup_theme', 'blankslate_setup');
function blankslate_setup()
{
    // load_theme_textdomain('blankslate', get_template_directory() . '/languages');
    // add_theme_support('title-tag');
    // add_theme_support('post-thumbnails');
    // add_theme_support('responsive-embeds');
    // add_theme_support('automatic-feed-links');
    // add_theme_support('html5', array('search-form', 'navigation-widgets'));
    // add_theme_support('woocommerce');
    // global $content_width;
    // if (!isset($content_width)) {
    //     $content_width = 1920;
    // }

    register_nav_menus(
        array(
            'main-menu' => esc_html__('Main Menu', 'wp-encart')
        )
    );
}

/**
 * REGISTRO DO TIPO DE POST 
 */

function create_post_types() {
    $labels = array(
      'name'                => __( 'Produtos', 'wp_encart' ),
      'singular_name'       => __( 'Produto', 'wp_encart' ),
      'add_new'             => __( 'Adicionar Novo', 'wp_encart' ),
      'add_new_item'        => __( 'Adicionar Novo Produto', 'wp_encart' ),
      'edit_item'           => __( 'Editar Produto', 'wp_encart' ),
      'new_item'            => __( 'Novo Produto', 'wp_encart' ),
      'all_items'           => __( 'Todos os Produtos', 'wp_encart' ),
      'view_item'           => __( 'Ver Produto', 'wp_encart' ),
      'search_items'        => __( 'Pesquisar Produtos', 'wp_encart' ),
      'not_found'           => __( 'Nenhum Produto encontrada', 'wp_encart' ),
      'not_found_in_trash'  => __( 'Nenhum Produto no Lixo', 'wp_encart' ),
      'menu_name'           => __( 'Produtos', 'wp_encart' ),
    );
  
    $supports = array( 'title', 'editor', 'thumbnail', 'author' );
  
    $slug = get_theme_mod( 'produto_permalink' );
    $slug = ( empty( $slug ) ) ? 'cliente' : $slug;
  
    $args = array(
      'labels'              => $labels,
      'public'              => true,
      'publicly_queryable'  => true,
      'show_ui'             => true,
      'show_in_menu'        => true,
      'query_var'           => true,
      'rewrite'             => array( 'slug' => $slug ),
      'capability_type'     => 'post',
      'has_archive'         => true,
      'hierarchical'        => true,
      'menu_position'       => 4,
      'supports'            => $supports,      
      'menu_icon'           => 'dashicons-products',
      'taxonomies'          => array( 'category' ),
    );
  
    register_post_type( 'produto', $args );
  
  }
  add_action( 'init', 'create_post_types' );










add_action('admin_notices', 'blankslate_notice');
function blankslate_notice()
{
    $user_id = get_current_user_id();
    $admin_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $param = (count($_GET)) ? '&' : '?';
    if (!get_user_meta($user_id, 'blankslate_notice_dismissed_7') && current_user_can('manage_options'))
        echo '<div class="notice notice-info"><p><a href="' . esc_url($admin_url), esc_html($param) . 'dismiss" class="alignright" style="text-decoration:none"><big>' . esc_html__('Ⓧ', 'blankslate') . '</big></a>' . wp_kses_post(__('<big><strong>📝 Thank you for using BlankSlate!</strong></big>', 'blankslate')) . '<br /><br /><a href="https://wordpress.org/support/theme/blankslate/reviews/#new-post" class="button-primary" target="_blank">' . esc_html__('Review', 'blankslate') . '</a> <a href="https://github.com/tidythemes/blankslate/issues" class="button-primary" target="_blank">' . esc_html__('Feature Requests & Support', 'blankslate') . '</a> <a href="https://calmestghost.com/donate" class="button-primary" target="_blank">' . esc_html__('Donate', 'blankslate') . '</a></p></div>';
}
add_action('admin_init', 'blankslate_notice_dismissed');
function blankslate_notice_dismissed()
{
    $user_id = get_current_user_id();
    if (isset($_GET['dismiss']))
        add_user_meta($user_id, 'blankslate_notice_dismissed_7', 'true', true);
}





add_action('wp_footer', 'blankslate_footer');
function blankslate_footer()
{
?>
    <script>
        jQuery(document).ready(function($) {
            var deviceAgent = navigator.userAgent.toLowerCase();
            if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
                $("html").addClass("ios");
                $("html").addClass("mobile");
            }
            if (deviceAgent.match(/(Android)/)) {
                $("html").addClass("android");
                $("html").addClass("mobile");
            }
            if (navigator.userAgent.search("MSIE") >= 0) {
                $("html").addClass("ie");
            } else if (navigator.userAgent.search("Chrome") >= 0) {
                $("html").addClass("chrome");
            } else if (navigator.userAgent.search("Firefox") >= 0) {
                $("html").addClass("firefox");
            } else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
                $("html").addClass("safari");
            } else if (navigator.userAgent.search("Opera") >= 0) {
                $("html").addClass("opera");
            }
        });
    </script>
<?php
}
add_filter('document_title_separator', 'blankslate_document_title_separator');
function blankslate_document_title_separator($sep)
{
    $sep = esc_html('|');
    return $sep;
}
add_filter('the_title', 'blankslate_title');
function blankslate_title($title)
{
    if ($title == '') {
        return esc_html('...');
    } else {
        return wp_kses_post($title);
    }
}
function blankslate_schema_type()
{
    $schema = 'https://schema.org/';
    if (is_single()) {
        $type = "Article";
    } elseif (is_author()) {
        $type = 'ProfilePage';
    } elseif (is_search()) {
        $type = 'SearchResultsPage';
    } else {
        $type = 'WebPage';
    }
    echo 'itemscope itemtype="' . esc_url($schema) . esc_attr($type) . '"';
}
add_filter('nav_menu_link_attributes', 'blankslate_schema_url', 10);
function blankslate_schema_url($atts)
{
    $atts['itemprop'] = 'url';
    return $atts;
}
if (!function_exists('blankslate_wp_body_open')) {
    function blankslate_wp_body_open()
    {
        do_action('wp_body_open');
    }
}
add_action('wp_body_open', 'blankslate_skip_link', 5);
function blankslate_skip_link()
{
    echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__('Skip to the content', 'blankslate') . '</a>';
}
add_filter('the_content_more_link', 'blankslate_read_more_link');
function blankslate_read_more_link()
{
    if (!is_admin()) {
        return ' <a href="' . esc_url(get_permalink()) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('excerpt_more', 'blankslate_excerpt_read_more_link');
function blankslate_excerpt_read_more_link($more)
{
    if (!is_admin()) {
        global $post;
        return ' <a href="' . esc_url(get_permalink($post->ID)) . '" class="more-link">' . sprintf(__('...%s', 'blankslate'), '<span class="screen-reader-text">  ' . esc_html(get_the_title()) . '</span>') . '</a>';
    }
}
add_filter('big_image_size_threshold', '__return_false');
add_filter('intermediate_image_sizes_advanced', 'blankslate_image_insert_override');
function blankslate_image_insert_override($sizes)
{
    unset($sizes['medium_large']);
    unset($sizes['1536x1536']);
    unset($sizes['2048x2048']);
    return $sizes;
}
add_action('widgets_init', 'blankslate_widgets_init');
function blankslate_widgets_init()
{
    register_sidebar(array(
        'name' => esc_html__('Sidebar Widget Area', 'blankslate'),
        'id' => 'primary-widget-area',
        'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('wp_head', 'blankslate_pingback_header');
function blankslate_pingback_header()
{
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s" />' . "\n", esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('comment_form_before', 'blankslate_enqueue_comment_reply_script');
function blankslate_enqueue_comment_reply_script()
{
    if (get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
function blankslate_custom_pings($comment)
{
?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url(comment_author_link()); ?></li>
<?php
}
add_filter('get_comments_number', 'blankslate_comment_count', 0);
function blankslate_comment_count($count)
{
    if (!is_admin()) {
        global $id;
        $get_comments = get_comments('status=approve&post_id=' . $id);
        $comments_by_type = separate_comments($get_comments);
        return count($comments_by_type['comment']);
    } else {
        return $count;
    }
}




/**
 * Adicionando a imagem destacada na lista do post
 */
/* Adiciona Imagem Destacada na Coluna da Listagem de Posts */
if ( function_exists( 'add_theme_support' ) ) {
    add_image_size( 'admin-thumb', 100, 999999 ); // 100 pixels de largura (e altura ilimitada)
}
    
    add_filter('manage_posts_columns', 'posts_columns', 5);
    add_action('manage_posts_custom_column', 'posts_custom_columns', 5, 2);
    
function posts_columns($defaults){
    $defaults['my_post_thumbs'] = __('Foto'); //Modifique o nome para o que desejar
    return $defaults;
}
    
function posts_custom_columns($column_name, $id){
    if($column_name === 'my_post_thumbs'){
        echo the_post_thumbnail( 'admin-thumb' );
    }
}

function your_columns_head($defaults) {

    $new = array();
    $tags = $defaults['my_post_thumbs']; // Salva a coluna Imagem
    unset($defaults['my_post_thumbs']); // Remove a coluna Imagem da lista
    
    foreach($defaults as $key=>$value) {
    if($key=='title') { // Quando encontrar a coluna titulo
    $new['my_post_thumbs'] = $tags; // Coloque a coluna Imagem antes dele
    }
    $new[$key]=$value;
    }
    
    return $new;
    }
add_filter('manage_posts_columns', 'your_columns_head');
