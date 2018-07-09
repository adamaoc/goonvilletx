<form action="" method="post" class="login-form">
  <div class="fields">
    <label for="username">User name</label>
    <input type="text" name="username" id="username" autocomplete="off" value="<?php echo escape(Input::get('username')); ?>" placeholder="User Name" />
  </div>
  <div class="fields">
    <label for="password">password</label>
    <input type="password" name="password" id="password" autocomplete="off" placeholder="Password" />
  </div>
  <div class="fields">
    <label for="name">name</label>
    <input type="text" name="name" id="name" autocomplete="off" value="<?php echo escape(Input::get('name')); ?>" placeholder="Full Name" />
  </div>
  <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
  <input type="submit" value="Register" />
</form>
