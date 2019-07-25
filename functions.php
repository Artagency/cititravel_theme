<?php
	add_filter( 'wpcf7_load_css', '__return_false' );

	function cookie_notice_front() {
		wp_dequeue_style('cookie-notice-front');
		wp_deregister_style('cookie-notice-front');
	}
	add_action('wp_print_styles', 'cookie_notice_front');

	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' ); 

	function wpdocs_dequeue_dashicon() {
		if (current_user_can( 'update_core' )) {
		    return;
		}
		wp_deregister_style('dashicons');
	}
	add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );

	function my_deregister_styles() { 
	   wp_deregister_style( 'freshmail-style' );
	}
	add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'Primary Menu' ),
		'footer_1' => __( 'Informacje ogólne', 'Informacje ogólne' ),
		'footer_2' => __( 'Współpraca', 'Współpraca' ),
		'footer_3' => __( 'Bezpieczeństwo', 'Bezpieczeństwo' ),
		'footer_4' => __( 'Kontakt', 'Kontakt' ),
		'footer_5' => __( 'Wybrane wycieczki', 'Wybrane wycieczki' ),
		'footer_6' => __( 'Last minute', 'Last minute' ),
		'footer_7' => __( 'Regiony', 'Regiony' ),
		'footer_8' => __( 'Wakacje', 'Wakacje' ),
		'footer_9' => __( 'Na skróty', 'Na skróty' ),
		'trip_cats' => __( 'Trip categories', 'Trip categories' )
	));

	add_theme_support('post-thumbnails'); 

	function page_bodyclass() {
		global $wp_query;
		$page = '';

		if(is_front_page()) {
	    	$page = 'home';
		} elseif(is_page()) {
	   		$page = $wp_query->query_vars["pagename"];
		} elseif(is_category()) {
			$page = get_category(get_query_var('cat'))->slug;
		}

		if($page) {
			echo 'class= "'. $page. '"';
		}
	}

	add_filter( 'template_include', 'var_template_include', 1000 );
	function var_template_include( $t ){
           /* if(strpos($_SERVER["REQUEST_URI"], '/wakacje') !== false) {
                $tab_t = explode('/', $t);
                $tab_t[count($tab_t)-1] = 'single.php';
                $t = join('/', $tab_t);
            }*/
	    $GLOBALS['current_theme_template'] = basename($t);
	    return $t;
	}

	function get_current_template( $echo = false ) {
	    if( !isset( $GLOBALS['current_theme_template'] ) )
	        return false;
	    if( $echo )
	        echo $GLOBALS['current_theme_template'];
	    else
	        return $GLOBALS['current_theme_template'];
	}

	function remove_menu_pages() {
	    remove_menu_page('edit-comments.php'); // Komentarze
	}
	add_action( 'admin_menu', 'remove_menu_pages' );

	add_action('after_setup_theme', 'wpdocs_theme_setup');
	function wpdocs_theme_setup() {
                add_image_size('large', get_option( 'large_size_w' ), get_option( 'large_size_h' ), true );
	}

	// if(class_exists('MultiPostThumbnails')) {
	// 	for($i=1;$i<8;$i++) {
	//         new MultiPostThumbnails(array(
	//             'label' => "Zdjęcie $i w ofercie do slidera",
	//             'id' => "thumb-image-$i",
	//                 'post_type' => 'post'
	//             )
	//         );
	// 	}
	// }

	// flush_rewrite_rules();

	function main_slider() {
    	register_post_type('main_slider',
	        array(
	            'labels' => array(
	                'name' => __('Slajder'),
	                'add_new' => 'Dodaj wpis',
	                'singular_name' => __('main_slider')
	            ),
	            'public' => true,
	            'has_archive' => true,
	            'rewrite' => array('slug' => 'Slajder'),
	            'supports' => array('title', 'editor', 'thumbnail'),
	            'menu_icon' => 'dashicons-schedule'
	        )
	    );
	}
	add_action('init', 'main_slider');

	function team() {
    	register_post_type('team',
	        array(
	            'labels' => array(
	                'name' => __('Zespół'),
	                'add_new' => 'Dodaj wpis',
	                'singular_name' => __('team')
	            ),
	            'public' => true,
	            'has_archive' => true,
	            'supports' => array('title', 'editor', 'thumbnail'),
	            'menu_icon' => 'dashicons-schedule'
	        )
	    );
	}
	add_action('init', 'team');

	function blog() {
    	register_post_type('blog',
	        array(
	            'labels' => array(
	                'name' => __('Blog'),
	                'add_new' => 'Dodaj wpis',
	                'singular_name' => __('blog')
	            ),
	            'public' => true,
	            'has_archive' => true,
	            'supports' => array('title', 'editor', 'thumbnail'),
	            'menu_icon' => 'dashicons-schedule'
	        )
	    );
	}
	add_action('init', 'blog');

	include_once('extensions/device_detect/mobble.php');

	function remove_head_scripts() { 
	   remove_action('wp_head', 'wp_print_scripts'); 
	   remove_action('wp_head', 'wp_print_head_scripts', 9); 
	   remove_action('wp_head', 'wp_enqueue_scripts', 1);

	   remove_action( 'wp_head', 'rsd_link');
	   remove_action( 'wp_head', 'wlwmanifest_link');
	   remove_action( 'wp_head', 'wp_generator');
	   remove_action( 'wp_head', 'start_post_rel_link');
	   remove_action( 'wp_head', 'index_rel_link');
	   remove_action( 'wp_head', 'adjacent_posts_rel_link');
	   remove_action( 'wp_head', 'wp_shortlink_wp_head');

	   add_action('wp_footer', 'wp_print_scripts', 5);
	   add_action('wp_footer', 'wp_enqueue_scripts', 5);
	   add_action('wp_footer', 'wp_print_head_scripts', 5); 
	} 
	add_action( 'wp_enqueue_scripts', 'remove_head_scripts' );

	function dimox_breadcrumbs() {
		/* === OPTIONS === */
		$text['home']     = 'Home'; // text for the 'Home' link
		$text['category'] = '%s'; // text for a category page
		$text['search']   = 'Wyniki wyszukiwania dla "%s"'; // text for a search results page
		$text['404']      = 'Błąd 404'; // text for the 404 page
		$text['page']     = '%s'; // text 'Page N'
		$text['cpage']    = 'Comment Page %s'; // text 'Comment Page N'
		$wrap_before    = '<div class="breadcrumbs" itemscope itemtype="htt://schema.org/BreadCrumbList">'; // the opening wrapper tag
		$wrap_after     = '</div><!-- .breadcrumbs -->'; // the closing wrapper tag
		$sep            = '›'; // separator between crumbs
		$sep_before     = '<span class="sep">'; // tag before separator
		$sep_after      = '</span>'; // tag after separator
		$show_home_link = 1; // 1 - show the 'Home' link, 0 - don't show
		$show_on_home   = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$show_current   = 1; // 1 - show current page title, 0 - don't show
		$before         = '<span class="current">'; // tag before the current crumb
		$after          = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post;
		$home_link      = home_url('/');
		$link_before    = '<span itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">';
		$link_after     = '</span>';
		$link_attr      = ' itemprop="url"';
		$link_in_before = '<span itemprop="title">';
		$link_in_after  = '</span>';
		$link           = $link_before . '<a href="%1$s"' . $link_attr . '>' . $link_in_before . '%2$s' . $link_in_after . '</a>' . $link_after;
		$frontpage_id   = get_option('page_on_front');
		$parent_id      = $post->post_parent;
		$sep            = ' ' . $sep_before . $sep . $sep_after . ' ';
		if (is_home() || is_front_page()) {
			if ($show_on_home) echo $wrap_before . '<a href="' . $home_link . '">' . $text['home'] . '</a>' . $wrap_after;
		} else {
			echo $wrap_before;
			if ($show_home_link) echo sprintf($link, $home_link, $text['home']);
			if ( is_category() ) {
				$cat = get_category(get_query_var('cat'), false);
				if ($cat->parent != 0) {
					$cats = get_category_parents($cat->parent, TRUE, $sep);
					$cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					if ($show_home_link) echo $sep;
					echo $cats;
				}
				if ( get_query_var('paged') ) {
					$cat = $cat->cat_ID;
					echo $sep . sprintf($link, get_category_link($cat), get_cat_name($cat)) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ($show_current) echo $sep . $before . sprintf($text['category'], single_cat_title('', false)) . $after;
				}
			} elseif ( is_search() ) {
				if (have_posts()) {
					if ($show_home_link && $show_current) echo $sep;
					if ($show_current) echo $before . sprintf($text['search'], get_search_query()) . $after;
				} else {
					if ($show_home_link) echo $sep;
					echo $before . sprintf($text['search'], get_search_query()) . $after;
				}
			} elseif ( is_single() && !is_attachment() ) {
				if ($show_home_link) echo $sep;
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $home_link . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($show_current) echo $sep . $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $sep);
					if (!$show_current || get_query_var('cpage')) $cats = preg_replace("#^(.+)$sep$#", "$1", $cats);
					$cats = preg_replace('#<a([^>]+)>([^<]+)<\/a>#', $link_before . '<a$1' . $link_attr .'>' . $link_in_before . '$2' . $link_in_after .'</a>' . $link_after, $cats);
					echo $cats;
					if ( get_query_var('cpage') ) {
						echo $sep . sprintf($link, get_permalink(), get_the_title()) . $sep . $before . sprintf($text['cpage'], get_query_var('cpage')) . $after;
					} else {
						if ($show_current) echo $before . get_the_title() . $after;
					}
				}
			// custom post type
			} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object(get_post_type());
				if ( get_query_var('paged') ) {
					echo $sep . sprintf($link, get_post_type_archive_link($post_type->name), $post_type->label) . $sep . $before . sprintf($text['page'], get_query_var('paged')) . $after;
				} else {
					if ($show_current) echo $sep . $before . $post_type->label . $after;
				}
			} elseif ( is_page() && !$parent_id ) {
				if ($show_current) echo $sep . $before . get_the_title() . $after;
			} elseif ( is_page() && $parent_id ) {
				if ($show_home_link) echo $sep;
				if ($parent_id != $frontpage_id) {
					$breadcrumbs = array();
					while ($parent_id) {
						$page = get_page($parent_id);
						if ($parent_id != $frontpage_id) {
							$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
						}
						$parent_id = $page->post_parent;
					}
					$breadcrumbs = array_reverse($breadcrumbs);
					for ($i = 0; $i < count($breadcrumbs); $i++) {
						echo $breadcrumbs[$i];
						if ($i != count($breadcrumbs)-1) echo $sep;
					}
				}
				if ($show_current) echo $sep . $before . get_the_title() . $after;
			} elseif ( is_404() ) {
				if ($show_home_link && $show_current) echo $sep;
				if ($show_current) echo $before . $text['404'] . $after;
			} elseif ( has_post_format() && !is_singular() ) {
				if ($show_home_link) echo $sep;
				echo get_post_format_string( get_post_format() );
			}
			echo $wrap_after;
		}
	}
        
    require_once 'elements/hotels.php';    
    require_once 'elements/guides.php';
    require_once 'elements/conditions.php';
    require_once 'elements/regions.php';
    require_once 'elements/reservations.php';
    require_once 'elements/contacts.php';
    require_once 'elements/contacts_newsletter.php';
    require_once 'options/config_mds.php';
    
    function post_xml($url, $xml){ 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST,   1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }  
    
    $GLOBALS['mds_url'] = 'http://mdswsb.merlinx.pl/dataV4/';
    $GLOBALS['mds_url_booking'] = 'http://mws.merlinx.pl/bookV4/';
    
    function get_data($type = 'offers', $conditions = array('par_adt' => 2, 'ofr_xCatalog' => 'LAST', 'trp_depDate' => '20180222:20180315', 'obj_codeNameFts' => 'Resort', 'ofr_type' => 'F'), $selectAnswerFields = NULL) {
    
        $xml = new XMLWriter(); 
	$xml->openMemory(); 
	$xml->startDocument('1.0', 'UTF-8');
			 
            $xml->startElement('mds');

                $xml->startElement('auth');
                    $xml->writeElement('login', esc_attr( get_option('login')));
                    $xml->writeElement('pass', esc_attr( get_option('password')));
                    $xml->writeElement('source', 'mdsws');      
                    $xml->writeElement('srcDomain', 'citytravel.pl');
                $xml->endElement();

                $xml->startElement('request');
                    $xml->writeElement('type', $type);
                    if(!empty($selectAnswerFields)) {
                        $xml->writeElement('selectAnswerFields', $selectAnswerFields);
                    }
                    $xml->startElement('conditions');
                        foreach($conditions as $key=>$val) {
                            $xml->writeElement($key, $val);
                        }
                    $xml->endElement();	    
                $xml->endElement();

            $xml->endElement();
	$xml->endDocument();
        
	$xml_response_string = post_xml($GLOBALS['mds_url'], $xml->outputMemory(true));   
        
			 
	if(!$xml_response_string) 
            die('ERROR');
			 
	$xml_response = simplexml_load_string($xml_response_string);

	$array = json_decode(json_encode((array) $xml_response));
        
        return $array;
    }
    
    function get_attributes($offer_id, $htlXCode, $htlCode, $tourOp, $type='image', $single = false) {
        $site_url = get_site_url();
        if($site_url == 'https://cititravel.pl') {
        global $wpdb;
        
        require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        
        $login = esc_attr( get_option('login'));
        $password = esc_attr( get_option('password'));	

        $link = array('http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S&htlCat=LAST',
                    'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W&htlCat=LAST',  
                    'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S',
                    'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W',
                    'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&fromDate='.date('md'),
                    'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp);
   
        $queried_post = get_page_by_path($htlXCode,OBJECT,'hotels');
        $post_id = (int) $queried_post->ID;
        
        //jeśli nie ma hotelu o danym kodzie to go dodajemy wraz z miniaturą
        if($type=='thumb' && empty($queried_post)) {        
            
            foreach($link as $lnk) {
                $xml_response = simplexml_load_file($lnk);
                $array = json_decode(json_encode((array) $xml_response));
                if($array->status=='ok') {
                    $hotel = !is_object($array->hotelData->hotel) ? $array->hotelData->hotel : '';

                    $data = array('post_type' => 'hotels',
                            'post_name' => $htlXCode,
                            'post_content' => '',
                            'post_title' => $hotel,
                            'post_status' => 'publish');

                    $post_id = wp_insert_post($data);

                    $thumb = $array->hotelData->images->thumb;
                    $attachment = media_sideload_image($thumb, $post_id, '', 'id');
                    
                    if(!empty($thumb) && $type=='thumb') return array($thumb);
              }
            }
        }
        
        //jeśli hotel istnieje i chcemy tylko miniaturkę
        if($type=='thumb') {
            $images_list = array();
            
            //pobieramy miinaturkę z wpisu
            $thumbnail = get_the_post_thumbnail_url($queried_post->ID);
            if(!empty($thumbnail)) $images_list[] = $thumbnail;
                           
            if(empty($images_list)) {
                //jeśli nie ma miniaturki to sprawdzamy czy jest jakikolwiek obraz załączony do posta    
                $media = get_attached_media( 'image', $queried_post->ID );
                
                //jeśli nie ma żadnego obrazu, to go pobieramy z MerlinX
                if(empty($media[$queried_post->ID])) {

                    foreach($link as $lnk) {
                        $xml_response = simplexml_load_file($lnk);
                        $array = json_decode(json_encode((array) $xml_response));
                        if($array->status=='ok') {
                            $hotel = $array->hotelData->hotel;

                            if(is_array($array->hotelData->images->pictures->picture)) $image = $array->hotelData->images->pictures->picture[0];
                            elseif(!empty($array->hotelData->images->pictures->picture)) $image = $array->hotelData->images->pictures->picture;
                            $i=0;
                                $attachment = media_sideload_image($image, $queried_post->ID, '', 'id');
                                set_post_thumbnail( $queried_post->ID, $attachment );
                    
                                $wpdb->insert( 
                                    'wp_images_cache', 
                                    array( 
                                        'code' => $htlCode, 
                                        'xCode' => $htlXCode,
                                        'tourOp' => $tourOp,
                                        'image_number' => 1,
                                        'image_link' => $image
                                    ), 
                                    array( 
                                        '%s', 
                                        '%s',
                                        '%s',
                                        '%d',
                                        '%s'
                                    ) 
                                );
                            break;
                        }
                    }
                    $images_list[0] = $image;
                }
                else {
                    $images_list[0] = $media[$queried_post->ID]->guid;
                }
               
                //jeśli nie ma miniaturki to dajemy zaślepkę
                if(empty($images_list) || empty($images_list[0])) $images_list[] = get_template_directory_uri().'/img/cititravel-placeholder.jpg';            
            }
                   
            //jeśli obrazek ma rozszerzenie inne niż możliwe do wyświetlenia na stronie to ustawiamy zaślepkę
            $file_tab = explode('/', $images_list[0]);
            $ext_tab = explode('.', $file_tab[count($file_tab)-1]);
            $ext = $ext_tab[count($ext_tab)-1];
                 
            if($ext!='png'&&$ext!='jpg'&&$ext!='jpeg'&&$ext!='gif') {
                $images_list[0] = get_template_directory_uri().'/img/cititravel-placeholder.jpg';
            }
            else {
                $images_list[0] = get_the_post_thumbnail_url( $queried_post->ID, 'thumbnail' );
            }
      
            return $images_list;
        }
          
        //jeśli chcemy pobrać listę obrazków
        if($type=='image') {
            $images_list = array();
            for($x=1;$x<=30;$x++) {
                $image = get_field('zdjecie'.$x, $queried_post->ID);
                if(!empty($image)) $images_list[] = $image['url'];
            }
            if(empty($images_list)) {
                $images_list[0] = get_the_post_thumbnail_url( $queried_post->ID, 'medium' );
            }
                    
            /*if(empty($images_list)) {
                   
                foreach($link as $lnk) {
                    $xml_response = simplexml_load_file($lnk);
                    $array = json_decode(json_encode((array) $xml_response));
                    if($array->status=='ok') {
                        $hotel = $array->hotelData->hotel;
                            
                        if(is_array($array->hotelData->images->pictures->picture)) $images_list = $array->hotelData->images->pictures->picture;
                        elseif(!empty($array->hotelData->images->pictures->picture)) $images_list[0] = $array->hotelData->images->pictures->picture;
                        $i=0;
                        foreach($images_list as $il) {                      
                            if($i<=30) {
                                $attachment = media_sideload_image($il, $queried_post->ID, '', 'id');
                                update_field('zdjecie'.$i, $attachment, $queried_post->ID);    
                            }
                            $wpdb->insert( 
                                'wp_images_cache', 
                                array( 
                                    'code' => $htlCode, 
                                    'xCode' => $htlXCode,
                                    'tourOp' => $tourOp,
                                    'image_number' => $i,
                                    'image_link' => $il
                                ), 
                                array( 
                                    '%s', 
                                    '%s',
                                    '%s',
                                    '%d',
                                    '%s'
                                ) 
                            );
                            $i++;
                        }
                            break;
                        }
                    }
                }*/
                
                foreach($images_list as $key=>$il) {
                    if(empty($il)) unset($images_list[$key]);
                }
                
                if(empty($images_list)) $images_list[] = get_template_directory_uri().'/img/cititravel-placeholder.jpg';
                    
                return $images_list;
            }

            if($type=='text') {
                $texts_list = array();

                $kategoria_n = get_field('kategoria', $queried_post->ID);
                if(!empty($kategoria_n)) $texts_list['kategoria'] = $kategoria_n;

                $region_n = get_field('region', $queried_post->ID);
                if(!empty($region_n)) $texts_list['region'] = $region_n;

                $polozenie_n = get_field('polozenie', $queried_post->ID);
                if(!empty($polozenie_n)) $texts_list['polozenie'] = $polozenie_n;

                $plaza_n = get_field('plaza', $queried_post->ID);
                if(!empty($plaza_n)) $texts_list['plaza'] = $plaza_n;

                $wyposazenie_n = get_field('wyposazenie', $queried_post->ID);
                if(!empty($wyposazenie_n)) $texts_list['wyposazenie'] = $wyposazenie_n;

                $dostep_do_internetu_n = get_field('dostep_do_internetu', $queried_post->ID);
                if(!empty($dostep_do_internetu_n)) $texts_list['dostep_do_internetu'] = $dostep_do_internetu_n;

                $kategoria_lokalna_n = get_field('kategoria_lokalna', $queried_post->ID);
                if(!empty($kategoria_lokalna_n)) $texts_list['kategoria_lokalna'] = $kategoria_lokalna_n;

                $zakwaterowanie_n = get_field('zakwaterowanie', $queried_post->ID);
                if(!empty($zakwaterowanie_n)) $texts_list['zakwaterowanie'] = $zakwaterowanie_n;

                $wyzywienie_n = get_field('wyzywienie', $queried_post->ID);
                if(!empty($wyzywienie_n)) $texts_list['wyzywienie'] = $wyzywienie_n;

                $sport_n = get_field('sport', $queried_post->ID);
                if(!empty($sport_n)) $texts_list['sport'] = $sport_n;

                $restauracje_i_bary_n = get_field('restauracje_i_bary', $queried_post->ID);
                if(!empty($restauracje_i_bary_n)) $texts_list['restauracje_i_bary'] = $restauracje_i_bary_n;

                $dodatkowe_informacje_n = get_field('dodatkowe_informacje', $queried_post->ID);
                if(!empty($dodatkowe_informacje_n)) $texts_list['dodatkowe_informacje'] = $dodatkowe_informacje_n;

                $bagaz_n = get_field('bagaz', $queried_post->ID);
                if(!empty($bagaz_n)) $texts_list['bagaz'] = $bagaz_n;
                //}
                return $texts_list;
            }
        }
        else {
            $images_list[] = get_template_directory_uri().'/img/cititravel-placeholder.jpg';
            return $images_list;
        }
       // }
        
    }
    
    function get_images_from_db($htlCode, $tourOp, $single) {
        global $wpdb;
        $qry = "SELECT `image_number`, `image_link` FROM wp_images_cache WHERE xCode='{$htlCode}' AND tourOp='{$tourOp}'";
        $qry .= ($single===false) ? " AND image_number=0" : "";
        $results = $wpdb->get_results( $qry );
        $attrs = array();
        if(!empty($results)) {
            foreach($results as $res) {
                $attrs[$res->image_number] = $res->image_link;
            }
        }
        return $attrs;
    }
    
    function get_attributes_from_db($htlCode, $tourOp, $type) {
        global $wpdb;
        $qry = "SELECT `key`, `value` FROM wp_hotels_attributes WHERE obj_xCode='{$htlCode}' AND tourOp='{$tourOp}' AND type='{$type}'";
        $results = $wpdb->get_results( $qry );
        $attrs = array();
        foreach($results as $res) {
            $attrs[$res->key] = $res->value;
        }
        return $attrs;
    }
    
    function add_offer_to_db($offer_id) {
        global $wpdb;
        if(is_offer($offer_id)) {
            return $wpdb->update('wp_offers_cache', array('offer_id' => $offer_id), array('offer_id' => $offer_id));
        }
        else {
            return $wpdb->insert('wp_offers_cache', array(
                'offer_id' => $offer_id
            ));    
        }
    }
    
    function add_custom_permalink($hotel_code, $country, $hotel_name) {
        $new_link = 'wakacje/'.sanitize_title($country).'/hotel-'.$hotel_code.'-'.sanitize_title($hotel_name).'.html';
        $post = get_page_by_path($hotel_code,OBJECT,'hotels');
        $post_id = $post->ID;    
        
        global $wpdb;
        
        $qry = "SELECT 1 FROM wp_postmeta WHERE meta_key='custom_permalink' AND post_id='{$post_id}'";
        $results = $wpdb->get_results( $qry );
        
        if(empty($results)) {
            return $wpdb->insert('wp_postmeta', array(
                'post_id' => $post_id,
                'meta_key' => 'custom_permalink',
                'meta_value' => $new_link
            ));
        }
        return true;
    }
    
    function is_offer($offer_id) {
        global $wpdb;
        $qry = "SELECT last_date FROM wp_offers_cache WHERE offer_id='{$offer_id}'";
        $results = $wpdb->get_results( $qry );
        return !empty($results);
    }
    
    function is_offer_newer($offer_id) {
        global $wpdb;
        $qry = "SELECT last_date FROM wp_offers_cache WHERE offer_id='{$offer_id}' AND last_date>DATE_SUB(NOW(), INTERVAL 1 HOUR)";
        $results = $wpdb->get_results( $qry );
        return !empty($results);
    }
    
    function add_attributes_to_db($htlCode, $tourOp, $type, $value, $key) {
        global $wpdb;
        return $wpdb->insert('wp_hotels_attributes', array(
            'obj_xCode' => $htlCode,
            'tourOp' => $tourOp,
            'type' => $type, 
            'value' => $value,
            'key' => $key
        ));
    }
    
    add_action('parse_request', 'my_custom_url_handler');

    function my_custom_url_handler() {
       if(strpos($_SERVER["REQUEST_URI"], '/import_data') !== false) {
            //tutaj wykonujemy cały import
            //echo import_regions();
            //import_options();
            //import_tourop();
            //import_services();
            //import_codes();
            //import_hotels();
            update_regions();
            //wp_redirect('/options-general.php?page=mds');
            exit;
       }
    }

    require_once 'import_mds.php';
    
    add_action('parse_request', 'my_obrazki_url_handler');

    function my_obrazki_url_handler() {
       if(strpos($_SERVER["REQUEST_URI"], '/obrazki') !== false) {
          global $wpdb;
          $result = $wpdb->get_results( 
                "SELECT `code`
                FROM m_mds_place WHERE checked=1 AND published=1
                GROUP BY code ORDER BY code DESC"
                );
          
          $list = array();
          foreach($result as $res) {
              $list[] = $res->code;
          }
          
          $args = array('post_type' => 'hotels', 'numberposts' => 100, 'exclude' => $list, 'date_query'    => array(
                                                                                            'column'  => 'post_modified',
                                                                                            'before'   => '- 5 days'
                                                                                        ));
          $hotels = get_posts($args);
           
          foreach($hotels as $post) {
              $code = get_field('hotel_code', $post->ID);
              $tourOp = get_field('tour_operator', $post->ID);
              if((empty($code) || empty($tourOp))) {
                $offer = get_data('offers', array('obj_xCode'=>$id, 'calc_found' => 1, 'limit_count' => 1));
                if($offer->count>0) {
                    update_field('hotel_code', $offer->ofr->obj->{'@attributes'}->code, $post->ID);         
                    update_field('tour_operator', $offer->ofr->{'@attributes'}->tourOp, $post->ID);  
                }
                
                $code = $offer->ofr->obj->{'@attributes'}->code;
                $tourOp = $offer->ofr->{'@attributes'}->tourOp;
              } 
              
               $x++;
            
               $htlCode = $code;
              $post_id = $post->ID;
          if(!empty($htlCode) && !empty($tourOp)) {
            $i=0;
            $login = esc_attr( get_option('login'));
            $password = esc_attr( get_option('password'));
            $post_id = $post->ID;

            $link[0] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S&htlCat=LAST';
            $link[1] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W&htlCat=LAST';   
            $link[2] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S';
            $link[3] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W';
            $link[4] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&fromDate='.date('md');
            $link[5] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp;    
            
            foreach($link as $lnk) {
                $xml_response = simplexml_load_file($lnk);
                $array = json_decode(json_encode((array) $xml_response));
                $new_text = '';
                if($array->status=='ok') {
                    if(!empty($array->hotelData->texts)) {
                        if(!empty($array->hotelData->texts->text)) {
                            foreach($array->hotelData->texts->text as $txt) {
                                if(!empty($txt->content)) {
                                    if(!is_object($txt->subject) && !is_object($txt->content)) {
                                        $new_text .= (string)$txt->subject.'|||'.(string)$txt->content.'<br/><br/>';
                                    }
                                }
                            }

                            $my_post = array(
                                'ID'           => $post_id,
                                'post_content' => $new_text
                            );

                            wp_update_post( $my_post );
                            
                        }
                        continue;
                    }
                  
                    continue;
                }
                }
                }
                $my_post = array(
                    'ID'           => $post_id
                );
                wp_update_post( $my_post );
                
                echo $post_id."<br/>";
              
             
              
          }
            exit;
       }
    }
    
    add_action('parse_request', 'my_images_url_handler');

    function my_images_url_handler() {
       if(strpos($_SERVER["REQUEST_URI"], '/oimages') !== false) {
           global $wpdb;
           
          /*  require_once(ABSPATH . 'wp-admin/includes/media.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/image.php');
       
          $conditions = array(
            'par_adt' => 2,
            'par_chd' => 0,
            'trp_depDate' => '20181009:20191231',
            'ofr_tourOp' => 'ITAK,VNET,ECCO,ECTR,EXIM,SYLO,VMAT,NPL,RNBW,WEZY,TUIZ',
            'limit_from' => 0,
            'limit_count' => 1000,
            'calc_found' => 1000,
            'ofr_xStatus' => 'A',
            'minPrice' => 0
        );
          
          $offers = get_data('groups', $conditions);

          foreach($offers->grp as $ofr) {*/
        
        $hotels = get_posts(array('post_type' => 'hotels', 'numberposts' => 100, 'date_query'    => array(
                                                                                            'column'  => 'post_modified',
                                                                                            'after'   => '- 2 days'
                                                                                        )));
        $x=1;
        foreach($hotels as $hotel) {
            $x++;
            
              $post_id = $hotel->ID;
              $htlCode = get_field('field_5bbbc589f17ee', $post_id);
              $tourOp = get_field('field_5bbc639494319', $post_id);
          if(!empty($htlCode) && !empty($tourOp)) {
            $i=0;
            $login = esc_attr( get_option('login'));
            $password = esc_attr( get_option('password'));	

            $link[0] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S&htlCat=LAST';
            $link[1] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W&htlCat=LAST';   
            $link[2] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S';
            $link[3] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W';
            $link[4] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&fromDate='.date('md');
            $link[5] = 'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp;    
            
            echo "<pre>";
            print_r($link);

            /*foreach($link as $lnk) {
                $xml_response = simplexml_load_file($lnk);
                $array = json_decode(json_encode((array) $xml_response));
                if($array->status=='ok') {
                    $hotel = $array->hotelData->hotel;
                    $images = $array->hotelData->images->pictures->picture;
                    if(!empty($images) && is_array($images)) {
                        foreach($images as $image) {
                            $i++;
                            if($i<=30 && !file_exists('wp-content/uploads/2018/10/'.$image)) {
                                $attachment = media_sideload_image($image, $post_id, '', 'id');
                                update_field('zdjecie'.$i, $attachment, $post_id);    
                                if($i==1) set_post_thumbnail( $post_id, $attachment );
                            }
                        }  
                        break;
                    }
                    elseif(!empty($images)) {
                        $attachment = media_sideload_image($images, $post_id, '', 'id');
                        update_field('zdjecie1', $attachment, $post_id);    
                        set_post_thumbnail( $post_id, $attachment );
                        break;
                    }
                    
                }}
                echo $x.':'.$post_id."<br/>";*/
            
            foreach($link as $lnk) {
                $xml_response = simplexml_load_file($lnk);
                $array = json_decode(json_encode((array) $xml_response));
                $new_text = '';
                if($array->status=='ok') {
                    if(!empty($array->hotelData->texts)) {
                        if(!empty($array->hotelData->texts->text)) {
                            foreach($array->hotelData->texts->text as $txt) {
                                if(!empty($txt->content)) {
                                    if(!is_object($txt->subject) && !is_object($txt->content)) {
                                        $new_text .= (string)$txt->subject.'|||'.(string)$txt->content.'<br/><br/>';
                                    }
                                }
                            }
                            $my_post = array(
                                'ID'           => $post_id,
                                'post_content' => $new_text
                            );

                            echo $post_id."<br/>";
                            wp_update_post( $my_post );
                            
                        }
                        continue;
                    }
                    else {
                        echo $post_id."<br/>";
                        $my_post = array(
                            'ID'           => $post_id
                        );
                        wp_update_post( $my_post );
                
                    }
                    continue;
                }
                else {
                    echo $post_id."<br/>";
                    $my_post = array(
                        'ID'           => $post_id
                    );
                    wp_update_post( $my_post );
                }
            }
                }
                else {
                    echo $post_id."<br/>";
                    $my_post = array(
                        'ID'           => $post_id
                    );
                    wp_update_post( $my_post );
                }
                 
          }
            exit;
       }
    }
    
    /*
     add_action('parse_request', 'my_skrypt_url_handler');

    function my_skrypt_url_handler() {
       if(strpos($_SERVER["REQUEST_URI"], '/skrypt') !== false) {
           global $wpdb;
            $result = $wpdb->get_results( 
                "SELECT `code`, `title`, `body`
                FROM m_mds_place WHERE published=1 AND is_last_version=1"
                );
            foreach($result as $res) {
                $body = explode("\n", $res->body);
                foreach($body as $key=>$string) {
                    $string = trim(strip_tags($string));
                    $content = $body[$key+1];
                    switch($string) {
                                case 'Kategoria':
                                case 'Kategoryzacja hotelu':
                                    $kategoria = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Region':
                                case '2':
                                    $region = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Położenie':
                                    $polozenie = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Plaża':
                                    $plaza = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Wyposażenie':
                                    $wyposazenie = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Dostęp do internetu':
                                    $dostep_do_internetu = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Kategoria lokalna':
                                    $kategoria_lokalna = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Zakwaterowanie':
                                case 'Pokoje':
                                    $zakwaterowanie = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Wyżywienie':
                                    $wyzywienie = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Sport':
                                case 'Sport, Relaks, Rozrywka':
                                    $sport = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                                case 'Restauracje i bary':
                                    $restauracje_i_bary = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;    
                                case 'Dodatkowe informacje':
                                    $dodatkowe_informacje = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;    
                                case 'Bagaż':
                                    $bagaz = ucfirst(trim(strip_tags($content)));
                                    unset($body[$key]);
                                    unset($body[$key+1]);
                                break;
                            }
                            
                            $other = strip_tags(join("\n", $body));
                }
                $queried_post = get_page_by_path($res->code,OBJECT,'hotels');
                if(empty($queried_post)) {    
                             $data = array('post_type' => 'hotels',
                                'post_name' => $res->code,
                                'post_content' => $res->body,
                                'post_title' => $res->title,
                                'post_status' => 'publish');

            $post_id = wp_insert_post($data);
                }
                elseif(!empty($queried_post->ID) && !empty($res->body)) {
                    $my_post = array(
                        'ID'           => $queried_post->ID,
                        'post_content' => $res->body
                    );

                    echo wp_update_post( $my_post );
                }
          /*  update_field('kategoria', $kategoria, $post_id);   
            update_field('region', $region, $post_id);   
            update_field('polozenie', $polozenie, $post_id);   
            update_field('plaza', $plaza, $post_id);   
            update_field('wyposazenie', $wyposazenie, $post_id);   
            update_field('dostep_do_internetu', $dostep_do_internetu, $post_id);   
            update_field('kategoria_lokalna', $kategoria_lokalna, $post_id);   
            update_field('zakwaterowanie', $zakwaterowanie, $post_id);   
            update_field('wyzywienie', $wyzywienie, $post_id);   
            update_field('sport', $sport, $post_id);   
            update_field('restauracje_i_bary', $restauracje_i_bary, $post_id);   
            update_field('dodatkowe_informacje', $dodatkowe_informacje, $post_id);   
            update_field('bagaz', $bagaz, $post_id);   
            update_field('pozostale_informacje', $other, $post_id); */  
            
                
             
            /*}
            exit;
       }
    }
    */
    function get_conditions_by_id($trip_id, $only_conditions = false) {
     
        $page = get_query_var('page', 1);
        $limit_from = max(array(($page-1)*15, 0))+1;
        $limit = 15;
        $kierunek = get_field('kierunek', $trip_id);
        $ofr_type = array();
        $doj_terms = wp_get_post_terms($trip_id, 'trp_type');
        foreach($doj_terms as $dt) {
            $ofr_type[] = get_field('code', 'trp_type_'.$dt->term_id);
        }
        
        $ofr_tourOp = array();
        $conditions_tourop = wp_get_post_terms($trip_id, 'conditions_tourop');
        if(!empty($conditions_tourop)) {
            foreach($conditions_tourop as $dt) {
                $ofr_tourOp[] = strtoupper($dt->slug);
            }
        }
        else {
            $terms = get_terms('conditions_tourop', array('hide_empty' => false));
            if(!empty($terms)) {
            foreach($terms as $dt) {
                if((bool)get_field('active', 'conditions_tourop_'.$dt->term_id)===true)
                    $ofr_tourOp[] = strtoupper($dt->slug);
            }
        }
        }

        $par_adt = get_field('par_adt', $trip_id);
        if(empty($par_adt)) $par_adt = 2;
        $trp_duration = get_field('trp_duration', $trip_id);
        if(empty($trp_duration)) $trp_duration = '6:8';
        $trp_depDate = get_field('trp_depDate', $trip_id);
        
        $trp_retDate = get_field('trp_retDate', $trip_id); 
        if(strtotime($trp_depDate)<time()) $trp_depDate = date('Ymd', strtotime('+2 day')).':'.$trp_retDate;
        $orderby = get_query_var('orderby', 'ofr_price');
        
        $obj_type_terms = wp_get_post_terms($trip_id, 'obj_type');
        foreach($obj_type_terms as $dt) {
            $obj_type[] = get_field('code', 'obj_type_'.$dt->term_id);
        }
         
        $conditions = array(
            'par_adt' => (int)$par_adt, 
            'trp_duration' => $trp_duration, 
            'limit_from' => $limit_from, 
            'limit_count' => $limit, 
            'ofr_xStatus' => 'A',
            'calc_found' => 500,
            'order_by' => $orderby);
        
        if(!empty($kierunek)) $conditions['trp_destination'] = $kierunek;
      
        if(!empty($ofr_type)) $conditions['ofr_type'] = join(',', $ofr_type); 
        else $conditions['ofr_type'] = 'F'; 
        
        if(!empty($obj_type)) $conditions['obj_type'] = join(',', $obj_type); 
        else $conditions['obj_type'] = 'H,AP'; 
        
        if(!empty(get_field('trp_depDate', $trip_id))) {
            $trp_depDate = explode(':', get_field('trp_depDate', $trip_id));   
            $trp_depDateFrom = date('Ymd', strtotime($trp_depDate[0]));
            if(strtotime($trp_depDateFrom)<time()) $trp_depDateFrom = date('Ymd', strtotime('+2 day'));
            $trp_retDate = get_field('trp_retDate', $trip_id); 
            if(strtotime($trp_retDate)<time()) $trp_retDate = date('Ymd', strtotime('+32 day'));
            if(!empty($trp_retDate)) $conditions['trp_retDate'] = $trp_retDate;
            $trp_depDateTo = date('Ymd', strtotime($trp_depDate[1]));
        }
        else {
            $trp_depDateFrom = date('Ymd', strtotime('+2 day'));   
            $trp_depDateTo = date('Ymd', strtotime('+32 day'));   
        }
        
    $ofr_xCatalog = (int)get_field('ofr_xCatalog', $trip_id);
    $obj_xServiceId = array(get_field('obj_xServiceId', $trip_id));
    $kierunek = explode(',', get_field('kierunek', $trip_id));
    $trp_depName = array();
    $dep_codes = wp_get_post_terms($trip_id, 'dep_codes');
    foreach($dep_codes as $dt) {
        $trp_depName[] = get_field('code', 'dep_codes_'.$dt->term_id);
    }
    
    $trp_depCode = (!empty($trp_depName)) ? $trp_depName[0] : '';
    
    $trp_depDate = $trp_depDateFrom.':'.$trp_depDateTo;
        
        if(!empty($ofr_tourOp)) $conditions['ofr_tourOp'] = join(',', $ofr_tourOp);  
        if(!empty($trp_depDate)) $conditions['trp_depDate'] = $trp_depDate;
        else $conditions['trp_depDate'] = date('Ymd', strtotime('+2 day'));
        
        $maxPrice = get_field('maxPrice', $trip_id); 
        if(!empty($maxPrice) && $maxPrice<8000) $conditions['maxPrice'] = $maxPrice;
        
        $minPrice = get_field('minPrice', $trip_id); 
        if(!empty($minPrice)) $conditions['minPrice'] = $minPrice;
        else $conditions['minPrice'] = 600;
        
        $obj_category = get_field('obj_category', $trip_id); 
        if(!empty($obj_category)) $conditions['obj_category'] = $obj_category;
        
        $obj_codeNameFts = get_field('obj_codeNameFts', $trip_id); 
        if(!empty($obj_codeNameFts)) $conditions['obj_codeNameFts'] = $obj_codeNameFts;
        
        $par_chd = get_field('par_chd', $trip_id); 
        $par_chdAge = get_field('par_chdAge', $trip_id); 
        if(!empty($par_chd) && !empty($par_chdAge)) {
            $conditions['par_chd'] = $par_chd;
            $conditions['par_chdAge'] = $par_chdAge;
        }
        
        $par_inf = get_field('par_inf', $trip_id); 
        if(!empty($par_inf)) $conditions['par_inf'] = $par_inf;
        
        $trp_depCode = array();
        $dep_codes = wp_get_post_terms($trip_id, 'dep_codes');
        foreach($dep_codes as $dt) {
            $trp_depCode[] = get_field('code', 'dep_codes_'.$dt->term_id);
        }
        if(!empty($trp_depCode)) $conditions['trp_depCode'] = join(',', $trp_depCode);
        
        $ofr_xCatalog = array();
        $conditions_promotions = wp_get_post_terms($trip_id, 'conditions_promotions');
        foreach($conditions_promotions as $dt) {
            $ofr_xCatalog[] = get_field('code', 'conditions_promotions_'.$dt->term_id);
        }
        if(!empty($ofr_xCatalog)) $conditions['ofr_xCatalog'] = join(',', $ofr_xCatalog);
        
        $obj_xServiceId = array();
        $conditions_service = wp_get_post_terms($trip_id, 'conditions_service');
        foreach($conditions_service as $dt) {
            $obj_xServiceId[] = get_field('code', 'conditions_service_'.$dt->term_id);
        }
        if(!empty($obj_xServiceId)) $conditions['obj_xServiceId'] = join(',', $obj_xServiceId);
        
        //echo "<pre>";
        //print_r($conditions);exit;

        if($only_conditions === true) return $conditions;
       // print_r($conditions);
        $data = get_data('groups', $conditions);
     //   echo "<pre>";
      //  print_r($data);exit;

        return $data;
    }
    
    function add_query_vars_filter( $vars ){
        $vars[] = "page";
        $vars[] = "id";
        $vars[] = "start";
        $vars[] = "par_adt";     
        $vars[] = "par_chd";
        $vars[] = "par_chdAge";
        $vars[] = "ofr_xCatalog";
        $vars[] = "trp_depCode";
        $vars[] = "trp_destination";
        $vars[] = "trp_duration";
        $vars[] = "trp_depDate";
        $vars[] = "trp_depDateFrom";
        $vars[] = "trp_depDateTo";
        $vars[] = "orderby";
        $vars[] = "sort";
        $vars[] = "obj_xServiceId";
        $vars[] = "ofr_type";
        $vars[] = "obj_xAttributes";
        $vars[] = "ofr_tourOp";
        $vars[] = "obj_category";
        $vars[] = "oferta";
        $vars[] = "minPrice";
        $vars[] = "maxPrice";
        $vars[] = "obj_type";
        return $vars;
    }
    add_filter( 'query_vars', 'add_query_vars_filter' );
    
    function multiexplode ($delimiters,$string) {
   
        $ready = str_replace($delimiters, $delimiters[0], $string);
        $launch = explode($delimiters[0], $ready);
        return  $launch;
    }
    
    function get_rating($rating) {
        $rating_tab = explode('/',$rating);
	foreach($rating_tab as $rat) {
            list($key, $val) = explode(':', $rat);
            if(strtolower($key)=='a') $new_rating = $val;
	}
        if(!empty($rating)) return $new_rating;
        return 6.0;
    }
    
        
        add_action('wp_ajax_schowek', 'process_schowek');
        add_action('wp_ajax_nopriv_schowek', 'process_schowek');

	function process_schowek() {
            global $wpdb;
            
            $hanging_code = $_COOKIE["hanging_code"];
            if(empty($hanging_code)) {
                $hanging_code = generateRandomString(15);
                setcookie("hanging_code", $hanging_code, time() + (86400 * 30), "/", str_replace('http://', '', get_site_url()));  
                $wpdb->insert( 
                    'wp_hanging', 
                    array( 
                        'code' => $hanging_code
                    ), 
                    array( 
                        '%s'
                    ) 
                );
            }

            $qry_sel = "SELECT id FROM wp_hanging 
                    WHERE code='{$hanging_code}'";
            $row = $wpdb->get_row( $qry_sel );
            $hanging_id = $row->id;
            
            $ip = getRealIpAddr();
            echo $wpdb->insert( 
                    'wp_hanging_offers', 
                    array( 
                        'hanging_id' => $hanging_id,
                        'offer_id' => $_POST['id'],
                        'ip' => $ip
                    ), 
                    array( 
                        '%d',
                        '%s',
                        '%s'
                    ) 
                );
            exit;
	}
        
        add_action('wp_ajax_schowek_remove', 'process_schowek_remove');
        add_action('wp_ajax_nopriv_schowek_remove', 'process_schowek_remove');

	function process_schowek_remove() {
            global $wpdb;
            
            $hanging_code = $_COOKIE["hanging_code"];
            if(empty($hanging_code)) {
                echo 0;
                exit;
            }

            $qry_sel = "SELECT id FROM wp_hanging 
                    WHERE code='{$hanging_code}'";
            $row = $wpdb->get_row( $qry_sel );
            $hanging_id = $row->id;
            
            echo $wpdb->delete( 'wp_hanging_offers', array( 'hanging_id' => $hanging_id, 'offer_id' => $_POST['id']), array( '%d', '%d' ) );

            exit;
	}
        
        function generateRandomString($length = 10) {
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
             return $randomString;
         }
         
         function getRealIpAddr()
        {
            if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
            {
              $ip=$_SERVER['HTTP_CLIENT_IP'];
            }
            elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
            {
              $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
            }
            else
            {
              $ip=$_SERVER['REMOTE_ADDR'];
            }
            return $ip;
        }
        
    add_action('wp_ajax_change_offer', 'process_change_offer');
    add_action('wp_ajax_nopriv_change_offer', 'process_change_offer');

    function process_change_offer() {
        $values = array();
        parse_str($_POST['form'], $values);
        //$data_wyj_pow = explode('-', $values['data-wyjazdu-powrotu-input']);
        //$data_wyjazdu = date('Ymd', strtotime(trim($data_wyj_pow[0])));      
        //$data_powrotu = date('Ymd', strtotime(trim($data_wyj_pow[0])));
        
        $data = get_data('offers', array('trp_duration' => $values['trp_duration'], 'trp_depDate' => $values['trp_depDate'],
            'ofr_type' => $values['ofr_type'], 'ofr_tourOp' => $values['ofr_tourOp'], 'obj_xCode' => $values['obj_xCode'], 
            'obj_code' => $values['obj_code'], 'ofr_xStatus' => $values['ofr_xStatus'], 'par_adt' => $values['par_adt'], 
            'par_chd' => $values['par_chd'], 'par_chdAge' => $values['par_chdAge']));
        if(!empty($data->ofr[0])) {
            echo $data->ofr[0]->{'@attributes'}->id;
        }
        else {
            echo $data->ofr->{'@attributes'}->id;
        }
        exit;
    }
    
    add_action('wp_ajax_search_dates', 'process_search_dates');
    add_action('wp_ajax_nopriv_search_dates', 'process_search_dates');
    
    function process_search_dates() {
        $conditions_it = (array)json_decode(stripslashes($_POST['data']));
        $dep_date = explode('-', $_POST['trp_depDate']);
        if(!empty($_POST['trp_depDateFrom'])) $trp_depDateFrom = date('Ymd', strtotime($_POST['trp_depDateFrom']));
        if(!empty($_POST['trp_depDateTo'])) $trp_depDateTo = date('Ymd', strtotime($_POST['trp_depDateTo']));
        $conditions_it['trp_depDate'] = $trp_depDateFrom.':'.$trp_depDateTo;
        $conditions_it['trp_retDate'] = $trp_depDateTo;
        
        $services_names = array();
        foreach(json_decode(stripslashes($_POST['services_names'])) as $key=>$sn) {
            $services_names[$key] = $sn;
        }
    
        $depDesc_popup = array();
        $inne_terminy = get_data('offers', $conditions_it);   
        if($inne_terminy->count>0) {
        foreach($inne_terminy->ofr as $dt) {
                $depDesc_popup[] = $dt->trp->{'@attributes'}->depName;
            }
        }
        
        $par_adt = $_POST['par_adt'];
        $par_chd = $_POST['par_chd'];
        
        if($inne_terminy->count>0) {?>
            <table class="other-travel-periods">
		<thead>
                    <tr>
			<th>Termin pobytu</th>
                        <?php if($inne_terminy->ofr[0]->{'@attributes'}->type=='F') {?>                                  
                            <th>Wylot z</th>
                        <?php }?>
			<th>Wyżywienie</th>
			<th>Cena (<?=$par_adt+$par_chd;?> os.)</th>
			<th></th>
                    </tr>
		</thead>
		<tbody>
                <?php foreach($inne_terminy->ofr as $it) {?>
                    <tr>
			<td><?=date('d.m.Y', strtotime($it->trp->{'@attributes'}->depDate));?> - <?=date('d.m.Y', strtotime($it->trp->{'@attributes'}->rDepDate));?> (<?=$it->trp->{'@attributes'}->duration;?> dni)</td>
                        <?php if($inne_terminy->ofr[0]->{'@attributes'}->type=='F') {?>    
                        <td><?=$it->trp->{'@attributes'}->depDesc;?></td>
                        <?php }?>
			<td><?=$services_names[$it->obj->{'@attributes'}->xServiceId];?></td>
			<td><span class="price"><?=$it->{'@attributes'}->price;?> <?=$it->{'@attributes'}->curr;?></span></td>
                        <td><a href="<?=get_permalink(get_page_by_path('wakacje'));?>?id=<?=$it->{'@attributes'}->id;?>&par_adt=<?=$par_adt;?>&par_chd=<?=$par_chd;?>&par_chdAge=<?=$par_chdAge;?>">szczegóły >></a></td>
                    </tr>
                <?php }?>
		</tbody>
            </table>
        <?php }
        else {?>
            <p>Brak wyników spełniających wybrane kryteria</p>
        <?php }
        wp_die();
    }
    
    function my_update_attachment($f,$pid,$t='',$c='') {
  wp_update_attachment_metadata( $pid, $f );
  if( !empty( $_FILES[$f]['name'] )) { //New upload
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
 include( ABSPATH . 'wp-admin/includes/image.php' );
    // $override['action'] = 'editpost';
    $override['test_form'] = false;
    $file = wp_handle_upload( $_FILES[$f], $override );
 
    if ( isset( $file['error'] )) {
      return new WP_Error( 'upload_error', $file['error'] );
    }
 
    $file_type = wp_check_filetype($_FILES[$f]['name'], array(
      'jpg|jpeg' => 'image/jpeg',
      'gif' => 'image/gif',
      'png' => 'image/png',
    ));
    if ($file_type['type']) {
      $name_parts = pathinfo( $file['file'] );
      $name = $file['filename'];
      $type = $file['type'];
      $title = $t ? $t : $name;
      $content = $c;
 
      $attachment = array(
        'post_title' => $title,
        'post_type' => 'attachment',
        'post_content' => $content,
        'post_parent' => $pid,
        'post_mime_type' => $type,
        'guid' => $file['url'],
      );
 
      foreach( get_intermediate_image_sizes() as $s ) {
        $sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => true );
        $sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
        $sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
        $sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
      }
 
      $sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );
 
      foreach( $sizes as $size => $size_data ) {
        $resized = image_make_intermediate_size( $file['file'], $size_data['width'], $size_data['height'], $size_data['crop'] );
        if ( $resized )
          $metadata['sizes'][$size] = $resized;
      }
 
      $attach_id = wp_insert_attachment( $attachment, $file['file'] /*, $pid - for post_thumbnails*/);
 
      if ( !is_wp_error( $attach_id )) {
        $attach_meta = wp_generate_attachment_metadata( $attach_id, $file['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_meta );
      }
   
   return array(
  'pid' =>$pid,
  'url' =>$file['url'],
  'file'=>$file,
  'attach_id'=>$attach_id
   );
    }
  }
}

add_image_size('medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );

require_once 'reservations.php';

add_action('wp_ajax_load_images', 'process_load_images');
add_action('wp_ajax_nopriv_load_images', 'process_load_images');

function process_load_images() {
    $htlCode = $_POST['htlCode'];
    $htlXCode = $_POST['htlXCode'];
    $tourOp = $_POST['tourOp'];
    global $wpdb;
        
    require_once(ABSPATH . 'wp-admin/includes/media.php');
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    require_once(ABSPATH . 'wp-admin/includes/image.php');
        
    $login = esc_attr( get_option('login'));
    $password = esc_attr( get_option('password'));	

    $link = array('http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S&htlCat=LAST',
                'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W&htlCat=LAST',  
                'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=S',
                'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&season=W',
                'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp.'&fromDate='.date('md'),
                'http://data2.merlinx.pl/index.php?login='.$login.'&password='.$password.'&htlCode='.$htlCode.'&tourOp='.$tourOp);
   
    $queried_post = get_page_by_path($htlXCode,OBJECT,'hotels');
    $post_id = (int) $queried_post->ID;

    $images_list = array();
    for($x=1;$x<=30;$x++) {
        $image = get_field('zdjecie'.$x, $queried_post->ID);
        if(!empty($image)) $images_list[] = $image['sizes']['medium'];
    }
                    
    if(empty($images_list)) {
                  
        foreach($link as $lnk) {
            $xml_response = simplexml_load_file($lnk);
            $array = json_decode(json_encode((array) $xml_response));
            if($array->status=='ok') {
                $hotel = $array->hotelData->hotel;
                            
                if(is_array($array->hotelData->images->pictures->picture)) $images_list = $array->hotelData->images->pictures->picture;
                elseif(!empty($array->hotelData->images->pictures->picture)) $images_list[0] = $array->hotelData->images->pictures->picture;
                $i=0;
                foreach($images_list as $il) {                      
                    if($i<=30) {
                        $attachment = media_sideload_image($il, $queried_post->ID, '', 'id');
                        update_field('zdjecie'.$i, $attachment, $queried_post->ID);    
                    }
                    $wpdb->insert( 
                            'wp_images_cache', 
                            array( 
                                'code' => $htlCode, 
                                'xCode' => $htlXCode,
                                'tourOp' => $tourOp,
                                'image_number' => $i,
                                'image_link' => $il
                            ), 
                            array( 
                                '%s', 
                                '%s',
                                '%s',
                                '%d',
                                '%s'
                            ) 
                    );
                    $i++;
                }
                break;
            }
        }
    }
    else {echo json_encode('0');exit;}
                    
    echo json_encode($images_list);
    exit;
}

function my_login_redirect( $redirect_to, $request, $user ) {
    if (isset($user->roles) && is_array($user->roles)) {
        //check for subscribers
        if (in_array('author', $user->roles)) {
            // redirect them to another URL, in this case, the homepage 
            $redirect_to =  home_url().'/wp-admin/edit.php?post_type=reservations';
        }
    }

    return $redirect_to;
}

add_filter( 'login_redirect', 'my_login_redirect', 10, 3 );

function my_save_region( $post_id ) {

	if ( wp_is_post_revision( $post_id ) ) {
		return;
        }
        
        global $wpdb;
        $type = get_post_type($post_id);
        if($type == 'regions') {
            
            $wyszukiwanie = (int)get_field('field_5acbde2e0bac3', $post_id);
            $kod_mds = get_field('field_5a99ed683cb05', $post_id);
            $active = (int)get_field('field_5aa4658340313', $post_id);

            $wpdb->update('wp_regions', array('home' => $wyszukiwanie, 'active' => $active), array('kod_mds' => $kod_mds), 
                                array('%d', '%d'), array('%s') );
    
        }
}
add_action( 'save_post', 'my_save_region' );

function my_save_country($term_id, $tt_id, $taxonomy) {
   $term = get_term($term_id, $taxonomy);
   if($term->taxonomy == 'regions_countries') {
        global $wpdb;
       
        $wyszukiwanie = (int)get_field('field_5acbde2e0bac3', 'regions_countries_'.$term_id);
        $kod_mds = get_field('field_5a99ed683cb05', 'regions_countries_'.$term_id);
        $active = (int)get_field('field_5aa4658340313', 'regions_countries_'.$term_id);
        
        $wpdb->update('wp_regions', array('home' => $wyszukiwanie, 'active' => $active), array('kod_mds' => $kod_mds),
                array( '%d', '%d' ), array( '%s') );
   }
}
add_action( 'edit_term', 'my_save_country', 10, 3 );


add_action('parse_request', 'my_miasta_url_handler');

function my_miasta_url_handler() {
   if(strpos($_SERVER["REQUEST_URI"], '/miasta') !== false) {
       $tourOp = array();                            
        $terms = get_terms('conditions_tourop', array('hide_empty' => false));
        foreach($terms as $dt) {
            if((bool)get_field('active', 'conditions_tourop_'.$dt->term_id)===true) {
                $tourOp[] = strtoupper($dt->slug);
            }
        }

        $cities = array();
        
        global $wpdb;
        $qry = "SELECT `id`, `kod_mds` FROM `wp_regions` WHERE active = 1";
        $results = $wpdb->get_results( $qry );
        foreach($results as $res) {
            $cities[$res->id] = array();
            $offers = get_data('offers', array('trp_destination'=>$res->kod_mds, 'calc_found' => 1000, 'limit_count' => 1000, 'ofr_tourOp' => join(',', $tourOp)));
            if(!empty($offers->ofr)) {
                foreach($offers->ofr as $ofr) {
                    $cities[$res->id][] = $ofr->obj->{'@attributes'}->city;
                }
            }
            
            $cities[$res->id] = array_unique($cities[$res->id]);     
        }
        
        $x = 0;
        foreach($cities as $id=>$country) {
            $qry = "SELECT `kod_mds` FROM `wp_regions` WHERE id = ".$id;
            $kod_mds = $wpdb->get_var($qry);
            foreach($country as $city) {
                $x += $wpdb->insert( 
                    'wp_cities', 
                    array( 
                        'name' => $city, 
                        'parent_id' => $id,
                        'parent_kod_mds' => $kod_mds,
                        'active' => 1
                    ), 
                    array( 
                        '%s', 
                        '%d',
                        '%s',
                        '%d'
                    ) 
                );
            }
        }
        echo $x;
        exit;
    }
}


add_action('wp_ajax_get_region', 'process_get_region');
add_action('wp_ajax_nopriv_get_region', 'process_get_region');

function process_get_region() {
    global $wpdb;
    $qry = "SELECT `parent_kod_mds` FROM `wp_cities` WHERE id = '".$_POST['data_id']."' AND active=1";
    $region_id = $wpdb->get_var($qry);
    
    $qry2 = "SELECT `name` FROM `wp_regions` WHERE kod_mds = '".$region_id."' AND active=1";
    $region_name = $wpdb->get_var($qry2);
    echo $region_name;exit;
}

add_action('wp_ajax_get_country', 'process_get_country');
add_action('wp_ajax_nopriv_get_country', 'process_get_country');

function process_get_country() {
    global $wpdb;
    if($_POST['data_type']=='city') {
        $qry = "SELECT `parent_kod_mds` FROM `wp_cities` WHERE id = '".$_POST['data_id']."' AND active=1";
        $region_id = $wpdb->get_var($qry);
    }
    else $region_id = $_POST['data_id'];
    
    $qry2 = "SELECT `parent` FROM `wp_regions` WHERE kod_mds = '".$region_id."' AND active=1";
    $country_id = $wpdb->get_var($qry2);
    
    $qry3 = "SELECT `kod_mds` FROM `wp_regions` WHERE id = '".$country_id."' AND active=1";
    $country_kod = $wpdb->get_var($qry3);
    echo $country_kod;exit;
}

add_action('wp_ajax_get_cities', 'process_get_cities');
add_action('wp_ajax_nopriv_get_cities', 'process_get_cities');

function process_get_cities() {
    global $wpdb;
    $list = explode(',', $_POST['list']);
    $list = array_unique($list);
    
    $regions_checked = explode(',', $_POST['regions_checked']);
    $regions_checked = array_unique($regions_checked);
    
    $cities_checked = explode(',', $_POST['cities_checked']);
    $cities_checked = array_unique($cities_checked);
    
    foreach($list as $ll) {
        $qry = "SELECT `id`, `name` FROM `wp_regions` WHERE kod_mds = '".$ll."' AND active=1";
        $country = $wpdb->get_row($qry);
    
        $qry2 = "SELECT `id`, `name`, `kod_mds` FROM `wp_regions` WHERE parent<>0 AND parent = '".$country->id."' AND active=1";
        $regions = $wpdb->get_results($qry2);
        if(!empty($regions)) {
            echo '<li class="area"> '.$country->name.'<span class="txt">regiony</span>';
            foreach($regions as $reg) {
                if(!empty($reg->name)) {
                    $reg_checked = (in_array($reg->kod_mds, $regions_checked)) ? ' checked' : '';
                    echo '<ul class="ul-regions"><li><label><input class="region" type="checkbox" value="'.$reg->kod_mds.'" data-region-name="'.$reg->name.'" data-region-id="'.$reg->kod_mds.'"'.$reg_checked.'> '.$reg->name.'</label> ';

                    $qry3 = "SELECT `id`, `name` FROM `wp_cities` WHERE name<>'".$reg->name."' AND parent_id<>0 AND parent_kod_mds = '".$reg->kod_mds."' AND active=1";

                    $cities = $wpdb->get_results($qry3);
                    if(!empty($cities)) {
                        ?>
                        <span class="txt">miasta</span>
                        <ul class="ul-cities">
                        <?php
                        foreach($cities as $city) {
                            if(!empty($city->name)) {
                                $ct_checked = (in_array($city->name, $cities_checked)) ? ' checked' : '';
                                echo '<li><label><input class="city" type="checkbox" value="'.$city->id.'" data-city-name="'.$city->name.'" data-city-id="'.$city->id.'"'.$ct_checked.'> '.$city->name.'</label>';
                            }
                        }
                        ?>
                        </ul>
                        <?php
                    }   
                    echo '</li></ul>';
                }
            }
            echo '</li>';
        }   
    }    
    echo "<script>
        $('input.region').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                increaseArea: '20%',
        });
        $('input.city').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                increaseArea: '20%',
        });
        $('.country, .region, .city').on('ifUnchecked', function() {
            $('.del-item[data-id=\"'+$(this).val()+'\"]').parent().remove();
            if($(this).hasClass('country')) {
                name = $(this).attr('data-country-name');
            }
            else if($(this).hasClass('region')) {
                name = $(this).attr('data-region-name');
            }
            else if($(this).hasClass('city')) {
                name = $(this).attr('data-city-name');
            }
            $('.del-item[data-name=\"'+name+'\"]').parent().remove();
            var all_checked = $('#all_checked').val().split(',');
            all_checked = all_checked.filter(function(e) { return e !== name })
            $('#all_checked').val(all_checked.join(','));
            if($('.actual-choice-list').html()=='') $('.actual-choice-list').hide();
      });
      
    jQuery(document).ready(function() {
                
                var all_checked = jQuery('#all_checked').val().split(',');
                for(var i in all_checked) {
                    if(all_checked[i]!='') {
                        $('input.region[data-region-name=\"'+all_checked[i]+'\"]').iCheck('check'); 
                        $('input.city[data-city-name=\"'+all_checked[i]+'\"]').iCheck('check'); 
                        }   
                }
                
            var checked_tab_region = [];
                $.each($('.region'), function() {
                    if($(this).is(':checked')) {
                        checked_tab_region.push($(this).val());
                    } 
                });    

                var checked_tab_city = [];
                $.each($('.city'), function() {
                    if($(this).is(':checked')) {
                        checked_tab_city.push($(this).val());
                    } 
                });   

                var checked_tab_region = checked_tab_region.filter((v, i, a) => a.indexOf(v) === i); 
                for(var i in checked_tab_region) {
                    var country_name = $('input.region[value=\"'+checked_tab_region[i]+'\"]').attr('data-region-name');
                    var data_id = $('.actual-choice-list').find('span.del-item[data-id=\"'+checked_tab_region[i]+'\"]').attr('data-id');
                    if(country_name!='' && data_id==undefined)
                        $('.actual-choice-list').append('<li><span class=\"del-item\" data-type=\"region\" data-name=\"'+country_name+'\" data-id=\"'+checked_tab_region[i]+'\">'+country_name+' <span class=\"icon-delete\"></span></span></li>').show();               
                    if(all_checked.length>8) $('.actual-choice-list').append('<li class=\"kropki\"><span class=\"del-item\"><b>...</b></span></li>');

                }

                var checked_tab_city = checked_tab_city.filter((v, i, a) => a.indexOf(v) === i); 
                for(var i in checked_tab_city) {
                    var country_name = $('input.city[data-city-id=\"'+checked_tab_city[i]+'\"]').attr('data-city-name');
                    var data_id = $('.actual-choice-list').find('span.del-item[data-name=\"'+country_name+'\"]').attr('data-id');
                    if(country_name!='' && data_id==undefined)
                        $('.actual-choice-list').append('<li><span class=\"del-item\" data-type=\"city\" data-name=\"'+country_name+'\" data-id=\"'+checked_tab_city[i]+'\">'+country_name+' <span class=\"icon-delete\"></span></span></li>').show();               
                    if(all_checked.length>8) $('.actual-choice-list').append('<li class=\"kropki\"><span class=\"del-item\"><b>...</b></span></li>');

                }
            });
        </script>";
    exit;
}

