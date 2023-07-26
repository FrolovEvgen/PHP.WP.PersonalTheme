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
function sc_static_image($attr) {
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
	if (!isNullOrEmpty($params['class'])) {
		$result .= ' class="' . $params['class'] . '"';
	}
	if (!isNullOrEmpty($params['title'])) {
		$result .= ' title="' . $params['title'] . '"';
	}
	if (!isNullOrEmpty($params['alt'])) {
		$result .= ' alt="' . $params['alt'] . '"';
	}
	if (!isNullOrEmpty($params['width'])) {
		$result .= ' width="' . $params['width'] . '"';
	}
	if (!isNullOrEmpty($params['height'])) {
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
 * $attr["title"] - (optional) Text for heading.
 * $attr["title_id"] - (optional) Internationalization key for text.
 * 
 * @example [post_images name="Favorites"]
 * @example [post_images id="5"]
 * @example [static_image id="5" count="8"]
 * 
 * @param array $attr Shortcode's attributes.
 * @return string Html.
 */
function sc_post_images($attr) {
    $params = shortcode_atts( array( 
        'title' => '',
        'title_id' => '',
        'name' => '',
        'id' => '',
        'count'=> '4'
    ), $attr );
        
    $html = '';
    $category_ID = null;
    
    // Collect category ID
    if (!isNullOrEmpty($params['name'])) {
        $category_ID = get_cat_ID($params['name']);
    } elseif(!isNullOrEmpty($params['id'])) {
        $category_ID = (int) $params['id'];
    }
    
    // If Category ID exists;
    if (!isNullOrEmpty($category_ID)) {
        $lang_category_ID = apply_filters('wpml_object_id', $category_ID, 'category', TRUE);
        
        $title = '';    
        if (!isNullOrEmpty($params['title'])) {
            $title = $params['title'];
        } else if (!isNullOrEmpty($params['title_id'])) {
            $title = i18l($params['title_id']);
        } else {
            $category = get_category($lang_category_ID);
            $title = $category->name;
        }
        
        // Create header.
        $html .= '<div class="row"><div class="cell">';
        $html .= '<h3>' . $title . '</h3>';
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
 * $attr['title_id'] - (optional) Id for internationalization link title.
 * $attr['head'] - (optional) Name for link container.
 * $attr['head_id'] - (optional) Id for internationalization name for container.
 * 
 * @param array $attr Attributes.
 * @return string Html.
 */
function sc_download_link($attr) {
    $params = shortcode_atts( array( 
        'details_id' => '',
        'details' => '',
        'file' => '',
        'link' => '',
        'title' => '',
        'title_id' => 'download.link.title'
    ), $attr );
    
    if (!isNullOrEmpty($params['file'])) {
        $filename = $params['file'];        
        $icom_img = get_icon($filename);       
        $source = get_resource('/download.php?file=' . $filename);        
    } else if (!isNullOrEmpty($params['link'])) {
        $url = $params['link'];
        $icom_img = get_icon($url);
        $attachment_id = get_attachment_id($url);
        $source = get_resource('/download.php?attachment_id=' .  $attachment_id);
    } else {    
        return '<p style="color:red">' . i18l('download.error') . '</p>';    
    }
    
    $title = '';    
    if (!isNullOrEmpty($params['title'])) {
        $title = $params['title'];
    } else if (!isNullOrEmpty($params['title_id'])) {
        $title = i18l($params['title_id']);
    }
    
    $details = '';
    if (!isNullOrEmpty($params['details'])) {
        $details = $params['details'];
    } else if (!isNullOrEmpty($params['details_id'])) {
        $details = i18l($params['details_id']);
    }
    
    if (!isNullOrEmpty($details)) { 
        $details = '<span>' . $details . '&nbsp;:&nbsp;</span>';
    }
    
    return '<p class="download">' . $details . '<a href="' .  $source . 
            '" title="' . $title . '">' . $icom_img . '</a></p>';
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
    $icon_image = THEME_PATH . DS . 'i' . DS . $extension . '.png';
        
    if (!file_exists ($icon_image)) {
        $icon = 'empty.png';
    } else {
        $icon = $extension . '.png';
    }
    return sc_static_image(array('name' => $icon, 'alt' => ''));
}

/**
 * Get attachment id by URL.
 * @global Handler $wpdb WP Database connector.
 * @param string $url Attachment URL 
 * @return int Attachment id
 */
function get_attachment_id($url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $url )); 
    return $attachment[0]; 
}

/**
 * Creates italic decoration for specified content.
 * $attr['class'] - (optional) Adds specified class for tag.
 * 
 * @param array $attr Attributes.
 * @param string $content Text content.
 * 
 * @return string Decorated content.
 */
function sc_italic_format($attr, $content = null) {
    $params = shortcode_atts( array( 
        'class' => ''
    ), $attr );
    $class = '';
    $result = decorates($content);
    if (!isNullOrEmpty($params['class'])) {
        $class = ' class="' .  $params['class'] . '"';
    }
    return "<i$class>$result</i>";
}

/**
 * Creates bold decoration for specified content.
 * $attr['class'] - (optional) Adds specified class for tag.
 * 
 * @param array $attr Attributes.
 * @param string $content Text content.
 * 
 * @return string Decorated content.
 */
function sc_bold_format($attr, $content = null) {
    $params = shortcode_atts( array( 
        'class' => ''
    ), $attr );
    $class = '';
    $result = decorates($content);        
    if (!isNullOrEmpty($params['class'])) {
        $class = ' class="' .  $params['class'] . '"';
    }
    return "<b$class>$result</b>";
}

/**
 * Creates underline decoration for specified content.
 * $attr['class'] - (optional) Adds specified class for tag.
 * 
 * @param array $attr Attributes.
 * @param string $content Text content.
 * 
 * @return string Decorated content.
 */
function sc_underline_format($attr, $content = null) {
    $params = shortcode_atts( array( 
        'class' => ''
    ), $attr );
    $class = '';
    $result = decorates($content);
    if (!isNullOrEmpty($params['class'])) {
        $class = ' class="' .  $params['class'] . '"';
    }
    return "<u$class>$result</u>";
}

/**
 * Creates quotes decoration for specified content.
 * $attr['class'] - (optional) Adds specified class for tag.
 * 
 * @param array $attr Attributes.
 * @param string $content Text content.
 * 
 * @return string Decorated content.
 */
function sc_quotes_format($attr, $content = null) {
    $params = shortcode_atts( array( 
        'class' => ''
    ), $attr );
    $class = '';
    $result = decorates($content);
    if (!isNullOrEmpty($params['class'])) {
        $class = ' class="' .  $params['class'] . '"';
        return "&laquo;<span$class>$result</span>&raquo;";
    }
    return "&laquo;$result&raquo;";
}

/**
 * Decorates text according specified tags.
 * 
 * @param string $content Text content.
 * 
 * @return string Decorated text.
 */
function decorates($content) {
    $result = bold_decorate($content);
    $result = underline_decorate($result);
    $result = italic_decorate($result);
    return quotes_decorate($result);
}

/**
 * Decorates text with bold style.
 * 
 * @param string $content Text content.
 * 
 * @return string Decorated text.
 */
function bold_decorate($content) {
    $pattern = '/\[bold\s*class\s*=\s*[\"|\'](.*)[\"|\']\s*\](.*)\[\/bold\]/';
    $template = '<b class="$1">$2</b>';    
    if (preg_match($pattern, $content) == 0) { 
        $pattern = '/\[bold\](.*)\[\/bold\]/';
        $template = '<b>$1</b>';        
    }
    return preg_replace($pattern, $template, $content);
}

/**
 * Decorates text with underline style.
 * 
 * @param string $content Text content.
 * 
 * @return string Decorated text.
 */
function underline_decorate($content) {
    $pattern = '/\[undelrine\s*class\s*=\s*[\"|\'](.*)[\"|\']\s*\](.*)\[\/underline\]/';
    $template = '<u class="$1">$2</u>';    
    if (preg_match($pattern, $content) == 0) { 
        $pattern = '/\[underline\](.*)\[\/underline\]/';
        $template = '<u>$1</u>';        
    }
    return preg_replace($pattern, $template, $content);
}

/**
 * Decorates text with italic style.
 * 
 * @param string $content Text content.
 * 
 * @return string Decorated text.
 */
function italic_decorate($content) {
    $pattern = '/\[italic\s*class\s*=\s*[\"|\'](.*)[\"|\']\s*\](.*)\[\/italic\]/';
    $template = '<i class="$1">$2</i>';    
    if (preg_match($pattern, $content) == 0) { 
        $pattern = '/\[italic\](.*)\[\/italic\]/';
        $template = '<i>$1</i>';        
    }
    return preg_replace($pattern, $template, $content);
}

/**
 * Decorates text with quotes.
 * 
 * @param string $content Text content.
 * 
 * @return string Decorated text.
 */
function quotes_decorate($content) {
    $pattern = '/\[quotes\s*class\s*=\s*[\"|\'](.*)[\"|\']\s*\](.*)\[\/quotes\]/';
    $template = '&laquo;<span class="$1">$2</span>&raquo;';    
    if (preg_match($pattern, $content) == 0) { 
        $pattern = '/\[quotes\](.*)\[\/quotes\]/';
        $template = '&laquo;$1&raquo;';        
    }
    return preg_replace($pattern, $template, $content);
}

/**
 * Builds the Caption shortcode output.
 * 
 * The supported attributes for the shortcode are 'id', 'align', 'width', 'max-width' and
 * 'caption'.
 * 
 * @param array  $attr {
 *     Attributes of the caption shortcode.
 *
 *     @type string $id         ID of the div element for the caption.
 *     @type string $align      Class name that aligns the caption. 
 *                              Default 'alignnone'. 
 *                              Accepts 'alignleft', 'aligncenter', alignright', 'alignnone'.
 *     @type int    $width      The width of the caption, in pixels or %.
 *     @type int    $max-width  The width of the caption, in pixels or %.
 *     @type string $caption    The caption text.
 *     @type string $class      Additional class name(s) added to the caption container.
 * }
 * @param string $content Shortcode content.
 * 
 * @return string HTML content to display the caption.
 */
function sc_caption_image($attr, $content = null) {
    // New-style shortcode with the caption inside the shortcode with the link and image tags.
    if ( ! isset( $attr['caption'] ) ) {
        if ( preg_match( '#((?:<a [^>]+>\s*)?<img [^>]+>(?:\s*</a>)?)(.*)#is', $content, $matches ) ) {
            $content = $matches[1];
            $attr['caption'] = trim( $matches[2] );
        }
    } elseif ( strpos( $attr['caption'], '<' ) !== false ) {
        $attr['caption'] = wp_kses( $attr['caption'], 'post' );
    }      
    
    $atts = shortcode_atts( array(
        'id'        => '',
        'align'     => 'alignnone',
        'width'     => '',
        'max-width' => '',
        'caption'   => '',
        'class'     => '',
	), $attr, 'caption' );   
    
    if ( (empty($atts['width']) && empty($atts['max-width'])) || 
            empty( $atts['caption'] ) ) {
	return $content;
    }
    
    if ( ((int) $atts['width']) < 1 && ((int) $atts['max-width'])< 1) {
        return $content;
    }
    
    $class = trim( 'wp-caption ' . $atts['align'] . ' ' . $atts['class'] );

    $html5 = current_theme_supports( 'html5', 'caption' );
    $tag_attr = array();
    if ( ! empty( $atts['id'] ) ) {
        $tag_attr['id'] = esc_attr( sanitize_html_class( $atts['id'] ) ) ;
    }       
    
    if ( ! empty( $atts['class'] ) ) {
        $tag_attr['class'] = esc_attr( $class );
    }
    
    $style = join( ';', get_style($atts));
    
    if ( ! empty( $style ) ) {
        $tag_attr['style'] = $style;
    }
    
    $caption = do_shortcode( $content );
    
    if ( $html5 ) {       
        
        if (! empty($atts['caption'])) {
            $caption .= build_tag("figcaption", array("class" => "wp-caption-text"), $atts['caption']);    
        }
        
        $html = build_tag("figure", $tag_attr,  $caption);        
         
    } else {
	if (! empty($atts['caption'])) {
            $caption .= build_tag("p", array("class" => "wp-caption-text"), $atts['caption']);    
        }
        
        $html = build_tag("div", $tag_attr,  $caption);  
    }    
    
    return $html;
}

/**
 * Gets styles as array.
 * 
 * Now supports 'width' and 'max-width' only. 
 * 
 * @param array $attr  Attributes of the caption shortcode.
 * 
 * @return array     Style attributes.
 */
function get_style($attr) {
    $style_arr = array();
    
    if (isset($attr['width']) && !empty($attr['width'])) {
        $style_arr[] = parse_length('width', $attr);    
    }
    
    if (isset($attr['max-width']) && !empty($attr['max-width'])) {
        $style_arr[] = parse_length('max-width', $attr);    
    }
    
    return $style_arr;
} 

/**
 * Parse numeric attribute.
 * 
 * @param string $name Name of attribute.
 * @param array $attr Attributes of the caption shortcode.
 * 
 * @return string Parsed attribute with px or %. 
 */
function parse_length($name, $attr) {    
    
    $value = trim($attr[$name]);
    $int_value = (int) $value;

    if (str_endWith($value, '%')) {
        return $name . ': ' . (int) $int_value . '%';
    } else {
        $html5 = current_theme_supports( 'html5', 'caption' );    
        $int_value = $html5 ? $int_value : ( 10 + $int_value );
        return $name . ': ' . (int) $int_value . 'px';
    }
}

/**
 * Build tag with name, attributes and content.
 * 
 * @param string $name Tag name.
 * @param array $attr Attributes of the tag.
 * @param string $content String content.
 * 
 * @return string HTML content.
 */
function build_tag($name, $attr, $content = null) {
    $tag = "<$name ";
    $attributes = array();
    
    foreach ($attr as $key => $value) {
        $attributes[] = "$key=\"$value\"";
    }
    $tag .=  join(' ', $attributes);
    
    return $tag . ">" . $content . "</$name>";
}

/**
 *  Checks if a string ends with a given substring
 * 
 * @param string $haystack The string to search in.
 * @param string $needle The substring to search for in the haystack.
 * 
 * @return boolen Returns true if haystack ends with needle, false otherwise.
 */
function str_endWith($haystack, $needle) {
    return substr($haystack, (strlen($haystack) - strlen($needle)), 
            strlen($needle)) === $needle;    
}
 
/**
 * Register all shortcodes.
 */
function register_shortcodes() {
   add_shortcode('static_image', 'sc_static_image');
   add_shortcode('post_images', 'sc_post_images');
   add_shortcode('download_link', 'sc_download_link');
   add_shortcode('underline', 'sc_underline_format');
   add_shortcode('bold', 'sc_bold_format');
   add_shortcode('italic', 'sc_italic_format');
   add_shortcode('quotes', 'sc_quotes_format');
   add_shortcode('caption_image', 'sc_caption_image');
}

// Add registration to WordPress’ initialization action.
add_action( 'init', 'register_shortcodes');