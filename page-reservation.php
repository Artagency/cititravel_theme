<?php  
    /* Template Name: Podstrona rezerwacji */
?> 

<?php include('header.php');
$par_adt = get_query_var('par_adt', 2);
$par_chd = get_query_var('par_chd', 0);
$conditions = array('ofr_id' => get_query_var('id'), 'par_adt' => $par_adt);
if(!empty($par_chd)) {
    $conditions['par_chd'] = $par_chd;
}
//print_r($conditions);
$data_pr = get_data('details', $conditions, 'ofr_price,ofr_TFGIncluded');
//$conditions['totalPrice'] = true;
$data = get_data('details', $conditions);
$ofr = $data->ofr;
$images = get_attributes($ofr->{'@attributes'}->id, $ofr->obj->{'@attributes'}->xCode, $ofr->obj->{'@attributes'}->code, $ofr->{'@attributes'}->tourOp, 'image');

$adult_price = $data_pr->ofr->{'@attributes'}->price;
$full_price = $par_adt*$data->ofr->{'@attributes'}->price;
$all_child_price = $full_price - $adult_price*$par_adt;
if(!empty($par_chd)) $child_price = $all_child_price/$par_chd;

$tfg = $data_pr->ofr->{'@attributes'}->TFGIncluded;
$cat = (int)$data->ofr->obj->{'@attributes'}->category;

$services_name = array();
$terms = get_terms('conditions_service', array('hide_empty' => false));
foreach($terms as $term) {
    $code = (int)get_field('code', 'conditions_service_'.$term->term_id);
    $services_names[$code] = $term->name;
}

$terms = get_terms('regions_countries', array('hide_empty' => false));
foreach($terms as $term) {
    $code = trim(get_field('kod_regionu_mds', 'regions_countries_'.$term->term_id));
    if($code == trim($data->ofr->obj->{'@attributes'}->xCountryId).':') {
        $country = $term;
        continue;
    }
}

$posts = get_posts(array('post_type' => 'regions', 'posts_per_page' => -1));
foreach($posts as $post) {
    $code = trim(get_field('kod_regionu_mds', $post->ID));
    if($code == trim($data->ofr->obj->{'@attributes'}->xCountryId).'_'.trim($data->ofr->obj->{'@attributes'}->xRegionId)) {
        $region = $post;
        continue;
    }
}

$paszport_kraj = get_field('paszport', 'regions_countries_'.$country->term_id);
$paszport_region = get_field('paszport', $region->ID);
$paszport = (bool)$paszport_kraj || (bool)$paszport_region;

$terms = get_terms('conditions_tourop', array('hide_empty' => false));
foreach($terms as $term) {
    //$code = trim(get_field('code', 'conditions_tourop_'.$term->term_id));
    $code = $term->slug;
    if(strtolower($code) == strtolower(trim($data->ofr->{'@attributes'}->tourOp))) {
        $tourOperator = $term;
        continue;
    }
}

$online = (bool)get_field('online', 'conditions_tourop_'.$tourOperator->term_id);

$now = time();
$your_date = strtotime($ofr->trp->{'@attributes'}->depDate);
$datediff = $your_date - $now;
$zostalo_dni = round($datediff / (60 * 60 * 24));
$minimalna_ilosc_dni_dla_platnosci = (int)get_field('minimalna_ilosc_dni_dla_platnosci', 'conditions_tourop_'.$tourOperator->term_id);
if($zostalo_dni < $minimalna_ilosc_dni_dla_platnosci) $online = true;

