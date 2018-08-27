<?php

    function make_thumb($src, $dest, $desired_width) {
        $source_image = imagecreatefromjpeg($src);
        $width = imagesx($source_image);
        $height = imagesy($source_image);
        $desired_height = floor($height * ($desired_width / $width));
        $virtual_image = imagecreatetruecolor($desired_width, $desired_height);
        imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);
        imagejpeg($virtual_image, $dest);
    }
    $dir = "public/images/" . $data['folder'];
    $thumbsDir = $dir . "/thumbs";
    $imgArray = array();
    if(file_exists($dir)) {
        $scanned = array_diff(scandir($dir), array('..', '.'));
        foreach ($scanned as $key => $value) {
            if ($value !== 'banner.jpg' && $value !== 'thumbs') {
                array_push($imgArray, $value);
            }
        }
    }
    if (!file_exists($thumbsDir)) {
        mkdir($thumbsDir);
        foreach($imgArray as $image) {
            make_thumb(
                ($dir . "/" . $image), 
                ($thumbsDir . "/" . $image), 
                300);
        }
    }
?>

<?php if (count($imgArray) > 0) : ?>
    <div class="page-gallery">
        <?php foreach ($imgArray as $img) : ?>
            <div class="gallery-img" style="background-image: url(<?php echo '/'.$thumbsDir.'/'.$img; ?>)" data-img="<?= $img ?>"></div>
        <?php endforeach; ?>
    </div>
    <div class="gallery-overlay">
        <button id="gallery-prev">&lt;</button>
        <img src="" />
        <button id="gallery-next">&gt;</button>
    </div>
    <script>
        var gallery = <?php echo json_encode($imgArray); ?>;
        // console.log(gallery);
        var galleryBox = document.querySelector('.page-gallery');
        var overlayBox = document.querySelector('.gallery-overlay');
        var overlayImg = document.querySelector('.gallery-overlay img');
        var prevBtn = document.getElementById('gallery-prev');
        var nextBtn = document.getElementById('gallery-next');

        var goToPrevImg = function(e) {
            var curSrc = overlayImg.dataset.img;
            var curIndex = 0;
            gallery.forEach(function(img, i) {
                if (img === curSrc) {
                    curIndex = i;
                }
            });
            if (curIndex === 0) {
                return;
            }
            overlayImg.src = "/public/images/pages/pnp/" + gallery[curIndex -1];
            overlayImg.dataset.img = gallery[curIndex -1];
        }
        var goToNextImg = function(e) {
            var curSrc = overlayImg.dataset.img;
            var curIndex = 0;
            gallery.forEach(function(img, i) {
                if (img === curSrc) {
                    curIndex = i;
                }
            });
            
            if (curIndex === (gallery.length - 1)) {
                return;
            }
            overlayImg.src = "/public/images/pages/pnp/" + gallery[curIndex + 1];
            overlayImg.dataset.img = gallery[curIndex + 1];
        }
        overlayBox.addEventListener('click', function() {
            if (event.target.className === 'gallery-overlay gallery-overlay--open') {
                event.target.classList.remove('gallery-overlay--open');
                overlayImg.src = '';
                document.body.style.overflow = '';
            }
        })
        galleryBox.addEventListener('click', function() {
            overlayBox.classList.add('gallery-overlay--open');
            overlayImg.src = "/public/images/pages/pnp/" + event.target.dataset.img;
            overlayImg.dataset.img = event.target.dataset.img;
            document.body.style.overflow = 'hidden';
        });
        prevBtn.addEventListener('click', goToPrevImg.bind(this));
        nextBtn.addEventListener('click', goToNextImg.bind(this));
    </script>
<?php endif; ?>