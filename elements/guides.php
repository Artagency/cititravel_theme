<?php

add_action('init', 'guides_register');
 
function guides_register() {
 
	$labels = array(
		'name' => __('Przewodniki', 'cititravel_theme'),
		'singular_name' => __('Przewodniki', 'cititravel_theme'),
		'add_new' => __('Dodaj nowy', 'cititravel_theme'),
		'add_new_item' => __('Dodaj nowy przewodnik', 'cititravel_theme'),
		'edit_item' => __('Edytuj przewodnik', 'cititravel_theme'),
		'new_item' => __('Nowy przewodnik', 'cititravel_theme'),
		'view_item' => __('Zobacz przewodnik', 'cititravel_theme'),
		'search_items' => __('Szukaj przewodników', 'cititravel_theme'),
		'not_found' =>  __('Nie znaleziono przewodników', 'cititravel_theme'),
		'not_found_in_tracititravel_theme' => __('Nie znaleziono przewodników w koszu', 'cititravel_theme'),
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
                'rewrite' => array(
                    'slug' => 'przewodnik', 
                    'hierarchical' => true
		)
	  ); 
 
	register_post_type( 'guides' , $args );
}