<!DOCTYPE html>
<!--[if IE 9]>    <html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!--> <html itemscope itemtype="http://schema.org/WebPage" <?php language_attributes(); ?> class="no-js <?php if(is_tablet()) { echo 'tablet-view'; } elseif(is_mobile()) { echo 'mobile-view'; }; ?>"> <!--<![endif]-->

<head>
	<?php include('common/head.php'); ?>
</head>

<?php $frontpage_id = get_option('page_on_front'); ?>

<body <?php page_bodyclass(); ?>>

	<?php if(is_mobile() || is_tablet()): ?>
	<div class="trigger-btn">&nbsp;</div>

	<div class="overlay overlay-hugeinc">
		<button type="button" class="overlay-close">Zamknij</button>
		<nav>
			<?php wp_nav_menu(array('menu_id' => 'overlay-menu', 'theme_location' => 'primary')); ?>
		</nav>
	</div>
	<?php endif; ?>

	<div id="holder">
		<header class="header">
			<div class="container">
				<a href="<?php echo home_url('/') ?>" class="logo">
					<img src="<?php echo get_template_directory_uri(); ?>/img/logo.svg" alt="Cititravel.pl">

					<span class="title"><strong>Najsłoneczniej</strong> od 20 lat</span>
				</a>

				<div class="right-top">
					<?php if(get_field('contact_link', $frontpage_id)): ?>
					<a href="<?php the_field('contact_link', $frontpage_id); ?>" class="link">Kontakt</a>
					<?php endif; ?>

					<span class="phone">infolinia (22) 487 55 55</span>
				</div>

				<?php if(!is_mobile()): ?>
				<nav class="main-navigation">
					<?php 
						class WPSE_78121_Sublevel_Walker extends Walker_Nav_Menu{
						    function start_lvl( &$output, $depth = 0, $args = array() ) {
						        $indent = str_repeat("\t", $depth);
						        $output .= "\n$indent<div class='sub-menu-hld'><div class='container'><ul class='sub-menu'>\n";
						    }
						    function end_lvl( &$output, $depth = 0, $args = array() ) {
						        $indent = str_repeat("\t", $depth);
						        $output .= "$indent</ul></div></div>\n";
						    }
						}

						wp_nav_menu(array('menu_id' => 'main', 'container_class' => 'menu', 'theme_location' => 'primary', 'walker' => new WPSE_78121_Sublevel_Walker)); 
					?>
				</nav>
				<?php endif; ?>
			</div>
		</header>

	