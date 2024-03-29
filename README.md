# PHP.WP.PersonalTheme.
[ **En** | [**Ru**](/README.RU.md) ]

## Description.

WordPress theme for my personal site. 

![Screen1](/screenshot.jpg)

## Requirements.

Requires WordPress: >= **5.4**

Requires PHP: **5.6**

## Template Hierarchy.

### Root files.

* `classes/` - Included classes.
* `css/` - Style sheets for theme.
* `i/` - Static images.
* `inc/` - Included modules.
* `js/` - Javascripts.
* `lang/` - Translations.
* `templates/` - Included templates.
* `category.php` - The template for displaying all single posts.
* `download.php` - Script for download file.
* `footer.php` - The template for displaying the footer.
* `front-page.php` - The template for displaying main page.
* `functions.php` - Theme's functions and definitions.
* `header.php` - The header for our theme.
* `index.php` - The main template file. 
* `page.php` - The template for displaying all single pages (page post-type). 
* `screenshot.jpg` - The theme's preview.
* `sidebar.php` - The sidebar containing the main widget area.
* `single.php` - The template for displaying all single posts.
* `style.css` - The main stylesheet contains the information header for this theme.

### Included classes.

* `AbstractEntity.php` - Class `AbstractEntity` is base class for complex objects.
* `AbstractParamEntity.php` - Class `AbstractParamEntity` is abstract class with parameters.
* `Properties.php` - Class `Properties` is single key/value list.
* `Settings.php` - Class `Settings` is used to control the basic settings of a component loaded from a `*.ini` file or specified by local settings.

### Included modules.

* `i18l.php` -  The theme's localization functions.
* `shortcodes.php` - The theme's useful shortcodes.

### Included templates.
* `empty_posts.php` -  The theme's template for empty post.
* `posts.php` - The theme's useful shortcodes.

## Widgets.

None.

## Plugins.

None.

## Shortcodes.

* `static_image` - Shows image with specific tag.
* `post_images` - Creates post's list as image gallery.
* `download_link` - Creates download link with icon.
* `underline` - Creates underline decoration for specified content.
* `bold` - Creates bold decoration for specified content.
* `italic` - Creates italic decoration for specified content.
* `caption_image` - Builds the image with caption.

### [static_image]

Loads static image from `/i/` folder and show it.

#### Attributes

* `name` - Image filename.
* `title` - (optional) Image title.
* `alt` - (optional) Alternative description.
* `width` - (optional) Image width.
* `height` - (optional) Image height.

#### Examples

* `[static_image name="test.jpg" title="Test image"]`
* `[static_image name="test.jpg" alt="This is test"]`
* `[static_image name="test.jpg" width="100" height="100"]` 

### [post_images]

Loads last thumbnails from post in specified category. All thimbnails shows with 
link to related post.

#### Attributes

* `name` - The name of category.
* `id` - The id of category.
* `count` - (optional) Count of last posts for selecting. [default = 4]
* `title` - (optional) Title for head.
* `title_id` - (optional) Internationalization key for title.

#### Examples

* `[post_images name="Favorites"]`
* `[post_images id="5"]`
* `[static_image id="5" count="8"]` 

### [download_link]

Creates download link with icon, which dependence on file extension. If not found related icon it creates default icon.

#### Attributes

* `file` - Name of file located in '/download/' static folder.
* `link` - Link to internal or external resource.
* `title` - (optional) Title for link.
* `title_id` - (optional) Internationalization key for title.
* `details` - (optional) Details text for link.
* `details_id` - (optional) Internationalization key for details.

#### Examples

* `[download_link file='test.pdf' title='Test PDF']`
* `[download_link link='http://wordpress.tst:81/wp-content/uploads/2020/05/2615001.pdf']`
* `[download_link file='test.pdf' details='Special downloads']`

### [underline]

Creates underline decoration for specified content.

#### Attributes

* `class` - (optional) Adds specified class for tag.

#### Examples

* `[underline]Text[/underline]`
* `[underline class="RedText"]Text[/underline]`

### [bold]

Creates bold decoration for specified content.

#### Attributes

* `class` - (optional) Adds specified class for tag.

#### Examples

* `[bold]Text[/bold]`
* `[bold class="RedText"]Text[/bold]`

### [italic]

Creates italic decoration for specified content.

#### Attributes

* `class` - (optional) Adds specified class for tag.

#### Examples

* `[italic]Text[/italic]`
* `[italic class="RedText"]Text[/italic]`

### [caption_image]

Builds the image with caption.

#### Attributes

* `id` - ID of the div element for the caption.
* `width` -  The width of the caption, in pixels or %.
* `max-width` - The max width of the caption, in pixels or %.
* `align`- (optional) Class name that aligns the caption. Default 'alignnone'. Accepts 'alignleft', 'aligncenter', alignright', 'alignnone'.
* `caption`- (optional) The caption text.
* `class`- (optional) Additional class name(s) added to the caption container.

#### Examples

* `[caption_image id="attachment_97" class="img" align="aligncenter" max-width="231"]<img src="http://wordpress.tst:81/wp-content/uploads/2020/06/lcage-231x300.jpg" alt="Alt" width="100%" height="auto" class="size-medium wp-image-97" /> podpis 1[/caption_image]`

## Link.

Working link: https://frolov.kyiv.ua

## Used online utilities.

- Online minifier (js & css): https://www.uglifyjs.net/
- Image compressor: https://imagecompressor.com/
- Icons made by [**Smashicons**](https://www.flaticon.com/authors/smashicons) from [**www.flaticon.com**](https://www.flaticon.com/packs/file-types)