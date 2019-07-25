<?php

add_action('init', 'conditions_register');
 
function conditions_register() {
 
	$labels = array(
		'name' => __('Wycieczki', 'cititravel_theme'),
		'singular_name' => __('Wycieczki', 'cititravel_theme'),
		'add_new' => __('Dodaj nową', 'cititravel_theme'),
		'add_new_item' => __('Dodaj nową wycieczkę', 'cititravel_theme'),
		'edit_item' => __('Edytuj wycieczkę', 'cititravel_theme'),
		'new_item' => __('Nowa wycieczka', 'cititravel_theme'),
		'view_item' => __('Zobacz wycieczkę', 'cititravel_theme'),
		'search_items' => __('Szukaj wycieczek', 'cititravel_theme'),
		'not_found' =>  __('Nie znaleziono wycieczek', 'cititravel_theme'),
		'not_found_in_tracititravel_theme' => __('Nie znaleziono wycieczek w koszu', 'cititravel_theme'),
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
				'slug' => 'wycieczki', 
				'hierarchical' => true
				)
	  ); 
 
	register_post_type( 'conditions' , $args );
}

function conditions_option(){
	register_taxonomy(__( "conditions_option", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Opcje", 'cititravel_theme' ), 
		"singular_label" => __( "Opcja", 'cititravel_theme' )
	)); 
} 

function conditions_tourop(){
       
	register_taxonomy(__( "conditions_tourop", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Tour operatorzy", 'cititravel_theme' ), 
		"singular_label" => __( "Tour operator", 'cititravel_theme' ),
                'show_ui'                    => true,
                'show_in_quick_edit'         => false,
                'meta_box_cb'                => false,
	)); 
 
} 

function add_conditions_tourop_columns($columns){
    unset($columns['description']);
    unset($columns['posts']);
    $columns['slug'] = 'Kod';
    $columns['active'] = 'Aktywny';
    return $columns;
}
add_filter('manage_edit-conditions_tourop_columns', 'add_conditions_tourop_columns');
       
        function add_conditions_tourop_column_content($content,$column_name,$term_id){
            $term= get_term($term_id, 'conditions_tourop');
            switch ($column_name) {
                case 'active':
                    $active = get_field('active', 'conditions_tourop_'.$term_id);
                    $content = ((bool)$active===true) ? 'TAK' : 'NIE';
                    break;
                default:
                    break;
            }
            return $content;
        }
        add_filter('manage_conditions_tourop_custom_column', 'add_conditions_tourop_column_content',10,3);
            
function conditions_service(){
	register_taxonomy(__( "conditions_service", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "ID wyżywienia/serwisu", 'cititravel_theme' ), 
		"singular_label" => __( "ID wyżywienia/serwisu", 'cititravel_theme' ), 
		"rewrite" => array(
				'slug' => 'wyzywienie-serwis', 
				'hierarchical' => true
				),
               // 'meta_box_cb'       => 'movie_rating_meta_box',
		)
	); 
} 

function conditions_obj_type(){
	register_taxonomy(__( "obj_type", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Typ obiektu", 'cititravel_theme' ), 
		"singular_label" => __( "Typ obiektu", 'cititravel_theme' ), 
		"rewrite" => array(
				'slug' => 'typ-obiektu', 
				'hierarchical' => true
				)
		)
	); 
} 

function conditions_codes(){
	register_taxonomy(__( "conditions_codes", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Kody odpowiedzi MDS", 'cititravel_theme' ), 
		"singular_label" => __( "Kody odpowiedzi MDS", 'cititravel_theme' )
	)); 
} 

function conditions_trp_type(){
	register_taxonomy(__( "trp_type", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Typ dojazdu", 'cititravel_theme' ), 
		"singular_label" => __( "Typ dojazdu", 'cititravel_theme' ), 
		"rewrite" => array(
				'slug' => 'typ-dojazdu', 
				'hierarchical' => true
				)
		)
	); 
} 

function conditions_promotions(){
	register_taxonomy(__( "conditions_promotions", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Typ promocji", 'cititravel_theme' ), 
		"singular_label" => __( "Typ promocji", 'cititravel_theme' ), 
		"rewrite" => array(
				'slug' => 'typ-promocji', 
				'hierarchical' => true
				)
		)
	); 
} 

function conditions_dep_codes(){
	register_taxonomy(__( "dep_codes", 'cititravel_theme' ), 
	
	array(__( "conditions", 'cititravel_theme' )), 
	
	array(
		"hierarchical" => true, 
		"label" => __( "Miejsca wylotów", 'cititravel_theme' ), 
		"singular_label" => __( "Miejsca wylotów", 'cititravel_theme' ), 
		"rewrite" => array(
				'slug' => 'miejsca-wylotów', 
				'hierarchical' => true
				)
		)
	); 
} 

/**
 * Display Movie Rating meta box
 */
/*function movie_rating_meta_box( $post ) {
	$terms = get_terms( 'obj_xServiceId', array( 'hide_empty' => false ) );
    ?>
<select>
<?php
	foreach ( $terms as $term ) {
?>
    <option><?php esc_html_e( $term->name ); ?></option>
<?php
    }?>
</select>
    <?php
}

/**
 * Save the movie meta box results.
 *
 * @param int $post_id The ID of the post that's being saved.
 */
