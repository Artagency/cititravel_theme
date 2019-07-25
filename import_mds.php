<?php

header('Content-Type: text/html; charset=utf-8');

function import_regions() {
    $file = 'http://www.merlinx.pl/mdsws/regions_tree_utf8.zip';
    $new_file = '/wp-content/uploads/regions/regions_tree_utf8.zip';
    if (!copy($file, $new_file)) {
        echo "failed to copy $file...\n";
    }
    $zip = new ZipArchive;
    if ($zip->open($new_file) === FALSE) {
        echo "0";
    }
    $zip->extractTo('/wp-content/uploads/regions/');
    $zip->close();
    
    //pobranie wszystkich krajów
    $all_countries = get_terms('regions_countries', array('hide_empty' => false));
    foreach($all_countries as $code) {
        update_field('active', 0, 'regions_countries_'.$code->term_id);
    }
    
    $csv = array_map('str_getcsv', file('/wp-content/uploads/regions/regions_tree_utf8.csv'));
    //dodajemy kraje
    foreach($csv as $c) {
        $tab = explode(';', $c[0]);
        if(is_numeric($tab[0]) && date('Y-m-d', strtotime(str_replace('"', '', $tab[4])))>=date('Y-m-d')) {
            $id = $tab[0];
            $name = $tab[1];
            $parentid = $tab[2]; 
            $mdsval = $tab[3];

            $tab[1] = str_replace(array('¯','³','¶','¿','ê','æ','¦', '"', '\N'), array('Ż', 'ł','ś','ż','ę','ć','Ś','',''), trim($tab[1]));
            if(!empty($tab[1]) && (int)str_replace('"', '', $tab[2])===0 && isset($tab[3])) {
                    $term = get_term_by('name', $tab[1], 'regions_countries');
                    $cid = (int)str_replace(array(':','"'), '', $tab[3]);
                    if(!empty($term)) {
                        update_field('field_5a99ed683cb05', str_replace('"', '', $tab[3]), 'regions_countries_'.$term->term_id);
                        $result = update_field("active", 1, 'regions_countries_'.$term->term_id) && $result;
                        $countries[$cid] = $term->term_id;
                    }
                    else {
                        $new_term_id = wp_insert_term(
                            $tab[1],
                            'regions_countries',
                            array(
                                'slug' => sanitize_title($tab[1]),
                                'parent'=> 0
                            )
                        );
                        update_field('field_5a99ed683cb05', str_replace('"', '', $tab[3]), 'regions_countries_'.$new_term_id['term_id']);
                        $result = update_field('active', 1, 'regions_countries_'.$new_term_id['term_id']) && $result;
                        $countries[$cid] = $new_term_id['term_id'];
                    }
                }
        
        }
    }
    
    foreach($all_countries as $code) {
        if(get_field('active', 'regions_countries_'.$code->term_id)==0) {
            wp_delete_term( $code->term_id, 'regions_countries');
        }
    }

    $all_regions = get_posts(array('post_type' => 'regions', 'posts_per_page' => -1, 'post_status' =>'any'));
    foreach($all_regions as $code) {
        update_field('active', 0, $code->ID);
    }
    
    foreach($csv as $c) {
        $tab = explode(';', $c[0]);
        if(is_numeric($tab[0]) && date('Y-m-d', strtotime(str_replace('"', '', $tab[4])))>=date('Y-m-d')) {
            $id = $tab[0];
            $name = $tab[1];
            $parentid = $tab[2]; 
            $mdsval = $tab[3];

            $tab[1] = str_replace(array('¯','³','¶','¿','ê','æ','¦', '"', '\N'), array('Ż', 'ł','ś','ż','ę','ć','Ś','',''), trim($tab[1]));
            if(!empty($tab[1]) && (int)str_replace('"', '', $tab[2])>0 && isset($tab[3])) {
                $page = get_page_by_title($tab[1], OBJECT, 'regions');
                $cid_tab = explode('_', str_replace('"', '', $tab[3]));
                $cid = (int)$cid_tab[0];
                
                if(!empty($page)) {
                    update_field('field_5a99ed683cb05', str_replace('"', '', $tab[3]), $page->ID);
                    update_field("active", 1, $page->ID);
                    wp_set_post_terms( $page->ID, array($countries[$cid]), 'regions_countries', false );
                }
                else {
                    $my_post = array(
                        'post_title'    => wp_strip_all_tags( $tab[1] ),
                        'post_status'   => 'publish',
                        'post_type'     => 'regions',
                    );
                    $insert_id = wp_insert_post( $my_post );
                    update_field('field_5a99ed683cb05', str_replace('"', '', $tab[3]), $insert_id);
                    wp_set_post_terms( $insert_id, array($countries[$cid]), 'regions_countries', false );
                }               
            }
        }
    }
    
    foreach($all_regions as $code) {
        if(get_field('active', $code->ID)==0) {
            wp_delete_post($code->ID);
        }
    }
    
    return 1;
}

