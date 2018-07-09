<?php getHeader($data['header_data']); ?>
<div style="margin-top: 100px"></div>

<h2>Register</h2>

<?php
$loggedin = $data['user_data']['loggedin'];
$user = $data['user_data']['user'];
if ($loggedin) : ?>
  <p>Hello <a href="#"><?php echo escape($user['username']); ?></a>! - - <a href="/admin/logout/">logout</a></p>
<?php endif; ?>

<?php if ($loggedin && $user['group'] === "1") : ?>
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
    <div class="fields">
      <label for="name">name</label>
      <input type="text" name="name" id="name" autocomplete="off" value="<?php echo escape(Input::get('name')); ?>" />
    </div>
    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
    <input type="submit" value="Register" />
  </form>
<?php else: ?>
  <p>Sorry, only an admin can register a new user.</p>
<?php endif; ?>




<div style="margin-top: 100px"></div>

<?php getFooter($data['footer_data']); ?>
