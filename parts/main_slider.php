<div class="slider-hld">
	<div class="main-slider">
		<?php
			$sliderOneArr = array('post_type' => 'main_slider', 'orderby' => 'menu_order','order' => 'ASC');
		    $sliderOneLoop = new WP_Query($sliderOneArr);
		?>
		<?php while($sliderOneLoop->have_posts()) : $sliderOneLoop->the_post(); ?>
		<?php 
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
	    ?>
		<div class="main-slider-item bg-cover" style="background-image: url('<?php echo $image[0]; ?>');">
			<div class="container">
				<div class="slider-content">
					<?php the_content(); ?>
				</div>
			</div>
		</div>

	    <?php endwhile; wp_reset_query(); ?>
	</div>

	<div class="search-panel">
		<div class="container">
			<?php include('search_panel.php'); ?>
		</div>
	</div>
</div>