<?php
/**
 * File for functions and definitions of the theme
 *
 * Contain loading of styles and scripts
 *
 */
//Style css
add_action('wp_enqueue_scripts', 'load_sec_css');
function load_sec_css() {
    wp_register_style( 'mine',  get_template_directory_uri() . '/css/mine.css', array(), ' ' );
    wp_enqueue_style( 'mine');
    wp_register_style( 'fonts',  get_template_directory_uri() . '/css/fonts.css', array(), ' ' );
    wp_enqueue_style( 'fonts');
    wp_register_style( 'styles', get_stylesheet_uri(), array(), ' ' );
    wp_enqueue_style( 'styles' );
}
//JQUERY
add_action( 'wp_enqueue_scripts', 'my_scripts_method' );
function my_scripts_method() {
    $url = 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js';
    $response = wp_remote_get('https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js');
    $code = wp_remote_retrieve_response_code( $response );
    if ( !is_wp_error( $response ) ){
        if( isset( $url ) && !empty( $url) && ( $code == '200') ){
        	wp_deregister_script( 'jquery-core' );
	        wp_register_script( 'jquery-core', $url ,array(), null, true);
	        wp_enqueue_script( 'jquery' );
        }
    }
    else{
            wp_deregister_script( 'jquery-core' );
	        wp_register_script( 'jquery-core', get_theme_file_uri( 'js/jquery-3.3.1.min.js' ) ,array(), null, true);
	        wp_enqueue_script( 'jquery' );
    }
}
//Load js
add_action( 'wp_enqueue_scripts', 'load_js' );
function load_js() {
    if( ! is_single() ){
     wp_register_script( 'mihdan-infinite-scroll', get_theme_file_uri( 'js/jquery-ias.min.js' ), array( 'jquery' ), null, true );
     wp_enqueue_script('mihdan-infinite-scroll');
     $wnm_custom = array( 'ajax_text_button' => get_field('text_for_ajax_button_more','options'), 'ajax_end_load' => get_field('text_fo_end_of_ajax_load','options') );
     wp_localize_script( 'mihdan-infinite-scroll', 'wnm_custom', $wnm_custom );
     }
    if( is_single() ){
     wp_register_script('progress', get_theme_file_uri( 'js/progress.js' ), array( 'jquery' ), null, true );
     wp_enqueue_script('progress');
    }
     wp_register_script('custom', get_theme_file_uri( 'js/custom.js' ), array( 'jquery' ), null, true );
     wp_enqueue_script('custom');
}
//Setup
add_theme_support( 'post-thumbnails', array( 'post' ) );
if ( function_exists( 'add_image_size' ) ) {
	add_image_size( 'blog-thumb', 170, 160, array( 'left', 'center' ) ); 
    add_image_size( 'icons-small', 100, 100, array( 'left', 'center' ) ); 
    add_image_size( 'icons-middle', 95, 95, array( 'left', 'top' ) );
    add_image_size( 'sale', 260, 145, array( 'left', 'top' ) );
    add_image_size( 'sale-full', 700, 330, array( 'left', 'top' ) );
}
if ( ! function_exists( 'theme_setup' ) ) :
function theme_setup(){
    //Add support theme html 5    
    add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption') ); 
    //Add custom logo
    add_theme_support( 'custom-logo', array(
		'height'      => 52,
		'width'       => 166,
		'flex-height' => false,
	) );
}
endif;
add_action( 'after_setup_theme', 'theme_setup' );
remove_filter('the_content', 'wpautop');
//Options page for main information
if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Main Settings',
		'menu_title'	=> 'Main information',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}
/**
 * Disable the confirmation notices when an administrator
 * changes their email address.
 *
 * @see http://codex.wordpress.com/Function_Reference/update_option_new_admin_email
 */
function wpdocs_update_option_new_admin_email( $old_value, $value ) {

    update_option( 'admin_email', $value );
}
add_action( 'add_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );
add_action( 'update_option_new_admin_email', 'wpdocs_update_option_new_admin_email', 10, 2 );
//No slash
add_filter('user_trailingslashit', 'no_page_slash', 70, 2);
function no_page_slash( $string, $type ){
   global $wp_rewrite;

	if( $type == 'page' && $wp_rewrite->using_permalinks() && $wp_rewrite->use_trailing_slashes )
		$string = untrailingslashit($string);

   return $string;
}
//Remove admin pages
function remove_menus(){
    remove_menu_page( 'edit.php?post_type=page' ); 
    remove_menu_page( 'users.php' );
    remove_menu_page( 'edit-comments.php' );   
}
add_action( 'admin_menu', 'remove_menus' );
//Register sidebars
add_action( 'widgets_init', 'register_my_widgets' );
function register_my_widgets(){
    register_sidebar( array(
		'name'          => 'Footer',
		'id'            => "footer",
		'description'   => 'Zone for footer`s widgets',
		'class'         => '',
		'before_widget' => '<div class="footer-widget">',
		'after_widget'  => "</div>\n",
		'before_title'  => '',
		'after_title'   => "\n",
	) );
        register_sidebar( array(
		'name'          => 'Right',
		'id'            => "right",
		'description'   => 'Zone for right widgets',
		'class'         => '',
		'before_widget' => '<div class="right-widget">',
		'after_widget'  => "</div>\n",
		'before_title'  => '<p class="right-widget-title">',
		'after_title'   => "</p>\n",
	) );
}
//Breadcrumbs
function the_breadcrumb(){
global $post;
if(!is_home()){ 
   echo '<a href="'.site_url().'">Home</a> >> ';
	if(is_single()){ // записи
	the_category(', ');
	echo " >> ";
	the_title();
	}
	elseif (is_page()) { // страницы
		if ($post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">>' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) echo $crumb . ' >> ';
		}
		echo the_title();
	}
	elseif (is_category()) { // категории
		global $wp_query;
		$obj_cat = $wp_query->get_queried_object();
		$current_cat = $obj_cat->term_id;
		$current_cat = get_category($current_cat);
		$parent_cat = get_category($current_cat->parent);
		if ($current_cat->parent != 0) 
			echo(get_category_parents($parent_cat, TRUE, ' >> '));
		single_cat_title();
	}
	elseif (is_404()) { // если страницы не существует
		echo 'Error 404';
	}
 
	if (get_query_var('paged')) // номер текущей страницы
		echo ' (' . get_query_var('paged').'-я страница)';
 
} else { // главная
   $pageNum=(get_query_var('paged')) ? get_query_var('paged') : 1;
   if($pageNum>1)
      echo '<a href="'.site_url().'">Home</a> >> '.$pageNum.'-я страница';
}
}