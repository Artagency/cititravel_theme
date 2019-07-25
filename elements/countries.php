<?php

add_action('init', 'countries_register');
 
function countries_register() {
 
	$labels = array(
		'name' => __('Kraje', 'cititravel_theme'),
		'singular_name' => __('Kraje', 'cititravel_theme'),
		'add_new' => __('Dodaj nowy', 'cititravel_theme'),
		'add_new_item' => __('Dodaj nowy kraj', 'cititravel_theme'),
		'edit_item' => __('Edytuj kraj', 'cititravel_theme'),
		'new_item' => __('Nowy kraj', 'cititravel_theme'),
		'view_item' => __('Zobacz kraj', 'cititravel_theme'),
		'search_items' => __('Szukaj krajów', 'cititravel_theme'),
		'not_found' =>  __('Nie znaleziono krajów', 'cititravel_theme'),
		'not_found_in_tracititravel_theme' => __('Nie znaleziono krajów w koszu', 'cititravel_theme'),
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
		'supports' => array('title','thumbnail','page-attributes'),
                'show_in_menu' => 'edit.php?post_type=regions',
	  ); 
 
	register_post_type( 'countries' , $args );
}