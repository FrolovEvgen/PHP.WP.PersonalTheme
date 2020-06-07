<?php
/* 
 * The MIT License
 *
 * Copyright 2020 E.Frolov <frolov@amiriset.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * Theme's functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */

/**
 * Theme's root path.
 */
define('THEME_PATH', dirname(__FILE__));

/** 
 * Directory separator
 */
define('DS', DIRECTORY_SEPARATOR);

if (function_exists('add_theme_support')) {
    // Custom menus.
    add_theme_support('menus');
    //Add thumbnails support for all contents.
    add_theme_support( 'post-thumbnails' ); 
}

// Register themes style sheets.
add_action('wp_enqueue_scripts', 'register_theme_styles');
function register_theme_styles () {
    wp_register_style('main_css', get_resource('/css/style.min.css'));
    wp_enqueue_style('main_css');
}

// Register themes scripts.
add_action('wp_enqueue_scripts', 'register_theme_scripts');
function register_theme_scripts () {
    wp_register_script('main_js', get_resource('/js/main.min.js'));
    wp_enqueue_script('main_js');
}

/**
 * Get resource's full path.
 * 
 * @param string $path Relative path.
 * 
 * @return string Full path.
 */
function get_resource ($path) {
    return get_template_directory_uri() . $path;
}

/**
 * Start html content's container.
 * 
 * @param string $id (optional) Add item id to the Section.
 * @param string $class (optional) Additional class for Content container.
 */
function print_section_start($id = "", $class="") {
    if (!isNullOrEmpty($id)) {
        $id = " id=\"item-$id\"";
    }
    if (!isNullOrEmpty($class)) {
        $class = " $class";
    }
    echo '<section' . $id . ' class="post"><div class="content' . $class . '">';
}

/**
 * Finish html content's container.
 */
function print_section_end() { 
    echo '</div></section>';
}

/**
 * Print available posts in category.
 * 
 * @global object $wp_query Wordpress query object.
 * 
 * @param int $posts_per_page (optional) Count posts per page.
 */
function print_posts($posts_per_page = 10) {
    global $wp_query;    
    // Check current position.
    $paged = get_current_page();
    
    $query_arguments = array(
        'showposts' => $posts_per_page,
        'post_type' => 'post',
        'paged' => $paged        
    );
    
    // If category page add filter by category.
    if (is_category()) { 
        // Get category ID.
        $current_category = get_category(get_query_var('cat'));
        $cat_name = $current_category->name;
        $query_arguments['cat'] = get_cat_ID( $cat_name );
    }
    // If tag page add filter by tag.
    if (is_tag()) { 
        $tag = get_term_by('name', get_query_var('tag'), 'post_tag');
        $query_arguments['tag_id'] = $tag->term_id;
    }

    // Create query.
    $wp_query = null;
    $wp_query = new WP_Query($query_arguments);    
    
    if ($wp_query->have_posts()) {
        // Start the Loop.
		while ($wp_query->have_posts()) : $wp_query->the_post();
            print_section_start(get_the_ID());
            
            // Create category lists;
            $links = array_map( function ( $category ) {
                return sprintf(
                    '<a href="%s" class="link link_text">%s</a>', // Template link
                    esc_url( get_category_link( $category ) ), // Category link
                    esc_html( $category->name ) // Category name
                );
            }, get_the_category() );
            include_template("post", array('links' => implode( ', ', $links )));
            print_section_end();
        endwhile;
        
    } else {
        print_section_start("no-posts");
        include_template("empty_post");
        print_section_end();
    }
}

/**
 * Get current page in pagination list.
 * 
 * @return int Current page num.
 */
function get_current_page() {
    return (get_query_var('paged')) ? get_query_var('paged') : 1;
}

/**
 * Render top menu by saved WP menu configuration.
 * 
 * @param string $menu_name Menu configuration name.
 */
function print_top_menu($menu_name) {
    
    $menu_list = '<ul class="menu">';
    if ($menu_items = wp_get_nav_menu_items($menu_name)) {
        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        foreach ((array) $menu_items as $key => $menu_item) {	
            $title = $menu_item->title;
            if ($menu_item->object === 'wpml_ls_menu_item') {
                $attr_title = '';
                $title = "&nbsp;$title&nbsp;";
                $menu_list .= '<li class="lang_item">';
            } else {
                $attr_title = $menu_item->attr_title === '' ? $title : $menu_item->attr_title;
                $menu_list .= '<li class="item">';
            }
            
            $url = $menu_item->url;
            
            $menu_list .= '<a href="'. $url .'"'; 
            if ($url === $actual_link) {
                $menu_list .= ' class="selected"';
            }
            $menu_list .= ' title="' . $attr_title . '">' . $title . '</a>';
            $menu_list .= '</li>';	
        }   
    }
    
    echo $menu_list . '</ul>';
}

