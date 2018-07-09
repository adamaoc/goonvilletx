<?php getHeader($data['header_data']); ?>

<div class="admin-page">
  <div class="large-banner">
    <div class="large-banner__content">
      <h1>Login</h1>
    </div>
  </div>

  <?php if (!empty($data['errors'])) : ?>
    <ul>
  <?php foreach ($data['errors'] as $error) : ?>
      <li><?= $error ?></li>
  <?php endforeach; ?>
    </ul>
  <?php  endif; ?>

  <form action="" method="post">
    <div class="fields">
      <label for="username">User name</label>
      <input type="text" name="username" id="username" autocomplete="off" value="<?php echo escape(Input::get('username')); ?>" />
    </div>
    <div class="fields">
      <label for="password">password</label>
      <input type="password" name="password" id="password" autocomplete="off" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Login" />
  </form>

</div>


<?php getFooter($data['footer_data']); ?>
