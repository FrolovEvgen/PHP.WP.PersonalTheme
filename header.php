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
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything 
 * up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */
?>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />    
        <meta name="revisit-after" content="7 Day" />
        <meta name="distribution" content="global" />
        <meta name="robots" content="index,follow" />
        <meta name="classification" content="Personal page">
        <meta name="copyright" content="2010 - <?php echo date('Y') ?> (C) Фролов Евгений <frolov[AT]amiriset.com>">
        <meta name="developer" content="Фролов Евгений <frolov[AT]amiriset.com>">
        <link rel="profile" href="https://gmpg.org/xfn/11" />
        <title><?php echo wp_get_document_title(); ?></title>
        <?php wp_head(); ?>
    </head>
    <body>
        <header>                
            <div id="top">
                <div class="container">
                    <div class="row">
                        <div id="logo">
                            <div>
                                <img src="<?=get_resource('/i/logo.jpg'); ?>" alt=""/>
                            </div>                            
                        </div>
                        <div class="cell-auto">
                            <nav class="navbar">
                                <a class="brand" href="<?= site_url() ?>"><?=i18l('author.title') ?></a>
                                <button class="class-toggler" data-item="topContent" data-class="collapsed"><?=i18l('menu.title') ?></button>                                    
                                <div class="content collapsed" id="topContent">
                                    <?php print_top_menu('menu-ru'); ?>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div> 
        </header>
        <br>

