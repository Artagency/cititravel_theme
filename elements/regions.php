<?php

add_action('init', 'regions_register');
 
function regions_register() {
 
	$labels = array(
		'name' => __('Regiony', 'cititravel_theme'),
		'singular_name' => __('Regiony', 'cititravel_theme'),
		'add_new' => __('Dodaj nowy', 'cititravel_theme'),
		'add_new_item' => __('Dodaj nowy region', 'cititravel_theme'),
		'edit_item' => __('Edytuj region', 'cititravel_theme'),
		'new_item' => __('Nowy region', 'cititravel_theme'),
		'view_item' => __('Zobacz region', 'cititravel_theme'),
		'search_items' => __('Szukaj regionów', 'cititravel_theme'),
		'not_found' =>  __('Nie znaleziono regionów', 'cititravel_theme'),
		'not_found_in_tracititravel_theme' => __('Nie znaleziono regionów w koszu', 'cititravel_theme'),
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
		'supports' => array('title','editor', 'thumbnail')
	  ); 
 
	register_post_type( 'regions' , $args );
}

function regions_countries(){
	register_taxonomy(__( "regions_countries", 'cititravel_theme' ), 
	
	array(__( "regions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Kraje", 'cititravel_theme' ), 
		"singular_label" => __( "Kraj", 'cititravel_theme' )
	)); 
} 

add_action('init', 'regions_countries', 0 );