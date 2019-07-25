<?php  
    /* Template Name: Strona główna */
?> 

<?php $frontpage_id = get_option('page_on_front'); ?>

<?php include('header.php'); ?>

<?php include('parts/main_slider.php'); 
 $tourOp = array();                            
$terms = get_terms('conditions_tourop', array('hide_empty' => false));
foreach($terms as $dt) {
    if((bool)get_field('active', 'conditions_tourop_'.$dt->term_id)===true) {
        $tourOp[] = strtoupper($dt->slug);
    }
}
?>

<div class="main-content">
	<div class="container">
		<div class="container--offers">
			<div class="tabs">
				<h2 class="bordered">Sprawdź wyjątkowe oferty</h2>

				<?php wp_nav_menu(array('menu_id' => 'trip-cats', 'menu_class' => 'tab-nav', 'container_class' => 'trip-cats', 'theme_location' => 'trip_cats')); ?>
				
				<div class="tab-container">
					<div class="tab-content super-oferta">
                        <div class="row">
							<?php                      
                            $trp_depDateFrom = str_replace('-','',date('Y-m-d', strtotime('+2 day')));
                            $trp_depDateTo = str_replace('-','',date('Y-m-d', strtotime('+1 year')));

                            $conditions = array(
                                    'par_adt' => 2, //ilość osób dorosłych
                                    'trp_duration' => '6:8', //długość pobytu
                                    //'ofr_xCatalog' => 'PROM', //promocje
                                    'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo, //zakres terminów od do 
                                    'ofr_tourOp' => join(',', $tourOp), //lista touroperatorów
                                    'ofr_type' => 'F', //typ - samolot
                                    'ofr_xStatus' => 'A', //tylko oferty dostępne
                                    'calc_found' => 6, //ilość pobieranych rekordów
                                    'limit_count' => 6,
                                    'order_by' => 'ofr_price', //sortowanie według ceny
                                    'trp_destination' => '3_200,56425_191,14_89,197:,5:,6:,8:,10:,11:,372:,370:,14:,4219:,15:,243:,54:,19:,21:,26:,27:,29:,31:,36:,49:,38:,39:,44:' //lista regionów
                                );
                            include('parts/home_sliders_offer.php'); ?>
                        </div>
					</div>

					<div class="tab-content last-minute">
                        <div class="row">
							<?php
                            $trp_depDateFrom = str_replace('-','',date('Y-m-d', strtotime('+2 day')));
                            $trp_depDateTo = str_replace('-','',date('Y-m-d', strtotime('+23 day')));

                            $conditions = array(
                                    'par_adt' => 2, //ilość osób dorosłych
                                    'trp_durationM' => '5,6,7',
                                    'ofr_xCatalog' => 'LAST', //promocje
                                    'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo, //zakres terminów od do 
                                    'ofr_tourOp' => join(',', $tourOp), //lista touroperatorów
                                    'ofr_type' => 'F', //typ - samolot
                                    'ofr_xStatus' => 'A', //tylko oferty dostępne
                                    'calc_found' => 6, //ilość pobieranych rekordów
                                    'limit_count' => 6,
                                    'order_by' => 'ofr_price', //sortowanie według ceny
                                    'trp_destination' => '3_200,56425_191,14_89,3720_3075,197:,5:,6:,8:,10:,11:,372:,370:,14:,4219:,15:,243:,54:,19:,21:,26:,27:,29:,31:,36:,49:,38:,39:,44:' //lista regionów
                                );
                            include('parts/home_sliders_offer.php'); ?>
                        </div>
					</div>

					<div class="tab-content all-inclusive">
                        <div class="row">
							<?php 
                            $trp_depDateFrom = str_replace('-','',date('Y-m-d', strtotime('+2 day')));
                            $trp_depDateTo = str_replace('-','',date('Y-m-d', strtotime('+23 day')));

                            $conditions = array(
                                    'par_adt' => 2, //ilość osób dorosłych
                                    'trp_duration' => 7, //długość pobytu
                                    'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo, //zakres terminów od do 
                                    'ofr_tourOp' => join(',', $tourOp), //lista touroperatorów
                                    'ofr_type' => 'F', //typ - samolot
                                    'ofr_xStatus' => 'A', //tylko oferty dostępne
                                    'calc_found' => 6, //ilość pobieranych rekordów
                                    'limit_count' => 6,
                                    'order_by' => 'ofr_price', //sortowanie według ceny
                                    'trp_destination' => '3_200,56425_191,14_89,197:,5:,6:,8:,10:,11:,372:,370:,14:,4219:,15:,243:,54:,19:,21:,26:,27:,29:,31:,36:,49:,38:,39:,44:', //lista regionów
                                    'obj_xServiceId' => 1 //All Inclusive
                                );
                            include('parts/home_sliders_offer.php'); ?>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="section-bg">
		<?php if(get_field('img_cat_1') && get_field('content_on_img_cat_1')): ?>
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-4 hide-mobile">
					<div class="cat-hld">
						<img data-src="<?php the_field('img_cat_1'); ?>" alt="">
						
						<?php if(get_field('content_on_img_cat_1')): ?>
						<div class="content-cat">
							<?php the_field('content_on_img_cat_1'); ?>
						</div>
						<?php endif; ?>
					</div>
				</div>

				<div class="col-lg-8 col-md-8 col-mobile-100">
					<div class="row">
		            	<?php 
		                $trp_depDateFrom = str_replace('-','',date('Y-m-d', strtotime('+2 day')));
		                $trp_depDateTo = str_replace('-','',date('Y-m-d', strtotime('+350 day')));

		                $conditions = array(
		                        'par_adt' => 2, //ilość osób dorosłych
		                        'trp_duration' => '6,7,8', //długość pobytu
		                        'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo, //zakres terminów od do 
		                        'ofr_tourOp' => join(',', $tourOp), //lista touroperatorów
		                        'ofr_type' => 'F', //typ - samolot
		                        'ofr_xStatus' => 'A', //tylko oferty dostępne
		                        'calc_found' => 4, //ilość pobieranych rekordów
                                        'limit_count' => 4,
		                        'order_by' => 'ofr_price', //sortowanie według ceny
		                        'obj_type' => 'H',
		                        'trp_destination' => '197:,47:,10:,370:,802_2541,39549_20,18:,19:,21_2065,21_3941,21_182,24:,28:,29_2507,29_31,2598:,2925:,36:,49:,42:,801:,3030:' //lista regionów
		                    );
		                include('parts/home_offers.php'); ?>
		            </div>
				</div>
			</div>
		</div>
		<?php endif; ?>
	</div>

	<div class="space-small"></div>

	<?php if(get_field('img_cat_2') && get_field('content_on_img_cat_2')): ?>
	<div class="container">
		<div class="row">
			<div class="col-lg-4 col-md-4 hide-mobile">
				<div class="cat-hld">
					<img data-src="<?php the_field('img_cat_2'); ?>" alt="">
					
					<?php if(get_field('content_on_img_cat_2')): ?>
					<div class="content-cat">
						<?php the_field('content_on_img_cat_2'); ?>
					</div>
					<?php endif; ?>
				</div>
			</div>

			<div class="col-lg-8 col-md-8 col-mobile-100">
				<div class="row">
	            	<?php 
	                $trp_depDateFrom = str_replace('-','',date('Y-m-d', strtotime('+2 day')));
	                $trp_depDateTo = str_replace('-','',date('Y-m-d', strtotime('+350 day')));

	                $conditions = array(
	                        'par_adt' => 2, //ilość osób dorosłych
	                        'trp_duration' => '6,7,8', //długość pobytu
	                        'trp_depDate' => $trp_depDateFrom.':'.$trp_depDateTo, //zakres terminów od do 
	                        'ofr_tourOp' => join(',', $tourOp), //lista touroperatorów
	                        'ofr_type' => 'F', //typ - samolot
	                        'ofr_xStatus' => 'A', //tylko oferty dostępne
	                        'calc_found' => 4, //ilość pobieranych rekordów
                                'limit_count' => 4,
	                        'order_by' => 'ofr_price', //sortowanie według ceny
	                        'obj_type' => 'H',
	                        'trp_destination' => '197:,47:,10:,370:,802_2541,39549_20,18:,19:,21_2065,21_3941,21_182,24:,28:,29_2507,29_31,2598:,2925:,36:,49:,42:,801:,3030:' //lista regionów
	                    );
	                include('parts/home_offers.php'); ?>
	            </div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<div class="space-medium"></div>

	<div class="container">
		<div class="row">
			<div class="col-lg-7 col-md-12">
				<div class="content-home">
					<?php the_content(); ?>

					<div class="col-lg-6 col-md-6">
						<?php if(get_field('page_mail')): ?>
						<a class="mail" href="mailto:<?php the_field('page_mail'); ?>"><?php the_field('page_mail'); ?></a>
						<?php endif; ?>
					</div>

					<div class="col-lg-6 col-md-6">
						<?php include('parts/part_phone.php'); ?>
					</div>
				</div>
			</div>

			<div class="col-lg-5 col-md-12">
				<?php if(get_field('img_right')): ?>
				<img data-src="<?php the_field('img_right'); ?>" alt="">
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="space-medium"></div>

	<?php include('parts/part_blog.php'); ?>
</div>

<?php include('footer.php'); ?>

<?php include('parts/trip_directions.php'); ?>