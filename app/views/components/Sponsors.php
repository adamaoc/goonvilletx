<div class="sponsors">
  <div class="sponsors__banner">
    <h2>Sponsors</h2>
  </div>
  <div class="sponsors__logos">
    <ul>
      <?php foreach ($data as $sponsor) : ?>
        <?php if ($sponsor['placement'] === 'home') : ?>
          <li>
            <img src="/public/images/sponsors/<?= $sponsor['image'] ?>" alt="<?= $sponsor['image_alt'] ?>" />
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
</div>
