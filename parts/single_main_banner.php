<section id="banner" class="main-banner">
	<?php 
        if(!empty($images)) {
        foreach($images as $image) {?>
        <img data-lazy="<?=$image;?>" alt="" />
        <?php }}
        else {
        ?>
        <div class="main-banner-item bg-cover">
            <img data-lazy="<?=get_template_directory_uri().'/img/cititravel-placeholder.jpg';?>" alt="">
        </div>
        <?php
        }
    ?>
</section>

<div class="banner-thumbs">
    <?php if(!empty($images)) {
        foreach($images as $image) {?>
    <img data-lazy="<?=$image;?>" alt="" />
    <?php }}
    else {
    ?>
    <img data-lazy="<?=get_template_directory_uri().'/img/cititravel-placeholder.jpg';?>" alt="">
    <?php
        }
    ?>
</div>