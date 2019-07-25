<?php  
    /* Template Name: Podstrona szczegółu oferty */
?> 

<?php include('header.php'); 
$par_adt = (int) get_query_var('par_adt', 2);
$par_chd = (int) get_query_var('par_chd', 0);
$data = get_data('details', array('ofr_id' => get_query_var('oferta'), 'ofr_TFGincluded' => 1));
$ofr = $data->ofr;
$data_price = get_data('details', array('ofr_id' => get_query_var('oferta'), 'par_adt' => $par_adt, 'par_chd' => $par_chd, 'totalPrice' => 1));

$offers = $offers_pom = array();
$conditions = array( 
   // 'trp_duration' => $ofr->trp->{'@attributes'}->duration, 
   // 'ofr_xCatalog' => $ofr->{'@attributes'}->xCatalog, 
    'trp_depDate' => $ofr->trp->{'@attributes'}->depDate,
    'trp_retDate' => $ofr->trp->{'@attributes'}->rDepDate, 
    'ofr_type' => $ofr->{'@attributes'}->type, 
    'ofr_tourOp' => $ofr->{'@attributes'}->tourOp, 
    'obj_xCode' => $ofr->obj->{'@attributes'}->xCode,
    'obj_code' => $ofr->obj->{'@attributes'}->code,
   // 'obj_xServiceId' => $ofr->obj->{'@attributes'}->xServiceId,
    'ofr_xStatus' => 'A',
    'limit_count' => 10,
    'extraData' => 'hotelsExtra',
    'trp_depCode' => $ofr->trp->{'@attributes'}->depCode    
);  

$conditions2 = array('ofr_id' => get_query_var('oferta'), 'par_adt' => $par_adt);
$data_pr = get_data('details', $conditions2, 'ofr_price,ofr_TFGIncluded');
$tfg = $data_pr->ofr->{'@attributes'}->TFGIncluded;

$terms = get_terms('conditions_tourop', array('hide_empty' => false));
foreach($terms as $term) {
    //$code = trim(get_field('code', 'conditions_tourop_'.$term->term_id));
    $code = $term->slug;
    if(strtolower($code) == strtolower(trim($data->ofr->{'@attributes'}->tourOp))) {
        $tourOperator = $term;
        continue;
    }
}
   
$country_slug = sanitize_title($ofr->obj->{'@attributes'}->country);
$region_slug = sanitize_title($ofr->obj->{'@attributes'}->region);
$country_term = get_term_by('slug', $country_slug, 'regions_countries');
$reg_post = get_posts(array('name' => $region_slug, 'post_type' => 'regions', 'posts_per_page' => -1, 'offset' => 0, 'category' => $country_term->term_id));

$przewodnik = get_field('field_5a9b2766be990', $reg_post[0]->ID);
if(empty($przewodnik))
    $przewodnik = get_field('field_5a9b2766be990', 'regions_countries_'.$country_term->term_id);

$przewodnik_post = get_page_by_path( str_replace(array(get_site_url(), '/przewodnik'), '', $przewodnik), 'OBJECT', 'guides' );

$wycieczki = get_field('field_5a9b2783be991', $reg_post[0]->ID);
if(empty($wycieczki))
    $wycieczki = get_field('field_5a9b2783be991', 'regions_countries_'.$country_term->term_id);

$informacje = get_field('field_5a9b27b5be994', $reg_post[0]->ID);
if(empty($informacje))
    $informacje = get_field('field_5a9b27b5be994', 'regions_countries_'.$country_term->term_id);

$services_name = array();
$terms = get_terms('conditions_service', array('hide_empty' => false));
foreach($terms as $term) {
    $code = (int)get_field('code', 'conditions_service_'.$term->term_id);
    $services_names[$code] = $term->name;
}

$conditions['par_adt'] = (int)$par_adt;
if($par_chd>0) $conditions['par_chd'] = (int)$par_chd;
$data2 = get_data('offers', $conditions);

$maxAdults = $maxPax = array();

if(!empty($data2) && $data2->count>0) {
    if($data2->count==1) $data2->ofr = array($data2->ofr);
    $xServiceId = $xRoomTypes = $depDesc = array();
    foreach($data2->ofr as $dt) {
        if($dt->{'@attributes'}->id==get_query_var('oferta')) {
            $xRoomTypes[] = $dt->obj->{'@attributes'}->xRoomDesc;
            $offers[$dt->{'@attributes'}->id] = $dt->obj->{'@attributes'}->roomDesc;
            $depDesc[$dt->{'@attributes'}->id] = $dt->trp->{'@attributes'}->depName;
        }
    }
    foreach($data2->ofr as $dt) {
        if(!in_array($dt->obj->{'@attributes'}->xRoomDesc, $xRoomTypes)) {
            $xRoomTypes[] = $dt->obj->{'@attributes'}->xRoomDesc;
            $offers[$dt->{'@attributes'}->id] = ucfirst($dt->obj->{'@attributes'}->roomDesc);   
        } 
        if(!in_array($dt->obj->{'@attributes'}->xServiceId, $xServiceId)) {
            $xServiceId[] = $dt->obj->{'@attributes'}->xServiceId;      
            if(!empty($services_names[$dt->obj->{'@attributes'}->xServiceId])) {
                $services[$dt->{'@attributes'}->id] = $services_names[$dt->obj->{'@attributes'}->xServiceId];   
            }
        } 
        if(!in_array($dt->trp->{'@attributes'}->depName, $depDesc)) {
            if(!empty($dt->trp->{'@attributes'}->depName)) {
                $depDesc[$dt->{'@attributes'}->id] = $dt->trp->{'@attributes'}->depName;
            }
        }
        
        $maxAdults[] = $dt->obj->{'@attributes'}->maxAdt;
        $maxPax[] = $dt->obj->{'@attributes'}->maxPax;
    }
}

