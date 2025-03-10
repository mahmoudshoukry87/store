<?php
include 'includes/config.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';
require 'vendor/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$error = '';
$success = '';
$step = isset($_GET['step']) ? $_GET['step'] : 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($step == 1) {
        $email = $_POST['email'];
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            $token = bin2hex(random_bytes(16)); // رمز عشوائي
            $query = "UPDATE users SET reset_token = '$token' WHERE email = '$email'";
            mysqli_query($conn, $query);

            // إعداد الإيميل
            $mail = new PHPMailer(true);
            try {
                // إعدادات السيرفر
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'mahmoud.shoukry1221@gmail.com'; // ضع إيميلك هنا
                $mail->Password = 'ptzh yuwk rifq dxci  '; // ضع كلمة مرور التطبيق هنا
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // المرسل والمستلم
                $mail->setFrom('your-email@gmail.com', 'مشروعي');
                $mail->addAddress($email);

                // المحتوى
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';
                $mail->Subject = 'إعادة تعيين كلمة المرور';
                $reset_link = "http://localhost/project_name/forgot_password.php?step=2&token=$token";
                $mail->Body = "<p>اضغط على الرابط لإعادة تعيين كلمة المرور: <a href='$reset_link'>$reset_link</a></p>";

                $mail->send();
                $success = 'تم إرسال رابط إعادة التعيين إلى بريدك الإلكتروني!';
            } catch (Exception $e) {
                $error = "فشل إرسال الإيميل: {$mail->ErrorInfo}";
            }
        } else {
            $error = 'البريد الإلكتروني غير موجود';
        }
    } elseif ($step == 2 && isset($_GET['token'])) {
        $token = $_GET['token'];
        $query = "SELECT * FROM users WHERE reset_token = '$token'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) == 1) {
            if (isset($_POST['new_password'])) {
                $new_password = $_POST['new_password'];
                $query = "UPDATE users SET password = '$new_password', reset_token = NULL WHERE reset_token = '$token'";
                if (mysqli_query($conn, $query)) {
                    $success = 'تم تغيير كلمة المرور بنجاح! يمكنك الآن <a href="login.php">تسجيل الدخول</a>';
                } else {
                    $error = 'حدث خطأ أثناء تغيير كلمة المرور';
                }
            }
        } else {
            $error = 'الرابط غير صالح';
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<main>
    <div class="forgot-password-container">
        <h1>نسيت كلمة المرور</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php else: ?>
            <?php if ($step == 1): ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>البريد الإلكتروني</label>
                        <input type="email" name="email" required>
                    </div>
                    <button type="submit">إرسال</button>
                </form>
            <?php elseif ($step == 2): ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label>كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" required>
                    </div>
                    <button type="submit">تغيير</button>
                </form>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</main>
<?php include 'includes/footer.php'; ?>