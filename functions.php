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
 * Theme's functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */

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
 * Render top menu by saved WP menu configuration.
 * @param string $menu_name Menu configuration name.
 */
function render_top_menu($menu_name) {
    $menu_list = '<ul class="menu">
        <li class="item active">
            <a href="#">Обо мне</a>
        </li>
        <li class="item">
            <a href="#">Резюме</a>
        </li>
        <li class="item">
            <a href="#">Работы</a>
        </li>
        <li class="item">
            <a href="#">Блог</a>
        </li>
        <li class="item">
            <a href="#">Написать письмо</a>
        </li>
    </ul>';
    echo $menu_list;
}

/**
 * Theme shortcodes.
 */
require get_template_directory() . '/inc/shortcodes.php';