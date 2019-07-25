<?php
	$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'banner-image-size');
?>

<?php if(!empty($image)): ?>
<section class="banner-main">
    <div class="banner-img bg-cover" style="background-image: url('<?php echo $image[0]; ?>');">
        <div class="container">
            <?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
            
            <div class="banner-content">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>