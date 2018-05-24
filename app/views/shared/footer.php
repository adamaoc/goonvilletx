<?php $school = $data['school']; ?>
<footer class="site-footer">
  <div class="footer-top">
    <div class="footer-top__grid-1">
      <h4>Info</h4>
      <a href="mailto:<?= $school['email'] ?>"><?= $school['email'] ?></a>
      <span class="phone"><?= $school['phone'] ?></span>
    </div>
    <div class="footer-top__grid-2">
      <img src="/public/images/logos/NF-logo.png" alt="NF Logo" />
    </div>
    <div class="footer-top__grid-3">
      <h4>Address</h4>
      <span><?= $school['address']['street'] ?></span>
      <span><?= $school['address']['city'] ?>, <?= $school['address']['state'] ?> <?= $school['address']['zip'] ?></span>
    </div>
  </div>
  <div class="footer-social">
    <?php getComponent('SocialLinks', $data['social_links']); ?>
  </div>
  <div class="footer-lower">
    <a href="http://ampnetmedia.com">ampnetmedia</a> | Goonville, TX &copy; 2018. All Rights Reserved.
  </div>
</footer>
<script src="./public/js/main.js"></script>

<!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
<script>
    window.ga=function(){ga.q.push(arguments)};ga.q=[];ga.l=+new Date;
    ga('create','UA-XXXXX-Y','auto');ga('send','pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>
</html>
