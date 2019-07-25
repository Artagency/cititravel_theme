<?php  
    /* Template Name: Podstrona Schowka */
?> 

<?php include('header.php'); 

global $wpdb;
$qry = "SELECT ho.offer_id FROM wp_hanging h
        JOIN wp_hanging_offers ho ON h.id = ho.hanging_id
        WHERE h.code='{$_COOKIE['hanging_code']}'";
  
$results = $wpdb->get_results( $qry );
?>

<div class="main-content main-content--subpage">
	<div class="container">
		<?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>

		<div class="row--search-result">
			<h3>Schowek<br/> 
				<small>Masz <?=count($results);?> elementów w schowku</small>
			</h3>
		</div>
		
		<div class="row row--list row--hanging">
			<?php
			foreach($results as $res) {
	            $offer = get_data('details', array('ofr_id' => $res->offer_id, 'ofr_TFGincluded' => 1));
	            $arr = $offer->ofr;
			    $cat = (int)$arr->obj->{'@attributes'}->category;

			    $country = $arr->obj->{'@attributes'}->country;
			    $city = $arr->obj->{'@attributes'}->city;
			    $cat = (int)$arr->obj->{'@attributes'}->category;
			    $class[0] = $class[1] = $class[2] = $class[3] = $class[4] = '-normal';
			    if((int)$cat%10!==0) {
			        $class[floor($cat/10)] = '-half';
			    }
			    $thumbnail[$arr->{'@attributes'}->id] = get_attributes($arr->{'@attributes'}->id, $arr->obj->{'@attributes'}->xCode, $arr->obj->{'@attributes'}->code, $arr->{'@attributes'}->tourOp, 'thumb')[0];
			?>
			<div class="offer-item offer-item--sec">
				<div class="col-lg-4 col-md-12">
			        <div class="offer-item-photo">
			             <a href="<?=add_query_arg(array('id' => $arr->{'@attributes'}->id), get_permalink(get_page_by_path('wakacje')));?>">
                         	<img data-src="<?=$thumbnail[$arr->{'@attributes'}->id];?>" alt="" width="370" height="250" />           
                         </a>        
			        </div>
				</div>

				<div class="col-lg-6 col-md-12">
			        <div class="offer-item-details">
			            <div class="offer-item-details-header">
			               	<h3><a href="<?=add_query_arg(array('id' => $arr->{'@attributes'}->id), get_permalink(get_page_by_path('wakacje')));?>"><?=$arr->obj->{'@attributes'}->name;?></a></h3>
                            <span class="rating">
				                <i class="icon-star<?=($cat >= 10)?'':'-normal';?>"></i>
				                <i class="icon-star<?=($cat >= 20)?'':'-normal';?>"></i>
				                <i class="icon-star<?=($cat >= 30)?'':'-normal';?>"></i>
                                <i class="icon-star<?=($cat >= 40)?'':'-normal';?>"></i>
                                <i class="icon-star<?=($cat >= 50)?'':'-normal';?>"></i>
				            </span>
		                	<span class="region"><?=$arr->obj->{'@attributes'}->country;?>, <?=$arr->obj->{'@attributes'}->city;?></span>
			            </div>

			            <div class="offer-trip-details">
			                <span>Pobyt: <?=$arr->trp->{'@attributes'}->durationM;?> dni</span>
			                <span>Termin: <?=date('d.m.Y', strtotime($arr->trp->{'@attributes'}->depDate));?></span><!--03.08 Pt - 11.03 Pt-->
			                <span>Wylot z: <?=$arr->trp->{'@attributes'}->depDesc;?></span>
			                <span>Wyżywienie: <?php
                                                $conditions_service = get_terms( 'conditions_service', array( 'hide_empty' => false ));
                                                if(!empty($conditions_service)) {
                                                    foreach($conditions_service as $cs) {
                                                        $code = (int)get_field('code', 'conditions_service_'.$cs->term_id);
                                                        if($code==$arr->obj->{'@attributes'}->xServiceId) {echo $cs->name;break;}
                                                    }
                                                }?></span>
			                <span>Organizator: <?php
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
				<div class="col-lg-2 col-md-12 align-right">
		            <div class="price">
		                <span class="price-from">Cena od</span>
		                <span class="price-total"><?=$arr->{'@attributes'}->price;?> <?=$arr->{'@attributes'}->curr;?></span>
		                <span class="price-per">/ os.</span>

		                <span class="price-from price-from--two-persons">Cena za 2 os.</span>
                        <span class="price-total price-total--two-persons"><?=$arr->{'@attributes'}->price*2;?> <?=$arr->{'@attributes'}->curr;?></span>
		            </div>
					
					<a href="<?php echo admin_url('admin-ajax.php'); ?>" class="remove-from-hanging" data-offer-id="<?=$arr->{'@attributes'}->id;?>" data-type="remove">Usuń z ulubionych</a>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</div>

<?php include('parts/newsletter.php'); ?>

<?php include('footer.php'); ?>