/*function save_movie_rating_meta_box( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['movie_rating'] ) ) {
		return;
	}
	$rating = sanitize_text_field( $_POST['movie_rating'] );
	
	// A valid rating is required, so don't let this get published without one
	if ( empty( $rating ) ) {
		// unhook this function so it doesn't loop infinitely
		remove_action( 'save_post_movie', 'save_movie_rating_meta_box' );
		$postdata = array(
			'ID'          => $post_id,
			'post_status' => 'draft',
		);
		wp_update_post( $postdata );
	} else {
		$term = get_term_by( 'name', $rating, 'movie_rating' );
		if ( ! empty( $term ) && ! is_wp_error( $term ) ) {
			wp_set_object_terms( $post_id, $term->term_id, 'movie_rating', false );
		}
	}
}
add_action( 'save_post_movie', 'save_movie_rating_meta_box' );

/**
 * Display an error message at the top of the post edit screen explaining that ratings is required.
 *
 * Doing this prevents users from getting confused when their new posts aren't published, as we
 * require a valid rating custom taxonomy.
 *
 * @param WP_Post The current post object.
 */
/*function show_required_field_error_msg( $post ) {
	if ( 'movie' === get_post_type( $post ) && 'auto-draft' !== get_post_status( $post ) ) {
	    $rating = wp_get_object_terms( $post->ID, 'movie_rating', array( 'orderby' => 'term_id', 'order' => 'ASC' ) );
        if ( is_wp_error( $rating ) || empty( $rating ) ) {
			printf(
				'<div class="error below-h2"><p>%s</p></div>',
				esc_html__( 'Rating is mandatory for creating a new movie post' )
			);
		}
	}
}
// Unfortunately, 'admin_notices' puts this too high on the edit screen
add_action( 'edit_form_top', 'show_required_field_error_msg' );

*/
function product_meta_box_cb( $post ) {
    $kierunek = get_post_meta( $post->ID, 'kierunek', true );
    $kierunek_tab = explode(',', $kierunek);
    wp_nonce_field( 'product_meta_box_nonce', 'meta_box_nonce' );
        ?>
    <select name="kierunek[]" id="kierunek" size="20" style="width: 100%;" multiple>
<?php
    global $wpdb;
    $kraje = $wpdb->get_results( 
	"SELECT *
	FROM `wp_regions`
	WHERE active = 1 AND parent = 0
        ORDER BY name ASC");
    foreach($kraje as $kraj) {
        $regiony = $wpdb->get_results( 
            "SELECT *
            FROM `wp_regions`
            WHERE active = 1 AND parent = {$kraj->id}
            ORDER BY name ASC");
            
        ?>
        <option value="<?=$kraj->kod_mds;?>" <?=(in_array($kraj->kod_mds, $kierunek_tab))?'selected':'';?>><?=$kraj->name;?></option>
        <?php
        foreach($regiony as $region) {
            ?>
            <option value="<?=$region->kod_mds;?>" <?=(in_array($region->kod_mds, $kierunek_tab))?'selected':'';?>>- - <?=$region->name;?></option>
            <?php
        }
    }
    ?>
    </select>
    <?php
}

add_action( 'save_post', 'product_meta_box_save' );
function product_meta_box_save( $post_id )
{
	// Bail if we're doing an auto save
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	
	// if our nonce isn't there, or we can't verify it, bail
	if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'product_meta_box_nonce' ) ) return;
	
	// if our current user can't edit this post, bail
	if( !current_user_can( 'edit_post' ) ) return;
	
	// now we can actually save the data
	$allowed = array( 
		'@' => array (),
		'a' => array( // on allow a tags
			'href' => array() // and those anchords can only have href attribute
		)
	);
	
	// Probably a good idea to make sure your data is set
	if( isset( $_POST['kierunek'] ) ) {
            $kierunek = join(',', $_POST['kierunek']);
            update_post_meta( $post_id, 'kierunek', $kierunek );
        }
	
	}

function product_meta_box() {
	add_meta_box( 
		'test-meta-box-id', 
		'Kierunek [trp_destination]', 
		'product_meta_box_cb', 
		'conditions', 
		'normal', 
		'high' 
	);
}

add_action( 'add_meta_boxes', 'product_meta_box' );


add_action('init', 'conditions_option', 0 );
add_action('init', 'conditions_tourop', 0 );
add_action('init', 'conditions_service', 0 );
add_action('init', 'conditions_codes', 0 );
add_action('init', 'conditions_obj_type', 0 );
add_action('init', 'conditions_trp_type', 0 );
add_action('init', 'conditions_promotions', 0 );
add_action('init', 'conditions_dep_codes', 0 );

function custom_remove_metaboxes() {
    remove_meta_box( 'conditions_codesdiv' , 'conditions' , 'normal' ); 

}
add_action( 'admin_menu' , 'custom_remove_metaboxes' );

add_action('admin_footer', 'hide_tourop_taxonomy');
 
	function hide_tourop_taxonomy(){
            $post_id = get_the_ID();
            $conditions_tourop = wp_get_post_terms($post_id, 'conditions_tourop');
            if(empty($conditions_tourop)) {

                $terms = get_terms('conditions_tourop', array('hide_empty' => false));
                foreach($terms as $dt) {
                    if((bool)get_field('active', 'conditions_tourop_'.$dt->term_id)===true) {
                    ?>
                    <script>
                            $('li#conditions_tourop-<?=$dt->term_id;?>>label>input').attr('checked', 'checked');			
                    </script>
                    <?php
                    }
                }
            }
        }