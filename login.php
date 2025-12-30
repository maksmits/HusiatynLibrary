<?php
require_once 'db.php';
require_once 'functions.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $error = "Введіть email та пароль.";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            redirect('index.php');
        } else {
            $error = "Невірний email або пароль.";
        }
    }
}
?>

<?php require_once 'header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">
        <h2 class="auth-title">Вхід</h2>

        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Пароль</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Увійти</button>
        </form>
        <p style="margin-top: 1rem; text-align: center; color: var(--text-light);">
            Немає акаунту? <a href="register.php" style="color: var(--primary);">Зареєструватися</a>
        </p>
    </div>
</div>

</body>

</html>