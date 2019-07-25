<?php
add_action('init', 'contact_register');
 
function contact_register() {
 
	$labels = array(
		'name' => __('Formularz kontaktowy', 'equitone'),
		'singular_name' => __('Formularz kontaktowy', 'equitone'),
		'add_new' => __('Dodaj nowe', 'equitone'),
		'add_new_item' => __('Dodaj nowe zapytanie', 'equitone'),
		'edit_item' => __('Edytuj formularz', 'equitone'),
		'new_item' => __('Nowe formularz', 'equitone'),
		'view_item' => __('Zobacz formularz', 'equitone'),
		'search_items' => __('Szukaj zapytań', 'equitone'),
		'not_found' =>  __('Nie znaleziono zapytań', 'equitone'),
		'not_found_in_traequitone' => __('Nie znaleziono zapytań w koszu', 'equitone'),
		'parent_item_colon' => ''
	);
        
        $capabilities = array(
            'publish_posts' => 'publish_contacts',
            'edit_posts' => 'edit_contacts',
            'edit_others_posts' => 'edit_others_contacts',
            'delete_posts' => 'delete_contacts',
            'delete_others_posts' => 'delete_others_contacts',
            'read_private_posts' => 'read_private_contacts',
            'edit_post' => 'edit_contact',
            'edit_private_posts' => 'edit_private_contacts',
            'delete_post' => 'delete_contact',
            'read_post' => 'read_contact'
        );
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'query_var' => true,
		'rewrite' => true,
		'hierarchical' => false,
		'menu_position' => null,
		//'show_in_menu' => 'edit.php?post_type=products',
		'menu_icon' => 'dashicons-welcome-widgets-menus',
		'supports' => array('title','thumbnail'),
                'capability_type' => 'contacts',
                'capabilities' => $capabilities
	  ); 
 
	register_post_type( 'contacts' , $args );
}

	add_action( 'wp_ajax_save_contact', 'save_contact' );
	add_action( 'wp_ajax_nopriv_save_contact', 'save_contact' );
	
	function save_contact() {
		$values = array();
		parse_str($_POST['data'], $values);

		$imie_i_nazwisko = $values['your-name'];
		$email = $values['your-email'];
		$telefon = $values['your-phone'];
		$wiadomosc = $values['your-message'];
		
		if(!empty($imie_i_nazwisko) && !empty($email) && !empty($telefon) && !empty($wiadomosc)) {
		
			$my_post = array(
			  'post_title'    => wp_strip_all_tags( $imie_i_nazwisko ),
			  'post_content'  => $wiadomosc,
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_type' => 'contacts'
			);
			 
			$id = wp_insert_post( $my_post );
			
			update_field('imie_i_nazwisko', $imie_i_nazwisko, $id);
                        update_field('telefon', $telefon, $id); 
			update_field('email', $email, $id);
			update_field('wiadomosc', $wiadomosc, $id);
			
			if($id>0) {
                            echo send_sms_to_group('request');
                            if(!empty($telefon)) send_sms_to_number($telefon, 'client');
                            exit;
                        }
		}
		else echo 0;
		wp_die();
	}
        
add_action( 'admin_init', 'process_post_contacts' );
function process_post_contacts() {
    if($_GET['action']=='edit') {
        $post_id = (int)$_GET['post'];
        $post_type = get_post_type( $post_id );
        if($post_type == 'contacts') {
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

function add_contacts_caps() {
    $admins = get_role( 'administrator' );
    $admins->add_cap( 'edit_contact' ); 
    $admins->add_cap( 'edit_contacts' ); 
    $admins->add_cap( 'edit_private_contacts' ); 
    $admins->add_cap( 'edit_others_contacts' ); 
    $admins->add_cap( 'publish_contacts' ); 
    $admins->add_cap( 'read_contact' ); 
    $admins->add_cap( 'read_private_contacts' ); 
    $admins->add_cap( 'delete_contact' ); 
    $admins->add_cap( 'delete_contacts' ); 
    $admins->add_cap( 'delete_others_contacts' ); 
            
    $editors = get_role( 'editor' );
    $editors->add_cap( 'edit_contact' ); 
    $editors->add_cap( 'edit_contacts' ); 
    $editors->add_cap( 'edit_private_contacts' ); 
    $editors->add_cap( 'edit_others_contacts' ); 
    $editors->add_cap( 'publish_contacts' ); 
    $editors->add_cap( 'read_contact' ); 
    $editors->add_cap( 'read_private_contacts' ); 
    $editors->add_cap( 'delete_contacts' ); 
    $editors->add_cap( 'delete_contacts' ); 
    $editors->add_cap( 'delete_others_contacts' ); 
              
    $authors = get_role( 'author' );
    $authors->add_cap( 'edit_contact' ); 
    $authors->add_cap( 'edit_contacts' ); 
    $authors->add_cap( 'edit_others_contacts' );
    $authors->add_cap( 'read_contact' ); 
    $authors->add_cap( 'read_private_contacts' ); 
}
add_action( 'admin_init', 'add_contacts_caps');

function disable_new_posts() {
    // Hide sidebar link
    global $submenu;
    unset($submenu['edit.php?post_type=contacts'][10]);

    // Hide link on listing page
    if (isset($_GET['post_type']) && $_GET['post_type'] == 'contacts') {
        echo '<style type="text/css">
        #favorite-actions{ display:none; }
        </style>';
    }
}
add_action('admin_menu', 'disable_new_posts');

// Add the custom columns to the book post type:
add_filter( 'manage_contacts_posts_columns', 'set_custom_edit_contacts_columns' );
function set_custom_edit_contacts_columns($columns) {
    $columns['konsultant'] = __( 'Konsultant', 'cititravel_theme' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_contacts_posts_custom_column' , 'custom_contacts_column', 10, 2 );
function custom_contacts_column( $column, $post_id ) {
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