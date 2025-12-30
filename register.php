<?php
require_once 'db.php';
require_once 'functions.php';

if (isLoggedIn()) {
    redirect('index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'user'; // Force default role to user

    // Basic validation
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Всі поля обов'язкові для заповнення!";
    } elseif ($password !== $confirm_password) {
        $error = "Паролі не співпадають!";
    } elseif (strlen($password) < 6) {
        $error = "Пароль повинен містити не менше 6 символів.";
    } else {
        // Check if user exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR username = ?");
        $stmt->execute([$email, $username]);
        if ($stmt->rowCount() > 0) {
            $error = "Користувач з таким email або логіном вже існує.";
        } else {
            // Create user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            // Security: In a real app, don't allow arbitrary role selection without admin check.
            // For this project, we'll allow it for demonstration or restrict to 'user' by default.
            // Let's implement a 'secret key' for librarian registration or just default to user.
            // For now: allow user to pick for simplicity as requested "registration (users and librarians)"

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
            try {
                $stmt->execute([$username, $email, $hashed_password, $role]);
                $success = "Реєстрація успішна! Тепер ви можете увійти.";
            } catch (PDOException $e) {
                $error = "Помилка при реєстрації: " . $e->getMessage();
            }
        }
    }
}
?>

<?php require_once 'header.php'; ?>

<div class="auth-wrapper">
    <div class="auth-card">
        <h2 class="auth-title">Реєстрація</h2>

        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
            <p style="text-align: center;"><a href="login.php" class="btn btn-primary">Увійти</a></p>
        <?php else: ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="username">Логін</label>
                    <input type="text" id="username" name="username" class="form-control"
                        value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" required>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Підтвердіть пароль</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Зареєструватися</button>
            </form>

            <p style="margin-top: 1rem; text-align: center; color: var(--text-light);">
                Вже маєте акаунт? <a href="login.php" style="color: var(--primary);">Увійти</a>
            </p>
        <?php endif; ?>
    </div>
</div>

</body>

</html>