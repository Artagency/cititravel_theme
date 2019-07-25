<?php

add_action('init', 'reservations_register');
 
function reservations_register() {
 
	$labels = array(
		'name' => __('Rezerwacje', 'cititravel_theme'),
		'singular_name' => __('Rezerwacja', 'cititravel_theme'),
		'add_new' => __('Dodaj nową', 'cititravel_theme'),
		'add_new_item' => __('Dodaj nową rezerwację', 'cititravel_theme'),
		'edit_item' => __('Edytuj rezerwację', 'cititravel_theme'),
		'new_item' => __('Nowa rezerwacja', 'cititravel_theme'),
		'view_item' => __('Zobacz rezerwację', 'cititravel_theme'),
		'search_items' => __('Szukaj rezerwacji', 'cititravel_theme'),
		'not_found' =>  __('Nie znaleziono rezerwacji', 'cititravel_theme'),
		'not_found_in_tracititravel_theme' => __('Nie znaleziono rezerwacji w koszu', 'cititravel_theme'),
		'parent_item_colon' => ''
	);
     
        $capabilities = array(
            'publish_posts' => 'publish_reservations',
            'edit_posts' => 'edit_reservations',
            'edit_others_posts' => 'edit_others_reservations',
            'delete_posts' => 'delete_reservations',
            'delete_others_posts' => 'delete_others_reservations',
            'read_private_posts' => 'read_private_reservations',
            'edit_post' => 'edit_reservation',
            'edit_private_posts' => 'edit_private_reservations',
            'delete_post' => 'delete_reservation',
            'read_post' => 'read_reservation'
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
		'supports' => array(),
                'capability_type' => 'reservation',
                'capabilities' => $capabilities,
                'map_meta_cap' => false
	  ); 
 
	register_post_type( 'reservations' , $args );
}
        
function add_theme_caps() {
    $admins = get_role( 'administrator' );
    $admins->add_cap( 'edit_reservation' ); 
    $admins->add_cap( 'edit_reservations' ); 
    $admins->add_cap( 'edit_private_reservations' ); 
    $admins->add_cap( 'edit_others_reservations' ); 
    $admins->add_cap( 'publish_reservations' ); 
    $admins->add_cap( 'read_reservation' ); 
    $admins->add_cap( 'read_private_reservations' ); 
    $admins->add_cap( 'delete_reservation' ); 
    $admins->add_cap( 'delete_reservations' ); 
    $admins->add_cap( 'delete_others_reservations' ); 
            
    $editors = get_role( 'editor' );
    $editors->add_cap( 'edit_reservation' ); 
    $editors->add_cap( 'edit_reservations' ); 
    $editors->add_cap( 'edit_private_reservations' ); 
    $editors->add_cap( 'edit_others_reservations' ); 
    $editors->add_cap( 'publish_reservations' ); 
    $editors->add_cap( 'read_reservation' ); 
    $editors->add_cap( 'read_private_reservations' ); 
    $editors->add_cap( 'delete_reservation' ); 
    $editors->add_cap( 'delete_reservations' ); 
    $editors->add_cap( 'delete_others_reservations' ); 
              
    $authors = get_role( 'author' );
    $authors->add_cap( 'edit_reservation' ); 
    $authors->add_cap( 'edit_reservations' ); 
    $authors->add_cap( 'edit_others_reservations' );
    $authors->add_cap( 'read_reservation' ); 
    $authors->add_cap( 'read_private_reservations' ); 
}
add_action( 'admin_init', 'add_theme_caps');

add_action( 'admin_init', 'process_post' );
function process_post() {
    if($_GET['action']=='edit') {
        $post_id = (int)$_GET['post'];
        $post_type = get_post_type( $post_id );
        if($post_type == 'reservations') {
            $actual_field = get_field('field_5ca5c99965a43', $post_id);
            if(empty($actual_field)) {
                $this_user = wp_get_current_user();
                if(in_array('author', $this_user->roles)) {
                    update_field('field_5ca5c99965a43', $this_user->get('ID'), $post_id);
                }
            }
        }
    }
}

// Add the custom columns to the book post type:
add_filter( 'manage_reservations_posts_columns', 'set_custom_edit_reservations_columns' );
function set_custom_edit_reservations_columns($columns) {
    unset( $columns['author'] );
    $columns['konsultant'] = __( 'Konsultant', 'cititravel_theme' );
    $columns['typ_rezerwacji'] = __( 'Typ rezerwacji', 'cititravel_theme' );
    $columns['numer_rezerwacji'] = __( 'Numer rezerwacji MDS', 'cititravel_theme' );
    $columns['platnosc'] = __( 'Płatność', 'cititravel_theme' );
    $columns['rodzaj_platnosci'] = __( 'Rodzaj płatności', 'cititravel_theme' );
    $columns['status_platnosci'] = __( 'Status płatności', 'cititravel_theme' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_reservations_posts_custom_column' , 'custom_reservations_column', 10, 2 );
function custom_reservations_column( $column, $post_id ) {
    switch ( $column ) {
        case 'konsultant' :
            $user = get_user_by('id', get_field( 'field_5ca5c99965a43', $post_id));
            if(!empty($user) && in_array('author', $user->roles)) {
                echo $user->get('user_login').' ('.$user->get('display_name').')';
            }
            else echo '-';
            break;
        case 'numer_rezerwacji' :
            $numer = get_field('field_5c813ef33367f', $post_id);
            echo (!empty($numer))?$numer:'-';
            break;
        case 'typ_rezerwacji' :
            echo (get_field('field_5b1026dcae59a', $post_id)==1)?'Rezerwacja MDS':'Zapytanie';
            break;
        case 'platnosc' :
            echo (get_field('field_5b1026f4ae59b', $post_id)==0)?'Całość':'Zaliczka';
            break;
        case 'rodzaj_platnosci' :
            echo (get_field('field_5b1026fdae59c', $post_id)==0)?'dotpay':'przelew';
            break;
        case 'status_platnosci' :
            $status = get_field('field_5b102715ae59d', $post_id);
            if($status=='new') echo 'Nowa';
            elseif($status=='executed') echo 'Wykonana';
            elseif($status=='rejected') echo 'Odrzucona';
            elseif($status=='canceled') echo 'Anulowana';
            elseif($status=='reclamation') echo 'Reklamacja';
            break;
    }
}