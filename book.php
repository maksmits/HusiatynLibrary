<?php
require_once 'db.php';
require_once 'functions.php';

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book) {
    redirect('index.php');
}

$success_msg = '';
$error_msg = '';

// Handle Reservation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserve'])) {
    if (!isLoggedIn()) {
        redirect('login.php');
    }

    if ($book['available_copies'] > 0) {
        $user_id = $_SESSION['user_id'];

        // Check active reservations
        $stmt = $pdo->prepare("SELECT id FROM reservations WHERE user_id = ? AND book_id = ? AND status IN ('pending', 'approved')");
        $stmt->execute([$user_id, $id]);

        if ($stmt->rowCount() > 0) {
            $error_msg = "Ви вже забронювали цю книгу.";
        } else {
            $stmt = $pdo->prepare("INSERT INTO reservations (user_id, book_id) VALUES (?, ?)");
            if ($stmt->execute([$user_id, $id])) {
                $success_msg = "Запит на бронювання надіслано!";
                // In a real app, decrease available copies *after* librarian approval, or hold it now. 
                // Let's hold it simply for now or just notify librarian.
            } else {
                $error_msg = "Помилка бронювання.";
            }
        }
    } else {
        $error_msg = "На жаль, книги немає в наявності.";
    }
}

require_once 'header.php';
?>

<div class="container" style="padding-top: 2rem;">
    <div
        style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-card); overflow: hidden; margin-top: 2rem; border: 1px solid #e2e8f0;">
        <div style="display: flex; gap: 0; flex-wrap: wrap;">
            <!-- Left Column: Cover -->
            <div style="flex: 0 0 350px; background: #f8fafc; border-right: 1px solid #e2e8f0; position: relative;">
                <div class="book-cover-wrapper" style="height: 100%; min-height: 500px; aspect-ratio: auto;">
                    <?php if ($book['cover_image']): ?>
                        <img src="<?php echo htmlspecialchars($book['cover_image']); ?>"
                            alt="<?php echo htmlspecialchars($book['title']); ?>" class="book-cover">
                    <?php else: ?>
                        <?php
                        $hash = md5($book['title']);
                        $hue = hexdec(substr($hash, 0, 2));
                        $gradient = "linear-gradient(135deg, hsl($hue, 60%, 40%) 0%, hsl($hue, 60%, 20%) 100%)";
                        ?>
                        <div class="generated-cover" style="background: <?php echo $gradient; ?>; height: 100%;">
                            <div class="gen-title" style="font-size: 2rem;"><?php echo htmlspecialchars($book['title']); ?>
                            </div>
                            <div class="gen-author" style="font-size: 1.2rem; margin-top: 1rem;">
                                <?php echo htmlspecialchars($book['author']); ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div style="flex: 1; padding: 3rem;">
                <div style="margin-bottom: 2rem;">
                    <h1
                        style="font-size: 2.5rem; font-weight: 800; color: var(--secondary); margin-bottom: 0.5rem; line-height: 1.2;">
                        <?php echo htmlspecialchars($book['title']); ?>
                    </h1>
                    <h3 style="font-size: 1.25rem; color: var(--primary); font-weight: 600;">
                        <?php echo htmlspecialchars($book['author']); ?>
                    </h3>
                </div>

                <?php if ($success_msg): ?>
                    <div class="alert success"><?php echo $success_msg; ?></div>
                <?php endif; ?>

                <?php if ($error_msg): ?>
                    <div class="alert error"><?php echo $error_msg; ?></div>
                <?php endif; ?>

                <div
                    style="margin-bottom: 2rem; padding: 1.5rem; background: #f8fafc; border-radius: var(--radius-md); border: 1px solid #e2e8f0;">
                    <div
                        style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
                        <span
                            style="font-weight: 600; color: var(--text-muted); text-transform: uppercase; font-size: 0.875rem;">Статус
                            книги</span>
                        <?php if ($book['available_copies'] > 0): ?>
                            <span class="badge badge-available">В наявності
                                (<?php echo $book['available_copies']; ?>)</span>
                        <?php else: ?>
                            <span class="badge badge-unavailable">Немає в наявності</span>
                        <?php endif; ?>
                    </div>

                    <div style="display: flex; gap: 1rem;">
                        <?php if (isLoggedIn()): ?>
                            <form method="POST" style="flex: 1;">
                                <button type="submit" name="reserve" class="btn btn-primary" style="width: 100%;" <?php echo $book['available_copies'] <= 0 ? 'disabled' : ''; ?>>
                                    Забронювати паперову версію
                                </button>
                            </form>

                            <?php if ($book['pdf_file']): ?>
                                <a href="read.php?id=<?php echo $book['id']; ?>" class="btn btn-outline" style="flex: 1;"
                                    target="_blank">Читати онлайн</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="login.php" class="btn btn-primary" style="width: 100%;">Увійдіть, щоб забронювати</a>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; color: var(--secondary);">Опис
                    </h3>
                    <p style="line-height: 1.8; color: var(--text-main); font-size: 1.05rem;">
                        <?php echo nl2br(htmlspecialchars($book['description'])); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
</body>

</html>