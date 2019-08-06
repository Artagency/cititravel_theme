<?php  
    /* Template Name: Podstrona Wyników wyszukiwania */
?> 

<?php include('header.php'); 

$orderby = get_query_var('orderby', 'ofr_price');
$order_sort = (strpos($orderby, '-')===0) ? 'desc' : 'asc';
$order_negative = ($order_sort=='asc') ? 'desc' : 'asc';

$time_start = microtime(true); 
$post_type = get_post_type();

if($post_type=='conditions') {
    $data = get_conditions_by_id(get_the_ID());
} else {
    $trp_destination = get_query_var('trp_destination');
    $cities_names = get_query_var('cities_names');
    $hotels_names = get_query_var('hotels_names');
    if(!empty($trp_destination) || !empty($cities_names) || !empty($hotels_names)) {
        //if(!empty($trp_destination) && strpos($trp_destination, '_')===false) $trp_destination = (int)$trp_destination.':';
        if(!empty($trp_destination)) {
            $trp_tab = explode(',', $trp_destination);
            $countries = $regions = $new_countries = array();
            foreach($trp_tab as $tt) {
                if(strpos($tt, '_')===false) $countries[] = $tt;
                else $regions[] = $tt;
            }
            
            foreach($regions as $reg) {
                $reg_tab = explode('_', $reg);
                if(in_array((int)$reg_tab[0].':', $countries)) $new_countries[] = (int)$reg_tab[0].':';
            }
            
            $new_countries = array_diff($countries, $new_countries);
            $new_trp = array_merge($regions, $new_countries);
            $trp_destination = join(',', $new_trp);
        }
    
    $ofr_type = join(',', get_query_var('ofr_type', array('F')));
    
    $trp_depDate = explode('-', urldecode(get_query_var('trp_depDate')));

    $date_from = date('Ymd', strtotime(get_query_var('trp_depDateFrom')));
    $trp_depDateFrom = (!empty($date_from) && $date_from!='19700101') ? $date_from : date('d.m.Y', strtotime('+2 day'));

    $date_to = date('Ymd', strtotime(get_query_var('trp_depDateTo')));
    $trp_depDateTo = (!empty($date_to) && $date_to!='19700101') ? $date_to : date('d.m.Y', strtotime('+32 day'));
   
    $conditions = array(
        'par_adt' => get_query_var('par_adt', 2),
        'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo,
        'ofr_type' => $ofr_type,
        'limit_from' => max(get_query_var('page', 0)-1,0)*15+1,
        'limit_count' => 15,
        'order_by' => $orderby,
        'calc_found' => 1000,
        'ofr_xStatus' => 'A',
        'minPrice' => $minPrice
    );
    
    if(!empty($trp_destination)) $conditions['trp_destination'] = urldecode($trp_destination);

    //print_r($conditions);
    
    $par_chd = get_query_var('par_chd');
    if(!empty($par_chd)) $conditions['par_chd'] = $par_chd;
    
    $obj_type = get_query_var('obj_type', 'H');
    if(!empty($obj_type)) $conditions['obj_type'] = $obj_type;
    
    $ofr_tourOp = get_query_var('ofr_tourOp', 'ITAK,VNET,ECCO,ECTR,EXIM,SYLO,VMAT,NPL,RNBW,WEZY,GRCS,TUIZ');
    if(!empty($ofr_tourOp)) $conditions['ofr_tourOp'] = $ofr_tourOp;
    
    $trp_duration = get_query_var('trp_duration', '6:8');
    if(!empty($trp_duration)) $conditions['trp_duration'] = $trp_duration;
    
    $trp_depCode = get_query_var('trp_depCode');
    if(!empty($trp_depCode)) $conditions['trp_depCode'] = $trp_depCode;
    
    $obj_category = get_query_var('obj_category');
    if(!empty($obj_category)) $conditions['obj_category'] = $obj_category;
    
    $ofr_xCatalog = get_query_var('ofr_xCatalog');
    if(!empty($ofr_xCatalog)) $conditions['ofr_xCatalog'] = $ofr_xCatalog;
        
    if(!empty($obj_xServiceId)) $conditions['obj_xServiceId'] = $obj_xServiceId;
    
    if(!empty($maxPrice) && $maxPrice<8000) $conditions['maxPrice'] = $maxPrice;
    
    $new_attrs = array();
    for($i=1;$i<=64;$i++) {
        $new_attrs[$i] = 0;
    }
    
    $obj_xAttributes_tab = (!empty($_GET['obj_xAttributes'])) ? explode(',', $_GET['obj_xAttributes']) : '';
    
    $sum = 0;
    if(!empty($obj_xAttributes_tab)) {
        foreach($obj_xAttributes_tab as $attr) {
           $sum += $attr;
        }
    }
    
    for($i=0;$i<=63;$i++) {
        $l = pow(2, $i);
        if($l==$sum) $new_attrs[$i+1] = 1;
    }
    
    if(!empty($new_attrs)) {
        $bin = implode( '', $new_attrs);
        $obj_xAttributes = '0x'.dechex(bindec($bin));
    }
    if(!empty($obj_xAttributes) && !empty($sum)) {
        $conditions['obj_xAttributes'] = $sum;
        $conditions['obj_xAttributesCount'] =  count($obj_xAttributes_tab);
    }

    if(!empty($cities_names)) $conditions['obj_xCityFts'] = $cities_names;
    if(!empty($hotels_names)) $conditions['obj_codeNameFts'] = $hotels_names;
    
    $data = get_data('groups', $conditions);
  
    }
    else $GLOBALS['msg'] = 'Proszę wybrać kierunek wyjazdu';
}

