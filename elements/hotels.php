<?php

add_action('init', 'hotels_register');
 
function hotels_register() {
 
	$labels = array(
		'name' => __('Hotele', 'cititravel_theme'),
		'singular_name' => __('Hotele', 'cititravel_theme'),
		'add_new' => __('Dodaj nową', 'cititravel_theme'),
		'add_new_item' => __('Dodaj nowy hotel', 'cititravel_theme'),
		'edit_item' => __('Edytuj hotel', 'cititravel_theme'),
		'new_item' => __('Nowy hotel', 'cititravel_theme'),
		'view_item' => __('Zobacz hotel', 'cititravel_theme'),
		'search_items' => __('Szukaj hoteli', 'cititravel_theme'),
		'not_found' =>  __('Nie znaleziono hoteli', 'cititravel_theme'),
		'not_found_in_tracititravel_theme' => __('Nie znaleziono hoteli w koszu', 'cititravel_theme'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'cititravel_themeow_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'menu_icon' => 'dashicons-schedule',
		'supports' => array('title','editor', 'thumbnail'),
                "rewrite" => array(
				'slug' => 'hotele', 
				'hierarchical' => true
				)
	  ); 
 
	register_post_type( 'hotels' , $args );
}