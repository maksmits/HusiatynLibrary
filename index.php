<?php
require_once 'db.php';
require_once 'functions.php';

// Fetch books
$stmt = $pdo->query("SELECT * FROM books ORDER BY created_at DESC");
$books = $stmt->fetchAll();

require_once 'header.php';
?>

<div class="hero">
    <h1>Ласкаво просимо до Гусятинської бібліотеки</h1>
    <p>
        Відкрийте для себе світ знань та пригод. Бронюйте паперові книги або читайте їх онлайн.
    </p>
</div>

<div class="container">
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 2rem; color: var(--text-main);">Каталог книг</h2>

    <div class="book-grid">
        <?php foreach ($books as $book): ?>
            <div class="book-card">
                <div class="book-cover-wrapper">
                    <?php if ($book['cover_image']): ?>
                        <img src="<?php echo htmlspecialchars($book['cover_image']); ?>"
                            alt="<?php echo htmlspecialchars($book['title']); ?>" class="book-cover">
                    <?php else: ?>
                        <!-- Generated Cover Fallback -->
                        <?php
                        // Generate a consistent random color for the cover based on title
                        $hash = md5($book['title']);
                        $hue = hexdec(substr($hash, 0, 2));
                        $gradient = "linear-gradient(135deg, hsl($hue, 60%, 40%) 0%, hsl($hue, 60%, 20%) 100%)";
                        ?>
                        <div class="generated-cover" style="background: <?php echo $gradient; ?>">
                            <div class="gen-title"><?php echo htmlspecialchars($book['title']); ?></div>
                            <div class="gen-author"><?php echo htmlspecialchars($book['author']); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="book-info">
                    <h3 class="book-title"><?php echo htmlspecialchars($book['title']); ?></h3>
                    <p class="book-author"><?php echo htmlspecialchars($book['author']); ?></p>

                    <div class="book-footer">
                        <?php if ($book['available_copies'] > 0): ?>
                            <span class="badge badge-available">В наявності</span>
                        <?php else: ?>
                            <span class="badge badge-unavailable">Немає</span>
                        <?php endif; ?>

                        <a href="book.php?id=<?php echo $book['id']; ?>" class="btn btn-outline"
                            style="padding: 0.4rem 1rem; font-size: 0.85rem;">Детальніше</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (empty($books)): ?>
            <p style="text-align: center; width: 100%; color: var(--text-muted); padding: 4rem;">Книг поки немає.</p>
        <?php endif; ?>
    </div>
</div>

</body>

</html>