<?php  
    /* Template Name: Podstrona Bloga */
?> 

<?php include('header.php'); ?>

<?php include('parts/main_banner.php'); ?>

<div class="main-content main-content--subpage main-content--blog">
	<div class="container">
		<div class="row">
			<?php
				$blogOneArr = array('post_type' => 'blog', 'orderby' => 'menu_order','order' => 'ASC');
			    $blogOneLoop = new WP_Query($blogOneArr);

			    $a = 0;
			?>
			
			<?php while($blogOneLoop->have_posts()) : $blogOneLoop->the_post(); $a++; ?>
			<?php 
				$image_small = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
				$image_medium = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');
				$image_tall = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
			?>

			<?php if($a == 1 || $a == 7 || $a == 13): ?>
			<div class="col-lg-4 col-md-12">
				<a href="<?php the_permalink(); ?>" class="blog-item blog-item--medium">
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

			<?php if($a == 2 || $a == 8 || $a == 14): ?>
			<div class="col-lg-8 col-md-12">
				<a href="<?php the_permalink(); ?>" class="blog-item blog-item--medium">
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

			<?php if($a == 3 || $a == 4 || $a == 9 || $a == 10 || $a == 15 || $a == 16): ?>
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
			
			<?php if($a == 5 || $a == 11 || $a == 17): ?>
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

			<?php if($a == 6 || $a == 12 || $a == 18): ?>
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