if(!empty($maxAdults)) {
    $maxAdt = max($maxAdults);
}
if(!empty($maxPax)) {
    $mPax = max($maxPax);
    $maxChildren = $mPax - $par_adt;
}

$service = explode(',', $dt->obj->{'@attributes'}->xServiceId);
$dep = $ofr->trp->{'@attributes'}->depName;

$images = get_attributes($ofr->{'@attributes'}->id, $ofr->obj->{'@attributes'}->xCode, $ofr->obj->{'@attributes'}->code, $ofr->{'@attributes'}->tourOp, 'image', true);
$texts = get_attributes($ofr->{'@attributes'}->id, $ofr->obj->{'@attributes'}->xCode, $ofr->obj->{'@attributes'}->code, $ofr->{'@attributes'}->tourOp, 'text');   
if(!empty($texts)) {
    foreach($texts as $key=>$text) {
            if($key=='Kategoria') $kategoria = ucfirst(trim(strip_tags($text)));
            if($key=='Region') $region = ucfirst(trim(strip_tags($text)));
            if($key=='Położenie') {
                $polozenie_tab = multiexplode(array('.', ','), str_replace('ok. ', 'ok_ ', strip_tags($text)));
            }
            if($key=='Plaża') $plaza = ucfirst(trim(strip_tags($text)));
            if($key=='Wyposażenie') $wyposazenie = ucfirst(trim(strip_tags($text)));
            if($key=='Dostęp do internetu') $internet = ucfirst(trim(strip_tags($text)));
            if($key=='Kategoria lokalna') $kat_lokalna = ucfirst(trim(strip_tags($text)));
            if($key=='Zakwaterowanie') $zakwaterowanie = ucfirst(trim(strip_tags($text)));
            if($key=='Wyżywienie') $wyzywienie = ucfirst(trim(strip_tags($text)));
            if($key=='Sport') $sport = ucfirst(trim(strip_tags($text)));
    }
}

$cat = (int)$ofr->obj->{'@attributes'}->category;

$sum = $ofr->{'@attributes'}->price*(int)get_query_var('par_adt', 2) + $ofr->{'@attributes'}->price*(int)get_query_var('par_chd', 0)*0.5;
?>

