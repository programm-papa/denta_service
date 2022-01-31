<?php
/**
 * Denta_Service functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Denta_Service
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function denta_service_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on Denta_Service, use a find and replace
		* to change 'denta_service' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'denta_service', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'denta_service' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'denta_service_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'denta_service_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function denta_service_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'denta_service_content_width', 640 );
}
add_action( 'after_setup_theme', 'denta_service_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function denta_service_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'denta_service' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'denta_service' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'denta_service_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function denta_service_scripts() {
	wp_enqueue_style( 'denta_service-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'denta_service-style', 'rtl', 'replace' );

	wp_enqueue_script( 'denta_service-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'denta_service_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

//	Carbon Fields Registration
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
function crb_attach_theme_options() {
	Container::make( 'theme_options', 'Настройки сайта' )
	->add_fields(array(
		//Адрес
		Field::make('text', 'adress-text', 'Строка адреса')
		->set_width(50),
		Field::make('text', 'adress-coordinates', 'Строка координат из яндекс карт в формате')
		->set_width(50)
		->help_text('<p><b>В формате</b> <i>58.512249, 31.247035</i></p>'),
		//Номер телефона
		Field::make('text', 'phone', 'Строка номера')
		->set_width(100)
		->help_text('<p><b>В формате</b> <i>+7 (8162) 22-21-01</i></p>'),
		//Режим работы
		Field::make('complex', 'operating-mode', "Рабочие дни")
		->add_fields(array(
			Field::make( 'select', 'first-operating-day', 'Первый день' )
			// Добавляем опции (варианты ответов)
			->add_options( array( '','Пн', "Вт", "Ср", "Чт", "Пт" ,"Сб", "Вс" ))
			// Добавляем пояснение к полю, которое будет отображено под выпадающим списком из ответов
			->set_width(25),
			Field::make( 'select', 'last-operating-day', 'Последний день' )
			// Добавляем опции (варианты ответов)
			->add_options( array( '','Пн', "Вт", "Ср", "Чт", "Пт" ,"Сб", "Вс" ))
			// Добавляем пояснение к полю, которое будет отображено под выпадающим списком из ответов
			->set_width(25),
			Field::make('text', 'time-start', 'Работаем От')
			->set_width(25),
			Field::make('text', 'time-end', 'Работаем До')
			->set_width(25),
		)),
		Field::make('complex', 'main-slider', "Главный слайдер")
		->add_fields(array(
			Field::make("file", "slide-img", "Картинка слайда")
			->set_value_type('url') // сохранить в метаполе ссылку на файл
			->set_width(25),
			Field::make('text', 'slide-title', 'Оглавление слайда')
			->set_width(25),
			Field::make('textarea', 'slide-description', 'Описание слайда')
			->set_width(50),
		))
		->help_text('<p><b>Слайдер:</b> тут находится все необходимое для главного слайдера</p>'),
	));

	Container::make( 'term_meta', 'Настройки списка услуг' )
		->show_on_taxonomy( 'service_options' ) // По умолчанию, можно не писать
		->add_fields( array(
			Field::make( 'image', 'thumb', 'Миниатюра' ),
	));
		
}

