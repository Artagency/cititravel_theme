<?php include('header.php'); ?>

<?php include('parts/main_banner.php'); ?>

<div class="main-content main-content--subpage main-content--singleblog">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="page-content">
					<?php the_content(); ?>
				</div>
			</div>

			<div class="col-lg-4">
				<h2 class="bordered">Przeczytaj również</h2>
				
				<?php
					$blogOneArr = array('post_type' => 'blog', 'orderby' => 'menu_order','order' => 'rand', 'post__not_in' => array($post->ID));
				    $blogOneLoop = new WP_Query($blogOneArr);

				    $a = 0;
				?>
				<ul class="shortcuts">
					<?php while($blogOneLoop->have_posts()) : $blogOneLoop->the_post(); $a++; ?>
					<?php if($a <= 5): ?>
					<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
					<?php endif; ?>
					<?php endwhile; wp_reset_query(); ?>
				</ul>
				
				<?php if(get_field('img_cat_1', $frontpage_id) && get_field('content_on_img_cat_1', $frontpage_id)): ?>
				<div class="cat-hld">
					<img src="<?php the_field('img_cat_1', $frontpage_id); ?>" alt="">
					
					<?php if(get_field('content_on_img_cat_1', $frontpage_id)): ?>
					<div class="content-cat">
						<?php the_field('content_on_img_cat_1', $frontpage_id); ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
				
				<?php if(get_field('img_cat_2', $frontpage_id) && get_field('content_on_img_cat_2', $frontpage_id)): ?>
				<div class="cat-hld">
					<img src="<?php the_field('img_cat_2', $frontpage_id); ?>" alt="">
					
					<?php if(get_field('content_on_img_cat_2', $frontpage_id)): ?>
					<div class="content-cat">
						<?php the_field('content_on_img_cat_2', $frontpage_id); ?>
					</div>
					<?php endif; ?>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<div class="section-bg section-bg--spb">
	<div class="container">
		<?php
			$blogOneArr = array('post_type' => 'blog', 'orderby' => 'menu_order','order' => 'ASC', 'post__not_in' => array($post->ID));
		    $blogOneLoop = new WP_Query($blogOneArr);

		    $i = 0;
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
					<div class="blog-item__image bg-cover" style="background-image: url('<?php echo $image_small[0]; ?>');">
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
					<div class="blog-item__image bg-cover" style="background-image: url('<?php echo $image_medium[0]; ?>');">
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
					<div class="blog-item__image bg-cover" style="background-image: url('<?php echo $image_tall[0]; ?>');">
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

<?php include('footer.php'); ?>