<div class="main-content main-content--details">
	<div class="container">
            <?php if(!empty($_GET['msg'])) {?>
                <div class="msg"><?=$_GET['msg'];?></div>
            <?php }?>
		<?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
		
		<div class="row">
			<div class="col-lg-7">
				<div class="details-head">
		            <h1><?=$ofr->obj->{'@attributes'}->name;?></h1>
					<span class="rating">
		                <i class="icon-star<?=($cat >= 10)?'':'-normal';?>"></i>
		                <i class="icon-star<?=($cat >= 20)?'':'-normal';?>"></i>
		                <i class="icon-star<?=($cat >= 30)?'':'-normal';?>"></i>
		                <i class="icon-star<?=($cat >= 40)?'':'-normal';?>"></i>
		                <i class="icon-star<?=($cat >= 50)?'':'-normal';?>"></i>
		            </span><br/>

					<h3><?=$ofr->obj->{'@attributes'}->country;?>, <?=$ofr->obj->{'@attributes'}->region;?></h3>
				</div>
			</div>

			<div class="col-lg-5">
				<div class="hotel-rating">
					<div class="hotel-rating-left">
						<h3>Ocena hotelu</h3>

						<?=get_rating($ofr->obj->{'@attributes'}->rating);?>/<span>10</span>
					</div>

					<a class="zoover" href="http://www.zoover.pl/" target="_blank"><img src="<?php echo get_template_directory_uri(); ?>/img/logo-zoover.svg" alt="Zoover"></a>
				</div>

				<div class="hanging-hld">
	                <input type="hidden" id="offer_id" value="<?=get_query_var('oferta');?>" />
                        <?php
                        //sprawdzanie czy jest w schowku
                        global $wpdb;
                        $oferta = get_query_var('oferta');
                        $qry = "SELECT ho.offer_id FROM wp_hanging h
                                JOIN wp_hanging_offers ho ON h.id = ho.hanging_id
                                WHERE h.code='{$_COOKIE['hanging_code']}' AND ho.offer_id='{$oferta}'";
                        $results = $wpdb->get_results( $qry );
                        if(empty($results)) {?>
					<div class="hanging-btn-hld"><a href="<?php echo admin_url('admin-ajax.php'); ?>" id="add_to_hanging" class="add_to_hanging add-to-hanging" data-offer-id="<?=get_query_var('oferta');?>"><i class="icon-like"></i> Dodaj do ulubionych</a></div>
                        <?php }
                        else {?>
                               <div class="hanging-btn-hld"><a href="<?php echo admin_url('admin-ajax.php'); ?>" class="remove-from-hanging" data-offer-id="<?=get_query_var('oferta');?>">Usuń z ulubionych</a></div>
                        <?php }?>
                                </div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-7 col-md-12" id="banner_container" 
                             data-href="<?php echo admin_url('admin-ajax.php'); ?>" 
                             data-code="<?=$ofr->obj->{'@attributes'}->code;?>" 
                             data-xcode="<?=$ofr->obj->{'@attributes'}->xCode;?>"
                             data-tourop="<?=$ofr->{'@attributes'}->tourOp;?>">
				<?php include('parts/single_main_banner.php'); ?>

				<div class="details-main-content">
					<div class="tabs">
						<ul class="details-content-nav tab-nav">
							<li class="active"><a href="#o-hotelu">Hotel</a></li>
							<?php /*
							<li><a href="#opinie">Opinie</a></li>
	                        <?php if(!empty($ofr->obj->{'@attributes'}->xLat) && $ofr->obj->{'@attributes'}->xLat!=200 && !empty($ofr->obj->{'@attributes'}->xLong) && $ofr->obj->{'@attributes'}->xLong!=200) {?>
                        	*/ ?>
                        	<?php {?>
							<li><a href="#mapa">Mapa</a></li>
	                        <?php }?>
	                        <?php if(!empty($przewodnik_post)) {?>
							<li><a href="#przewodnik">Przewodnik</a></li>
	                        <?php }?>
	                        <?php if(!empty($wycieczki)) {?>
							<li><a href="#wycieczki">Wycieczki fakultatywne</a></li>
	                        <?php }?>
	                        <?php if(!empty($informacje)) {?>
							<li><a href="#informacje">Przydatne informacje</a></li>
							<?php }?>
							<li><a href="#udogodnienia">Udogodnienia</a></li>
						</ul>

						<div class="tab-container">
							<div class="tab-content o-hotelu">
                                                                <?php
                                                                $args=array(
                                                                    'name'           => $ofr->obj->{'@attributes'}->xCode,
                                                                    'post_type'      => 'hotels',
                                                                    'post_status'    => 'publish',
                                                                    'posts_per_page' => 1
                                                                );
                                                                $my_posts = get_posts( $args );
                                                                $hotel_id = $my_posts[0]->ID;
                                                                $content = get_the_content();
                                                                if(!empty($content)) {?>
                                                                <table>
                                                                    <tr><td>
                                                                <?php
                                                                $content = preg_replace("/<br\W*?\/><br\W*?\/>/", "</td></tr><tr><td>", $content);
                                                                echo str_replace(array('|||'), 
                                                                        array('</td><td>'), $content);
                                                                ?>
                                                                        </td></tr>
                                                                </table>
                                                                <?php }
                                                                else {
                                                                ?>
                                                                
                                 				<table>
									<?php if(get_field('kategoria', $hotel_id)) {?>
									<tr>
										<td>Kategoria</td>
										<td><?php the_field('kategoria', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('region')) {?>
									<tr>
										<td>Region</td>
										<td><?php the_field('region'); ?></td>
									</tr>
									<?php }?>
										
									<?php if(get_field('zakwaterowanie', $hotel_id)) {?>
									<tr>
										<td>Zakwaterowanie</td>
										<td><?php the_field('zakwaterowanie', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('polozenie', $hotel_id)) {?>
									<tr>
										<td>Położenie</td>
										<td>
											<?php the_field('polozenie', $hotel_id); ?>
										</td>
									</tr>
									<?php }?>

									<?php if(get_field('wyposazenie', $hotel_id)) {?>
									<tr>
										<td>Wyposażenie</td>
										<td><?php the_field('wyposazenie', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('kategoria_lokalna', $hotel_id)) {?>
									<tr>
										<td>Kategoria lokalna</td>
										<td><?php the_field('kategoria_lokalna', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('wyzywienie', $hotel_id)) {?>
									<tr>
										<td>Wyżywienie</td>
										<td><?php the_field('wyzywienie', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('sport', $hotel_id)) {?>
									<tr>
										<td>Sport</td>
										<td><?php the_field('sport', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('restauracje_i_bary', $hotel_id)) {?>
									<tr>
										<td>Restauracje i Bary</td>
										<td><?php the_field('restauracje_i_bary', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('bagaz', $hotel_id)) {?>
									<tr>
										<td>Bagaż</td>
										<td><?php the_field('bagaz', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('dodatkowe_informacje', $hotel_id)) {?>
									<tr>
										<td>Dodatkowe informacje</td>
										<td><?php the_field('dodatkowe_informacje', $hotel_id); ?></td>
									</tr>
									<?php }?>

									<?php if(get_field('pozostale_informacje', $hotel_id)) {?>
									<tr>
										<td>Pozostałe informacje</td>
										<td><?php the_field('pozostale_informacje', $hotel_id); ?></td>
									</tr>
									<?php }?>
								</table>
                                                                <?php } ?>
							</div>
							
							<div class="tab-content mapa">
								<iframe
		                            width="100%"
		                            height="600"
		                            frameborder="0" style="border:0"
		                            src="https://maps.google.com/maps?q=<?=$ofr->obj->{'@attributes'}->xLat;?>,<?=$ofr->obj->{'@attributes'}->xLong;?>&z=18&amp;output=embed&amp;maptype=satellite" allowfullscreen>
		                          </iframe>
							</div>

							<div class="tab-content przewodnik">
								<?=$przewodnik_post->post_content;?>
							</div>

							<div class="tab-content wycieczki">
								<?=$wycieczki;?>
							</div>

							<div class="tab-content informacje">
								<?=$informacje;?>
							</div>

							<div class="tab-content udogodnienia">
								<div class="facilities-hld">
									<ul>
			                        <?php 
			                        $mask = $ofr->obj->{'@attributes'}->xAttributes;
			                        $bin = decbin(hexdec($mask));
			                        
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

												$anClass = str_replace(' ', '-', $an); // Replaces all spaces with hyphens.
												$anClass = preg_replace('/[^A-Za-z0-9\-]/', '', $anClass); // Removes special chars.
												$anClass = strtolower($anClass); // Convert to lowercase

			                                    echo '<li><span class="'.$anClass.'">'.$an.'</span>';
			                                }
			                            }
			                        }
			                        ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="search-panel-small-hld">
				<div class="search-panel-small">
					<div class="search-panel-small-inner">
						<h2 class="bordered">Sprawdź cenę wycieczki</h2>

						<form id="offer_preview" action="<?php echo admin_url('admin-ajax.php'); ?>">
		                    <input type="hidden" name="ofr_id" id="ofr_id" value="<?=$ofr->{'@attributes'}->id;?>" />
		                    <input type="hidden" name="trp_duration" id="trp_duration" value="<?=$ofr->trp->{'@attributes'}->duration;?>" />
		                    <input type="hidden" name="trp_depDate" id="trp_depDate" value="<?=$ofr->trp->{'@attributes'}->depDate;?>" />
		                    <input type="hidden" name="ofr_type" id="ofr_type" value="<?=$ofr->{'@attributes'}->type;?>" />
		                    <input type="hidden" name="ofr_tourOp" id="ofr_tourOp" value="<?=$ofr->{'@attributes'}->tourOp;?>" />
		                    <input type="hidden" name="obj_xCode" id="obj_xCode" value="<?=$ofr->obj->{'@attributes'}->xCode;?>" />
		                    <input type="hidden" name="obj_code" id="obj_code" value="<?=$ofr->obj->{'@attributes'}->code;?>" />
		                    <input type="hidden" name="ofr_xStatus" id="ofr_xStatus" value="A" />

							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Dorośli:</span>
								</div>

								<div class="col-lg-8 col-md-12">
									<div class="input-hld">
										<select name="par_adt" id="par_adt" class="mobile-preventd">
		                                    <?php for($i=1;$i<=$maxAdt;$i++) {?>
											<option value="<?=$i;?>" <?=($par_adt===$i)?'selected':'';?>><?=$i;?></option>
		                                    <?php }?>
										</select>
									</div>
								</div>
							</div>
							
							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Dzieci:</span>
								</div>

								<div class="col-lg-8 col-md-12">
									<div class="input-hld">
										<select name="par_chd" id="par_chd" class="mobile-preventd">
		                                    <option value="0" <?=($par_chd===0)?'selected':'';?>>0</option>
											<?php for($i=1;$i<=$maxChildren;$i++) {?>
											<option value="<?=$i;?>" <?=($par_chd===$i)?'selected':'';?>><?=$i;?></option>
		                                    <?php }?>
										</select>
									</div>
								</div>
		                        <?php if($par_chd>0) {
	                            $par_chdAge = explode(',', $_GET['par_chdAge']);
	                            for($x=1;$x<=$par_chd;$x++) {?>
		                        <div class="col-lg-8 col-md-12 offset-lg-4">
									<span class="input-hld-span input-hld-span--children">Wiek dziecka:</span>
									<div class="input-hld">
		                                <input type="text" class="par_chdAge wiek-dziecka" name="par_chdAge[]" id="par_chdAge<?=$x;?>" value="<?=date('d.m.Y', strtotime($par_chdAge[$x-1]));?>"/>
									</div>
								</div>
		                        <?php }}?>
							</div>

							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Data wycieczki:</span>
								</div>
								<div class="col-lg-8 col-md-12">
									<div class="input-hld input-hld--disabled input-hld--date">
										<?php /* <input type="text" name="data-wyjazdu-powrotu-input" id="data-wyjazdu-powrotu-input" class="data-wyjazdu-powrotu-sec" value="<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->depDate));?> - <?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDepDate));?>" disabled> */ ?>
										<input type="text" class="data-wyjazdu-powrotu-sec" placeholder="data wyjazdu" value="<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->depDate));?>" name="trp_depDateFrom" disabled />
									</div> -
 
									<div class="input-hld input-hld--disabled input-hld--date">
										<?php /* <input type="text" name="data-wyjazdu-powrotu-input" id="data-wyjazdu-powrotu-input" class="data-wyjazdu-powrotu-sec" value="<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->depDate));?> - <?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDepDate));?>" disabled> */ ?>
										<input type="text" class="data-wyjazdu-powrotu-sec" placeholder="data powrotu" value="<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDepDate));?>" name="trp_depDateTo" disabled />
									</div>

									<a href="#" class="more-dates">więcej terminów</a>
								</div>
							</div>

							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Typ pokoju:</span>
								</div>
								<div class="col-lg-8 col-md-12">
									<div class="input-hld">
										<select name="room" id="room" class="mobile-preventd">
		                                    <?php
		                                    foreach($offers as $key=>$offer) {?>
		                                    <option value="<?=$key;?>" <?=($key==get_query_var('oferta'))?'selected':'';?>><?=$offer;?></option>
		                                    <?php }?>
										</select>
									</div>
								</div>
							</div>
		                    <?php if($ofr->{'@attributes'}->type=='F'&&!empty($depDesc)) {?>
							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Miejsce wylotu:</span>
								</div>
								<div class="col-lg-8 col-md-12">
									<div class="input-hld">
										<select name="dep" id="dep" class="mobile-preventd">
											<?php
		                                    foreach($depDesc as $key=>$offer) {?>
		                                    <option value="<?=$key;?>" <?=($key==get_query_var('oferta'))?'selected':'';?>><?=$offer;?></option>
		                                    <?php }?>
										</select>
									</div>
								</div>
								<div class="col-lg-8 col-md-12 offset-lg-4">
									<div class="city-hld">
										<span class="span-city"><span><?=$ofr->trp->{'@attributes'}->depName;?>:</span> <?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->depDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->depTime));?></span>
										<span class="span-city"><span><?=$ofr->trp->{'@attributes'}->desDesc;?>:</span> <?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->desDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->arrTime));?></span>
									</div>
									
									<div class="city-hld">
										<span class="span-city"><span><?=$ofr->trp->{'@attributes'}->desDesc;?>:</span> <?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDepDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->rDepTime));?></span>
										<span class="span-city"><span><?=$ofr->trp->{'@attributes'}->depName;?>:</span> <?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDesDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->rArrTime));?></span>
									</div>
								</div>
							</div>
							
		                    <?php }
		                    elseif($ofr->{'@attributes'}->type=='H') {?>
		                    <div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Transport:</span>
								</div>
		                        <div class="col-lg-8 col-md-12" style="padding-left: 18px;">
		                            dojazd własny
		                        </div>
		                    </div>
		                    <?php }
		                    elseif($ofr->{'@attributes'}->type=='BU') {?>
		                    <div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Transport:</span>
								</div>
		                        <div class="col-lg-8 col-md-12" style="padding-left: 18px;">
		                           autobus
		                        </div>
		                    </div>
		                    <?php }
		                    elseif($ofr->{'@attributes'}->type=='BA') {?>
		                    <div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Transport:</span>
								</div>
		                        <div class="col-lg-8 col-md-12" style="padding-left: 18px;">
		                            pociąg
		                        </div>
		                    </div>
		                    <?php }?>
							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Wyżywienie:</span>
								</div>
								<div class="col-lg-8 col-md-12">
									<div class="input-hld">
		                                                                
										<select name="service" id="service" class="mobile-preventd">
		                                    <?php
		                                        if(!empty($services)) {
		                                    foreach($services as $key=>$offer) {?>
		                                    <option value="<?=$key;?>" <?=($key==get_query_var('oferta'))?'selected':'';?>><?=$offer;?></option>
		                                    <?php }}
		                                        else {?><option value="<?=get_query_var('oferta');?>">Bez wyżywienia (RO)</option><?php }?>
										</select>
									</div>
								</div>
							</div>
							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Organizator:</span>
								</div>
								<div class="col-lg-8 col-md-12">
									<span class="input-hld-span"><strong><?=$tourOperator->name;?></strong></span>
								</div>
							</div>
							<div class="row row--feature">
								<div class="col-lg-4 col-md-12">
									<span class="input-hld-span">Kod oferty:</span>
								</div>
								<div class="col-lg-8 col-md-12">
									<span class="input-hld-span"><strong><?=$ofr->obj->{'@attributes'}->xCode;?>-<?=$ofr->{'@attributes'}->tourOp;?>-<?=$ofr->trp->{'@attributes'}->depDate;?></strong></span>
								</div>
							</div>
						</form>
					</div>

					<div class="search-panel-small-price">
						<div class="row">
							<div class="col-lg-8 col-md-12">
								<span class="search-panel-span-small-main">Cena za 1 osobę:</span>
							</div>
							<div class="col-lg-4 col-md-12">
								<span class="price"><?=$ofr->{'@attributes'}->price;?> <?=$ofr->{'@attributes'}->curr;?></span>
							</div>
						</div>

						<div class="row">
							<div class="col-lg-8 col-md-12">
								<span class="search-panel-span-small">Cena całkowita (za <?=$par_adt+$par_chd;?> osoby):</span>
							</div>
							<div class="col-lg-4 col-md-12">
								<span class="search-panel-span-small"><?=($par_adt+$par_chd>1&&$data_price->ofr->{'@attributes'}->price!=$ofr->{'@attributes'}->price)?$data_price->ofr->{'@attributes'}->price:($par_adt+$par_chd)*$ofr->{'@attributes'}->price;?> <?=$ofr->{'@attributes'}->curr;?></span>
							</div>
						</div>
					</div>

					<a href="<?=add_query_arg(array('id' => $ofr->{'@attributes'}->id, 'par_adt' => $par_adt, 'par_chd' => $par_chd), get_permalink(get_page_by_path('rezerwacja')));?>" class="btn">Zarezerwuj teraz</a>

					<div class="row row-search-panel-small-bottom">
						lub <a class="ask-question" href="#">wyślij zapytanie do konsultanta</a>
					</div>

					<div class="row row-search-panel-small-bottom row-search-panel-small-bottom--sec">
						<?php
	                    if($tfg==1) {?>
			        	<strong>Cena zawiera:</strong><br/>
						przelot w dwie strony, zakwaterowanie i wyżywienie zgodne z ofertą, opiekę rezydenta, ubezpieczenie KL i NW

						<div class="space-mini"></div>

			        	<strong>Cena nie zawiera:</strong><br/>
						kosztu wycieczek fakultatywnych, ubezpieczenia od rezygnacji
		                <?php }?>
					</div>
				</div>
				<div class="page-content page-content--details">
					<div class="row">
						<div class="col-lg-6 col-md-12">
							<?php if(get_field('page_mail', $frontpage_id)): ?>
							<a class="mail" href="mailto:<?php the_field('page_mail', $frontpage_id); ?>"><?php the_field('page_mail', $frontpage_id); ?></a>
							<?php endif; ?>
						</div>

						<div class="col-lg-6 col-md-12">
							<?php include('parts/part_phone.php'); ?>
						</div>
					</div>
				</div>

				<h2>Nasze atuty:</h2>
				<table border="0" width="100%" cellspacing="10" cellpadding="10" class="advantages">
					<tr>
						<td valign="top" width="77">
							<div><img data-src="<?php echo get_template_directory_uri(); ?>/img/najlepsza-oferta.svg" alt="Najlepsza oferta z gwarancją najniższej ceny"></div>
						</td>
						<td>
							<strong>Najlepsza oferta z gwarancją najniższej ceny</strong>
							<div>Więcej do wydania na urlopowe szaleństwa! Wybieraj spośród bogatej oferty portalu Cititravel.pl <b>
							bez obwaw o wysiekie ceny.</b> Wszystkie oferty prezentowane na portalu oferowane są w <b>cenach operatorów</b>, bez żadnych dodatkowych kosztów, co sprawia że masz do wyboru najlepszą ofertę na rynku.</div>
						</td>
					</tr>
					<tr>
						<td valign="top" width="77">
							<div><img data-src="<?php echo get_template_directory_uri(); ?>/img/dobre-wspomnienia.svg" alt="Tylko dobre wspomnienia"></div>
						</td>
						<td>
							<strong>Tylko dobre wspomnienia</strong>
							<div>Wracaj z wakacji z pięknymi wspomnieniami. Oferta <b>tylko sprawdzonych operatorów</b> oraz szeroka gama dostępnych ubezpieczeń podróży, to Twoja gwarancja udanego pobytu. Polecamy wyłącznie <b>zweryfikowane hotele</b> o standardzie, który sprosta Twoim oczekiwaniom, a nasz system ocen kierunków i hoteli pomoże Ci w trafnym wyborze.</div>
						</td>
					</tr>
					<tr>
						<td valign="top" width="77">
							<div><img data-src="<?php echo get_template_directory_uri(); ?>/img/dla-ciebie.svg" alt="Jesteśmy dla Ciebie"></div>
						</td>
						<td>
							<strong>Jesteśmy dla Ciebie</strong>
							<div>Wiemy jak ekscytujący jest moment wyjazdu na zasłużone wakacje. Nasi konsultanci dokładają największych starań aby zapewnić Ci <b>pozytywne emocje</b> już <b>od momentu wyboru</b> wymarzonych wakacji. Stawiamy na jakość obsługi i pełne wsparcie od pierwszego kontaktu.</div>
						</td>
					</tr>
					<tr>
						<td valign="top" width="77">
							<div><img data-src="<?php echo get_template_directory_uri(); ?>/img/pomysl-na-kierunek.svg" alt="Szukasz pomysłu na kierunek? Pomożemy!"></div>
						</td>
						<td>
							<strong>Szukasz pomysłu na kierunek? Pomożemy!</strong>
							<div>Nie musisz już przeszukiwać dziesiątek ofert aby znaleźć te najbardziej interesujące. Z przyjemnością <b>doradzimy i dopasujemy</b> wycieczkę do Twoich oczekiwań i potrzeb. To proste! Wystarczy kilka informacji dla naszych konsultantów, aby dopasować nasze propozycje do Twoich potrzeb i oczekiwań, gwarantując Ci wypoczynek, na jaki zasługujesz!</div>
						</td>
					</tr>
					<tr>
						<td valign="top" width="77">
							<div><img data-src="<?php echo get_template_directory_uri(); ?>/img/rezerwuj-online.svg" alt="Rezerwuj on-line"></div>
						</td>
						<td>
							<strong>Rezerwuj on-line</strong>
							<div>Wiesz już, jaka wycieczka Cię interesuje? Świetnie! Od jej rezerwacji dzieli Cię wyłącznie kilka kliknięć. Oferujemy możliwośc <b>samodzielnego zakupu</b>, dzięki któremu proces rezerwacji przebiegnie szybko i sprawnie, <b>oszczędzając Twój czas</b>. Niezdecydowanych zachęcamy do kontaku z konsultantem.</div>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<h2 class="bordered">Podobne wycieczki</h2>
			
		<div class="row">
			<div class="offers-slider">
				<?php 
                $trp_depDateFrom = str_replace('-','',date('Y-m-d', strtotime('+2 day')));
                $trp_depDateTo = str_replace('-','',date('Y-m-d', strtotime('+32 day')));
                
             
                $conditions = array(
                    'par_adt' => get_query_var('par_adt', 2), 
                 //   'par_chd' => get_query_var('par_chd', 0), 
                    'trp_destination' => $ofr->trp->{'@attributes'}->destination, //lista regionów                         
                    'trp_duration' => $ofr->trp->{'@attributes'}->duration, 
                 //   'ofr_xCatalog' => $ofr->{'@attributes'}->xCatalog, 
                    'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo, 
                    'ofr_type' => $ofr->{'@attributes'}->type, 
                    'ofr_tourOp' => $ofr->{'@attributes'}->tourOp,
                            'calc_found' => 6, //ilość pobieranych rekordów
                                        'limit_count' => 6,
                );
                include('parts/home_sliders_offer.php');?>
			</div>
		</div>

		<?php include('parts/newsletter.php'); ?>
	</div>
