<?php getHeader($data['header_data']); ?>

<style>
  .login-page {
    margin-top: 100px;
    padding: 1em;
    height: 50vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .form {
    background: #FFFFFF;
    max-width: 360px;
    padding: 45px;
    text-align: center;
    box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
  }
  .form label {
    display: none;
  }
  .form input {
    font-family: "Roboto", sans-serif;
    outline: 0;
    background: #f2f2f2;
    width: 100%;
    border: 0;
    margin: 0 0 15px;
    padding: 15px;
    box-sizing: border-box;
    font-size: 14px;
  }
  .form button,
  .form input[type="submit"] {
    text-transform: uppercase;
    outline: 0;
    background: #02255a;
    width: 100%;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
  }
  .form button:hover,.form button:active,.form button:focus,
  .form input[type="submit"]:hover,.form input[type="submit"]:active,.form input[type="submit"]:focus, {
    background: #02255a;
  }
  .form .message {
    margin: 15px 0 0;
    color: #b3b3b3;
    font-size: 12px;
  }
  .form .message a {
    color: #4CAF50;
    text-decoration: none;
  }
  .form .register-form {
    display: none;
  }
  .container {
    position: relative;
    z-index: 1;
    max-width: 300px;
    margin: 0 auto;
  }
  .container:before, .container:after {
    content: "";
    display: block;
    clear: both;
  }
  .container .info {
    margin: 50px auto;
    text-align: center;
  }
  .container .info h1 {
    margin: 0 0 15px;
    padding: 0;
    font-size: 36px;
    font-weight: 300;
    color: #1a1a1a;
  }
  .container .info span {
    color: #4d4d4d;
    font-size: 12px;
  }
  .container .info span a {
    color: #000000;
    text-decoration: none;
  }
</style>

<div class="login-page admin-page">
  <div class="form">
    <h2>Register</h2>

    <?php
    $loggedin = $data['user_data']['loggedin'];
    $user = $data['user_data']['user'];

    if ($loggedin) : ?>
      <p>Hello <a href="#"><?php echo escape($user['username']); ?></a>! - - <a href="/admin/logout/">logout</a></p>
    <?php endif; ?>

    <?php if (!$data['isSuperSet']) {
      getComponent('RegisterForm');
    } ?>

    <?php if ($loggedin && $user['group'] === "1") : ?>
      <?php if (!empty($data['errors'])) : ?>
        <ul>
      <?php foreach ($data['errors'] as $error) : ?>
          <li><?= $error ?></li>
      <?php endforeach; ?>
        </ul>
      <?php  endif; ?>
      <?php getComponent('RegisterForm'); ?>
    <?php else: ?>
      <p>Sorry, only an admin can register a new user.</p>
    <?php endif; ?>
  </div>
</div>

<?php getFooter($data['footer_data']); ?>
