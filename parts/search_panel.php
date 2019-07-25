<?php
$trip_id = get_the_ID();
//$terms = wp_get_post_terms($trip_id, 'conditions_region');
//$dest_id = $terms[0]->term_id;
//$region_code = get_field('kod_regionu_mds', 'conditions_region_'.$dest_id);
$region_code = '3:';

//$trp_depName = get_data('filters', array('filters' => 'trp_depName'));

$miejsca_wylotu = get_terms(array('taxonomy' => 'dep_codes', 'orderby' => 'slug', 'hide_empty' => false));

$tab = array();

$post_type = get_post_type();
if($post_type=='conditions') {
    $par_adt = (int)get_field('par_adt', $trip_id);
    $par_chd = (int)get_field('par_chd', $trip_id);
    $trp_depCode = (int)get_field('trp_depCode', $trip_id);
    if(!empty(get_field('trp_depDate', $trip_id))) {
        $trp_depDate = explode(':', get_field('trp_depDate', $trip_id));   
        $trp_depDateFrom = date('d.m.Y', strtotime($trp_depDate[0]));
        if(strtotime($trp_depDateFrom)<time()) $trp_depDateFrom = date('d.m.Y', strtotime('+2 day'));
        if(!empty($trp_depDate[1])) {
            $trp_depDateTo = date('d.m.Y', strtotime($trp_depDate[1]));
        }
        else {
            $trp_depDateTo = get_field('trp_retDate', $trip_id);   
        }
    }
    else {
        $trp_depDateFrom = date('d.m.Y', strtotime('+2 day'));   
        $trp_depDateTo = date('d.m.Y', strtotime('+32 day'));   
    }
    $ofr_xCatalog = (int)get_field('ofr_xCatalog', $trip_id);
    $obj_xServiceId = array(get_field('obj_xServiceId', $trip_id));
    $kierunek = explode(',', get_field('kierunek', $trip_id));
    $trp_depName = array();
    $dep_codes = wp_get_post_terms($trip_id, 'dep_codes');
    foreach($dep_codes as $dt) {
        $trp_depName[] = get_field('code', 'dep_codes_'.$dt->term_id);
    }
    
    $obj_type = array();
    $obj_types = wp_get_post_terms($trip_id, 'obj_type');
    foreach($obj_types as $ot) {
        $obj_type[] = get_field('code', 'obj_type_'.$ot->term_id);
    }
    
    $trp_depCode = (!empty($trp_depName)) ? $trp_depName[0] : '';
    
    $trp_depDate = $trp_depDateFrom.' - '.$trp_depDateTo;
    
    $mp = get_field('maxPrice', $trip_id); 
    $maxPrice = (!empty($mp)) ? $mp : 8000;
        
    $mp2 = get_field('minPrice', $trip_id); 
    $minPrice = (!empty($mp2)) ? $mp2 : 600;
    
    $trp_duration = get_field('trp_duration', $trip_id); 
    if(empty($trp_duration)) $trp_duration = '6:8';
    
    $ofr_type = array();
    $trp_types = wp_get_post_terms($trip_id, 'trp_type');
    foreach($trp_types as $dt) {
        $ofr_type[] = get_field('code', 'trp_type_'.$dt->term_id);
    }
    
    $ofr_tourOp = array();
    $conditions_tourops = wp_get_post_terms($trip_id, 'conditions_tourop');
    foreach($conditions_tourops as $dt) {
        $ofr_tourOp[] = strtoupper($dt->slug);
    }
    
    $trp_obj_type = $obj_type;
    
}
else {
    $par_adt = (int) get_query_var('par_adt', 2);
    $par_chd = (int) get_query_var('par_chd', 0);
    $trp_depCode = get_query_var('trp_depCode');
    $trp_depDate = urldecode(get_query_var('trp_depDate'));
    /*if(empty($trp_depDateFrom) || empty($trp_depDateTo)) {  
        $trp_depDateFrom = date('d.m.Y', strtotime('+2 day'));
        $trp_depDateTo =  date('d.m.Y', strtotime('+32 day'));
        $trp_depDate = $trp_depDateFrom.' - '.$trp_depDateTo;
    }
    else {*/
        $trp_depDateFrom = get_query_var('trp_depDateFrom');
        $trp_depDateTo = get_query_var('trp_depDateTo');
        $trp_depDate = $trp_depDateFrom.' - '.$trp_depDateTo;
    //}
    
    $ofr_xCatalog = get_query_var('ofr_xCatalog');
    $obj_xServiceId = (!empty(get_query_var('obj_xServiceId'))) ? explode(',', urldecode(get_query_var('obj_xServiceId'))) : array();
    $obj_xAttributes = (!empty(get_query_var('obj_xAttributes'))) ? explode(',', urldecode(get_query_var('obj_xAttributes'))) : array();
    //$ofr_tourOp = (!empty(get_query_var('ofr_tourOp'))) ? explode(',', urldecode(get_query_var('ofr_tourOp'))) : array();
    $kierunek = explode(',', get_query_var('trp_destination'));
    
    $mp = $maxPrice = get_query_var('maxPrice', 8000); 
        
    $mp2 = $minPrice = get_query_var('minPrice', 600); 
    
    $trp_duration = get_query_var('trp_duration', '6:8');   
    
    $ofr_type = get_query_var('ofr_type'); 
    
    $ofr_tourOp = explode(',', get_query_var('ofr_tourOp', 'ITAK,VNET,ECCO,ECTR,EXIM,SYLO,VMAT,NPL,RNBW,WEZY,GRCS,TUIZ')); 
    $trp_obj_type = explode(',', get_query_var('obj_type'));
    
    $city_names = get_query_var('cities'); 
   /* $mask = $ofr->obj->{'@attributes'}->xAttributes;
    $bin = decbin(hexdec($mask));
    
    
                                
    $expl =  array_filter(preg_split( '//', $bin ), 'strlen');
    $expl = array_reverse( $expl );
    foreach( $expl as $k => $binVal ) {
        if( $binVal == '1' ) {
                                        $attrs[] = pow( 2, $k );
                                    }
                                }*/
}

    if(!empty($kierunek)) {
       foreach($kierunek as $kier) {
            $tab[] = "'".$kier."'";
        }
        $trp_destination = join(',', $tab);
        
        $kraje = $wpdb->get_results( 
	"SELECT *
	FROM `wp_regions`
	WHERE active = 1 AND home = 1 AND kod_mds IN ({$trp_destination})
        ORDER BY name ASC"
);

if(!empty($kraje)) {
    $input_text = (count($kraje)>1) ? $kraje[0]->name.' (...)' : $kraje[0]->name;
}
    }
    