$minimalna_ilosc_dni_dla_zaliczki = (int)get_field('minimalna_ilosc_dni_dla_zaliczki', 'conditions_tourop_'.$tourOperator->term_id);
if($zostalo_dni >= $minimalna_ilosc_dni_dla_zaliczki) {
    $zaliczka = true;
    $tour_year = date('Y', $your_date);
    $lato_start = strtotime($tour_year.'-05-01');
    $lato_stop = strtotime($tour_year.'-10-31');
    if($your_date >= $lato_start && $your_date <= $lato_stop) {
        $procent = (int)get_field('procent_ceny_dla_zaliczki', 'conditions_tourop_'.$tourOperator->term_id);  
    }
    else {
        $procent = (int)get_field('procent_ceny_dla_zaliczki2', 'conditions_tourop_'.$tourOperator->term_id);  
    }
    $zaliczka_kwota = round($procent/100*$full_price, 2);
    $reszta = $full_price-$zaliczka_kwota;
    $zaliczka_termin = date('d.m.Y', $your_date - ($minimalna_ilosc_dni_dla_zaliczki+5)*60*60*24);
}
else $zaliczka = false;

$data_urodzenia_widoczna = (int)get_field('data_urodzenia_klienta', 'conditions_tourop_'.$tourOperator->term_id);

