<?php
require_once 'db.php';
require_once 'functions.php';

if (!isLoggedIn() || !isLibrarian()) {
    redirect('index.php');
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $author = trim($_POST['author']);
    $description = trim($_POST['description']);
    $total_copies = (int) $_POST['total_copies'];

    // File upload handling
    $upload_dir = 'uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $cover_path = '';
    $pdf_path = '';

    // Cover Image
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['cover_image']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('cover_') . '.' . $ext;
        move_uploaded_file($_FILES['cover_image']['tmp_name'], $upload_dir . $filename);
        $cover_path = $upload_dir . $filename;
    }

    // PDF File
    if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['pdf_file']['name'], PATHINFO_EXTENSION);
        $filename = uniqid('book_') . '.' . $ext;
        move_uploaded_file($_FILES['pdf_file']['tmp_name'], $upload_dir . $filename);
        $pdf_path = $upload_dir . $filename;
    }

    if (empty($title) || empty($author)) {
        $error = "Назва та автор є обов'язковими.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO books (title, author, description, cover_image, pdf_file, total_copies, available_copies) VALUES (?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$title, $author, $description, $cover_path, $pdf_path, $total_copies, $total_copies])) {
            $success = "Книгу успішно додано!";
        } else {
            $error = "Помилка при додаванні книги.";
        }
    }
}

require_once 'header.php';
?>

<div class="auth-wrapper" style="align-items: flex-start; padding-top: 2rem;">
    <div class="auth-card" style="max-width: 600px;">
        <h2 class="auth-title">Додати нову книгу</h2>

        <?php if ($error): ?>
            <div class="alert error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert success"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="title">Назва книги</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="author">Автор</label>
                <input type="text" id="author" name="author" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Опис</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="total_copies">Кількість примірників (паперових)</label>
                <input type="number" id="total_copies" name="total_copies" class="form-control" value="1" min="0"
                    required>
            </div>

            <div class="form-group">
                <label for="cover_image">Обкладинка (Зображення)</label>
                <input type="file" id="cover_image" name="cover_image" class="form-control" accept="image/*">
            </div>

            <div class="form-group">
                <label for="pdf_file">PDF Файл (для читання онлайн)</label>
                <input type="file" id="pdf_file" name="pdf_file" class="form-control" accept=".pdf">
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%;">Додати книгу</button>
        </form>

        <div style="margin-top: 1rem; text-align: center;">
            <a href="admin_dashboard.php" class="btn btn-outline">Назад до панелі керування</a>
        </div>
    </div>
</div>

</body>

</html>