/**
 * Create fluid preview from thumbnail.
 * 
 * @param boolean $fLink (optional) create link to post.
 */
function get_the_post_image($fLink = false) {
    $thumbnails = get_the_post_thumbnail();
    $html = preg_replace( '/(width|height)=\"\d*\"\s/', '',  $thumbnails );
    if ($fLink) {
        $html = '<a  href="' . get_the_permalink() . 
                '" title="' . get_the_title() . 
                '">' . $html . '</a>';
    }
    return '<div class="img preview">' . $html . '</div>';     
}

/**
 * Print fluid preview from thumbnail.
 * 
 * @param boolean $fLink (optional) create link to post.
 */
function print_post_image($fLink = false) {
    echo get_the_post_image($fLink); 
}

/**
 * Creates "bread crumbs" for posts. 
 */
function print_breadcrumb(){
    echo '<div class="container"><div class="row"><div class="cell">'; 
    // Get current page number.
    $page_num = get_current_page(); 
    $separator = ' &raquo; '; //  » 
    // If main page.
    if( is_front_page() ){ 
        if( $page_num > 1 ) {
            echo '<a href="' . site_url() . '">' . i18l('page.main.title') . 
                '</a>' . $separator . $page_num . i18l('page.iterator');
        } else {
            echo i18l('page.position');
	} 
    } else {  
        echo '<a href="' . site_url() . '">' . i18l('page.main.title') . 
            '</a>' . $separator;
        if( is_single() ){ // post  
            the_category($separator, 'multiply'); 
            echo $separator; 
            the_title(); 
        }  elseif ( is_404() ) { // If page not found.
            echo i18l('page.404.title'); 
        }
    }
    echo '</div></div><br><hr><br></div>';
}

/**
 * Function to check the string is ends with given substring or not.
 * 
 * @param string $string This parameter holds the text which need to test.
 * @param string $endString The text to search at the end of given String. If is 
 *                      an empty string, it returns true.
 * 
 * @return boolean This function returns True on success or False on failure.
 */
function ends_with($string, $endString) { 
    $len = strlen($endString); 
    if ($len == 0) { 
        return true; 
    } 
    return (substr($string, -$len) === $endString); 
} 

/**
 * Creates pagination.
 * 
 * @global object $wp_query Wordpress query object.
 */
function print_page_navigation() {
    global $wp_query;

    $total = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    $paged = get_current_page();
    
    // Pagination config.
    $config['total'] = $total;
    $config['mid_size'] = 3; 
    $config['end_size'] = 1; 
    $config['prev_text'] = '&laquo;';     
    $config['next_text'] = '&raquo;'; 
    $config['current'] = $paged;
    $config['type'] = 'list';
    $config['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
    
    // Print page navigation
    echo paginate_links($config);            
}

/**
 * Shows post navigation (to next/previous item).
 */
function print_post_navigation() {
    $prev_link_template = '<span class="meta-nav" aria-hidden="true">' . 
            i18l('back.title') . '</span> ' .
		'<span class="screen-reader-text" title="%title">' . 
            i18l('back.post') . '</span> ' .
		'<span class="post-title" title="' . i18l('back.post') . '">%title</span>';
    $next_link_template = '<span class="meta-nav" aria-hidden="true">' . 
            i18l('next.title') . '</span> ' .
		'<span class="screen-reader-text" title="%title">' . 
            i18l('next.post') . '</span> ' .
		'<span class="post-title" title="' . i18l('next.post') . '">%title</span>';
    
    $nav = '<div class="row"><div class="cell"><h2>' . 
            i18l('post.navigation.title') . '</h2></div></div>';
    
    $nav .= '<div class="row">';
    $nav .= get_previous_post_link(
		'<div class="cell-50"><div class="nav-previous">%link</div></div>',
		$prev_link_template, false, '', 'category'
	);
    $nav .= get_next_post_link(
		'<div class="cell-50"><div class="nav-next">%link</div>',
		$next_link_template, false, '', 'category');
    $nav .=  '</div>';
    echo '<div id="item-nav" class="container"><br><hr><br>' . $nav . '</div>';
}

/**
 * Import PHP modules/classes.
 * 
 * @param string $path Relative path to the PHP file.
 */
function import($path) {
    require THEME_PATH . $path;    
}

/**
 * Imports template.
 * 
 * @param string $include_path Relative path to template;
 * @param array $params (optional) Template's parameters if need.
 */
function include_template($include_path, $params = []) {
    include THEME_PATH . DS . 'templates' . DS . $include_path . '.php';
}

/**
 * Check if value is Null or empty string.
 * 
 * @param string $value
 * 
 * @return type
 */
function isNullOrEmpty($value) {
    return NULL === $value || '' === $value;
}

/**
 * Theme shortcodes.
 */
import(DS .'inc' . DS . 'shortcodes.php');

/**
 * Theme internationalization.
 */
import(DS .'inc' . DS . 'i18l.php');