<?php
	/**
	 * Starkers functions and definitions
	 *
	 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
	 *
	 * @package 	WordPress
	 * @subpackage 	Starkers
	 * @since 		Starkers 4.0
	 */

	/* ========================================================================================================================
	
	Required external files
	
	======================================================================================================================== */

	require_once( 'external/starkers-utilities.php' );
	require_once( 'external/metabox-utilities.php' );



	/* ========================================================================================================================
	
	Register scripts and CSS
	
	======================================================================================================================== */

	function starkers_script_enqueuer() {
		wp_register_script( 'site', get_template_directory_uri().'/js/scripts.min.js', array( 'jquery' ) );
		wp_enqueue_script( 'site' );

		wp_register_style( 'screen', get_stylesheet_directory_uri().'/style.css', '', '', 'screen' );
		wp_enqueue_style( 'screen' );
	}


	//Custom admin styles
	function my_admin_theme_style() {
		wp_enqueue_style('admin-custom-style', get_template_directory_uri() . '/admin.css');
	}
	add_action('admin_enqueue_scripts', 'my_admin_theme_style');


	//Custom admin scripts
	function my_admin_script() {
		wp_register_script( 'admin-custom-script', get_template_directory_uri().'/js/admin.js', array( 'jquery' ),'',true );
		wp_enqueue_script( 'admin-custom-script' );
	}
	add_action('admin_enqueue_scripts', 'my_admin_script',9999);



	//Load WP Contact Form 7 plugin dependencies only if its shortcode is present
	function dvk_dequeue_scripts() {
		$load_scripts = false;
		if( is_singular() ) {
			$post = get_post();
			if( has_shortcode($post->post_content, 'contact-form-7') ) {
				$load_scripts = true;
				//Additional scripts that may be used with CF7
				wp_enqueue_style( 'select2-style', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css' );
				wp_enqueue_script( 'select2-js', '//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js');
			}
		}
		if( ! $load_scripts ) {
			wp_dequeue_script( 'contact-form-7' );
			wp_dequeue_style( 'contact-form-7' );
		}
	}
	
	add_action( 'wp_enqueue_scripts', 'dvk_dequeue_scripts', 99 );



	/* ========================================================================================================================
	
	Theme specific settings - theme support, menus, thumbnails

	======================================================================================================================== */

	//Add theme support for various features
	add_theme_support('post-thumbnails');
	add_theme_support('menus');
	add_theme_support('widgets');
	add_theme_support( 'html5', array( 'search-form', 'caption', 'gallery') );


	// Create menu locations
	register_nav_menus(
		array(
			'mainmenu' => 'Меню в шапке'
			,'socialmenu' => 'Меню соцсетей'
		)
	);

	// Main thumbnail size
	//thumbnail = news thumb
	//medium = teacher
	//large = gallery photos, contact route photos
	//Custom post thumbnail sizes
	// add_image_size( 'test-lang-symbol', 9999, 140, false ); //(cropped)

	//Register widget areas
	function widgets_init_now() {
		register_sidebar( array(
			'name' => 'Текст вверху шапки'
			,'id' => 'header_top'
			,'description' => 'Добавьте сюда виджет "Текст" из левой части страницы. Несколько виджетов будут расположены в строчку. Названия виджетов на сайте не отобразятся'
		) );
		register_sidebar( array(
			'name' => 'Блок для виджета рассылки в подвале'
			,'id' => 'footer_mailings'
			,'description' => 'Добавьте сюда виджет "Текст" из левой части страницы. Названия виджетов на сайте не отобразятся'
		) );
		register_sidebar( array(
			'name' => 'Блок контактов в подвале'
			,'id' => 'footer_contacts'
			,'description' => 'Добавьте сюда виджет "Текст" из левой части страницы. Названия виджетов на сайте не отобразятся'
		) );
		register_sidebar( array(
			'name' => 'Подробнее о системе обучения в Linguamore'
			,'id' => 'homepage_education-feats'
			,'description' => 'Блок, расположенный на странице "Преимущества". Добавьте сюда виджет "Rich Text" из левой части страницы. Иконки можно добавить кнопкой "Add Media". Названия виджетов на сайте не отобразятся'
		) );
	}
	add_action( 'widgets_init', 'widgets_init_now' );



	/* ========================================================================================================================
	
	Actions and filters
	
	======================================================================================================================== */

	add_action( 'wp_enqueue_scripts', 'starkers_script_enqueuer', 999 );


	add_filter( 'body_class', array( 'Starkers_Utilities', 'add_slug_to_body_class' ) );


	//turn off categories
	function wpse120418_unregister_categories() {
		register_taxonomy( 'category', array() );
	}
	add_action( 'init', 'wpse120418_unregister_categories' );


	//makes all classes in custom menu dissappear, except noted
	function css_attributes_filter($var) {
		return is_array($var) ? array_intersect($var, array('current-menu-item','current_page_item','current-page-ancestor','current-menu-ancestor','current-menu-parent')) : '';
	}
	// add_filter('nav_menu_css_class', 'css_attributes_filter', 100, 1); 
	add_filter('nav_menu_item_id', 'css_attributes_filter', 100, 1);



	/* ========================================================================================================================
	
	Admin changes
	
	======================================================================================================================== */

	//Remove comments from admin
	function remove_menus(){
		remove_menu_page( 'edit-comments.php' );//Comments
	}
	add_action( 'admin_menu', 'remove_menus' );


	function unregister_taxonomy(){
		register_taxonomy('post_tag', array());
	}
	add_action('init', 'unregister_taxonomy');


	//add excerpts to pages
	add_action( 'init', 'add_excerpts_to_pages' );
	function add_excerpts_to_pages() {
		add_post_type_support( 'page', 'excerpt' );
	}


	//Change main query parameters (for default archive pages or by url variables)
	function change_query_parameters( $query ) {
		if ( is_admin() || ! $query->is_main_query() ) 
			return;

		if (is_home() && !(isset($_GET['post_type']) && $_GET['post_type'] === 'post')) {
			$query->set( 'posts_per_page', 3 );
		}
	}
	add_action( 'pre_get_posts', 'change_query_parameters', 1 );


	//more fields http://themefoundation.com/wordpress-theme-customizer/
	//get options with get_theme_mod('setting_id','some value if setting is blank');

	function site_customize_register($wp_customize){

		$wp_customize->remove_section('title_tagline');
		$wp_customize->remove_section('nav');
		$wp_customize->remove_panel('widgets');
		$wp_customize->remove_section('static_front_page');

		$wp_customize->add_section('custom_options_section_id', array( 
			'title' => 'Дополнительные настройки',
			'description' => 'Настройки для разных частей сайта',
			// 'priority' => 10
		));

		$wp_customize->add_setting('languages_letsgo_russian', array(
			// 'default'    => ''
		));
		 
		$wp_customize->add_control('languages_letsgo_russian', array(
			'label' => 'Текст на русском языке под фото преподавателя',
			'section' => 'custom_options_section_id',
			'description' => 'aka <em>Поехали!</em>',
			'type' => 'text'
		));
	}
	add_action('customize_register', 'site_customize_register');



	/* ========================================================================================================================
	
	Reusable functions
	
	======================================================================================================================== */

	function custom_is_archive() {return (is_archive() || is_search());} // || is_page_template('template-custompage.php')
	function custom_is_newsarchive() {return ((get_query_var('post_type') === 'post' && is_home()) || custom_is_part_archive('post') || is_category() || is_tag() || is_date() );}
	function custom_is_news() {return ( custom_is_newsarchive() || is_singular('post') );}
	function custom_is_teacher_archive() {return ( is_post_type_archive('teacher') || custom_is_part_archive('teacher') );}
	function custom_is_teachers() {return ( is_post_type_archive('teacher') || is_singular('teacher') );}
	function custom_is_languages() {return ( is_post_type_archive('language') || is_singular('language') );}
	function test_is_adv() {return ( isset($_GET['is_advanced']) && $_GET['is_advanced'] == 'true' );}


	//Check if a custom query of selected post types is in action
	function custom_is_part_archive($post_types = array()) {
		global $custom_wp_query;

		if ( isset($custom_wp_query) ) {
			if (!isset($post_types) || empty($post_types)) { //if no parameters at all
				return true;
			} else {
				if (!is_array($post_types)) { //if parameter is string
					$post_types_arr[] = $post_types;
				} else {
					$post_types_arr = $post_types;
				}
				global $post;
				foreach ($post_types_arr as $post_type) {
					if ($post->post_type == $post_type) {
						return true;
					}
				}
			}
		} else {
			return;
		}
	}


	/**
	 * Get the current Url taking into account Https and Port
	 * @link http://css-tricks.com/snippets/php/get-current-page-url/
	 * @version Refactored by @AlexParraSilva
	 */
	function getCurrentUrl() {
		$url  = isset( $_SERVER['HTTPS'] ) && 'on' === $_SERVER['HTTPS'] ? 'https' : 'http';
		$url .= '://' . $_SERVER['SERVER_NAME'];
		$url .= in_array( $_SERVER['SERVER_PORT'], array('80', '443') ) ? '' : ':' . $_SERVER['SERVER_PORT'];
		$url .= $_SERVER['REQUEST_URI'];
		return $url;
	}


	function getNumEnding($number, $endingArray) {
		$number = $number % 100;
		if ($number>=11 && $number<=19) {
			$ending=$endingArray[2];
		}
		else {
			$i = $number % 10;
			switch ($i)
			{
				case (1): $ending = $endingArray[0]; break;
				case (2):
				case (3):
				case (4): $ending = $endingArray[1]; break;
				default: $ending=$endingArray[2];
			}
		}
		return $ending;
	}



	function cc_mime_types($mimes) {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
	}
	add_filter('upload_mimes', 'cc_mime_types');



	//Custom content function with words manual limit
	function content($limit, $postid, $showmorelink = true) {
		$content = explode(' ', get_post_field('post_content', $postid), $limit);
		if (count($content)>=$limit) {
			array_pop($content);
			$content = implode(" ",$content);
			$content = preg_replace('/\[.+\]/','', $content);
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
			$content = strip_tags($content,'<br />');
			$content .= '&hellip;';
			if ($showmorelink) {$content .= ' <a class="more-link" href="'. get_permalink($postid) . '">Читать далее...</a>';}
		} else {
			$content = implode(" ",$content);
			$content = preg_replace('/\[.+\]/','', $content);
			$content = apply_filters('the_content', $content);
			$content = str_replace(']]>', ']]&gt;', $content);
		}
		return $content;
	}



	//Add custom body classes to the chosen templates. 
	//Usage: add_filter('body_class','add_bodyclass_customarchive'); in the template code
	function add_bodyclass_testing($classes = '') {
		$classes[] = 'language_testing'; //Pages that are standard archives
		return $classes;
	}
	function add_bodyclass_testing_result($classes = '') {
		$classes[] = 'language_testing_result'; //Pages that are standard archives
		return $classes;
	}



	//Add category class to img tag when adding media

	function give_linked_images_class($html, $id, $caption, $title, $align, $url, $size, $alt = '' ){
		$classes = '';
		if (has_term('','att_tax',$id)) {
			$terms = wp_get_post_terms($id, 'att_tax');
			if ($terms) {
				foreach ($terms as $term) {
					$classes .= $term->slug.' '; // separated by spaces, e.g. 'img image-link'
				}
			}
		}

		// check if there are already classes assigned to the anchor
		if ( preg_match('/<a.*? class=".*?">/', $html) ) {
		$html = preg_replace('/(<a.*? class=".*?)(".*?>)/', '$1 ' . $classes . '$2', $html);
		} else {
			$html = preg_replace('/(<a.*?)>/', '$1 class="' . $classes . '" >', $html);
		}
		return $html;
	}
	add_filter('image_send_to_editor','give_linked_images_class',10,8);



	//Add site manual
	function dashboard_widget_function( $post, $callback_args ) {
		include("manual.html");
	}

	function add_dashboard_widgets() {
		wp_add_dashboard_widget('sitemanual', 'Справочник по наполнению сайта', 'dashboard_widget_function');
	}

	add_action('wp_dashboard_setup', 'add_dashboard_widgets' );

	function cd_meta_box_cb() {include("manual.html");}

	add_action( 'add_meta_boxes', 'cd_meta_box_add' );
	
	function cd_meta_box_add($postType) {
		$types = array('page', 'post', 'teacher', 'language');
		if(in_array($postType, $types)){
			add_meta_box('sitemanual', 'Справочник по наполнению сайта', 'cd_meta_box_cb', $postType, 'normal', 'low' );
		}
	}



	//Произвольная конвертация русских дат (например, в метах)
	function dateToRussian($date) {
		$month = array("january"=>"января", "february"=>"февраля", "march"=>"марта", "april"=>"апреля", "may"=>"мая", "june"=>"июня", "july"=>"июля", "august"=>"августа", "september"=>"сентября", "october"=>"октября", "november"=>"ноября", "december"=>"декабря");
		$days = array("monday"=>"Понедельник", "tuesday"=>"Вторник", "wednesday"=>"Среда", "thursday"=>"Четверг", "friday"=>"Пятница", "saturday"=>"Суббота", "sunday"=>"Воскресенье");
		return str_replace(array_merge(array_keys($month), array_keys($days)), array_merge($month, $days), strtolower($date));
	}

	//Add custom body classes to the chosen templates. 
	//Usage: add_filter('body_class','add_bodyclass_customarchive'); in the template code
	function add_bodyclass_newsarchive($classes = '') {
		$classes[] = 'news';
		return $classes;
	}


	// Admin - rename excerpt
	add_filter( 'gettext', 'wpse22764_gettext', 10, 2 );
	function wpse22764_gettext( $translation, $original )
	{
		if ( 'Excerpt' == $original ) {
			return 'Краткая информация';
		} else {
			$pos = strpos($original, 'Excerpts are optional hand-crafted summaries of your');
			if ($pos !== false) {
				global $post;
				return  '';
			}
		}
		return $translation;
	}


	add_action('do_meta_boxes', 'change_image_box');
	function change_image_box()
	{
		remove_meta_box( 'postimagediv', 'teacher', 'side' );
		add_meta_box('postimagediv', __('Фото преподавателя'), 'post_thumbnail_meta_box', 'teacher', 'normal', 'high');
	}



	/* ========================================================================================================================
	
	Register additional custom post types and taxonomies
	
	======================================================================================================================== */

	//Languages

	//Add custom post type (languages)
	function language_custompost_init() {
		$labels_languages = array(
			'name' => _x('Языки', 'post type general name'),
			'singular_name' => _x('Язык', 'post type singular name'),
			'add_new' => _x('Добавить', 'language'),
			'add_new_item' => __('Добавить '),
			'edit_item' => __('Редактировать язык'),
			'new_item' => __('Новый язык'),
			'all_items' => __('Все языки'),
			'view_item' => __('Просмотреть страницу языка'),
			'search_items' => __('Поиск языков'),
			'not_found' =>  __('Ни одного языка не найдено'),
			'not_found_in_trash' => __('В корзине ни одного языка не найдено'), 
			'parent_item_colon' => '',
			'menu_name' => 'Языки'
		);
		$args = array(
			'labels' => $labels_languages,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array("slug" => "language"),
			'capability_type' => 'page',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 21,
			'supports' => array( 'title', 'editor', 'custom-fields', 'excerpt', 'page-attributes' )
		);
		register_post_type('language',$args);
	}
	add_action( 'init', 'language_custompost_init' );



	//Add custom post type (teachers)
	function teacher_custompost_init() {
		$labels_teachers = array(
			'name' => _x('Преподаватели', 'post type general name'),
			'singular_name' => _x('Преподаватель', 'post type singular name'),
			'add_new' => _x('Добавить', 'teacher'),
			'add_new_item' => __('Добавить '),
			'edit_item' => __('Редактировать преподавателя'),
			'new_item' => __('Новый преподаватель'),
			'all_items' => __('Все преподаватели'),
			'view_item' => __('Просмотреть страницу преподавателя'),
			'search_items' => __('Поиск преподавателей'),
			'not_found' =>  __('Ни одного преподавателя не найдено'),
			'not_found_in_trash' => __('В корзине ни одного преподавателя не найдено'), 
			'parent_item_colon' => '',
			'menu_name' => 'Преподаватели'
		);
		$args = array(
			'labels' => $labels_teachers,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true, 
			'show_in_menu' => true, 
			'query_var' => true,
			'rewrite' => array("slug" => "teachers"),
			'capability_type' => 'post',
			'has_archive' => true, 
			'hierarchical' => false,
			'menu_position' => 24,
			'supports' => array( 'thumbnail', 'title', 'custom-fields', 'excerpt', 'page-attributes' )
		);
		register_post_type('teacher',$args);
	}
	add_action( 'init', 'teacher_custompost_init' );




	//Add custom taxonomy for attachments (for using in Library section)
	add_action( 'init', 'create_attachmentcat_taxonomy', 0 );

	function create_attachmentcat_taxonomy() 
	{
	$labels_att_cats = array(
		'name' => _x( 'Категории медиафайлов', 'taxonomy general name' ),
		'singular_name' => _x( 'Категория медиафайлов', 'taxonomy singular name' ),
		'search_items' =>  __( 'Искать в категориях медиафайлов' ),
		'all_items' => __( 'Все категории медиафайлов' ),
		'parent_item' => __( 'Родительская категория медиафайлов' ),
		'parent_item_colon' => __( 'Родительская категория медиафайлов' ),
		'edit_item' => __( 'Редактировать' ), 
		'update_item' => __( 'Обновить' ),
		'add_new_item' => __( 'Добавить категорию медиафайлов' ),
		'new_item_name' => __( 'Название' ),
		'menu_name' => __( 'Категории медиафайлов' ),
	);

	register_taxonomy('att_tax','attachment', array(
		'hierarchical' => true,
		'labels' => $labels_att_cats,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'att_tax' ),
	));
	};


	//Register custom taxonomy support (categories) for attachments
	add_action('admin_init', 'attachment');
	function attachment() {
		register_taxonomy_for_object_type('att_tax', 'attachment');
		add_post_type_support('attachment', array('att_tax'));
	}



	/* ========================================================================================================================
	
	Register meta boxes via Meta Box plugin
	
	======================================================================================================================== */



	global $meta_boxes;
	$meta_boxes = array();

	$prefix = 'lmmb_';
	$mb_image_reqs = 'Загружаемая на сайт картинка должна быть в форматах PNG или SVG, с прозрачным фоном и размером не более ';

	$prefix_languages = $prefix.'languages_';
	$meta_boxes[] = array(
		 'title' => 'Настройки отображения страницы языка'
		,'id' => $prefix_languages.'settings'
		,'pages' => array( 'language' )
		,'fields' => array(
			array(
				 'name' => 'Набор закрыт?'
				,'id' => $prefix_languages . 'is_closed'
				,'type' => 'checkbox'
			)
			,array(
				 'name' => 'В каком месяце начнется набор?'
				,'id' => $prefix_languages . 'start_month'
				,'type' => 'text'
				,'desc' => 'Введите название месяца в предложном падеже: например, <code class="insert-into-input" data-targetinput="'.$prefix_languages.'start_month">июне</code>)'
			)
			,array(
				'type' => 'divider'
			)
			,array(
				 'name' => 'Call to action'
				,'id' => $prefix_languages . 'calltoaction'
				,'type' => 'text'
				,'size' => 50
				,'desc' => 'фраза <strong>Поехали!</strong> на этом языке'
			)
			,array(
				 'name' => 'Выберите картинку-заставку (вверху страницы)'
				,'id' => $prefix_languages . 'image_big'
				,'type' => 'image_advanced'
				,'max_file_uploads' => 1
			)
			,array(
				 'name' => 'Выберите картинку-символ (в середине страницы, а также на страницах тестов)'
				,'desc' => $mb_image_reqs.'250x220'
				,'id' => $prefix_languages . 'image_small'
				,'type' => 'image_advanced'
				,'max_file_uploads' => 1
			)
			,array(
				 'name' => 'Выберите цвет 1'
				,'id' => $prefix_languages . 'color_1'
				,'type' => 'color'
			)
			,array(
				 'name' => 'Выберите цвет 2'
				,'id' => $prefix_languages . 'color_2'
				,'type' => 'color'
			)
		)
	);


	$prefix_pages = $prefix.'pages_';
	

	$prefix_teachers = $prefix.'teachers_';
	$meta_boxes[] = array(
		 'title' => 'Информация о преподавателе'
		,'id' => $prefix_teachers.'info'
		,'pages' => array( 'teacher' )
		,'fields' => array(
			array(
				 'name' => 'Образование'
				,'id' => $prefix_teachers . 'education'
				,'type' => 'text'
				,'size' => 50
			)
			,array(
				 'name' => 'Биография'
				,'id' => $prefix_teachers . 'bio'
				,'type' => 'wysiwyg'
				,'options' => array(
					'media_buttons' => false
					)
			)
		)
	);


	$meta_boxes[] = array(
		 'title' => 'Настройки страницы стоимости'
		,'id' => $prefix_pages.'settings_price'
		,'desc' => 'Стоимость курсов настраивается на страницах языков'
		,'pages' => array( 'page' )
		,'fields' => array(
			array(
				 'name' => 'Информационный блок'
				,'placeholder' => 'Информационный блок'
				,'id' => $prefix_pages . 'price_info-box'
				,'type' => 'key_value'
				,'clone' => true
			)
			,array(
				 'name' => 'Стоимость'
				,'desc' => 'в рублях'
				,'id' => $prefix_pages . 'price'
				,'type' => 'number'
			)
			,array(
				 'name' => 'Стоимость помесячного платежа, разделенного на два'
				,'desc' => 'в рублях'
				,'id' => $prefix_pages . 'price_half'
				,'type' => 'number'
			)
			,array(
				 'name' => 'Стоимость оплаты одного занятия'
				,'desc' => 'в рублях'
				,'id' => $prefix_pages . 'price_1day'
				,'type' => 'number'
			)
			,array(
				 'name' => 'Экономия'
				,'desc' => 'в процентах'
				,'id' => $prefix_pages . 'economy'
				,'type' => 'number'
			)
		)
		,'only_on' => array(
			'id' => array( 109 )
		)
	);


	$meta_boxes[] = array(
		 'title' => 'Настройки страницы контактов'
		,'id' => $prefix_pages.'contacts'
		,'pages' => array( 'page' )
		,'fields' => array(
			array(
				 'name' => 'Карта'
				,'placeholder' => 'Вставьте embed-код карты с Google Maps или Yandex.Карты'
				,'id' => $prefix_pages . 'contactmap_code'
				,'type' => 'textarea'
			)
			,array(
				 'name' => 'Выберите фотографии маршрута'
				,'id' => $prefix_languages . 'contact_map_photos'
				,'type' => 'image_advanced'
			)
		)
		,'only_on' => array(
			'template' => array( 'template-contacts.php' ),
		)
	);


	$meta_boxes[] = array(
		 'title' => 'Настройки главной страницы (Как проходит обучение)'
		,'id' => $prefix_pages.'settings_home'
		,'pages' => array( 'page' )
		,'fields' => array(
			array(
				 'name' => 'Выберите иконку'
				,'desc' => 'Расставьте иконки по часовой стрелке, начиная с левого верхнего угла'
				,'id' => $prefix_pages . 'settings_home_icons'
				,'type' => 'file_advanced'
				// ,'mime_type' => 'image/svg+xml'
				,'max_file_uploads' => 10
			)
		)
		,'only_on' => array(
			'id' => array( 118 )
		)
	);


	$modules_parent_id = 86;
	$modules_count = count(get_pages('child_of='.$modules_parent_id));
	$meta_boxes[] = array(
		 'title' => 'Настройки модулей'
		,'id' => $prefix_pages.'modules'
		,'pages' => array( 'page' )
		,'fields' => array(
			array(
				 'name' => 'Выберите цвет'
				,'id' => $prefix_pages . 'modules_color'
				,'type' => 'color'
			)
			,array(
				 'name' => 'Количество месяцев'
				,'id' => $prefix_pages . 'modules_duration'
				,'type' => 'number'
			)
			,array(
				 'name' => 'Выберите картинку'
				,'desc' => '...и обновите эту страницу'
				,'id' => $prefix_pages . 'modules_image'
				,'type' => 'file_advanced'
				,'max_file_uploads' => 1
			)
			,array(
				'type' => 'divider'
			)
			,array(
				 'name' => 'Выберите уровень модуля'
				,'id' => $prefix_pages.'modules_number'
				,'type' => 'slider'
				,'std' => 1
				// ,'prefix' => 'Первый и "нулевой" уровень'
				// ,'suffix' => 'Последний и "идеальный" уровень'
				,'desc' => 'От простого к сложному'
				,'js_options' => array(
					'min'   => 1
					,'max'   => $modules_count
				)
			)
			,array(
				 'name' => 'Описание уровня, соответствующего этому модулю, в тесте'
				,'id' => $prefix_pages . 'modules_levels_desc'
				,'type' => 'textarea'
			)
			,array(
				 'name' => '<span id="'.$prefix_pages . 'modules_levels_desc_extremum_longdesc'.'" data-longdesc_lowest="Описание начального &laquo;нулевого&raquo; уровня (Beginner)" data-longdesc_highest="Описание продвинутого &laquo;идеального&raquo; уровня (Advanced)">Описание уровня</span>'
				,'id' => $prefix_pages . 'modules_levels_desc_extremum'
				,'type' => 'textarea'
			)
		)
		,'only_on' => array(
			// 'id' => array( 1, 2 ),
			// 'slug' => array( 'news', 'blog' ),
			// 'template' => array( 'fullwidth.php', 'simple.php' ),
			'parent' => array( $modules_parent_id )
		)
	);

	
	function lm_mb_register_meta_boxes( ) {

		global $meta_boxes;
		// Make sure there's no errors when the plugin is deactivated or during upgrade
		if ( class_exists( 'RW_Meta_Box' ) ) {
			foreach ( $meta_boxes as $meta_box ) {
						if ( isset( $meta_box['only_on'] ) && ! rw_maybe_include( $meta_box['only_on'] ) ) {
					continue;
				}
				new RW_Meta_Box( $meta_box );
			}
		}

		// return $meta_boxes;
	}


	add_action( 'admin_init', 'lm_mb_register_meta_boxes' );


	/**
	 * Check if meta boxes is included
	 *
	 * @return bool
	 */
	function rw_maybe_include( $conditions ) {
		// Include in back-end only
		if ( ! defined( 'WP_ADMIN' ) || ! WP_ADMIN ) {
			return false;
		}
		// Always include for ajax
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			return true;
		}
		if ( isset( $_GET['post'] ) ) {
			$post_id = intval( $_GET['post'] );
		}
		elseif ( isset( $_POST['post_ID'] ) ) {
			$post_id = intval( $_POST['post_ID'] );
		}
		else {
			$post_id = false;
		}
		$post_id = (int) $post_id;
		$post    = get_post( $post_id );
		foreach ( $conditions as $cond => $v ) {
			// Catch non-arrays too
			if ( ! is_array( $v ) ) {
				$v = array( $v );
			}
			switch ( $cond ) {
				case 'id':
					if ( in_array( $post_id, $v ) ) {
						return true;
					}
				break;
				case 'parent':
					if ($post) {
						$post_parent = $post->post_parent;
						if ( in_array( $post_parent, $v ) ) {
							return true;
						}
					}
				break;
				case 'slug':
					$post_slug = $post->post_name;
					if ( in_array( $post_slug, $v ) ) {
						return true;
					}
				break;
				case 'category': //post must be saved or published first
					$categories = get_the_category( $post->ID );
					$catslugs = array();
					foreach ( $categories as $category )
					{
						array_push( $catslugs, $category->slug );
					}
					if ( array_intersect( $catslugs, $v ) )
					{
						return true;
					}
				break;
				case 'template':
					$template = get_post_meta( $post_id, '_wp_page_template', true );
					if ( in_array( $template, $v ) )
					{
						return true;
					}
				break;
			}
		}
		// If no condition matched
		return false;
	}


	/* ========================================================================================================================
	
	Post connections
	
	======================================================================================================================== */


	function p2p_connections() {
		p2p_register_connection_type( array( //Привязка специальности к событиям
			'name' => 'teachers_to_languages'
			,'from' => 'teacher'
			,'to' => 'language'
		));
	}
	add_action( 'p2p_init', 'p2p_connections' );



	/* ========================================================================================================================
	
	Customized functions
	
	======================================================================================================================== */

	//like Custom Post Type's Archive in WP Nav Menu plugin
	//from http://stackoverflow.com/a/22602901/102397
	add_action('admin_head-nav-menus.php', 'wpclean_add_metabox_menu_posttype_archive');

	function wpclean_add_metabox_menu_posttype_archive() {
	add_meta_box('wpclean-metabox-nav-menu-posttype', 'Ссылки на архивы записей', 'wpclean_metabox_menu_posttype_archive', 'nav-menus', 'side', 'default');
	}

	function wpclean_metabox_menu_posttype_archive() {
	$post_types = get_post_types(array('show_in_nav_menus' => true, 'has_archive' => true), 'object');

	if ($post_types) :
		$items = array();
		$loop_index = 999999;

		foreach ($post_types as $post_type) {
			$item = new stdClass();
			$loop_index++;

			$item->object_id = $loop_index;
			$item->db_id = 0;
			$item->object = 'post_type_' . $post_type->query_var;
			$item->menu_item_parent = 0;
			$item->type = 'custom';
			$item->title = $post_type->labels->name;
			$item->url = get_post_type_archive_link($post_type->query_var);
			$item->target = '';
			$item->attr_title = '';
			$item->classes = array();
			$item->xfn = '';

			$items[] = $item;
		}

		$walker = new Walker_Nav_Menu_Checklist(array());

		echo '<div id="posttype-archive" class="posttypediv">';
		echo '<div id="tabs-panel-posttype-archive" class="tabs-panel tabs-panel-active">';
		echo '<ul id="posttype-archive-checklist" class="categorychecklist form-no-clear">';
		echo walk_nav_menu_tree(array_map('wp_setup_nav_menu_item', $items), 0, (object) array('walker' => $walker));
		echo '</ul>';
		echo '</div>';
		echo '</div>';

		echo '<p class="button-controls">';
		echo '<span class="add-to-menu">';
		echo '<input type="submit"' . disabled(1, 0) . ' class="button-secondary submit-add-to-menu right" value="' . __('Add to Menu', 'andromedamedia') . '" name="add-posttype-archive-menu-item" id="submit-posttype-archive" />';
		echo '<span class="spinner"></span>';
		echo '</span>';
		echo '</p>';

	endif;
	}


	//Adding select element dynamically populated with custom posts to Contact Form 7 WP plugin
	//In CF7 form use [customselect languagesdropdown] format to insert the select element, in the email body - [languagesdropdown]
	wpcf7_add_shortcode('customselect', 'createdynamicselect', true);
	function createdynamicselect(){
		//Settings
		$selectname = 'languagesdropdown';
		$is_multiple = false;

		global $post;
		$courses = get_posts( array('numberposts'=>-1,'post_type'=>'language', 'orderby'=>'menu_order', 'order' => 'ASC'  ) );
		$output = "\r\n<select data-id=".$post->ID." name='".$selectname.( $is_multiple ? "[]" : "" )."' id='".$selectname."' ".( $is_multiple ? "multiple" : "" ).">\r\n";
		if (isset($_GET['test_language'])) {
			$output .= "<option disabled>Выберите язык</option>\r\n";
		} else {
			$output .= "<option selected disabled>Выберите язык</option>\r\n";
		}
		foreach ( $courses as $post ) : setup_postdata($post);
			$coursename = get_the_title();
			if (isset($_GET['test_language']) && $_GET['test_language'] == get_the_ID()) {
				$output .= "<option data-langid='".get_the_ID()."' selected value='".$coursename."'>".$coursename."</option>\r\n";
			} else {
				$output .= "<option data-langid='".get_the_ID()."' value='".$coursename."'>".$coursename."</option>\r\n";
			}
		endforeach;
		$output .= "</select>";
		$output = '<span class="wpcf7-form-control-wrap '.$selectname.'">'.$output.'</span>';
		return $output;
	}


	wpcf7_add_shortcode('test_level', 'form_showtestresult', true);
	function form_showtestresult(){
		$user_level_titles = array(
			'Beginner',
			'Elementary',
			'Pre-Intermediate',
			'Intermediate',
			'Upper Intermediate',
			'Advanced'
		);
		$questions_total = 24;
		if (isset($_GET['is_test_adv']) && $_GET['is_test_adv'] == 'false') {
			$questions_total = 12;
		}
		$name = 'testlevel';
		
		$output = '';
		if (isset($_GET['test_level'])) {
			$output .= "<label>Результат тестирования</label><div class='test_result'>";
			$output .= $user_level_titles[$_GET['test_level']];
			$output .= '<input type="hidden" name="'.$name.'" value="'.$user_level_titles[$_GET['test_level']].'">';
			if (isset($_GET['test_correct_answers'])) {
				$output .= '<br>('.$_GET['test_correct_answers'];
				$output .= ' '.getNumEnding($_GET['test_correct_answers'],array('правильный','правильных','правильных')).' ';
				$output .= getNumEnding($_GET['test_correct_answers'],array('ответ','ответа','ответов'));
				$output .= ' из '.$questions_total.')';
			}
			$output .= "</div>";
		} 
		return $output;
	}


	add_action( 'wpcf7_before_send_mail', 'attach_test_results' );
	function attach_test_results($contact_form) {
		$submission = WPCF7_Submission::get_instance();
		if (isset($_GET['test_level'])){
			if ($submission) {
				$mail = $contact_form->prop('mail');
				include TEMPLATEPATH . '/external/htmltodocx/download.php';
				$mail['attachments'] = $h2d_file_uri;
				$contact_form->set_properties(array('mail' => $mail));
			}
		}
	}


	function show_test_results($postid) {
		// global $post;
		$questions = get_post_meta($postid,'test_questions',false);
		$questions = reset($questions);
		if (test_is_adv()) {
			$questions_total = 24;
		} else {
			foreach ($questions as $question) {
				if (!array_key_exists('is_advanced', $question)) {
					$questions_simple[] = $question;
				}
			}
			$questions = $questions_simple;
			$questions_total = 12;

		}
		// if (isset($_GET['result'])) {
			$user_answers = $_GET['q'];
			$user_answers = reset($user_answers);
			foreach ($questions as $question) {
				$real_answers[] = mb_substr($question['is_correct'],-2,1);
			}
			// Returns an array containing all the values from array1 that are not present in any of the other arrays
			$questions_not_answered = array_diff_key($real_answers,$user_answers);
			$questions_user_wrong = array_diff_assoc($user_answers, $real_answers);
			$questions_not_answered_and_wrong = $questions_not_answered+$questions_user_wrong;
			ksort($questions_not_answered_and_wrong);

			// $level_beginner = range(0, 5);
			//Уровни вопросов
			$stages_elementary = range(0, 5);
			$stages_preint = range(6, 11);
			$stages_int = range(12, 17);
			$stages_uppint = range(18, 23);
			// $stages_adv = array(24);
			if (test_is_adv()) {
				$stages = array($stages_elementary,$stages_preint,$stages_int,$stages_uppint);
				$wrong_answers_by_stage = array(0,0,0,0);

				foreach ($questions_not_answered_and_wrong as $q_number => $value) {
					$i = 0;
					foreach ($stages as $stage) {
						if (in_array($q_number,$stage)) {
							$wrong_answers_by_stage[$i]++;
						}
						$i++;
					}
				}

			} else {
				$stages = array($stages_elementary,$stages_preint);
				$wrong_answers_by_stage = array(0,0);

				foreach ($questions_not_answered_and_wrong as $q_number => $value) {
					$i = 0;
					foreach ($stages as $stage) {
						if (in_array($q_number,$stage)) {
							$wrong_answers_by_stage[$i]++;
						}
						$i++;
					}
				}
				
			}

			$user_level = 10;
			$uniqum = false;

			if (test_is_adv()) {
				if (count($questions_not_answered_and_wrong) === 0) {
					$user_level = 5;
				} else if (count($questions_not_answered_and_wrong) < 3) {
					$user_level = 4;
				}
				if (($wrong_answers_by_stage[0] + $wrong_answers_by_stage[1]) === 0 && $wrong_answers_by_stage[2] < 2 && $wrong_answers_by_stage[3] > 2) {
					$user_level = 3;
				}
				if (($wrong_answers_by_stage[0] + $wrong_answers_by_stage[1]) < 3 && ($wrong_answers_by_stage[2] + $wrong_answers_by_stage[3]) > 6) {
					$user_level = 2;
				}
				if ($wrong_answers_by_stage[0] === 0 && count($questions_not_answered_and_wrong) > 15) {
					$user_level = 1;
				}
				if (count($questions_not_answered_and_wrong) > 18) {
					$user_level = 0;
				}

				
				if ($user_level === 10) {
					$uniqum = true;
					if (count($questions_not_answered_and_wrong) < 8) {
						$user_level = 3;
					} else if (count($questions_not_answered_and_wrong) < 14) {
						$user_level = 2;
					} else if (count($questions_not_answered_and_wrong) < 19) {
						$user_level = 1;
					} else {
						$user_level = 0;
					}
				}
			} else {
				if (count($questions_not_answered_and_wrong) < 3) {
					$user_level = 2;
				} else if (count($questions_not_answered_and_wrong) < 6) {
					$user_level = 1;
				} else {
					$user_level = 0;
				}

			}

			$user_level_titles = array(
			'Beginner',
			'Elementary',
			'Pre-Intermediate',
			'Intermediate',
			'Upper Intermediate',
			'Advanced'
			);
			$user_level_desc_pageids = array(73,73,75,77,81,81);

			$level_desc_module_id = 'lmmb_pages_modules_levels_desc';
			if ($user_level === 0 || $user_level === 5 ) {
				$level_desc_module_id = 'lmmb_pages_modules_levels_desc_extremum';
			}
			$level_desc = get_post_meta($user_level_desc_pageids[$user_level], $level_desc_module_id,true);
			$level_img = rwmb_meta('lmmb_pages_modules_image', array('type'=>'file_advanced'), $user_level_desc_pageids[$user_level]);
			$level_img = reset($level_img);
			

			$correct_answers_total = $questions_total - count($questions_not_answered_and_wrong);
			$test_results_pre = '';
			$test_results_pre .= '<a class="post-image-intro-round" href="javascript:;"><img class="wp-post-image" src="'.$level_img['url'].'" alt="'.$level_img['title'].'"></a>';
			$test_results_pre .= '<a class="button-big" href="'.add_query_arg(array('test_language'=>$postid, 'test_level' => $user_level, 'test_correct_answers' => $correct_answers_total, 'is_test_adv' => ((test_is_adv())?'true':'false') ), get_permalink(21)).'">Записаться на бесплатное занятие</a>';
			$test_results_pre .= '<div class="testing-intro"><h2>'.$user_level_titles[$user_level].' ('.$correct_answers_total.' ';
			$test_results_pre .= getNumEnding($correct_answers_total,array('правильный','правильных','правильных')).' ';
			$test_results_pre .= getNumEnding($correct_answers_total,array('ответ','ответа','ответов'));
			$test_results_pre .= ' из '.$questions_total.')</h2>';
			$test_results_pre .= $level_desc;
			$test_results_pre .= '<ul class="social-buttons"><li class="vk"><a href="http://vk.com/share.php?url='.urlencode( getCurrentUrl() ).'" target="_blank">Поделиться результатом</a></li><li class="facebook"><a href="http://www.facebook.com/sharer/sharer.php?u='.urlencode( getCurrentUrl() ).'" target="_blank">Поделиться результатом</a></li></ul>';
			$test_results_pre .= '</div>';
			$test_results_pre .= '<div class="testing">';
			$test_results_pre .= '<ul class="result_legend"><li><span class="correct"><span>Красный</span></span> &mdash; правильный ответ</li><li><span class="incorrect"><span>Желтый</span></span> &mdash; допущена ошибка</li></ul>';

			$test_results = '';
			if ($questions) {
				$test_results .= '<ol class="question_list">';
				$i = 0;
				foreach ($questions as $question_n => $question) {
					$test_results .= '<li><h2 class="question_name">'.$question['question'].'</h2><ol>';
					$incorrect_answer = NULL;
					if (array_key_exists($question_n,$questions_user_wrong)) {
						$incorrect_answer = $questions_user_wrong[$question_n];
					}
					$question_not_answered = false;
					if (array_key_exists($question_n,$questions_not_answered)) {
						$question_not_answered = true;
					}
					foreach($question as $key => $value){
						$exp_key = explode('_', $key);
						$correct_answer = mb_substr($question['is_correct'],-2,1);
						if($exp_key[0] == 'answer'){
							$test_results .= '<li class="';
							if ($exp_key[1] === $correct_answer) {
								if ($question_not_answered) {
									$test_results .= 'correct-not-answered';
								} else {
									$test_results .= 'correct';
								}
							}
							if ($exp_key[1] === $incorrect_answer) {
								$test_results .= 'incorrect';
							}
							$test_results .= '">';
								$test_results .= '<label>'.$value.'</label>';
							$test_results .= '</li>';
						}
					}
					$test_results .= '</ol></li>';
					$i++;
				}
				$test_results .= '</ol>';
			}
			$test_results_post = '';
			$test_results_post .= '<a class="button-big" href="http://linguamore.ru/wordpress/wp-content/themes/linguamore/external/htmltodocx/download.php?download=true">Сохранить в файл DOCX</a>';
			$test_results_post .=  '</div>';

			$_SESSION['download_data'] = $test_results;

			return array('user_level'=>$user_level,'level_desc'=>$level_desc,'test_results'=>$test_results_pre.$test_results.$test_results_post);

	}


	function show_test_form($postid) {
		$questions = get_post_meta($postid,'test_questions',false);
		$questions = reset($questions);
		if (test_is_adv()) {
			$questions_total = 24;
		} else {
			foreach ($questions as $question) {
				if (!array_key_exists('is_advanced', $question)) {
					$questions_simple[] = $question;
				}
			}
			$questions = $questions_simple;
			$questions_total = 12;

		}
		$test_code = '';
		$test_code .= '<fieldset class="testing"><form name="testing" method="get" action="">';
			$test_code .= '<input type="hidden" name="testing" value="true">';
			$test_code .= '<input type="hidden" name="result" value="false">';
			if (test_is_adv()) {
				$test_code .= '<input type="hidden" name="is_advanced" value="true">';
			} else {
				$test_code .= '<input type="hidden" name="is_advanced" value="false">';
			}
			$test_code .= '<legend>Выберите правильный вариант ответа или просто оставьте поле пустым, если затрудняетесь в выборе.</legend>';
		if ($questions) {
			$test_code .= '<ol class="question_list">';
			$i = 0;
			foreach ($questions as $question) {
				$test_code .= '<li><h2 class="question_name">'.$question['question'].'</h2><ol>';
					foreach($question as $key => $value){
						$exp_key = explode('_', $key);
						if($exp_key[0] == 'answer'){
							 // $answers[] = $value;
							$test_code .= '
							<li>
								<input type="radio" name="q['.$postid.']['.$i.']" id="q_'.$postid.'_'.$i.'_'.$exp_key[1].'" value="'.$exp_key[1].'">
								<label for="q_'.$postid.'_'.$i.'_'.$exp_key[1].'">'.$value.'</label>
							</li>';
						}
					}
				$test_code .= '</ol></li>';
				$i++;
			}
			$test_code .= '</ol>';
			$test_code .= '<input type="submit" class="button-big" value="Узнать результат">';
		}
		$test_code .= '</form></fieldset>';

		return $test_code;
	}
