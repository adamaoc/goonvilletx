<!doctype html>
<html itemscope itemtype="http://schema.org/Article">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $data['seo_title'] ?></title>
    <meta name="description" content="<?= $data['seo_desc'] ?>" />

    <?php getComponent('socialMetaTags', $data); ?>

    <link rel="apple-touch-icon" sizes="180x180" href="/public/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/public/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/public/images/icons/favicon-16x16.png">
    <link rel="manifest" href="/public/images/icons/site.webmanifest">
    <link rel="mask-icon" href="/public/images/icons/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/public/images/icons/favicon.ico">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-config" content="/public/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <link rel="stylesheet" href="<?= Config::get('http/root') ?>public/css/main.css">
  </head>
  <body>

    <div id="adminNav"></div>
    <?php getComponent('navigation'); ?>
