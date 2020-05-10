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
    //wp_register_script('jquery_1.4.2', theme_url('/js/script.min.js'));
    //wp_enqueue_script('jquery_1.4.2');
}

/**
 * Get resource's full path.
 * @param string $path Relative path.
 * @return string Full path.
 */
function get_resource ($path) {
    return get_template_directory_uri() . $path;
}

/**
 * Start html content's container.
 */
function section_start($id = "", $class="") {
    if ("" !== $id) {
        $id = " id=\"item-$id\"";
    }
    if ("" !== $class) {
        $class = " $class";
    }
    echo '<section' . $id . ' class="post"><div class="content' . $class . '">';
}

/**
 * Finish html content's container.
 */
function section_end() { 
    echo '</div></section>';
}

/**
 * Print all available posts.
 */
function print_posts() {	
    if (have_posts()) {
        // Start the Loop.
		while ( have_posts() ) :
            the_post();
            section_start(get_the_ID());
            
            // Create category lists;
            $links = array_map( function ( $category ) {
                return sprintf(
                    '<a href="%s" class="link link_text">%s</a>', // Шаблон вывода ссылки
                    esc_url( get_category_link( $category ) ), // Ссылка на рубрику
                    esc_html( $category->name ) // Название рубрики
                );
            }, get_the_category() );        
            
    ?>
<div class="container">
    <div class="row">
        <div class="cell"><h2><?php the_title() ?></h2></div>                            
    </div>
    <div class="row">
        <div class="cell-25">
            <div class="img preview"><?php the_post_thumbnail('thumbnail') ?></div>
        </div>
        <div class="cell-75">
            <p class="description"><?=get_the_excerpt() ?></p>
            <p class="readmore"><a
                    href="<?php the_permalink(); ?>" 
                    title="<?php the_title_attribute( 
                            array('before' => 'Permalink to: ', 'after' => '')); 
                    ?>"><?=i18l('read.more.title') ?></a></p>
            <hr>
            <p class="category"><?=i18l('categories.title') ?>: <?=implode( ', ', $links ); ?></p>
            <p class="tags"><?=i18l('tags.title') ?>: <?=get_the_tags(); ?></p>
        <div>
    </div>                            
</div>
       
	<?php
            section_end();
        endwhile;
        
    } else {
        section_start("no-posts");
        ?>
<div class="container">
    <div class="row">
        <div class="cell">
            <h1><?=i18l('has.no.post.title') ?></h1>
        </div>
    </div>
    <div class="row">
        <div class="cell">
            <p><?=i18l('has.no.post.info') ?></p>
        </div>
    </div>
</div>
        <?php
        section_end();
    }
}

/**
 * Render top menu by saved WP menu configuration.
 * @param string $menu_name Menu configuration name.
 */
function render_top_menu($menu_name) {
    
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
 * Import PHP modules/classes.
 * 
 * @param string $path
 */
function import($path) {
    require THEME_PATH . $path;    
}

/**
 * Theme shortcodes.
 */
import('/inc/shortcodes.php');

/**
 * Theme internationalization.
 */
import('/inc/i18l.php');