	<div class="trip-container">
		<div class="container">
			<img data-src="<?php echo get_template_directory_uri(); ?>/img/wycieczki-img.png" alt="Wycieczki">
		</div>
	</div>

	<footer class="<?php if(is_front_page()) { echo 'frontpage'; } ?>">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box">
						<header>
							<img data-src="<?php echo get_template_directory_uri(); ?>/img/logo_footer.png" alt="<?php bloginfo('name'); ?>">
						</header>

						<?php if(get_field('page_mail', $frontpage_id)): ?>
						<a class="mail" href="mailto:<?php the_field('page_mail', $frontpage_id); ?>"><?php the_field('page_mail', $frontpage_id); ?></a>
						<?php endif; ?>

						<?php if(get_field('phone', $frontpage_id)): ?>
						<span class="phone"><?php the_field('phone', $frontpage_id); ?></span>
						<?php endif; ?>

						<ul class="socialmedia">
							<li><a href="https://www.facebook.com/Cititravel.Polska/" class="fb" target="_blank"><i class="icon-facebook"></i></a></li>
						</ul>
					</div>
				</div>

				<div class="col-lg-2 col-md-6">
					<header>
						<h4>Informacje ogólne</h4>
					</header>

					<?php wp_nav_menu(array('container_class' => 'footer-main', 'theme_location' => 'footer_1')); ?>
				</div>

				<div class="col-lg-2 col-md-6">
					<header>
						<h4>Współpraca</h4>
					</header>

					<?php wp_nav_menu(array('container_class' => 'footer-main', 'theme_location' => 'footer_2')); ?>
				</div>

				<div class="col-lg-2 col-md-6">
					<header>
						<h4>Bezpieczeństwo</h4>
					</header>

					<?php wp_nav_menu(array('container_class' => 'footer-main', 'theme_location' => 'footer_3')); ?>
				</div>

				<div class="col-lg-2 col-md-6">
					<header>
						<h4>Kontakt</h4>
					</header>
			
					<?php wp_nav_menu(array('container_class' => 'footer-main', 'theme_location' => 'footer_4')); ?>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-3 col-md-6"></div>

				<div class="col-lg-2 col-md-6">
					<header>
						<h4>Wybrane wycieczki</h4>
					</header>
			
					<?php wp_nav_menu(array('container_class' => 'footer-main', 'theme_location' => 'footer_5')); ?>
				</div>

				<div class="col-lg-2 col-md-6">
					<header>
						<h4>Last minute</h4>
					</header>
			
					<?php wp_nav_menu(array('container_class' => 'footer-main', 'theme_location' => 'footer_6')); ?>
				</div>

				<div class="col-lg-2 col-md-6">
					<header>
						<h4>Regiony</h4>
					</header>
			
					<?php wp_nav_menu(array('container_class' => 'footer-main', 'theme_location' => 'footer_7')); ?>
				</div>
			</div>

			<div class="row row--footer">
				<div class="col-lg-6 col-md-12">
					<p class="copyright">Copyright &copy; cititravel.pl 2006-2019</p>
				</div>

				<div class="col-lg-6 col-md-12">
					<p class="made-by">code &amp; analytics by <a href="http://clickcloud.pl" target="_blank">clickcloud.pl</a></p>
				</div>
			</div>
		</div>
	</footer>
	
	<?php if(is_front_page()): ?>
	<div class="footer-promo bg-cover">
        <p class="footer-promo-content">Jeszcze więcej promocji i ciekawych informacji<br>znajdziesz na naszym profilu. Dołącz do nas.</p>

        <a href="https://www.facebook.com/Cititravel.Polska/" target="_blank" class="btn">Dołącz na facebook.com</a>
    </div>
    <?php endif; ?>

    <div class="popup-hld popup-hld--question">
	    <div class="popup-blank"></div>

	    <div class="container-hld">
	        <div class="close-btn"><span class="icon-delete"></span></div>
	        
	        <h3>Zadaj pytanie</h3>
	        
	        <?php echo do_shortcode("[contact-form-7 id='13' title='Formularz kontaktowy']"); ?>
	    </div>
	</div>

	<?php if(function_exists('cn_cookies_accepted') && cn_cookies_accepted()) ?>

            
	<?php if(is_front_page()): ?>
	<script src="<?php echo get_template_directory_uri(); ?>/dist/js/app-homejs.js"></script>
	<?php else: ?>
	<script src="<?php echo get_template_directory_uri(); ?>/dist/js/app.js"></script>
	<?php endif; ?>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.9.2/i18n/jquery.ui.datepicker-pl.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/renia.js"></script>
    <?php if($_GET['dev']==1) {?><script src="<?php echo get_template_directory_uri(); ?>/js/renia_dev.js" async></script><?php }?>

    <?php if(!is_front_page()): ?>
	<?php wp_footer(); ?>
	<?php endif; ?>

	<script>
        document.addEventListener('wpcf7submit', function(event) {
            var form = $('input[name="_wpcf7"][value="' + event.detail.contactFormId + '"]').parent().parent();
            var ret = true;
            jQuery.ajax({
                type: "POST",
                async: false,
                url: "https://cititravel.pl/wp-admin/admin-ajax.php",
                data: {'action': 'send_sms',data: form.serialize()},
                success: function(result) {
                    console.log(result);
                    if (result == 1) ret = true;
                    else ret = false;
                }
            }); 
        return false;}, false);
	</script>

	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/cookie-bar/cookiebar-latest.min.js?always=1&scrolling=1&hideDetailsBtn=1"></script>
</div>
</body>
</html>