</div>

<?php include('parts/part_blog.php'); ?>

<?php
$trp_depDateFrom = str_replace('-','',date('Y-m-d', strtotime('+2 day')));
$trp_depDateTo = str_replace('-','',date('Y-m-d', strtotime('+23 day')));
$duration_pre = $ofr->trp->{'@attributes'}->duration-2;
$duration_post = $ofr->trp->{'@attributes'}->duration+1;
$conditions_it = array( 
    'trp_duration' => "{$duration_pre}:{$duration_post}",
    'ofr_type' => $ofr->{'@attributes'}->type, 
    'ofr_tourOp' => $ofr->{'@attributes'}->tourOp, 
    'obj_xCode' => $ofr->obj->{'@attributes'}->xCode,
    'obj_code' => $ofr->obj->{'@attributes'}->code,
    'ofr_xStatus' => 'A',
    'limit_count' => 100,
    'par_adt' => $par_adt,
    'totalPrice' => 1,
    'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo,
    'trp_retDate' => $trp_depDateTo, //zakres terminów od do  
    //'group_by' => 'xCodeSrvDate,trp_depName',
    'order_by' => 'trp_depDate'
);  
    
$depDesc_popup = array();
$inne_terminy = get_data('offers', $conditions_it);   
if($inne_terminy->count>0) {
foreach($inne_terminy->ofr as $dt) {
    $depDesc_popup[$dt->trp->{'@attributes'}->depCode] = $dt->trp->{'@attributes'}->depName;
    }
}