function import_options() {
    $result = true;
    
    //pobranie wszystkich opcji
    $all_options = get_terms('conditions_option', array('hide_empty' => false));
    foreach($all_options as $option) {
        update_field('active', 0, 'conditions_option_'.$option->term_id);
    }
        
    $csv = array_map('str_getcsv', file('http://www.merlinx.pl/mdsws/options.csv'));
    foreach($csv as $c) {
        $tab = explode(';', $c[0]);
        $tab[0] = str_replace(array('¯','³','¶','¿','ê','æ','¦', '"'), array('Ż', 'ł','ś','ż','ę','ć','Ś',''), mb_convert_encoding($tab[0], 'UTF-8', 'ASCII'));
        $slug = sanitize_title($tab[0]);
        $term = get_term_by('slug', $slug, 'conditions_option');
        if(!empty($term)) {
            update_field('field_5aa51e5ec0a7a', $tab[1], 'conditions_option_'.$term->term_id);
            wp_update_term($term->term_id, 'conditions_option_', array('name' => $tab[0]));
            $result = update_field("field_5aa51f186f144", 1, 'conditions_option_'.$term->term_id) && $result;
        }
        else {
            if(!empty($tab[0])) {
                $new_term_id = wp_insert_term(
                    $tab[0],
                    'conditions_option',
                    array(
                        'slug' => $slug,
                        'parent'=> 0
                    )
                );
                update_field('field_5aa51e5ec0a7a', $tab[1], 'conditions_option_'.$new_term_id['term_id']);
                $result = update_field('field_5aa51f186f144', 1, 'conditions_option_'.$new_term_id['term_id']) && $result;
            }
        }
    }
    
    foreach($all_options as $option) {
        if(get_field('active', 'conditions_option_'.$option->term_id)==0) {
            wp_delete_term( $option->term_id, 'conditions_option');
        }
    }
    return $result;
}

function import_tourop() {
    $result = true;
    
    //pobranie wszystkich opcji
    $all_tourop = get_terms('conditions_tourop', array('hide_empty' => false));
    foreach($all_tourop as $tourop) {
        update_field('active', 0, 'conditions_tourop'.$tourop->term_id);
    }
        
    $csv = array_map('str_getcsv', file('http://www.merlinx.pl/mdsws/tourops.csv'));
    foreach($csv as $c) {
        $tab = explode(';', $c[0]);
        $tab[1] = str_replace(array('¯','³','¶','¿','ê','æ','¦', '"'), array('Ż', 'ł','ś','ż','ę','ć','Ś',''), mb_convert_encoding($tab[1], 'UTF-8', 'ASCII'));
        $slug = sanitize_title($tab[0]);
        $term = get_term_by('slug', $slug, 'conditions_tourop');
        if(!empty($term)) {
            update_field('field_5aa51e5ec0a7a', $tab[0], 'conditions_tourop_'.$term->term_id);
            wp_update_term($term->term_id, 'conditions_tourop', array('name' => $tab[1]));
            $result = update_field("field_5aa51f186f144", 1, 'conditions_tourop_'.$term->term_id) && $result;
        }
        else {
            if(!empty($tab[1])) {
                $new_term_id = wp_insert_term(
                    $tab[1],
                    'conditions_tourop',
                    array(
                        'slug' => $slug,
                        'parent'=> 0
                    )
                );
                update_field('field_5aa51e5ec0a7a', $tab[1], 'conditions_tourop_'.$new_term_id['term_id']);
                $result = update_field('field_5aa51f186f144', 1, 'conditions_tourop_'.$new_term_id['term_id']) && $result;
            }
        }
    }
    
    foreach($all_tourop as $tourop) {
        if(get_field('active', 'conditions_tourop_'.$tourop->term_id)==0) {
            wp_delete_term( $tourop->term_id, 'conditions_tourop');
        }
    }
    return $result;
}

