<?php getHeader($data['header_data']); ?>
<div class="admin-page">
  <div class="mid-banner">
    <div class="min-banner__content">
      <h1>Admin</h1>
    </div>
  </div>
  <section class="admin-page__wrap page-section">
    <h2>Welcome, <?= $data['user_data']['user']['name'] ?></h2>
    <p>Edit page titles and SEO details from the Edit Page button in the admin bar. Edit/Update Schedule and Sponors through the links in the admin bar as well.</p>
    <p>If you have any issues, please let Adam know ASAP! Thanks.</p>

    <form action="/admin/upload/" method="post" enctype="multipart/form-data" class="login-form">
      <input type="file" id="file" name="file" />
      <input type="submit" value="Upload" />
    </form>
  </section>
</div>
<?php getFooter($data['footer_data']); ?>
