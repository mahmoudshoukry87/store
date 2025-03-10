<?php include 'includes/header.php'; ?>
<main>
    <div class="slideshow-container" style="margin-top: 50px;"> <!-- مسافة أكبر تحت الهيدر -->
        <?php
        include 'includes/config.php';
        $query = "SELECT * FROM slideshow_images";
        $result = mysqli_query($conn, $query);
        $slides = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $slides[] = $row['image_path'];
        }
        ?>
        <div class="slider-wrapper">
            <?php foreach ($slides as $index => $slide): ?>
                <div class="slide" style="background-image: url('<?php echo $slide; ?>');"></div>
            <?php endforeach; ?>
        </div>
        <a class="prev" onclick="plusSlides(-1)">❮</a>
        <a class="next" onclick="plusSlides(1)">❯</a>
    </div>

    <!-- ربط ملفات الجافاسكريبت -->
    <script src="js/slideshow.js"></script>
</main>
<?php include 'includes/footer.php'; ?>