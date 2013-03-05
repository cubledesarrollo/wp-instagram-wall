<!DOCTYPE html>
<html>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php if (get_option('title')): ?>
    <title><?php echo get_option('title') ?> </title>
    <?php else: ?>
    <title><?php bloginfo('name'); ?> | Instagram Wall </title>
    <?php endif; ?>
    <link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory'); ?>/favicon.ico" />
    <?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
    <!--[if lt IE 9]>
    <script src="<?php echo plugins_url("wp-instagram-wall/assets/js/html5.js"); ?>" type="text/javascript"></script>
    <![endif]-->
    
    <link rel='stylesheet' href='<?php echo plugins_url("wp-instagram-wall/assets/css/style.css");?>' type='text/css' media='all' />
    
    <script type="text/javascript" src="<?php echo plugins_url("wp-instagram-wall/assets/js/jquery-1.9.1.min.js");?>"></script>
    <script type="text/javascript" src="<?php echo plugins_url("wp-instagram-wall/assets/js/jquery.masonry.min.js");?>"></script>
    <script type="text/javascript" src="<?php echo plugins_url("wp-instagram-wall/assets/js/spin.min.js");?>"></script>
    <script type="text/javascript" src="<?php echo plugins_url("wp-instagram-wall/assets/js/main.js");?>"></script>
</head>
<body>
<div id="title"></div>
<div id="container">
</div>
<script type="text/javascript">
var access_token = "<?php echo get_option('access_token')?>";
wp_instagram_wall();
</script>
</body>
</html>