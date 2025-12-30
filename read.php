<?php
require_once 'db.php';
require_once 'functions.php';

if (!isLoggedIn()) {
    redirect('login.php');
}

if (!isset($_GET['id'])) {
    redirect('index.php');
}

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$id]);
$book = $stmt->fetch();

if (!$book || empty($book['pdf_file'])) {
    die("Книга не знайдена або не має PDF файлу.");
}
?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Читання: <?php echo htmlspecialchars($book['title']); ?></title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }

        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-family: sans-serif;
            z-index: 100;
        }
    </style>
</head>

<body>
    <a href="book.php?id=<?php echo $book['id']; ?>" class="back-btn">← Повернутися до книги</a>
    <iframe src="<?php echo htmlspecialchars($book['pdf_file']); ?>"></iframe>
</body>

</html>