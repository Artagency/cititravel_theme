<?php
$data = get_data('groups', $conditions);

if($data->count>0) {
    if($data->count==1) {
        $new_grp = $data->grp;
        $data->grp = array();
        $data->grp[0] = $new_grp;
    }
foreach($data->grp as $dat) {
    $arr = $dat->ofr;
    $images = get_attributes($arr->{'@attributes'}->id, $arr->obj->{'@attributes'}->xCode, $arr->obj->{'@attributes'}->code, $arr->{'@attributes'}->tourOp, 'thumb');
    $texts = get_attributes($arr->{'@attributes'}->id, $arr->obj->{'@attributes'}->xCode, $arr->obj->{'@attributes'}->code, $arr->{'@attributes'}->tourOp, 'text');   
    if(!empty($texts)) {
        foreach($texts as $key=>$text) {
                if($key=='Zakwaterowanie') $zakwaterowanie = ucfirst(trim(strip_tags($text)));
        }    
    }
    $country = $arr->obj->{'@attributes'}->country;
    $city = $arr->obj->{'@attributes'}->city;
    $cat = (int)$arr->obj->{'@attributes'}->category;
    $class[0] = $class[1] = $class[2] = $class[3] = $class[4] = '-normal';
    if((int)$cat%10!==0) {
        $class[floor($cat/10)] = '-half';
    }
    
    add_custom_permalink($arr->obj->{'@attributes'}->xCode, $arr->obj->{'@attributes'}->country, $arr->obj->{'@attributes'}->name);
    //if(!empty($images)) {
?>
<div class="offer-item offer-item--small col-lg-6 col-md-12">
    <div class="offer-item-photo">
        <?php $page_path = get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
                                <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink($page_path));?>">
                                 <img data-src="<?=(!empty($images))?$images[0]:get_template_directory_uri().'/img/cititravel-placeholder.jpg';?>" alt="" /></a>  
        
        <div class="price">
            <span class="price-from">Cena od</span>
            <span class="price-total"><?=$arr->{'@attributes'}->price;?> <span class="price-curr"><?=$arr->{'@attributes'}->curr;?></span></span>
            <span class="price-per">/ os.</span>
        </div>
    </div>
    <div class="offer-item-details">
        <div class="offer-item-details-header">
            <h3><?php $page_path = get_page_by_path($arr->obj->{'@attributes'}->xCode,OBJECT,'hotels');
                                if(empty($page_path)) $page_path = get_page_by_path('hotel',OBJECT,'hotels'); ?>
                                <a href="<?=add_query_arg(array('oferta' => $arr->{'@attributes'}->id), get_permalink($page_path));?>">
                                 <?=$arr->obj->{'@attributes'}->name;?></a></h3>
            <span class="region"><?=(!empty($country))?$country:'';?><?=(!empty($city))?', '.$city:'';?></span>
        </div>

        <span class="rating">
            <i class="icon-star<?=($cat >= 10)?'':$class[0];?>"></i>
            <i class="icon-star<?=($cat >= 20)?'':$class[1];?>"></i>
            <i class="icon-star<?=($cat >= 30)?'':$class[2];?>"></i>
            <i class="icon-star<?=($cat >= 40)?'':$class[3];?>"></i>
            <i class="icon-star<?=($cat >= 50)?'':$class[4];?>"></i>
        </span>

        <div class="tripDetails">
            <div class="top">
                <span class="first">Pobyt:</span> <span><?=$arr->trp->{'@attributes'}->durationM;?> dni</span> |
                <span class="first">Termin:</span> <span><?=date('d.m.Y', strtotime($arr->trp->{'@attributes'}->depDate));?></span> |<!--03.08 Pt - 11.03 Pt-->
                <span class="first">Wylot z:</span> <span class="nowrap"><?=$arr->trp->{'@attributes'}->depDesc;?></span>
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

        <?php /*
        <a href="<?=add_query_arg(array('id' => $arr->{'@attributes'}->id), get_permalink(get_page_by_path('wakacje')));?>" class="btn">Sprawdź szczegóły</a>
        */ ?>
    </div>
</div>
<?php //}

                }}?>