//echo "<pre>";
//print_r($conditions);exit;

//print_r($data);exit;

if(empty($data) || $data->{'count'} == 0) $GLOBALS['msg'] = 'Brak wyników wyszukiwania';

$time_end = microtime(true);
$execution_time1 = ($time_end - $time_start);
$miejsca_wylotu = array();
$images = array();
$all_count = $data->{'count'};

if($all_count==1) {
    $new_grp = $data->grp;
    $data->grp = array();
    $data->grp[0] = $new_grp;
}

if(!empty($data->grp)) {
foreach($data->grp as $offer) {
   // echo $arr->obj->{'@attributes'}->xCode."<br/>";
    $arr = $offer->ofr;
    if(!in_array($arr->trp->{'@attributes'}->depDesc, $miejsca_wylotu))$miejsca_wylotu[] = $arr->trp->{'@attributes'}->depDesc;
    //add_offer_to_db($arr->{'@attributes'}->id);       
    $thumbnail[$arr->{'@attributes'}->id] = get_attributes($arr->{'@attributes'}->id, $arr->obj->{'@attributes'}->xCode, $arr->obj->{'@attributes'}->code, $arr->{'@attributes'}->tourOp, 'thumb');
    $texts[$arr->{'@attributes'}->id] = get_attributes($arr->{'@attributes'}->id, $arr->obj->{'@attributes'}->xCode, $arr->obj->{'@attributes'}->code, $arr->{'@attributes'}->tourOp, 'text');
    add_custom_permalink($arr->obj->{'@attributes'}->xCode, $arr->obj->{'@attributes'}->country, $arr->obj->{'@attributes'}->name);
    }
}

