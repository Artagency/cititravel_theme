<?php  
    /* Template Name: Podstrona Kontakt */
?> 

<?php include('header.php'); ?>

<?php include('parts/main_banner.php'); ?>

<?php $frontpage_id = get_option('page_on_front'); ?>

<div class="main-content main-content--subpage">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-12">
				<div class="page-content">
					<?php if($post->post_content != "") : ?>
					<div class="row">
						<div class="col-lg-4 col-md-12">
							<?php the_content(); ?>
						</div>
					</div>
					<?php endif; ?>

					<div class="row">
						<?php if(get_field('content_1nd_col')): ?>
						<div class="col-lg-4 col-md-12">
							<?php the_field('content_1nd_col'); ?>
						</div>
						<?php endif; ?>

						<?php if(get_field('content_2nd_col')): ?>
						<div class="col-lg-3 col-md-12">
							<?php the_field('content_2nd_col'); ?>
						</div>
						<?php endif; ?>

						<?php if(get_field('content_3rd_col')): ?>
						<div class="col-lg-5 col-md-12">
							<?php the_field('content_3rd_col'); ?>
						</div>
						<?php endif; ?>
					</div>
					
					<div class="row--contact">
						<div class="col-lg-6 col-md-12">
							<?php if(get_field('page_mail', $frontpage_id)): ?>
							<a class="mail" href="mailto:<?php the_field('page_mail', $frontpage_id); ?>"><?php the_field('page_mail', $frontpage_id); ?></a>
							<?php endif; ?>
						</div>

						<div class="col-lg-6 col-md-12">
							<?php include('parts/part_phone.php'); ?>
						</div>
					</div>
				
					<h2>Nasze biura</h2>
					<div id="map" class="google-map" data-temp-dir="<?php bloginfo('template_directory'); ?>"></div>
				</div>
				
				<div class="team-hld">
					<?php
						$teamOneArr = array('post_type' => 'team', 'orderby' => 'menu_order','order' => 'ASC');
					    $teamOneLoop = new WP_Query($teamOneArr);
					?>
					<h2>Konsultanci</h2>
					
					<div class="row">
						<?php while($teamOneLoop->have_posts()) : $teamOneLoop->the_post(); ?>
						<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'single-post-thumbnail'); ?>
						<div class="col-lg-4 team-item">
							<img data-src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>">

							<div class="team-item__content">
								<h4><?php the_title(); ?></h4>

								<?php if(get_field('position')): ?>
								<span class="position"><?php the_field('position'); ?></span>
								<?php endif; ?>
								
								<?php the_content(); ?>
							</div>
						</div>
						<?php endwhile; wp_reset_query(); ?>
					</div>
				</div>
			</div>

			<div class="col-lg-4">
				<h2 class="bordered">Na skróty</h2>

				<?php wp_nav_menu(array('container_class' => 'shortcuts', 'theme_location' => 'footer_9')); ?>
			</div>
		</div>
	</div>
</div>



<?php include('footer.php'); ?>