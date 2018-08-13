<?php $date = new DateTime('NOW'); ?>
<!-- Schema.org markup for Google+ -->
<meta itemprop="name" content="<?= $data['seo_title'] ?>">
<meta itemprop="description" content="<?= $data['seo_desc'] ?>">
<meta itemprop="image" content="http://www.example.com/image.jpg">

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:site" content="@NFQuarterback">
<meta name="twitter:title" content="<?= $data['seo_title'] ?>">
<meta name="twitter:description" content="<?= $data['seo_desc'] ?>">
<meta name="twitter:creator" content="@adamaoc">
<!-- Twitter summary card with large image must be at least 280x150px -->
<meta name="twitter:image:src" content="http://goonvilletx.com/public/images/banners/nf-slider-1.jpg">

<!-- Open Graph data -->
<meta property="og:title" content="<?= $data['seo_title'] ?>" />
<meta property="og:type" content="article" />
<meta property="og:url" content="http://www.goonvilletx.com/" />
<meta property="og:image" content="http://goonvilletx.com/public/images/banners/nf-slider-1.jpg" />
<meta property="og:description" content="<?= $data['seo_desc'] ?>" />
<meta property="og:site_name" content="GoonvilleTX" />
<meta property="article:published_time" content="2018-08-01T19:08:47+01:00" />
<meta property="article:modified_time" content="<?= $date->format('c'); ?>" />
<meta property="article:section" content="Sports" />
<meta property="article:tag" content="goonvilletx, goonville, north forney, north forney football, football, texas football, randy jackson, coach jackson, forney tx, texas, forney" />
<meta property="fb:admins" content="404630916250652" />
