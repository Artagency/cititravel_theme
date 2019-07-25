<?php
add_action('init', 'contact_newsletter_register');
 
function contact_newsletter_register() {
 
	$labels = array(
		'name' => __('Formularz newslettera', 'equitone'),
		'singular_name' => __('Formularz newslettera', 'equitone'),
		'add_new' => __('Dodaj nowe', 'equitone'),
		'add_new_item' => __('Dodaj nowe zapytanie', 'equitone'),
		'edit_item' => __('Edytuj formularz', 'equitone'),
		'new_item' => __('Nowe formularz', 'equitone'),
		'view_item' => __('Zobacz formularz', 'equitone'),
		'search_items' => __('Szukaj zapytań', 'equitone'),
		'not_found' =>  __('Nie znaleziono zapytań', 'equitone'),
		'not_found_in_traequitone' => __('Nie znaleziono zapytań w koszu', 'equitone'),
		'parent_item_colon' => '',
	);
        
        $capabilities = array(
            'publish_posts' => 'publish_contact_newsletter',
            'edit_posts' => 'edit_contact_newsletter',
            'edit_others_posts' => 'edit_others_contact_newsletter',
            'delete_posts' => 'delete_contact_newsletter',
            'delete_others_posts' => 'delete_others_contact_newsletter',
            'read_private_posts' => 'read_private_contact_newsletter',
            'edit_post' => 'edit_contact_newsletter',
            'edit_private_posts' => 'edit_private_contact_newsletter',
            'delete_post' => 'delete_contact_newsletter',
            'read_post' => 'read_contact_newsletter'
        );
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'hierarchical' => false,
		'menu_position' => null,
		'show_in_menu' => 'edit.php?post_type=contacts',
		'menu_icon' => 'dashicons-welcome-widgets-menus',
		'supports' => array('title','thumbnail'),
                'capability_type' => 'contact_newsletter',
                'capabilities' => $capabilities
	  ); 
 
	register_post_type( 'contact_newsletter' , $args );
}

	add_action( 'wp_ajax_save_contact_newsletter', 'save_contact_newsletter' );
	add_action( 'wp_ajax_nopriv_save_contact_newsletter', 'save_contact_newsletter' );
	
	function save_contact_newsletter() {
		$values = array();
		parse_str($_POST['data'], $values);

		$imie_i_nazwisko = $values['your-name'];
		$email = $values['your-email'];
		$telefon = $values['your-phone'];
		$kierunek_podrozy = $values['your-direction'];
		$termin = $values['your-term'];
		$cena = $values['your-price'];
		$opcje = join(', ', $values['checkbox-179']);            
		
		if(!empty($imie_i_nazwisko) && !empty($email) && !empty($termin)) {
		
			$my_post = array(
			  'post_title'    => wp_strip_all_tags( $imie_i_nazwisko ),
			  'post_content'  => '',
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_type' => 'contact_newsletter'
			);
			 
			$id = wp_insert_post( $my_post );
			
			update_field('imie_i_nazwisko', $imie_i_nazwisko, $id);
                        update_field('telefon', $telefon, $id); 
			update_field('email', $email, $id);
			update_field('kierunek_podrozy', $kierunek_podrozy, $id);
			update_field('termin', $termin, $id);
			update_field('cena', $cena, $id);
			update_field('opcje', $opcje, $id);
			
			if($id>0) {
                            echo send_sms_to_group('request');
                            if(!empty($telefon)) send_sms_to_number($telefon, 'client');
                            exit;
                        }
		}
		else echo 0;
		wp_die();
	}
        
add_action( 'admin_init', 'process_post_contact_newsletter' );
function process_post_contact_newsletter() {
    if($_GET['action']=='edit') {
        $post_id = (int)$_GET['post'];
        $post_type = get_post_type( $post_id );
        if($post_type == 'contact_newsletter') {
            $actual_field = get_field('field_5ce44eb936ad1', $post_id);
            if(empty($actual_field)) {
                $this_user = wp_get_current_user();
                if(in_array('author', $this_user->roles)) {
                    update_field('field_5ce44eb936ad1', $this_user->get('ID'), $post_id);
                }
            }
        }
    }
}    

function add_contact_newsletter_caps() {
    $admins = get_role( 'administrator' );
    $admins->add_cap( 'edit_contact_newsletter' ); 
    $admins->add_cap( 'edit_contact_newsletter' ); 
    $admins->add_cap( 'edit_private_contact_newsletter' ); 
    $admins->add_cap( 'edit_others_contact_newsletter' ); 
    $admins->add_cap( 'publish_contact_newsletter' ); 
    $admins->add_cap( 'read_contact_newsletter' ); 
    $admins->add_cap( 'read_private_contact_newsletter' ); 
    $admins->add_cap( 'delete_contact_newsletter' ); 
    $admins->add_cap( 'delete_contact_newsletter' ); 
    $admins->add_cap( 'delete_others_contact_newsletter' ); 
            
    $editors = get_role( 'editor' );
    $editors->add_cap( 'edit_contact_newsletter' ); 
    $editors->add_cap( 'edit_contact_newsletter' ); 
    $editors->add_cap( 'edit_private_contact_newsletter' ); 
    $editors->add_cap( 'edit_others_contact_newsletter' ); 
    $editors->add_cap( 'publish_contact_newsletter' ); 
    $editors->add_cap( 'read_contact_newsletter' ); 
    $editors->add_cap( 'read_private_contact_newsletter' ); 
    $editors->add_cap( 'delete_contact_newsletter' ); 
    $editors->add_cap( 'delete_contact_newsletter' ); 
    $editors->add_cap( 'delete_others_contact_newsletter' ); 
              
    $authors = get_role( 'author' );
    $authors->add_cap( 'edit_contact_newsletter' ); 
    $authors->add_cap( 'edit_contact_newsletter' ); 
    $authors->add_cap( 'edit_others_contact_newsletter' );
    $authors->add_cap( 'read_contact_newsletter' ); 
    $authors->add_cap( 'read_private_contact_newsletter' ); 
}
add_action( 'admin_init', 'add_contact_newsletter_caps');


// Add the custom columns to the book post type:
add_filter( 'manage_contact_newsletter_posts_columns', 'set_custom_edit_contact_newsletter_columns' );
function set_custom_edit_contact_newsletter_columns($columns) {
    $columns['konsultant'] = __( 'Konsultant', 'cititravel_theme' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_contact_newsletter_posts_custom_column' , 'custom_contact_newsletter_column', 10, 2 );
function custom_contact_newsletter_column( $column, $post_id ) {
    switch ( $column ) {
        case 'konsultant' :
            $user = get_user_by('id', get_field( 'field_5ce44eb936ad1', $post_id));
            if(!empty($user) && in_array('author', $user->roles)) {
                echo $user->get('user_login').' ('.$user->get('display_name').')';
            }
            else echo '-';
            break;
    }
}