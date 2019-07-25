<?php  
    /* Template Name: Podstrona O firmie */
?> 

<?php include('header.php'); ?>

<?php include('parts/main_banner.php'); ?>

<?php $frontpage_id = get_option('page_on_front'); ?>

<div class="main-content main-content--subpage">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="page-content">
					<?php the_content(); ?>

					<div class="col-lg-6 col-md-12">
						<?php if(get_field('page_mail', $frontpage_id)): ?>
						<a class="mail" href="mailto:<?php the_field('page_mail', $frontpage_id); ?>"><?php the_field('page_mail', $frontpage_id); ?></a>
						<?php endif; ?>
					</div>

					<div class="col-lg-6 col-md-12">
						<?php include('parts/part_phone.php'); ?>
					</div>

					<?php if(get_field('content_after')): ?>
					<?php the_field('content_after'); ?>
					<?php endif; ?>
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