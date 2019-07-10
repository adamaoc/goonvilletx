<?php $school = $data['school']; ?>
<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-top__grid-1">
      <h4>Info</h4>
      <a href="mailto:<?= $school['email'] ?>"><?= $school['email'] ?></a>
      <span class="phone"><?= $school['phone'] ?></span>
    </div>

    <div class="footer-top__grid-2">
      <!-- <img src="/<?= $school['footer_logo'] ?>" alt="NF Logo" /> -->
      <img src="https://ampnet.sfo2.cdn.digitaloceanspaces.com/Goonville/logos/5b74e538b8b5c1.64798301.png" alt="NF logo" />
    </div>
    
    <div class="footer-top__grid-3">
      <h4>Address</h4>
      <span><?= $school['street'] ?></span>
      <span><?= $school['city'] ?>, <?= $school['state'] ?> <?= $school['zip'] ?></span>
    </div>
  </div>
  <div class="footer-social">
    <?php getComponent('SocialLinks', $data['social_links']); ?>
  </div>
  <div class="footer-lower">
    <a href="http://ampnetmedia.com">ampnetmedia</a> | Goonville, TX &copy; 2018. All Rights Reserved.
  </div>
</footer>

<script src="<?= Config::get('http/root') ?>public/js/main.js"></script>
<?php if ($data['user_data']['loggedin']) : ?>
  <script>
    window.token = "<?= Config::get('data/api_token'); ?>";
    var USER = {
      username: "<?= $data['user_data']['user']['username'] ?>",
      fullname: "<?= $data['user_data']['user']['name'] ?>"
    };
  </script>
  <script src="<?= Config::get('http/root') ?>dist/admin.js"></script>
<?php endif; ?>

<?php if (Config::get('http/root') === 'http://goonvilletx.com/') : ?>
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-122648229-1"></script>
  <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-122648229-1');
  </script>
<?php endif; ?>
</body>
</html>
