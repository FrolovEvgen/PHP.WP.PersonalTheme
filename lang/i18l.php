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
 * Theme's localization functions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */

/**
 * Import classes.
 */
import ('/classes/AbstractEntity.php');
import ('/classes/Properties.php');
import ('/classes/AbstractParamEntity.php');
import ('/classes/Settings.php');

/**
 * Load language setting.
 */
/**
 * @var Settings Language settings.
 */
global $settings;
$settings = new Settings();
$settings->load('i18l');

/**
 * Get translation by key.
 * @param string $key
 */
function i18l($key) {
    global $settings;
    $locale = get_locale();    
    if (!$settings->isExists($locale)){
        $locale = 'default';
    }
    
    /**
     * @var Properties Translations.
     */
    $properties = $settings->get($locale);
    
    return $properties->get($key);
}
