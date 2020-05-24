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
 * Script for download file.
 * Downloads script from static '/download/' folder or from attachment id.
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */


/**
 * Read script parameters.
 * @param string $field Field name.
 * @param string $default Default value;
 * @return string Parameter value or NULL;
 */
function read_param($field, $default = NULL) {
    $var = $default;

    if (isset($_POST[$field]) && $_POST[$field] != '') {
        $var = $_POST[$field];
    } else if (isset($_GET[$field]) && $_GET[$field] != '') {
        $var = $_GET[$field];
    }
    
    return $var;
}

/**
 * Check if file exit, set and has correct path.
 * @param string $file Path to file.
 */
function check_file($file) {
    if (!isset($file)) {
        die(i18l('download.script.error2'));
    }
    
    if (strpos($file, '..') !== FALSE) {        
        die(i18l('download.script.error3'));
    }
    
    if (!file_exists($file) || empty($file)) {
        die(i18l('download.script.error4'));
    }    
}

/**
 * Start downloads specified file.
 * @param string $file Download path to file.
 */
function download_file($file) { // $file = include path 
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));

    ob_clean();
    flush();
    readfile($file);
}

// Load wp core
$path = explode( 'wp-content', __FILE__ );

if ( is_file( reset( $path ) . 'wp-load.php' ) ) {
	include_once( reset( $path ) . 'wp-load.php' );
} else {
	die(i18l('download.script.error1'));
}

// Get script location.
$theme_path = dirname(__FILE__);

// Try to check if filename set.
$file = read_param('file');
if ($file !== NULL) {
    $file = $theme_path . '/download/' . $file;    
} else {
    // Get file from attachment id.
    $attachment_id = read_param('attachment_id');
    if ($attachment_id === NULL ) {
        die(i18l('download.script.error5'));
    }
    $file = get_attached_file($attachment_id);
}
check_file($file);
download_file($file);
exit;