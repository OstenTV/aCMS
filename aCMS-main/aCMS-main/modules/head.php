<?php
$site_name = 'OstenTV';
if (isset($meta['title'])) {
    $title = $meta['title'] . ' - ' . $site_name;
} else {
    $title = $site_name;
    $meta['title'] = $site_name;
}
?>

<!-- Meta -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8">
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="revisit-after" content="7 days">

<meta name="robots" content="<?php if(!$meta['index']) { echo 'noindex'; } else { echo 'index'; } ?>, <?php if(!$meta['follow']) { echo 'nofollow'; } else { echo 'follow'; } ?>" />
<meta name="author" content="Tobias Sindrup">
<meta name="keywords" content="<?php echo $meta['keywords']; ?>">
<meta name="description" content="<?php echo $meta['description']; ?>" />
<title><?php echo $title; ?></title>

<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-title" content="<?php echo $title; ?>">
<meta name="apple-mobile-web-app-status-bar-style" content="black" />
<meta name="format-detection" content="telephone=no" />


<!-- Icons -->
<link rel="icon" href="/content/images/favicon.ico" />
<link rel="apple-touch-icon" href="/content/images/apple/touch-icon-iphone.png" />
<link rel="apple-touch-icon" href="/content/images/apple/touch-icon-ipad.png" sizes="152x152" />
<link rel="apple-touch-icon" href="/content/images/apple/touch-icon-iphone-retina.png" sizes="180x180" />
<link rel="apple-touch-icon" href="/content/images/apple/touch-icon-ipad-retina.png" sizes="167x167" />
<link rel="apple-touch-startup-image" href="/content/images/apple/launch.png" />


<!-- Scripts -->
<script src="/scripts/JS/jquery-3.3.1.min.js"></script>
<script src="/scripts/JS/popper.min.js"></script>
<script src="/scripts/JS/bootstrap.min.js"></script>
<script src="/scripts/JS/util/util.js"></script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118470729-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'UA-118470729-1');
</script>


<!-- Stylesheets -->
<link rel="stylesheet" type="text/css" href="/content/CSS/bootstrap/bootstrap.min.css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="/content/CSS/style.css" />
<link rel="stylesheet" type="text/css" href="/content/CSS/video-player.css" />


<!-- Misc -->
<base target="_self" />
