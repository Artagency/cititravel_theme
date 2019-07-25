<?php  
    /* Template Name: Podstrona podziękowania za zamówienie */
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

<!-- Event snippet for Zakup wycieczki online conversion page -->
<script>
  gtag('event', 'conversion', {
      'send_to': 'AW-752314411/-q_QCJPRiZgBEKvQ3eYC',
      'transaction_id': ''
  });
</script>