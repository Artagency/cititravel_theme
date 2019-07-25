<?php
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

$suma = count($wszystkie);
$ile_w_kolumnie = ceil($suma/4);

$dest_tab = explode(',', $trp_destination);
foreach($dest_tab as $key=>$dd) {
    $dest_tab[$key] = str_replace("'", "", $dd);
}

if($_GET['dev']==1) print_r($dest_tab);

?>
<div class="trip-direction-hld">
	<div class="container">
		<div class="trip-direction-container">
			<div class="col-lg-12">
				<div class="row row--top">
					<div class="col-lg-6">
						<h2>Wybierz kierunek podróży</h2>
					</div>

					<div class="col-lg-6 align-right">
						<i class="icon-delete close-trip-direction-hld"></i>
					</div>
				</div>
			</div>
			<div class="trip-direction-inner">
				<div class="row">
					<div class="col-lg-3">
						<ul>  
	                    <?php
	                    $ile = 0;
	                        foreach($kraje as $kraj) { 
	                            $ile++;
	                            $regiony = $wpdb->get_results( 
	                                "SELECT *
	                                FROM `wp_regions`
	                                WHERE active = 1 AND home = 1 AND parent = {$kraj->id}
	                                ORDER BY name ASC"
	                        );
							?>
							<li class="<?=(!empty($regiony)) ? 'parent-li' : '';?>">
	                            <label><input type="checkbox" name="regions[]" value="<?=$kraj->kod_mds;?>" <?=(in_array($kraj->kod_mds, $dest_tab))?'checked':'';?>> <span><?=$kraj->name;?></span></label>
						
	                            <?php 
	                            if(!empty($regiony)) {
	                                ?>
	                            <ul>
	                                <?php 
	                                foreach($regiony as $region) {
                                            $ile++;?>
									<li>
	                                    <label><input type="checkbox" name="regions[]" value="<?=$region->kod_mds;?>" <?=(in_array($region->kod_mds, $dest_tab))?'checked':'';?>> <span><?=$region->name;?></span></label>
									</li>
	                                <?php 
                                        
                                        
                                        }?>	
								</ul>
	                            <?php
	                                                
	                                                
	                            }
	                            if($ile>=$ile_w_kolumnie) {
	                            $ile = 0;
	                            ?>
	                   	</ul>
					</div>

					<div class="col-lg-3">
						<ul>   
	                        <?php
	                        }
	                                                
	                        }?>
						</ul>
					</div>
						
							
				</div>
			</div>
			
			<div class="col-lg-12">
				<div class="row row--bottom">
					<div class="col-lg-6">
						<a class="link link--check-all" href="#">Zaznacz wszystkie</a>
						<a class="link link--uncheck-all" href="#">Usuń wszystkie</a>
					</div>

					<div class="col-lg-6 align-right">
						<a href="#" class="btn close-trip-direction-hld">Wybierz</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>