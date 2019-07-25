<?php  
    /* Template Name: Podstrona Sitemapy */
?> 

<?php include('header.php'); ?>

<div class="main-content main-content--subpage">
	<div class="container">
		<div class="row">
			<?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
			
			<div class="page-content">
				<?php the_content(); ?>
				
				<ul class="sitemap">
					<?php wp_list_pages(array(
						'title_li' => '',
						'sort_column' => 'menu_order'
					)); ?>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>