$wszystkie = $wpdb->get_results( 
	"
	SELECT *
	FROM `wp_regions`
	WHERE active = 1 AND home = 1
        ORDER BY name ASC"
);

$kraje = $wpdb->get_results( 
	"
	SELECT *
	FROM `wp_regions`
	WHERE active = 1 AND home = 1 AND parent = 0
        ORDER BY name ASC"
);    

$kraje_popularne = $wpdb->get_results( 
	"
	SELECT *
	FROM `wp_regions`
	WHERE active = 1 AND home = 1 AND parent = 0 AND most_popular = 1
        ORDER BY name ASC"
);    

$dest_tab = explode(',', $trp_destination);
foreach($dest_tab as $key=>$dd) {
    $dest_tab[$key] = str_replace("'", "", $dd);
}

$kierunki_nazwy = array();
foreach($kierunek as $kier) {
    $kierunki_nazwy[] = $wpdb->get_var( 
	"SELECT name
	FROM `wp_regions`
	WHERE kod_mds='".$kier."'"
);   
}
?>

<form id="search_form" action="<?=get_permalink(get_page_by_path('wyniki-wyszukiwania'));?>">
	<div class="col">
		<div class="input-hld input-hld-tripdirection">
			<input type="text" class="trip-direction click-input" value="<?=(!empty($input_text))?$input_text:'kierunek podróży';?>" readonly="readonly">

            <div class="trip-direction-container">
                <div class="trip-direction-container-top">
                    <input type="text" class="trips-input" placeholder="Wpisz kraj, region lub miejscowość" value="" data-href="<?php echo admin_url('admin-ajax.php'); ?>" />
                    <br/>
                    <ul class="actual-choice-list">
                    </ul>

                    <i class="icon-delete close-trip-direction-hld"></i>
                </div>

                <div class="destinations">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-xs-6 countries-col">
                            <!--<h3>Grupy kierunków</h3>

                            <label><input class="country wyspy" type="checkbox"> Wyspy Kanaryjskie</label>
                            <label><input class="country bez_paszportu" type="checkbox"> Bez paszportu</label>
                            <label><input class="country egzotyka" type="checkbox"> Egzotyka</label>
                            -->
                            <h3>Najpopularniejsze</h3>

                            <?php foreach($kraje_popularne as $kraj) {?>
                            <label><input class="country" type="checkbox" value="<?=$kraj->kod_mds;?>" data-country-name="<?=$kraj->name;?>" <?=(in_array($kraj->kod_mds, $dest_tab))?'checked':'';?>> <?=$kraj->name;?></label>
                            <?php }?>

                            <h3>Alfabetycznie</h3>
                            <?php foreach($kraje as $kraj) {?>
                            <label><input class="country" type="checkbox" value="<?=$kraj->kod_mds;?>" data-country-name="<?=$kraj->name;?>" <?=(in_array($kraj->kod_mds, $dest_tab))?'checked':'';?>> <?=$kraj->name;?></label>
                            <?php }?>
                        </div>

                        <div class="col-lg-6 col-md-6 col-xs-6 regions-col">
                            <h3>Kraje, regiony</h3>

                            <ul class="regions-list" data-href="<?php echo admin_url('admin-ajax.php'); ?>">
                                
                            </ul>                                
                        </div>
                    </div>

                    <div class="destinations-search">
                        
                    </div>
                </div>

                <div class="trip-direction-container-bottom">
                    <span class="span-button span-button--del">Usuń wszystkie</span>
                    <span class="span-button span-button--add">Zaznacz wszystkie</span>

                    <span class="btn btn--choose">Wybierz</span>
                </div>
            </div>
		</div>
	</div>

	<div class="col">
        <div class="input-hld trp_depCode">
            <select name="trp_depCode" class="mobile-preventd">
                <option value="">miejsce wylotu</option>
                <?php
                foreach($miejsca_wylotu as $mw) {
                    $code = get_field('code', 'dep_codes_'.$mw->term_id);?>
                    <option value="<?=$code;?>" <?=(!empty($trp_depCode) && $code==$trp_depCode)?'selected':'';?>><?=$mw->name;?></option>
                <?php }?>
            </select>
        </div>
	</div>

	<div class="col">
		<div class="input-hld">
        	<input type="text" name="trp_depDateFrom" class="data-wyjazdu mobile-preventd click-input" placeholder="data wyjazdu" value="<?=!empty($trp_depDateFrom)?$trp_depDateFrom:'data wyjazdu';?>" readonly="readonly" required />
		</div>
    </div>
    <div class="col">
        <div class="input-hld">
            <input type="text" name="trp_depDateTo" class="data-powrotu mobile-preventd click-input" placeholder="data powrotu" value="<?=!empty($trp_depDateTo)?$trp_depDateTo:'data powrotu';?>" readonly="readonly" required />
        </div>
	</div>
    
    <?php /*
	<div class="col">
		<div class="input-hld">
			<input type="text" class="data-powrotu click-input" placeholder="data powrotu" value="<?=!empty($trp_depDateTo)?$trp_depDateTo:'';?>" name="trp_depDateTo" />
		</div>
	</div> */ ?>

    <div class="col">
        <div class="input-hld">
            <select class="small mobile-preventd" name="par_adt">
                <option value="0">dorośli</option>
                <option value="1" <?=($par_adt==1)?'selected':'';?>>1</option>
                <option value="2" <?=(empty($par_adt) || $par_adt==2)?'selected':'';?>>2</option>
                <option value="3" <?=($par_adt==3)?'selected':'';?>>3</option>
                <option value="4" <?=($par_adt==4)?'selected':'';?>>4</option>
                <option value="5" <?=($par_adt==5)?'selected':'';?>>5</option>
            </select>
        </div>
    </div>

    <div class="col">
        <div class="input-hld">
            <select class="small mobile-preventd" name="par_chd">
                <option value="0">dzieci</option>
                <option value="1" <?=($par_chd==1)?'selected':'';?>>1</option>
                <option value="2" <?=($par_chd==2)?'selected':'';?>>2</option>
                <option value="3" <?=($par_chd==3)?'selected':'';?>>3</option>
                <option value="4" <?=($par_chd==4)?'selected':'';?>>4</option>
                <option value="5" <?=($par_chd==5)?'selected':'';?>>5</option>
            </select>
        </div>
    </div>
    
    <?php /*
    <div class="col col--checkbox">
        <label class="checkbox-label"><input type="checkbox" name="ofr_xCatalog" value="LAST" <?=(!empty($ofr_xCatalog) && $ofr_xCatalog=='LAST')?'checked':'';?> /> Last minute</label>
    </div>*/ ?>

    <div class="col">
        <label class="checkbox-label"><input type="checkbox" id="all_inclusive1" value="1" <?=(isset($obj_xServiceId) && in_array(1, $obj_xServiceId))?'checked':'';?> /> All inclusive</label>
    </div>

    <button class="btn btn--white submit">Szukaj</button>

	<div class="row row--advanced-search" <?php if(!empty($_GET['advanced'])) echo "style='display: block;';";?>>
		<div class="search-panel-advanced-inner">
            <div class="col-adv col-lg-4 col-md-6">
                <p class="p-label">Cena za osobę</p>
                 
                <div id="slider-range"></div>
                <p>
                  <input type="text" id="amount" readonly>
                  <input type="hidden" id="slider-min" value="600" />
                  <input type="hidden" id="slider-max" value="8000" />
                  <input type="hidden" id="values-min" value="<?=$minPrice;?>" />
                  <input type="hidden" id="values-max" value="<?=$maxPrice;?>" />
                </p>
            </div>

            <div class="col-adv col-lg-4 col-md-6">
		<p class="p-label">Dojazd</p>
                <div class="input-hld">
                    <select id="trpType" class="mobile-preventd">
                        <?php $terms = get_terms('trp_type', array('hide_empty' => false));
                        foreach($terms as $term) {
                            $code = get_field('code', 'trp_type_'.$term->term_id);
                            ?>
                            <option name="trpType" value="<?=$code;?>" <?=(isset($ofr_type) && in_array($code, $ofr_type))?'selected':'';?>><?=$term->name;?></option>
                            <?php /*
                            <label class="advanced-label"><input type="checkbox" name="ofr_type[]" value="<?=$code;?>" <?=(isset($_GET['ofr_type']) && in_array($code, $_GET['ofr_type']))?'checked':'';?> /> <?=$term->name;?></label> */ ?>
                            <?php
                        }?>
                    </select>
                </div>
            </div>

			<div class="col-adv col-lg-4 col-md-6">
				<p class="p-label">Wyżywienie</p>
                <div class="input-hld">
                    <select multiple placeholder="Wybierz wyżywienie" id="xServiceId" class="mobile-preventd">
                    <?php $terms = get_terms('conditions_service', array('hide_empty' => false));
                    foreach($terms as $term) {
                        $code = (int)get_field('code', 'conditions_service_'.$term->term_id);
                        ?>
                        <option value="<?=$code;?>" <?=($code==1)?"id='all_inclusive2'":'';?>value="<?=$code;?>" <?=(isset($obj_xServiceId) && in_array($code, $obj_xServiceId))?'selected':'';?>><?=$term->name;?></option>
                        <?php /*
                        <label class="advanced-label"><input type="checkbox" name="obj_xServiceId[]" <?=($code==1)?"id='all_inclusive2'":'';?>value="<?=$code;?>" <?=(isset($_GET['obj_xServiceId']) && in_array($code, $_GET['obj_xServiceId']))?'checked':'';?> /> <?=$term->name;?></label> */ ?>
                        <?php
                    }?>
                    </select>
                </div>
			</div>

            <?php $obj_category_tab = (!empty($_GET['obj_category'])) ? explode(':', $_GET['obj_category']) : array(10,50);?>
            <div class="col-adv col-lg-4 col-md-6">
                <p class="p-label">Kategoria hotelu</p>
                <p style="float:left; margin-top: 22px;">
                    <i class="icon-star star11"></i>
                    <i class="icon-star-normal star12"></i>
                    <i class="icon-star-normal star13"></i>
                    <i class="icon-star-normal star14"></i>
                    <i class="icon-star-normal star15"></i>
                </p>
                <p style="float: right; margin-top: 22px;">
                    <i class="icon-star star21"></i>
                    <i class="icon-star star22"></i>
                    <i class="icon-star star23"></i>
                    <i class="icon-star star24"></i>
                    <i class="icon-star star25"></i>
                </p>
                <div id="slider-stars" data-min="<?=$obj_category_tab[0];?>" data-max="<?=$obj_category_tab[1];?>"></div>
                <input type="hidden" id="stars-values-min" value="<?=(!empty($obj_category_tab[0]))?$obj_category_tab[0]:10;?>" />
                <input type="hidden" id="stars-values-max" value="<?=(!empty($obj_category_tab[1]))?$obj_category_tab[1]:50;?>" />
            </div>

            <div class="col-adv col-lg-4 col-md-6">
                <p class="p-label">Zakwaterowanie</p>
                
                <div class="input-hld">
                    <select name="obj_type" class="mobile-preventd">
                        <option value="H" <?=(isset($trp_obj_type) && in_array('H', $trp_obj_type))?'selected':'';?>>hotel</option>
                        <option value="R" <?=(isset($trp_obj_type) && in_array('R', $trp_obj_type))?'selected':'';?>>wycieczka objazdowa</option>
                    </select>
                </div>
                <?php /*
                <label class="advanced-label"><input type="checkbox" name="obj_type[]" value="H,AP" <?=(isset($_GET['obj_type']) && in_array('H,AP', $_GET['obj_type']))?'checked':'';?> /> hotel</label>
                <label class="advanced-label"><input type="checkbox" name="obj_type[]" value="R,AT" <?=(isset($_GET['obj_type']) && in_array('R,AT', $_GET['obj_type']))?'checked':'';?> /> wycieczka objazdowa</label>
                */ ?>
            </div>

			<div class="col-adv col-lg-4 col-md-6">
				<p class="p-label">Organizator</p>
                <div class="input-hld input-hld--organizer">
                    <span class="icon-delete close-select-organizer"></span>
                    
                    <div class="select-organizer" id="tourOp" class="mobile-preventd"> Wybierz organizatorów
                        <ul>
                        <?php $terms = get_terms('conditions_tourop', array('hide_empty' => true));
                        foreach($terms as $term) {
                            $code = strtoupper($term->slug);
                            ?>
                            <label class="checkbox">
                                <input type="checkbox" value="<?=$code;?>" <?=(isset($ofr_tourOp) && in_array($code, $ofr_tourOp))?'checked':'';?>>
                                <span class="label-txt"><?=$term->name;?></span>
                            </label>
                            <?php /*
                            <label class="advanced-label"><input type="checkbox" name="ofr_tourOp[]" value="<?=$code;?>" <?=(isset($_GET['ofr_tourOp']) && in_array($code, $_GET['ofr_tourOp']))?'checked':'';?> /> <?=$term->name;?></label> */ ?>
                            <?php
                        }?>
                        </ul>
                    </div>
                </div>
			</div>
			
			<div class="col-adv col-lg-4 col-md-6">
				<p class="p-label">Udogodnienia</p>
                <div class="input-hld">
                    <select multiple placeholder="Wybierz udogodnienia" id="xAttributes" class="mobile-preventd">
                    <?php $terms = get_terms('conditions_option', array('hide_empty' => false));
                    foreach($terms as $term) {
                        $code = (int)get_field('code', 'conditions_option_'.$term->term_id);
                        ?>
                        <option value="<?=$code;?>" <?=(isset($obj_xAttributes) && in_array($code, $obj_xAttributes))?'selected':'';?>><?=$term->name;?></option>
                        <?php /*
                        <label class="advanced-label"><input type="checkbox" name="obj_xAttributes[]" value="<?=$code;?>" <?=(isset($_GET['obj_xAttributes']) && in_array($code, $_GET['obj_xAttributes']))?'checked':'';?> /> <?=$term->name;?></label> */ ?>
                        <?php
                    }?>
                    </select>
                </div>
			</div>

            <div class="col-adv col-lg-4 col-md-6">
                <p class="p-label">Długość pobytu</p>
                    
                <div class="input-hld">
                    <select id="duration" class="mobile-preventd">
                        <option name="trp_duration" value="0" <?=(empty($trp_duration))?'selected':'';?>>Dowolna długość</option>
                        <option name="trp_duration" value="6:8" <?=(!isset($trp_duration) || $_GET['trp_duration']=='6:8')?'selected':'';?>>6-8 dni</option>
                        <option name="trp_duration" value="9:13" <?=($trp_duration=='9:13')?'selected':'';?>>9-13 dni</option>
                        <option name="trp_duration" value="14:" <?=($trp_duration=='14:')?'selected':'';?>>14 i więcej dni</option>
                    </select>
                </div>
                
                <?php /*
                <label class="advanced-label"><input type="radio" name="iCheck" name="trp_duration" value="0" <?=(empty($_GET['trp_duration']))?'checked':'';?> /> Dowolna długość</label>
                <label class="advanced-label"><input type="radio" name="iCheck" name="trp_duration" value="6:8" <?=(!isset($_GET['trp_duration']) || $_GET['trp_duration']=='6:8')?'checked':'';?> /> 6-8 dni</label>
                <label class="advanced-label"><input type="radio" name="iCheck" name="trp_duration" value="9:13" <?=($_GET['trp_duration']=='9:13')?'checked':'';?> /> 9-13 dni</label>
                <label class="advanced-label"><input type="radio" name="iCheck" name="trp_duration" value="14:" <?=($_GET['trp_duration']=='14:')?'checked':'';?> /> 14 i więcej dni</label>
                */ ?>
            </div>
		</div>
	</div>
    <?php
    if(!empty($kierunki_nazwy) || !empty($cities_names) || !empty($hotels_names)) {
        $all_checked = join(',',$kierunki_nazwy).','.$cities_names.','.$hotels_names;
    }
    else {
        $all_checked = '';      
    }?>
    <input type="hidden" id="trp_destination" name="trp_destination" value="<?=str_replace("'", "", $trp_destination);?>" />
    <input type="hidden" id="obj_category" name="obj_category" value="<?=(!empty($obj_category_tab[0]))?$obj_category_tab[0]:10;?>:<?=(!empty($obj_category_tab[1]))?$obj_category_tab[1]:50;?>" />
    <input type="hidden" id="obj_xAttributes" name="obj_xAttributes" value="<?=(!empty($obj_xAttributes)) ? join(',', $obj_xAttributes) : '';?>" />
    <input type="hidden" id="ofr_tourOp" name="ofr_tourOp" value="<?=(!empty($ofr_tourOp)) ? join(',', $ofr_tourOp) : '';?>" />
    <input type="hidden" id="obj_xServiceId" name="obj_xServiceId" value="<?=(!empty($obj_xServiceId)) ? join(',', $obj_xServiceId) : '';?>" /> 
    <input type="hidden" id="ofr_type" name="ofr_type[]" value="<?=(!empty($ofr_type)) ? join(',',$ofr_type) : 'F';?>" />  
    <input type="hidden" id="minPrice" name="minPrice" value="<?=$minPrice;?>" />
    <input type="hidden" id="maxPrice" name="maxPrice" value="<?=$maxPrice;?>" />
    <input type="hidden" id="advanced" name="advanced" value="0" />
    <input type="hidden" id="all_checked" value="<?=$all_checked;?>" />
    <input type="hidden" id="trp_duration" name="trp_duration" value="<?=str_replace("'", "", $trp_duration);?>" />
    <input type="hidden" id="cities" name="cities_names" value="<?=$cities_names;?>" />
    <input type="hidden" id="hotels" name="hotels_names" value="<?=$hotels_names;?>" />
    <input type="hidden" id="regions" value="<?=str_replace("'", "", $trp_destination);?>" />
</form>