function import_services() {
    $result = true;
    
    //pobranie wszystkich opcji
    $all_services = get_terms('conditions_service', array('hide_empty' => false));
    foreach($all_services as $service) {
        update_field('active', 0, 'conditions_service'.$service->term_id);
    }
        
    $csv = array_map('str_getcsv', file('http://www.merlinx.pl/mdsws/htlsrvcode.csv'));
    foreach($csv as $c) {
        $tab = explode(';', $c[0]);
        $tab[1] = str_replace(array('¯','³','¶','¿','ê','æ','¦', '"'), array('Ż', 'ł','ś','ż','ę','ć','Ś',''), mb_convert_encoding($tab[1], 'UTF-8', 'ASCII'));
        $slug = sanitize_title($tab[1]);
        $term = get_term_by('slug', $slug, 'conditions_service');
        if(!empty($term)) {
            update_field('field_5aa51e5ec0a7a', $tab[0], 'conditions_service_'.$term->term_id);
            wp_update_term($term->term_id, 'conditions_service', array('name' => $tab[1]));
            $result = update_field("field_5aa51f186f144", 1, 'conditions_service_'.$term->term_id) && $result;
        }
        else {
            if(!empty($tab[1])) {
                $new_term_id = wp_insert_term(
                    $tab[1],
                    'conditions_service',
                    array(
                        'slug' => $slug,
                        'parent'=> 0
                    )
                );
                update_field('field_5aa51e5ec0a7a', $tab[1], 'conditions_service_'.$new_term_id['term_id']);
                $result = update_field('field_5aa51f186f144', 1, 'conditions_service_'.$new_term_id['term_id']) && $result;
            }
        }
    }
    
    foreach($all_services as $service) {
        if(get_field('active', 'conditions_service_'.$service->term_id)==0) {
            wp_delete_term( $service->term_id, 'conditions_service');
        }
    }
    return $result;
}

function import_codes() {
    $result = true;
    
    //pobranie wszystkich opcji
    $all_codes = get_terms('conditions_codes', array('hide_empty' => false));
    foreach($all_codes as $code) {
        update_field('active', 0, 'conditions_codes_'.$code->term_id);
    }
        
    $csv = array_map('str_getcsv', file('http://www.merlinx.pl/mdsws/msgcode.csv'));
    foreach($csv as $c) {
        $tab = explode(';', $c[0]);
        if(is_numeric($tab[0])) {
        $tab[1] = str_replace(array('¯','³','¶','¿','ê','æ','¦', '"'), array('Ż', 'ł','ś','ż','ę','ć','Ś',''), mb_convert_encoding($tab[1], 'UTF-8', 'ASCII'));
        $slug = sanitize_title($tab[1]);
        $term = get_term_by('slug', $slug, 'conditions_codes');
        if(!empty($term)) {
            update_field('field_5aa51e5ec0a7a', $tab[0], 'conditions_codes_'.$term->term_id);
            wp_update_term($term->term_id, 'conditions_codes', array('name' => $tab[1]));
            $result = update_field("field_5aa51f186f144", 1, 'conditions_codes_'.$term->term_id) && $result;
        }
        else {
            if(!empty($tab[1])) {
                $new_term_id = wp_insert_term(
                    $tab[1],
                    'conditions_codes',
                    array(
                        'slug' => $slug,
                        'parent'=> 0
                    )
                );
                update_field('field_5aa51e5ec0a7a', $tab[1], 'conditions_codes_'.$new_term_id['term_id']);
                $result = update_field('field_5aa51f186f144', 1, 'conditions_codes_'.$new_term_id['term_id']) && $result;
            }
        }
    }
    }
    
    foreach($all_codes as $code) {
        if(get_field('active', 'conditions_codes_'.$code->term_id)==0) {
            wp_delete_term( $code->term_id, 'conditions_codes');
        }
    }
    return $result;
}

function update_regions() {
    $result = true;
    global $wpdb;
    $all_countries = get_terms('regions_countries', array('hide_empty' => false));
    foreach($all_countries as $code) {
        $kod_mds = get_field('kod_regionu_mds', 'regions_countries_'.$code->term_id);
        $active = get_field('active', 'regions_countries_'.$code->term_id);
        $home = (int)get_field('wyszukiwanie', 'regions_countries_'.$code->term_id);
        $result =  $wpdb->replace('wp_regions', 
                array('id' => $code->term_id, 
                    'name' => $code->name,
                    'slug' => $code->slug, 
                    'kod_mds' => $kod_mds, 
                    'active' => $active, 
                    'home' => $home, 
                    'parent' => 0), 
                array('%d', '%s', '%s', '%s', '%d', '%d')) && (bool)$result;
    }
    
    $all_regions = get_posts(array('post_type' => 'regions', 'posts_per_page' => -1, 'post_status' =>'any'));
    foreach($all_regions as $code) {
        $kod_mds = get_field('kod_regionu_mds', $code->ID);
        $active = get_field('active', $code->ID);
        $home = (int)get_field('wyszukiwanie', $code->ID);
        $terms = wp_get_post_terms($code->ID, 'regions_countries');
        $parent = (int)$terms[0]->term_id;
        $result =  $wpdb->replace('wp_regions', 
                array('id' => $code->ID, 
                    'name' => $code->post_title,
                    'slug' => $code->slug, 
                    'kod_mds' => $kod_mds, 
                    'active' => $active, 
                    'home' => $home, 
                    'parent' => $parent), 
                array('%d', '%s', '%s', '%s', '%d', '%d')) && (bool)$result;
    }
    echo $result;
}