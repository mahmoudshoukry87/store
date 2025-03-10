<?php
include 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>الصفحة الرئيسية</title>
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/topbar.css">
    <!-- استدعاء مكتبة Swiper وتنسيقاتها -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/slideshow.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <div class="main-container">
        <?php include 'includes/header.php'; ?>

        <main>
            <!-- السلايدر الأول (الحالي) -->
            <div class="container">
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php
                        $query = "SELECT * FROM slideshow_images";
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($slide = mysqli_fetch_assoc($result)) {
                                echo '<div class="swiper-slide">';
                                if ($slide['image_path']) {
                                    echo '<img src="' . htmlspecialchars($slide['image_path']) . '" alt="Slide">';
                                } else {
                                    echo '<p>لا توجد صورة</p>';
                                }
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="swiper-slide"><p>لا توجد سلايدات لعرضها.</p></div>';
                        }
                        ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>

            <!-- سلايدر التصنيفات -->
            <div class="categories-container">
                <h2>التصنيفات الرئيسية</h2>
                <div class="swiper categoriesSwiper">
                    <div class="swiper-wrapper">
                        <?php
                        $query = "SELECT * FROM product_categories ORDER BY sort_order ASC"; // غيرنا display_order لـ sort_order
                        $result = mysqli_query($conn, $query);
                        if (mysqli_num_rows($result) > 0) {
                            while ($category = mysqli_fetch_assoc($result)) {
                                echo '<div class="swiper-slide">';
                                echo '<div class="category-card">';
                                if ($category['image_path']) { // غيرنا image لـ image_path
                                    echo '<img src="' . htmlspecialchars($category['image_path']) . '" alt="' . htmlspecialchars($category['name']) . '">';
                                } else {
                                    echo '<p>لا توجد صورة</p>';
                                }
                                echo '<h3>' . htmlspecialchars($category['name']) . '</h3>';
                                echo '</div>';
                                echo '</div>';
                            }
                        } else {
                            echo '<div class="swiper-slide"><p>لا توجد تصنيفات لعرضها.</p></div>';
                        }
                        ?>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-pagination categories-pagination"></div>
                </div>
            </div>
        </main>

        <?php include 'includes/footer.php'; ?>
    </div>

    <!-- استدعاء مكتبة Swiper وJavaScript الخاص بالسلايدر -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="js/slideshow.js"></script>
    <script src="js/categories-slideshow.js"></script>
</body>
</html>