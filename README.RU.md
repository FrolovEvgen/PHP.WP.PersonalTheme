# PHP.WP.PersonalTheme.
[ [**En**](/README.md) | **Ru** ]

## Описание.

WordPress тема для персонального сайта. 

![Screen1](/screenshot.jpg)

## Требования.

WordPress: >= **5.4**

PHP: **5.6**

## Иерархия файлов/папок.

### Корневая структура.

* `classes/` - Подключаемые классы.
* `css/` - Стили для темы.
* `i/` - Статические картинки.
* `inc/` - Подключаемые модули.
* `js/` - JS скрипты.
* `lang/` - Переводы.
* `templates/` - Подключаемые шаблоны.
* `category.php` - Шаблон для списка статей.
* `download.php` - Скрипт для скачивания файла.
* `footer.php` - Шаблон нижней части сайта.
* `front-page.php` - ШАблон главной страницы.
* `functions.php` - Определения и функции для темы.
* `header.php` - Шаблон верхней части сайта.
* `index.php` - Основной шаблон темы. 
* `page.php` - Шаблон отображения одиночной страницы. 
* `screenshot.jpg` - Картинка предпросмотра темы.
* `sidebar.php` - Боковая панель с виджетами.
* `single.php` - Шаблон отображения одиночной статьи.
* `style.css` - Описание для темы.

### Подключаемые классы

* `AbstractEntity.php` - Класс `AbstractEntity` базовый абстрактный класс.
* `AbstractParamEntity.php` - Класс `AbstractParamEntity` абстрактный класс с параметрами.
* `Properties.php` - Класс `Properties` для работы с параметрами "Ключ/Значение".
* `Settings.php` - Класс `Settings` используется для загрузки и работы с настройками загружаемые из `*.ini` файла.

### Подключаемые модули.

* `i18l.php` -  Для работы с локализацией.
* `shortcodes.php` - Шорткоды для темы.

### Подключаемые шаблоны
* `empty_posts.php` -  Шаблон для пустой статьи.
* `posts.php` - Шаблон для предпросмотра статьи в списке.

## Виджеты.

Нет.

## Плагины.

Нет.

## Шорткоды.

* `static_image` - Отображает картинки с конфигурацией.
* `post_images` - Отображает список статей, как галерею превьюшек.
* `download_link` - Создает ссылку на скачивание с иконкой.
* `underline` - создает подчеркивание текста.
* `bold` - Создает жирный текст.
* `italic` - Создает наклонный текст.

### [static_image]

Загружает статическое изображение из папки `/i/` и отображает его.

#### Параметры.

* `name` - Имя файла изображения.
* `title` - (необязательный) Название изображения.
* `alt` - (необязательный) Альтернативное описание.
* `width` - (необязательный) Ширина изображения.
* `height` - (необязательный) Высота изображения.

#### Примеры использования.

* `[static_image name="test.jpg" title="Test image"]`
* `[static_image name="test.jpg" alt="This is test"]`
* `[static_image name="test.jpg" width="100" height="100"]` 

### [post_images]

Загружает последние статьи по категории и отображает их в виде галереи с изображениями, которые содержат ссылки на оригинальную статью.
Для загрузки использовать ИД или название категории. Если есть WMPL, то корректно отобразит статьи под переводом категории.

#### Параметры.

* `name` - Имя категории.
* `id` - ИД категории.
* `count` - (необязательный) Число последних статей. [По-умолчанию = 4]
* `title` - (optional) Заголовок для блока.
* `title_id` - (optional) Ключ для интернациии заголовка.

#### Примеры использования.

* `[post_images name="Favorites"]`
* `[post_images id="5"]`
* `[static_image id="5" count="8"]` 

### [download_link]

Создает ссылку на скачивание файла с иконкой, в зависимости от типа файла. Если иконки не найдено, возвращает иконку документа.

#### Параметры.

* `file` - Имя файла находящегося в папке '/download/'.
* `link` - Ссылка на внутренний или внешний ресурс.
* `title` - (optional) Заголовок для ссылки.
* `title_id` - (optional) Ключ для интернациии заголовка ссылки.
* `details` - (optional) Детальный текст для ссылки.
* `details_id` - (optional) Ключ для интернационализации текста.

#### Примеры использования.

* `[download_link file='test.pdf' title='Тестовый PDF']`
* `[download_link link='http://wordpress.tst:81/wp-content/uploads/2020/05/2615001.pdf']`
* `[download_link file='test.pdf' details='Ссылка для скачивания']`

### [underline]

Создает подчеркивание текста.

#### Параметры.

* `class` - (optional) Добавляет дополнительные классы.

#### Примеры использования.

* `[underline]Text[/underline]`
* `[underline class="RedText"]Text[/underline]`

### [bold]

Создает жирный текст.

#### Параметры.

* `class` - (optional) Добавляет дополнительные классы.

#### Примеры использования.

* `[bold]Text[/bold]`
* `[bold class="RedText"]Text[/bold]`

### [italic]

Создает наклонный текст.

#### Параметры.

* `class` - (optional) Добавляет дополнительные классы.

#### Примеры использования.

* `[italic]Text[/italic]`
* `[italic class="RedText"]Text[/italic]`

### [caption_image]

Создает изображение с подписью.

#### Параметры.

* `id` - ID для тега контейнера.
* `width` - Ширина элемента, в px или %.
* `max-width` - Максимальная ширина элемента, в px или %.
* `align`- (optional) Имя класса для выравнивания элемента. По умолчанию 'alignnone'. Принимает 'alignleft', 'aligncenter', alignright', 'alignnone'.
* `caption`- (optional) Текст подписи.
* `class`- (optional) Дополнительные классы стилей элемента.

#### Примеры использования.

* `[caption_image id="attachment_97" class="img" align="aligncenter" max-width="231"]<img src="http://wordpress.tst:81/wp-content/uploads/2020/06/lcage-231x300.jpg" alt="Alt" width="100%" height="auto" class="size-medium wp-image-97" /> podpis 1[/caption_image]`


## Ссылки.

Работающий пример: https://frolov.kyiv.ua

## Использованы ресурсы.

- Онлайн минификатор (js & css): https://www.uglifyjs.net/
- Сжатие картинок: https://imagecompressor.com/
- Иконки от [**Smashicons**](https://www.flaticon.com/authors/smashicons) взяты с [**www.flaticon.com**](https://www.flaticon.com/packs/file-types)