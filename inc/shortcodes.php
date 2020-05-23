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

if (!defined('THEME_PATH')) {
    header('Refresh: 0; url=' . ($_SERVER['HTTP_HOST']));
}

/**
 * The theme's useful shortcodes.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */

/**
 * Show image with specific tag.
 * $attr["name"] - Image filename.
 * $attr["title"] - (optional) Image title.
 * $attr["alt"] - (optional) Alternative description.
 * $attr["width"] - (optional) Image width.
 * $attr["height"] - (optional) Image height.
 * 
 * @example [static_image name="test.jpg" title="Test image"] 
 * @example [static_image name="test.jpg" alt="This is test"] 
 * @example [static_image name="test.jpg" width="100" height="100"] 
 * 
 * @param array $attr Image attributes             
 * @return string
 */
function static_image($attr) {
	$params = shortcode_atts( array( 
		'name' => '',
		'title'=> '',
		'alt' => '',
		'width' => '',
		'height' => '',
		'class' => ''
	), $attr );
	
	$url = get_resource('/i/' . $params['name']);
	
	$result = '<img src="' . $url . '"';	
	if ($params['class'] != '') {
		$result .= ' class="' . $params['class'] . '"';
	}
	if ($params['title'] != '') {
		$result .= ' title="' . $params['title'] . '"';
	}
	if ($params['alt'] != '') {
		$result .= ' alt="' . $params['alt'] . '"';
	}
	if ($params['width'] != '') {
		$result .= ' width="' . $params['width'] . '"';
	}
	if ($params['height'] != '') {
		$result .= ' height="' . $params['height'] . '"';
	}
	$result .= '>';
	return 	$result;
}

/**
 * Creates post's list as image gallery.
 * $attr["name"] - The name of category.
 * $attr["id"] - The id of category.
 * $attr["count"] - (optional) Count of last posts for selecting.
 * 
 * @example [post_images name="Favorites"]
 * @example [post_images id="5"]
 * @example [static_image id="5" count="8"]
 * 
 * @param array $attr Shortcode's attributes.
 * @return string Html.
 */
function post_images($attr) {
    $params = shortcode_atts( array( 
        'name' => '',
        'id' => '',
        'count'=> '4'
    ), $attr );
        
    $html = '';
    $category_ID = null;
    
    // Collect category ID
    if ($params['name'] !== '') {
        $category_ID = get_cat_ID($params['name']);
    } elseif( $params['id'] !== '') {
        $category_ID = (int) $params['id'];
    }
    
    // If Category ID exists;
    if ($category_ID !== null) {
        $lang_category_ID = apply_filters('wpml_object_id', $category_ID, 'category', TRUE);
        $category = get_category($lang_category_ID);
        // Create header.
        $html .= '<div class="row"><div class="cell">';
        $html .= '<h3>' . $category->name . '</h3>';
        $html .= '</div></div>';    
        // Create images.
        $posts = new WP_Query('cat=' . $lang_category_ID . '&posts_per_page=' . $params['count']);
        $cnt = 0;
        while($posts->have_posts()) : $posts->the_post();
            if ($cnt++ % 4 == 0) {
                $html .= '<div class="row">';
            }
            $html .= '<div class="cell-25">'. get_the_post_image(true) . '</div>';
            if ($cnt % 4 == 0) {
                $html .= '</div>';
            } 
        endwhile;
        // If row doesn't close.
        if (!ends_with($html, '</div></div>')) {
            $html .= '</div>';    
        }        
    }
    
    return $html;
}

/**
 * Creates download link with icon.
 * $attr['file'] - Filename located in '/download/' static folder.
 * $attr['link'] - Link to internal or external resource.
 * $attr['title'] - (optional) Title for link.
 * 
 * @param array $attr Attributes.
 * @return string Html.
 */
function download_link($attr) {
    $params = shortcode_atts( array( 
        'file' => '',
        'link' => '',
        'title' => i18l('download.link.title')
    ), $attr );
    
    if ($params['file'] !== '') {
        $filename = $params['file'];        
        $icom_img = get_icon($filename);       
        $source = get_resource('/download/' . $filename);        
    } else if ($params['link'] !== '') {
        $source = $params['link'];
        $icom_img = get_icon($source);            
    } else {    
        return '<p style="color:red">'. i18l('download.error'). '</p>';    
    }
    $title = $params['title'];
    return '<p class="download"><span>'. i18l('download.title'). '&nbsp;:&nbsp;</span>' . 
           '<a href="' .  $source . '" target="_blank" title="' . $title . '">' . 
            $icom_img . '</a></p>';;
}

/**
 * Get icon by file extension.
 * If icon not found it creates empty icon.
 * 
 * @param string $path Path or link to file.
 * @return string Img tag with icon.
 */
function get_icon($path) {
    $array = explode('.', $path);
    $extension = end($array);        
    $icon_image = THEME_PATH . '\\i\\' . $extension . '.png';
        
    if (!file_exists ($icon_image)) {
        $icon = 'empty.png';
    } else {
        $icon = $extension . '.png';
    }
    return static_image(array('name' => $icon, 'alt' => ''));
}

/**
 * Register all shortcodes.
 */
function register_shortcodes(){
   add_shortcode('static_image', 'static_image');
   add_shortcode('post_images', 'post_images');
   add_shortcode('download_link', 'download_link');
}

// Add registration to WordPress’ initialization action.
add_action( 'init', 'register_shortcodes');