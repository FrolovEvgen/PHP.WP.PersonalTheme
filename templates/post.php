<?php

/* 
 * The MIT License
 *
 * Copyright 2020 evGen.
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
 * The theme's template for display post preview.
 *
 * @package WordPress
 * @subpackage EFrolov_Theme
 */
?>
<div class="container">
    <div class="row">
        <div class="cell"><h2><?php the_title() ?></h2></div>                            
    </div>
    <div class="row">
        <div class="cell-25">
            <?php print_post_image() ?>
        </div>
        <div class="cell-auto">
            <p class="description"><?=get_the_excerpt() ?></p>
            <p class="readmore"><a
                    href="<?php the_permalink(); ?>" 
                    title="<?php the_title_attribute(array(
                        'before' => 'Permalink to: ', 
                        'after' => ''
                        )); ?>"><?=i18l('read.more.title') ?></a></p>
            <hr>
            <p class="category"><?=i18l('categories.title') ?>: <?=$params['links'] ?></p>
            <p class="tags"><?=i18l('tags.title') ?>: <?php the_tags(); ?></p>
        <div>
    </div>                            
</div>
       
