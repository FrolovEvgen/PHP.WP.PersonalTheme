<?php

/* 
 * The MIT License
 *
 * Copyright 2020 E.Frolov <frolov@amiriset.com>.
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
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */
?>
<aside>
    <h2 class="sidebar-heading"><?=i18l("aside.cat.title")?><span 
            class="class-toggler" 
            data-item="asideMenu" 
            data-class="collapsed"><?=single_cat_title("", false)?></span></h2>
	<nav id="asideMenu" class="aside-navigation collapsed">
		<? wp_nav_menu(array('menu' => 'aside-menu', 'menu_class' => 'aside-menu')); ?>
	</nav>
    <br>
    <div class="tagcloud"><?php
    wp_tag_cloud( array(
        'smallest' => 100, // size of least used tag
        'largest'  => 150, // size of most used tag
        'unit'     => '%', // unit for sizing the tags
        'number'   => 45, // displays at most 45 tags
        'orderby'  => 'name', // order tags alphabetically
        'order'    => 'ASC', // order tags by ascending order
        'taxonomy' => 'post_tag' // you can even make tags for custom taxonomies
     ) ); ?></div>

</aside>