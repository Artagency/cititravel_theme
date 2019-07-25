<div class="section-bg">
	<div class="container">
		<?php
			$blogOneArr = array('post_type' => 'blog', 'orderby' => 'menu_order','order' => 'ASC');
		    $blogOneLoop = new WP_Query($blogOneArr);

		    $i = 0;
		    $ii = 0;
		?>
		<div class="row">
			<?php while($blogOneLoop->have_posts()) : $blogOneLoop->the_post(); $i++; ?>

			<?php 
				$image_small = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
				$image_medium = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
				$image_tall = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
			?>

			<?php if($i <= 2): ?>
			<div class="col-lg-4 col-md-12">
				<a href="<?php the_permalink(); ?>" class="blog-item">
					<?php if(!empty($image_small)): ?>
					<div class="blog-item__image bg-cover" data-src="<?php echo $image_small[0]; ?>">
						<div class="blog-item__title">
							<h2><?php the_title(); ?></h2>
						</div>
					</div>
					<?php endif; ?>
				</a>
			</div>
			<?php endif; ?>
			
			<?php if($i == 3): ?>
			<div class="col-lg-8 col-md-12">
				<a href="<?php the_permalink(); ?>" class="blog-item">
					<?php if(!empty($image_medium)): ?>
					<div class="blog-item__image bg-cover" data-src="<?php echo $image_medium[0]; ?>">
						<div class="blog-item__title">
							<h2><?php the_title(); ?></h2>
						</div>
					</div>
					<?php endif; ?>
				</a>
			</div>
			<?php endif; ?>

			<?php if($i == 4): ?>
			<div class="col-lg-4 col-md-12">
				<a href="<?php the_permalink(); ?>" class="blog-item blog-item--long">
					<?php if(!empty($image_tall)): ?>
					<div class="blog-item__image bg-cover" data-src="<?php echo $image_tall[0]; ?>">
						<div class="blog-item__title">
							<h2><?php the_title(); ?></h2>
						</div>
					</div>
					<?php endif; ?>
				</a>
			</div>
			<?php endif; ?>
			<?php endwhile; wp_reset_query(); ?>
		</div>
	</div>
</div>