add_action('wp_ajax_search_in_all', 'process_search_in_all');
add_action('wp_ajax_nopriv_search_in_all', 'process_search_in_all');

function process_search_in_all() {
    global $wpdb;
    $search = $_POST['val'];
    
    $kraje = $regiony = $miasta = "";
    
    $qry = "SELECT `kod_mds`, `name` FROM `wp_regions` WHERE name LIKE '%".$search."%' AND active = 1 AND parent = 0 GROUP BY `name`";
    $countries = $wpdb->get_results($qry);
        
    if(!empty($countries)) {
        $kraje .= "<ul><legend>Kraje</legend>";
        foreach($countries as $count) {
            $kraje .= "<li class='search_item' data-type='country' data-name='".$count->name."' data-id='".$count->kod_mds."'>".$count->name."</li>";
        }
        $kraje .= "</ul>";
    }
    
    $qry = "SELECT `kod_mds`, `name` FROM `wp_regions` WHERE name LIKE '%".$search."%' AND active=1 AND parent<>0 GROUP BY `name`";
    $regions = $wpdb->get_results($qry);
    
    if(!empty($regions)) {
        $regiony .= "<ul><legend>Regiony</legend>";
        foreach($regions as $count) {
            $regiony .= "<li class='search_item' data-type='region' data-name='".$count->name."' data-id='".$count->kod_mds."'>".$count->name."</a></li>";
        }
        $regiony .= "</ul>";
    }
    
    $qry = "SELECT `id`, `name` FROM `wp_cities` WHERE name LIKE '%".$search."%' AND active=1 AND parent_id<>0 GROUP BY `name`";
    $cities = $wpdb->get_results($qry);
    
    if(!empty($cities)) {
        $miasta .= "<ul><legend>Miasta</legend>";
        foreach($cities as $count) {
            $miasta .= "<li class='search_item' data-type='city' data-name='".$count->name."' data-id='".$count->id."'>".$count->name."</a></li>";
        }
        $miasta .= "</ul>";
    }
    
    echo $kraje.$regiony.$miasta;
    exit;
}

add_action('wp_ajax_search_hotel', 'process_search_hotel');
add_action('wp_ajax_nopriv_search_hotel', 'process_search_hotel');

function process_search_hotel() {
    global $wpdb;
    $search = $_POST['val'];
    
    $hotele = "";
    
    $args = array(
	'posts_per_page'   => 50,
	'post_type'        => 'hotels',
        's' => $search
    );
    $hotels = get_posts( $args );
    
    if(!empty($hotels)) {
        $hotele .= "<legend>Hotele</legend>";
        foreach($hotels as $hotel) {
            $hotele .= "<li class='search_item' data-type='hotel' data-name='".$hotel->post_title."'>".$hotel->post_title."</li>";
        }
    }
    
    echo $hotele;
    exit;
}       
