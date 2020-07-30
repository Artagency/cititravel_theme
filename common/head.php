<meta charset="UTF-8">

<title><?php wp_title(''); ?></title>

<meta name="keywords" content="">

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '915479702131640');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=915479702131640&ev=PageView&noscript=1"
/></noscript><!-- End Facebook Pixel Code -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-844586-1"></script>

<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-844586-1');


    const loadFont = (url) => {
      // the 'fetch' equivalent has caching issues
      var xhr = new XMLHttpRequest();
      xhr.open('GET', url, true);
      xhr.onreadystatechange = () => {
        if (xhr.readyState == 4 && xhr.status == 200) {
          let css = xhr.responseText;
          css = css.replace(/}/g, 'font-display: swap; }');

          const head = document.getElementsByTagName('head')[0];
          const style = document.createElement('style');
          style.appendChild(document.createTextNode(css));
          head.appendChild(style);
        }
      };
      xhr.send();
    }

    loadFont('https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700&subset=latin-ext');
</script>

<?php if(!is_mobile()): ?>
<script src="//code.tidio.co/urcenbqebocqeskmmfwcrmt7mjl3te0h.js"></script>
<?php endif; ?>

<!-- Global site tag (gtag.js) - Google Ads: 752314411 -->
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-752314411"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'AW-752314411');
          
    document.addEventListener('wpcf7submit', function(event) {
        var form = $('input[name="_wpcf7"][value="' + event.detail.contactFormId + '"]').parent().parent();
        var ret = true;
        var action = (event.detail.contactFormId==13) ? 'save_contact' : 'save_contact_newsletter';
        jQuery.ajax({
            type: "POST",
            async: false,
            url: "https://cititravel.pl/wp-admin/admin-ajax.php",
            data: {'action': action, data: form.serialize()},
            success: function(result) {
                console.log(result);
                if (result == 1) ret = true;
                else ret = false;
            }
        }); 
        return false;}, false);
</script>

<?php if(is_single()): ?>
	
<?php if(have_posts()) : while (have_posts()) : the_post(); ?>
<?php 
    $imageFacebook = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
?>
<meta property="og:image" content="<?php if(!empty($imageFacebook)) { echo $imageFacebook; } else { echo 'http://cititravel.pl/wp-content/uploads/2018/02/plaza.jpg'; } ?>">
<?php endwhile; endif; ?>
<?php endif; ?>

<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="google-site-verification" content="pbf6Tl2GResG9zJkaIu7pfoP12InIBOWG0e5Dbkv2UI" />

<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">

<link href='https://fonts.gstatic.com' rel='preconnect' crossorigin>

<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/style.css?<?php echo time();?>">
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/print.css" media="print" />
<link rel="Shortcut Icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">

<?php wp_head(); ?>