$depDesc_popup = array_unique($depDesc_popup);
?>

<div class="popup-hld popup-hld--tours">
    <div class="popup-blank"></div>

    <div class="container-hld">
        <div class="close-btn"><span class="icon-delete"></span></div>
        
        <h3>Inne terminy wycieczki</h3>

        <div class="details-main">
        	<div class="details-head">
                <h5 class="h5"><?=$ofr->obj->{'@attributes'}->name;?></h5>

        		<span class="rating">
	                <i class="icon-star<?=($cat >= 10)?'':'-normal';?>"></i>
	                <i class="icon-star<?=($cat >= 20)?'':'-normal';?>"></i>
	                <i class="icon-star<?=($cat >= 30)?'':'-normal';?>"></i>
	                <i class="icon-star<?=($cat >= 40)?'':'-normal';?>"></i>
	                <i class="icon-star<?=($cat >= 50)?'':'-normal';?>"></i>
	            </span><br/>

				<h3><?=$ofr->obj->{'@attributes'}->country;?>, <?=$ofr->obj->{'@attributes'}->region;?></h3>
        	</div>
        </div>
    
        <div class="search-form">
	        <form id="similar-offers-form">
	        	<div class="row">
		            <div class="col-md-4">
		                <label><?=($ofr->{'@attributes'}->type=='F')?'Data wylotu':'Data wyjazdu';?>
		                	<div class="col">
			                	<div class="input-hld">
			                		<?php /* <input type="text" name="data-wyjazdu" id="data_wyjazdu" class="data-wyjazdu-powrotu" value="<?=date('d.m.Y', strtotime($trp_depDateFrom));?> - <?=date('d.m.Y', strtotime($trp_depDateTo));?>" /> */ ?>

							        <input type="text" id="data_wyjazdu" class="data-wyjazdu mobile-preventd click-input" placeholder="data wyjazdu" value="<?=date('d.m.Y', strtotime($trp_depDateFrom));?>" name="trp_depDateFrom" readonly="readonly" />
			                	</div>
			                </div>
		                </label>
		            </div>
		            <div class="col-md-4">
		                <label><?=($ofr->{'@attributes'}->type=='F')?'Data powrotu':'Data powrotu';?>
			                <div class="col">
								<div class="input-hld">
						            <input type="text" id="data_powrotu" class="data-powrotu mobile-preventd click-input" placeholder="data powrotu" value="<?=date('d.m.Y', strtotime($trp_depDateTo));?>"  name="trp_depDateTo" readonly="readonly" />
						        </div>
			                </div>
		                </label>
		            </div>
                    <?php
                    if($ofr->{'@attributes'}->type=='F') {?>
		            <div class="col-md-4">
		                <label>Miejsce wylotu
		                	<div class="input-hld">
				                <select name="wylot" id="wylot">
				                    <option value="0">Wybierz</option>
                                    <?php
                                    foreach($depDesc_popup as $key=>$offer) {?>
                                    <option value="<?=$key;?>" <?=($key==get_query_var('oferta'))?'selected':'';?>><?=$offer;?></option>
                                    <?php }?>
				                </select>
				            </div>
		            	</label>
		            </div>
                    <?php }?>
	        	</div>

				<div class="row">
		            <div class="col-md-12">         
			            <div class="search-button-section">
			               <button id="similarOffersSubmit" type="button" class="btn" 
                           data-url="<?php echo admin_url('admin-ajax.php'); ?>" 
                           data-conditions='<?=json_encode($conditions_it);?>'
                           data-par-adt='<?=$par_adt;?>'
                           data-par-chd='<?=$par_chd;?>'
                           data-services-names='<?=json_encode($services_names);?>'>Szukaj</button>          
			            </div>
			        </div>
				</div>
			</form>

			<div class="results">
				
                <?php if($inne_terminy->count>0) {?>
                            <?php $page_path = get_page_by_path($ofr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
				<table class="other-travel-periods">
					<thead>
						<tr>
							<th>Termin pobytu</th>
                            <?php if($ofr->{'@attributes'}->type=='F') {?>                                  
							<th>Wylot z</th>
                            <?php }?>
							<th>Wyżywienie</th>
							<th>Cena (<?=$par_adt+$par_chd;?> os.)</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
                    <?php foreach($inne_terminy->ofr as $it) {
                                            
					?>
						<tr>
							<td><?=date('d.m.Y', strtotime($it->trp->{'@attributes'}->depDate));?> - <?=date('d.m.Y', strtotime($it->trp->{'@attributes'}->rDepDate));?> (<?=$it->trp->{'@attributes'}->duration;?> dni)</td>
                            <?php if($ofr->{'@attributes'}->type=='F') {?>    
                            <td><?=$it->trp->{'@attributes'}->depDesc;?></td>
                            <?php }?>
							<td><?=$services_names[$it->obj->{'@attributes'}->xServiceId];?></td>
							<td><span class="price"><?=$it->{'@attributes'}->price;?> <?=$it->{'@attributes'}->curr;?></span></td>
                            <td><a href="<?=add_query_arg(array('oferta' => $it->{'@attributes'}->id, 'par_adt' => $par_adt, 'par_chd' => $par_chd, 'par_chdAge' => $par_chdAge), get_permalink($page_path));?>">szczegóły >></a></td>
						</tr>
                     <?php }?>
					</tbody>
				</table>
                <?php }
                else {?>
                <p>Brak wyników spełniających wybrane kryteria</p>
                <?php }?>
			</div>
    	</div>
    </div>
</div>
<?php include('footer.php'); ?>