if(get_query_var('advanced')==0 || get_query_var('advanced')==1 || !empty(get_query_var('orderby'))) {
    
    $ofr_type_str = (!empty(get_query_var('ofr_type'))) ? join(',', get_query_var('ofr_type')) : '';
    $string_param = '?trp_depCode='.get_query_var('trp_depCode').'&trp_depDateFrom='.get_query_var('trp_depDateFrom').'&trp_depDateTo='.get_query_var('trp_depDateTo').'&par_adt='.get_query_var('par_adt').
        '&par_chd='.get_query_var('par_chd').'&trp_destination='.get_query_var('trp_destination').'&obj_category='.get_query_var('obj_category').
        '&obj_xAttributes='.get_query_var('obj_xAttributes').'&ofr_tourOp='.get_query_var('ofr_tourOp').'&obj_xServiceId='.get_query_var('obj_xServiceId').
        '&ofr_type[]='.$ofr_type_str.'&minPrice='.get_query_var('minPrice').'&maxPrice='.get_query_var('maxPrice').'&trp_duration='.get_query_var('trp_duration').
        '&advanced='.get_query_var('advanced').'&orderby='.get_query_var('orderby').'&';
}
else $string_param = '?';
?>

<div class="main-content main-content--search">
    <div class="search-panel search-panel--sub">
        <div class="container">
            <?php include('parts/search_panel.php'); ?>

            <a href="#" class="search-more <?=($_GET['advanced']==1)?'active':'';?>"><span class="expand">Pokaż</span> <span class="fold">Schowaj</span> opcje zaawansowane</a>
        </div>
    </div>

	<div class="container">
        <?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>

        <div class="page-content page-content--main">
            <?php the_content(); ?>
        </div>

        <?php
            if(!empty($GLOBALS['msg'])) {
                echo '<h3>Nic nie znaleziono</h3>';
                echo '<p>'.$GLOBALS['msg'].'</p>';
                $GLOBALS['msg'] = NULL;
                 
            }
            else {
        ?>
		<div class="row--search-result">            
            <h3>Znaleźliśmy dla Ciebie <?=$all_count;?> ofert</h3>

			<div class="filter filter--sec">Widok:
				<ul class="filter-ul filter-ul--sec">
					<li><a class="column" href="#">Kafelki</a></li>
					<li><a class="list active" href="#">Lista</a></li>
				</ul>
			</div>
			<div class="filter">Sortuj:
				<ul class="filter-ul filter-ul-clicked">
					<li><a class="<?=($orderby=='ofr_price')?'active':'';?>" href="<?=$string_param;?>orderby=<?=($order_negative=='desc')?'-':'';?>ofr_price">Cena</a></li>
					<li><a class="<?=($orderby=='-obj_category')?'active':'';?>" href="<?=$string_param;?>orderby=<?=($order_negative=='desc')?'-':'';?>obj_category">Standard hotelu</a></li>
				</ul>
			</div>
		</div>
        <?php }?>
		
		<div class="row row--columns">				
			<?php
            if(!empty($data->grp)) {              
            foreach($data->grp as $offer) {
                $arr = $offer->ofr;
                $cat = (int)$arr->obj->{'@attributes'}->category; ?>
			<div class="col-lg-4 col-md-4 col-xs-6 offer-item">
                            <div class="offer-item-photo">
                                <?php $page_path = get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
                                <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink($page_path));?>">
                                    <img data-src="<?=(!empty($thumbnail[$arr->{'@attributes'}->id][0]))?$thumbnail[$arr->{'@attributes'}->id][0]:get_template_directory_uri().'/img/cititravel-placeholder.jpg';?>" alt="" />
                                           
                                    <div class="price">
                                        <span class="price-from">Cena od</span>
                                        <span class="price-total"><?=$arr->{'@attributes'}->price;?> <?=$arr->{'@attributes'}->curr;?></span>
                                        <span class="price-per">/ os.</span>
                                        <?php /*
                                        <span class="price-from price-from--two-persons">Cena za 2 os.</span>
                                        <span class="price-total price-total--two-persons"><?=$arr->{'@attributes'}->price*2;?> <?=$arr->{'@attributes'}->curr;?></span>
                                        */ ?>
                                    </div>
                                </a>   
                            </div>
                            <div class="offer-item-details">
                                <div class="offer-item-details-header">
                                    <h3>
                                        <?php $page_path = get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
                                <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink($page_path));?>"><?=$arr->obj->{'@attributes'}->xName;?></a>
                                    </h3>
                                    <span class="region"><?=$arr->obj->{'@attributes'}->country;?>, <?=$arr->obj->{'@attributes'}->region;?></span>
                                </div>

                                <span class="rating rating--sec">
                                    <i class="icon-star<?=($cat == 5)?'-half':(($cat >= 10)?'':'-normal');?>"></i>
                                    <i class="icon-star<?=($cat == 15)?'-half':(($cat >= 20)?'':'-normal');?>"></i>
                                    <i class="icon-star<?=($cat == 25)?'-half':(($cat >= 30)?'':'-normal');?>"></i>
                                    <i class="icon-star<?=($cat == 35)?'-half':(($cat >= 40)?'':'-normal');?>"></i>
                                    <i class="icon-star<?=($cat == 45)?'-half':(($cat >= 50)?'':'-normal');?>"></i>
                                </span>

                                <div class="tripDetails">
                                    <div class="top">
                                        <span class="first">Pobyt:</span> <span><?=$arr->trp->{'@attributes'}->durationM;?> dni</span> |
                                        <span class="first">Termin:</span> <span><?=date('d.m.Y', strtotime($arr->trp->{'@attributes'}->depDate));?></span> |<!--03.08 Pt - 11.03 Pt-->
                                        <span class="first"><?php if($arr->{'@attributes'}->type=='BU') echo 'Wycieczka autokatorowa'; elseif($arr->{'@attributes'}->type=='F') {?>Wylot z: <?=($arr->trp->{'@attributes'}->depDesc) ? $arr->trp->{'@attributes'}->depDesc : '-';} else echo 'Dojazd własny';?></span>
                                    </div>
                                    <div class="bottom">
                                        <span class="first">Wyżywienie:</span> <span class="nowrap"><?php
                                                    $conditions_service = get_terms( 'conditions_service', array( 'hide_empty' => false ));
                                                    if(!empty($conditions_service)) {
                                                        foreach($conditions_service as $cs) {
                                                            $code = (int)get_field('code', 'conditions_service_'.$cs->term_id);
                                                            if($code==$arr->obj->{'@attributes'}->xServiceId) {echo $cs->name;break;}
                                                        }
                                                    }?></span><br/>
                                        <span class="first">Organizator:</span> <span class="nowrap"><?php
                                                    $conditions_tourop = get_terms( 'conditions_tourop', array( 'hide_empty' => false ));
                                                    if(!empty($conditions_tourop)) {
                                                        foreach($conditions_tourop as $dt) {
                                                            if(strtoupper($dt->slug)==$arr->{'@attributes'}->tourOp) {echo $dt->name;break;}
                                                        }
                                                    }?></span>
                                    </div>
                                </div> 
                            </div>
			</div>
            <?php }}?>
		</div>

		<div class="row--list">
			<?php
                        if(!empty($data->grp)) {
                            foreach($data->grp as $offer) {
                                $arr = $offer->ofr;
                                $cat = (int)$arr->obj->{'@attributes'}->category;
                            ?>
                            <div class="col-lg-12 col-md-12 offer-item offer-item--sec">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-xs-12">
                                        <div class="offer-item-photo">
                                            <?php $page_path = get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
                                <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink($page_path));?>">
                                                <img data-src="<?=(!empty($thumbnail[$arr->{'@attributes'}->id][0]))?$thumbnail[$arr->{'@attributes'}->id][0]:get_template_directory_uri().'/img/cititravel-placeholder.jpg';?>" alt="" />
                                            </a>   
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-xs-8">
                                        <div class="offer-item-details">
                                            <div class="offer-item-details-header">
                                                <h3><?php $page_path = get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
                                <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink($page_path));?>"><?=$arr->obj->{'@attributes'}->xName;?></a></h3>
                                                <span class="rating">
                                                    <i class="icon-star<?=($cat >= 10)?'':'-normal';?>"></i>
                                                    <i class="icon-star<?=($cat >= 20)?'':'-normal';?>"></i>
                                                    <i class="icon-star<?=($cat >= 30)?'':'-normal';?>"></i>
                                                    <i class="icon-star<?=($cat >= 40)?'':'-normal';?>"></i>
                                                    <i class="icon-star<?=($cat >= 50)?'':'-normal';?>"></i>
                                                </span>
                                                <span class="region"><?=$arr->obj->{'@attributes'}->country;?>, <?=$arr->obj->{'@attributes'}->region;?></span>
                                            </div>

                                            <div class="offer-trip-details">
                                                <span>Pobyt: <?=$arr->trp->{'@attributes'}->durationM;?> dni</span>
                                                <span>Termin: <?=date('d.m.Y', strtotime($arr->trp->{'@attributes'}->depDate));?><!--03.08 Pt - 11.03 Pt--></span>
                                                <span><?php if($arr->{'@attributes'}->type=='BU') echo 'Wycieczka autokatorowa'; elseif($arr->{'@attributes'}->type=='F') {?>Wylot z: <?=($arr->trp->{'@attributes'}->depDesc) ? $arr->trp->{'@attributes'}->depDesc : '-';} else echo 'Dojazd własny';?></span><br/> 
                                                <span>Wyżywienie: 
                                                <?php
                                                $conditions_service = get_terms( 'conditions_service', array( 'hide_empty' => false ));
                                                if(!empty($conditions_service)) {
                                                    foreach($conditions_service as $cs) {
                                                        $code = (int)get_field('code', 'conditions_service_'.$cs->term_id);
                                                        if($code==$arr->obj->{'@attributes'}->xServiceId) {echo $cs->name;break;}
                                                    }
                                                }?></span><br/>
                                                <span>Organizator: 
                                                <?php
                                                $conditions_tourop = get_terms( 'conditions_tourop', array( 'hide_empty' => false ));
                                                if(!empty($conditions_tourop)) {
                                                    foreach($conditions_tourop as $dt) {
                                                        if(strtoupper($dt->slug)==$arr->{'@attributes'}->tourOp) {echo $dt->name;break;}
                                                    }
                                                }?></span>
                                            </div> 
                                            <div class="facilities-hld">
                								<ul>
                		                        <?php 
                		                        $mask = $arr->obj->{'@attributes'}->xAttributes;
                		                        $bin = decbin(hexdec($mask));
                                                $i = 0;
                		                        
                		                        $expl =  array_filter(preg_split( '//', $bin ), 'strlen');
                		                        $expl = array_reverse( $expl );
                		                        foreach( $expl as $k => $binVal ) {
                		                            if( $binVal == '1' ) {
                		                                $attrs[] = pow( 2, $k );
                		                            }
                		                        }
                		                        
                		                        if(!empty($attrs)) {
                		                            $attrs_names = array();
                		                            $terms = get_terms('conditions_option', array('hide_empty' => false));
                		                            foreach($terms as $term) {
                		                                $code = (int)get_field('code', 'conditions_option_'.$term->term_id);
                		                                if(in_array($code, $attrs)) {
                		                                    $attrs_names[] = $term->name;
                		                                }
                		                            }

                		                            if(!empty($attrs_names)) {
                		                                foreach($attrs_names as $an) {

                                                            if($i <= 8) {
                    											$anClass = str_replace(' ', '-', $an); // Replaces all spaces with hyphens.
                    											$anClass = preg_replace('/[^A-Za-z0-9\-]/', '', $anClass); // Removes special chars.
                    											$anClass = strtolower($anClass); // Convert to lowercase

                    		                                    echo '<li><span class="'.$anClass.'">'.$an.'</span>';

                                                            }

                                                            $i++;
                		                                }
                		                            }
                		                        }
                		                        ?>
                								</ul>
                							</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-xs-4 align-right">
                                        <div class="price">
                                            <span class="price-from">Cena od</span>
                                            <span class="price-total"><?php $page_path = get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
                                <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink($page_path));?>"><?=$arr->{'@attributes'}->price;?> <?=$arr->{'@attributes'}->operCurr;?> <span class="price-per">/ os.</span></a></span>

                                            <span class="price-from price-from--two-persons">Cena za 2 os.</span>
                                            <span class="price-total price-total--two-persons"><?=$arr->{'@attributes'}->price*2;?> <?=$arr->{'@attributes'}->curr;?></span>
                                        </div>
                                        
                                        <?php /*
                                        <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink(get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels')));?>" class="btn">Zobacz ofertę</a>*/ ?>
                                        <?php
                        //sprawdzanie czy jest w schowku
                        global $wpdb;
                        $qry = "SELECT ho.offer_id FROM wp_hanging h
                                JOIN wp_hanging_offers ho ON h.id = ho.hanging_id
                                WHERE h.code='{$_COOKIE['hanging_code']}' AND ho.offer_id='".$arr->{'@attributes'}->id."'";
                        $results = $wpdb->get_results( $qry );
                        if(empty($results)) {?>
                                        <div class="hanging-btn-hld"><a href="<?php echo admin_url('admin-ajax.php'); ?>" class="add-to-hanging" data-offer-id="<?=$arr->{'@attributes'}->id;?>">Dodaj do ulubionych</a></div>
                        <?php }
                        else {?>
                               <div class="hanging-btn-hld"><a href="<?php echo admin_url('admin-ajax.php'); ?>" class="remove-from-hanging" data-offer-id="<?=$arr->{'@attributes'}->id;?>">Usuń z ulubionych</a></div>
                        <?php }?>
                                    </div>
                                </div>
                            </div>
                            <?php }
                        
                        }?>
		</div>
		
		<div class="row row--pagination align-center">
            <?php
            $trp_destination = str_replace("'", "", $trp_destination);
            $all = $data->{'count'}-1;
            if($all>0) {
            $pages_final = ceil($all/15);
            $page = get_query_var('page');
            if(empty($page)) $page=1;
            if($page>3) $x=$page-2;
            else $x=1;
           
            $pages = $x+5;
            if($pages>$pages_final) {$pages = $pages_final; $x=$pages_final-5;}
            $x = max($x, 1);
            
            if($page>1) {
                if($post_type=='conditions') {
                    ?>
                         <a href="?orderby=<?=$orderby;?>&page=<?=$page-1;?>" class="btn btn--more">wstecz</a>
                        <?php
                }
                else {
                      ?>
                <a href="<?=$string_param;?>page=<?=$page-1;?>" class="btn btn--more">wstecz</a>
                <?php
                }
            }
            ?>
            <?php
            for($i=$x;$i<=$pages;$i++) {
                if($post_type=='conditions') {
                   ?>
                     <a href="?orderby=<?=$orderby;?>&page=<?=$i;?>" class="btn btn--more <?=($page==$i)?'active':'';?>"><?=$i;?></a>
            
                    <?php
                }
                else {
            ?>
            <a href="<?=$string_param;?>page=<?=$i;?>" class="btn btn--more <?=($page==$i)?'active':'';?>"><?=$i;?></a>
            <?php }}
            
            if($page<$pages) {
                if($post_type=='conditions') {
                    ?>
                         <a href="?orderby=<?=$orderby;?>&page=<?=$page+1;?>" class="btn btn--more">dalej</a>
                        <?php
                }
                else {
                      ?>
                <a href="<?=$string_param;?>page=<?=$page+1;?>" class="btn btn--more">dalej</a>
                <?php
                }
            }
            
                }?>
		</div>

        <?php include('parts/newsletter.php'); ?>
    </div>
</div>

<?php include('parts/part_blog.php'); ?>

<?php include('parts/trip_directions.php'); ?>

<?php include('footer.php'); ?>
