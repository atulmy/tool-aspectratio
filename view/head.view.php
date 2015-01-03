<!-- Head -->

<!-- Meta Tags -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $dataArr["website"]["title"]; ?></title>
    <meta name="description" content="<?php echo $dataArr["website"]["description"]; ?>"/>
    <meta name="keywords" content="<?php echo $dataArr["website"]["keywords"]; ?>"/>

<!-- Meta Tags OG -->
    <meta property="og:type" content="website"/>
    <meta property="og:title" content="<?php echo $dataArr["website"]["title"]; ?>"/>
    <meta property="og:url" content="<?php echo WEB_URL; ?>"/>
    <meta property="og:image" content="<?php echo IMAGE_URL; ?>og.png"/>
    <meta property="og:description" content="<?php echo $dataArr["website"]["description"]; ?>"/>
    <meta property="og:site_name" content="<?php echo $dataArr["website"]["title"]; ?>"/>

    <link rel="icon" href="<?php echo IMAGE_URL; ?>favicon.ico?v=0.0.2" type="image/x-icon"/>

<!-- Style Sheet -->
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo CSS_URL; ?>app.css" />
    <style type="text/css">
        
    </style>

<!-- Javascript Libraries and App -->
    <script type="text/javascript" src="<?php echo JS_URL; ?>jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_URL; ?>bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo JS_URL; ?>app.js"></script>