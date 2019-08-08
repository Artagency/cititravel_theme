<?php include('header.php'); ?>

<section class="banner-main">
    <div class="banner-img bg-cover" style="background-image: url('https://cititravel.pl/wp-content/uploads/2019/01/8.jpg');">
        <div class="container">
            <?php if(function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
            
            <div class="banner-content">
                <h1><?php the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>

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