?>
<div class="main-content main-content--details">
	<div class="container">
		<?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
		
		<div class="page-content">
			<h2>Formularz rezerwacji wstępnej</h2>
			
			<div class="row">
				<div class="col-lg-4 push-lg-8">
					<div class="reservation-panel">
						<div class="details-head">
							<h2 class="bordered">Wybrana oferta</h2>

							<h1><?=$ofr->obj->{'@attributes'}->name;?></h1>
							<span class="rating">
				                <i class="icon-star<?=($cat >= 10)?'':'-normal';?>"></i>
				                <i class="icon-star<?=($cat >= 20)?'':'-normal';?>"></i>
				                <i class="icon-star<?=($cat >= 30)?'':'-normal';?>"></i>
		                        <i class="icon-star<?=($cat >= 40)?'':'-normal';?>"></i>
		                        <i class="icon-star<?=($cat >= 50)?'':'-normal';?>"></i>
							</span>
							<h3><?=$ofr->obj->{'@attributes'}->country;?>, <?=$ofr->obj->{'@attributes'}->region;?></h3>
						</div>

			            <?php if(!empty($images)) {?>
	                        <img src="<?=$images[0];?>" alt="">
	                    <?php }?>
						
						<div class="reservation-panel-inner">
			            	<span class="reserv-span">Organizator:</span> <strong><?=$tourOperator->name;?></strong><br/>
		                   	<span class="reserv-span">Kod oferty:</span> <?=$ofr->obj->{'@attributes'}->xCode;?>-<?=$ofr->{'@attributes'}->tourOp;?>-<?=$ofr->trp->{'@attributes'}->depDate;?>

		                   	<div class="space-micro"></div>

			                <hr>
			                <div class="space-micro"></div>

			            	<span class="reserv-span">Typ pokoju:</span> <?=$ofr->obj->{'@attributes'}->roomDesc;?><br/>
			            	<span class="reserv-span">Wyżywienie:</span> <?=$services_names[$ofr->obj->{'@attributes'}->xServiceId];?><br/>
		                    <span class="reserv-span">Paszport:</span> <?php if($paszport===false) {?>nie <?php }?>jest wymagany
							
							<div class="space-micro"></div>
			                <hr>

			               	<?php if($ofr->{'@attributes'}->type=='F') {?>   
		               		<div class="row">
		               			<div class="space-micro"></div>

		               			<div class="col-lg-6 col-md-12">
					            	WYLOT<br/>
				                    <?=$ofr->trp->{'@attributes'}->depName;?> - <?=$ofr->trp->{'@attributes'}->desDesc;?><br/>
					            	<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->depDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->depTime));?><br/>
									<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->desDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->arrTime));?>
		               			</div>
							
		               			<div class="col-lg-6 col-md-12">
					            	POWRÓT<br/>
					            	<?=$ofr->trp->{'@attributes'}->desDesc;?> - <?=$ofr->trp->{'@attributes'}->depName;?><br/>
					            	<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDepDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->rDepTime));?><br/>
									<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDesDate));?>, godz <?=date('H:i', strtotime($ofr->trp->{'@attributes'}->rArrTime));?>
		               			</div>
		               		</div>
		                   	<?php }?>
		               	</div>
						
						<div class="reservation-panel-price">
	                        <div class="row">
								<div class="col-lg-8 col-md-12">
			                        <?php
			                        {?>
					        		Cena za 1 osobę dorosłą
					        		<div class="space-micro"></div>
			                        <?php }
			                        if(!empty($par_chd)){?>
			                        Cena za 1 dziecko
			                        <?php }?>
								</div>

								<div class="col-lg-4 col-md-12">
			                        <?php
			                        {?>
					        		<?=$adult_price;?> zł
			                        <?php }
			                        if(!empty($par_chd)){?>
			                        <?=$child_price;?> zł
			                        <?php }?>
								</div>
							</div>

	                        <div class="row">
								<div class="col-lg-8 col-md-12">
									<span class="reservation-panel-span-small">Cena całkowita</span>
								</div>
								<div class="col-lg-4 col-md-12">
									<span class="reservation-panel-span-small"><?=$full_price;?> zł</span>
								</div>
							</div>
						</div>

						<div class="reservation-panel-inner">
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
				</div>

				<div class="col-lg-8 pull-lg-4">
					<form id="rezerwacja" action="<?php echo admin_url('admin-ajax.php'); ?>" method="post">
						<h3>Dane osoby dokonującej rezerwacji</h3>

						<div class="row">
							<?php /*
							<div class="col-lg-2">
								<select name="plec">
									<option value="">Płeć</option>
									<option value="H">Pan</option>
									<option value="F">Pani</option>
								</select>
							</div>
							*/ ?>
							
                            <?php /* if((bool)$data_urodzenia_widoczna===true): ?>
                            <div class="col-lg-4 col-md-12">
								<input type="text" placeholder="imię *" name="imie" required />
							</div>

							<div class="col-lg-4 col-md-12">
								<input type="text" placeholder="nazwisko *" name="nazwisko" required />
							</div>

							<div class="col-lg-4 col-md-12">
								<input type="text" class="data-urodzenia" placeholder="data urodzenia *" name="data_urodzenia" autocomplete="off" required>
							</div>
                            <?php else: */  ?>
                            <div class="col-lg-6 col-md-12">
								<input type="text" placeholder="imię *" name="imie" required />
							</div>

							<div class="col-lg-6 col-md-12">
								<input type="text" placeholder="nazwisko *" name="nazwisko" required />
							</div>
						</div>

						<div class="row">
							<div class="col-lg-4 col-md-12">
								<input type="text" placeholder="ulica *" name="ulica" required />
							</div>
							<div class="col-lg-4 col-md-12">
								<input type="text" placeholder="nr domu / nr lokalu *" name="numer_domu" required />
							</div>
							<div class="col-lg-4 col-md-12">
								<input type="text" placeholder="kod pocztowy *" name="kod_pocztowy" required />
							</div>
						</div>

						<div class="row">
							<div class="col-lg-4 col-md-12">
								<input type="text" placeholder="miasto *" name="miasto" required />
							</div>

							<div class="col-lg-4 col-md-12">
								<input type="tel" title="Wpisz telefon kontaktowy w formacie xxx xxxx xxx" placeholder="Telefon" name="numer_telefonu" required />
							</div>

							<div class="col-lg-4 col-md-12">
								<input type="text" placeholder="adres e-mail *" name="email" />
							</div>
						</div>

						<div class="space-small"></div>

						<h3>Dane uczestników wycieczki</h3>
                        <?php
                        for($i=1;$i<=$par_adt;$i++) {?>
						<div class="row">
							<div class="col-lg-2">
								<p class="participant"><strong>Dorosły <?=$i;?></strong></p>
							</div>

							<div class="col-lg-1 col-npd">
								<div class="input-hld">
									<select name="dorosly<?=$i;?>_plec" required class="mobile-preventd">
										<option value="">Płeć</option>
										<option value="H">Pan</option>
										<option value="F">Pani</option>
									</select>
								</div>
							</div>

							<div class="col-lg-3 col-md-12">
								<input type="text" placeholder="imię *" name="dorosly<?=$i;?>_imie" required>
							</div>

							<div class="col-lg-3 col-md-12">
								<input type="text" placeholder="nazwisko *" name="dorosly<?=$i;?>_nazwisko" required>
							</div>

							<div class="col-lg-3 col-md-12">
								<input type="text" class="data-urodzenia" placeholder="data urodzenia *" name="dorosly<?=$i;?>_data_urodzenia" required autocomplete="off">
							</div>
						</div>
                        <?php }
                        for($i=1;$i<=$par_chd;$i++) {?>
						
						<div class="row">
							<div class="col-lg-2">
								<p class="participant"><strong>Dziecko <?=$i;?></strong></p>
							</div>

							<div class="col-lg-1 col-npd">
								<div class="input-hld">
									<select name="dziecko<?=$i;?>_plec" required>
										<option value="">Płeć</option>
										<option value="K">Pan</option>
										<option value="K">Pani</option>
									</select>
								</div>
							</div>

							<div class="col-lg-3 col-md-12">
								<input type="text" placeholder="Imię *" name="dziecko<?=$i;?>_imie" required>
							</div>

							<div class="col-lg-3 col-md-12">
								<input type="text" placeholder="Nazwisko *" name="dziecko<?=$i;?>_nazwisko" required>
							</div>

							<div class="col-lg-3 col-md-12">
								<input type="text" class="data-urodzenia" placeholder="Data urodzenia *" name="dziecko<?=$i;?>_data_urodzenia" required autocomplete="off">
							</div>
						</div>
	                    <?php }?>

	                    <div class="space-small"></div>

						<h3>Dokończenie wstępnej rezerwacji</h3>
						<div class="row row--inputs">
							<div class="col-lg-12">
								<label class="label-hld">
									<input type="radio" name="iCheck" value="online" checked> 

									<div class="input-content">
										<strong>Wybierz sposób płatności</strong><br/>
										W następnym kroku zostaniecie Państwo przekierowani do bezpiecznego terminalu płatności elektronicznych Dotpay.
									</div>
								</label>
							</div>

							<div class="col-lg-5">
								<label class="label-hld">
									<input type="radio" name="iCheck_price" value="calosc" checked> 

									<div class="input-content">
										Wpłacam całość - <?=number_format($full_price, 2, '.', '');?> zł
									</div>
								</label>
							</div>
							
							<?php if($zaliczka === true): ?>
							<div class="col-lg-7">
								<label class="label-hld">
									<input type="radio" name="iCheck_price" value="zaliczka"> 

									<div class="input-content">
										Wpłacam zaliczkę - <?=number_format($zaliczka_kwota, 2, '.', '');?> zł (pozostałą kwotę <?=number_format($reszta, 2, '.', '');?> zł do dnia <?=$zaliczka_termin;?>)
									</div>
								</label>
							</div>
                            <?php endif; ?>

                            <?php /*if($online === false): ?>
							<div class="col-lg-5">
								<label class="label-hld">
									<input type="radio" name="iCheck_payment" value="dotpay"> 

									<div class="input-content">Płatność online / karta kredytowa</div>
								</label>
							</div>  
							<?php endif;*/ ?>

	                        <?php /* if($przelew === false): ?>
	                        <div class="col-lg-7">
								<label class="label-hld label-hld--sec">
									<input type="radio" name="iCheck_payment" value="przelew">

									<div class="input-content">Tradycyjny przelew bankowy</div>
								</label>
							</div>
                            <?php endif; */ ?>
		                  <input type="hidden" name="iCheck_payment" value="dotpay" />
						</div>

						<div class="space-mini"></div>

						<div class="row">
							<div class="col-lg-12">
								<label class="label-hld label-telefonicznie">
									<input type="radio" name="iCheck" value="telefonicznie"> 

									<div class="input-content">
										<strong>Telefonicznie z konsultantem</strong><br/>
										Konsultant Cititravel.pl skontaktuje się z Państwem w celu omówinia szczegółów i dogodnych form płatności.
									</div>
								</label>
							</div>
						</div>

						<div class="space-small"></div>

						<div class="row">
							<div class="col-lg-12">
								<p class="p-checkbox">
									<label><input type="checkbox" required>*Oświadczam, że zapoznałam (-em) się i akceptuję Ogólne Warunki Uczestnictwa Touroperatora oraz Regulamin Cititravel Polska Sp. z o. o.</label>
								</p>
							</div>

							<div class="col-lg-12">
								<p class="p-checkbox">
									<label><input type="checkbox">Chcę otrzymywać Newsletter z aktualnymi ofertami i nowościami Cititravel.pl.</label>
								</p>
							</div>
							
							<div class="col-lg-12">
								<p class="p-checkbox">
									<label><input type="checkbox">W związku z art.23 ust.1 pkt 1 i ust.2 ustawy z dnia 29 sierpnia 1997 r. o ochronie danych osobowych (Dz.U.Nr 133 poz. 883) oświadczam, że wyrażam zgodę na przetwarzanie przez Cititravel Polska Sp. o.o w systemach informatycznych moich danych osobowych. Mam prawo do ich późniejszego usunięcia.</label>
								</p>
							</div>
						</div>
                        <input name="action" value="rezerwacja" type="hidden">
                        <input name="price" type="hidden" value="<?=$full_price;?>" />
                        <input name="id_oferty" type="hidden" value="<?=get_query_var('id');?>" />
                        <input name="hotel" type="hidden" value="<?=$ofr->obj->{'@attributes'}->name;?>" />
                        <input name="kierunek" type="hidden" value="<?=$ofr->obj->{'@attributes'}->country;?>" />                
                        <input name="kategoria" type="hidden" value="<?=$cat;?>" />
                        <input name="zdjecie" type="hidden" value="<?=(!empty($images))?$images[0]:'';?>" />
                        <input name="dlugosc_pobytu" type="hidden" value="<?=$ofr->trp->{'@attributes'}->durationM;?>" />
                        <input name="data_wyjazdu" type="hidden" value="<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->depDate));?>" />
                        <input name="data_powrotu" type="hidden" value="<?=date('d.m.Y', strtotime($ofr->trp->{'@attributes'}->rDesDate));?>" />
                        <input name="wylot_z" type="hidden" value="<?=$ofr->trp->{'@attributes'}->depDesc;?>" />
                        <input name="zakwaterowanie" type="hidden" value="<?=$ofr->obj->{'@attributes'}->roomDesc;?>" />
                        <input name="wyzywienie" type="hidden" value="<?=$services_names[$ofr->obj->{'@attributes'}->xServiceId];?>" />
                        <input name="kod_oferty" type="hidden" value="<?=$ofr->obj->{'@attributes'}->xCode;?>-<?=$ofr->{'@attributes'}->tourOp;?>-<?=$ofr->trp->{'@attributes'}->depDate;?>" />
                        <input name="organizator" type="hidden" value="<?=$tourOperator->name;?>" />
                        <input name="tour_op" type="hidden" value="<?=$ofr->{'@attributes'}->tourOp;?>" />
                        <input name="paszport" type="hidden" value="<?=($paszport)?'TAK':'NIE';?>" />
                        <input name="par_adt" type="hidden" value="<?=get_query_var('par_adt', 2);?>" />
                        <input name="par_chd" type="hidden" value="<?=get_query_var('par_chd', 0);?>" />
                        <input name="xCode" type="hidden" value="<?=$ofr->obj->{'@attributes'}->xCode;?>" />
                        <input name="kwota_zaliczki" type="hidden" value="<?=number_format($zaliczka_kwota, 2, '.', '');?>" />
                       
						
						<p>
							<input type="submit" value="Zarezerwuj">
						</p>

						<p>* Na kolejnym ekranie wyświetla się numery rachunków bankowych, na które prosimy dokonać płatności oraz dodatkowe informacje pomocne przy dokonaniu przelewu i przesłanie potwierdzenia w ciągu 24 godzin od złożenia rezerwacji na e-mail: biuro@cititravel.pl</p>

	                    <?php wp_nonce_field('rezerwacja', 'rezerwacja'); ?>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include('parts/trip_directions.php'); ?>

<?php include('footer.php'); ?>