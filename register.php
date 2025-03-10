<?php
include 'includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $error = 'اسم المستخدم أو البريد الإلكتروني موجود بالفعل';
    } else {
        $insert_query = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        if (mysqli_query($conn, $insert_query)) {
            $success = 'تم إنشاء الحساب بنجاح! يمكنك الآن <a href="login.php">تسجيل الدخول</a>';
        } else {
            $error = 'حدث خطأ أثناء التسجيل';
        }
    }
}
?>

<?php include 'includes/header.php'; ?>
<main>
    <div class="register-container">
        <h1>تسجيل حساب جديد</h1>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <?php if (!$success): ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label>اسم المستخدم</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit">تسجيل</button>
                <p>لديك حساب؟ <a href="login.php">سجل الدخول</a></p>
            </form>
        <?php endif; ?>
    </div>
</main>
<?php include 'includes/footer.php'; ?>