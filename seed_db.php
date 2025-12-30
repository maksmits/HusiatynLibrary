<?php
require 'db.php';

try {
    echo "Seeding database...\n";

    // 1. Create a Librarian Account
    $admin_email = 'admin@library.com';
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$admin_email]);

    if ($stmt->rowCount() == 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Chief Librarian', $admin_email, $password, 'librarian']);
        echo "Created Librarian: $admin_email / admin123\n";
    } else {
        echo "Librarian already exists.\n";
    }

    // 2. Create a Regular User
    $user_email = 'user@test.com';
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$user_email]);

    if ($stmt->rowCount() == 0) {
        $password = password_hash('user123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->execute(['Test Reader', $user_email, $password, 'user']);
        echo "Created User: $user_email / user123\n";
    } else {
        echo "Test user already exists.\n";
    }

    // 3. Seed Books
    $books = [
        [
            'title' => 'Кобзар',
            'author' => 'Тарас Шевченко',
            'description' => 'Збірка поетичних творів Тараса Шевченка. "Кобзар" — це не просто книга, це душа українського народу.',
            'total' => 5
        ],
        [
            'title' => 'Тіні забутих предків',
            'author' => 'Михайло Коцюбинський',
            'description' => 'Повість про кохання українських Ромео і Джульєтти — Івана та Марічки, що розгортається на тлі гуцульського побуту та міфології.',
            'total' => 3
        ],
        [
            'title' => 'Захар Беркут',
            'author' => 'Іван Франко',
            'description' => 'Історична повість про боротьбу давньої карпатської громади проти монгольського нашестя.',
            'total' => 4
        ],
        [
            'title' => 'Лісова пісня',
            'author' => 'Леся Українка',
            'description' => 'Драма-феєрія в трьох діях. Шедевр української драматургії про зіткнення світу людей і світу природи.',
            'total' => 2
        ],
        [
            'title' => 'Кайдашева сім\'я',
            'author' => 'Іван Нечуй-Левицький',
            'description' => 'Соціально-побутова повість, у якій на прикладі однієї родини показано життя українського села в пореформену добу.',
            'total' => 6
        ]
    ];

    $stmt_check = $pdo->prepare("SELECT id FROM books WHERE title = ?");
    $stmt_insert = $pdo->prepare("INSERT INTO books (title, author, description, total_copies, available_copies) VALUES (?, ?, ?, ?, ?)");

    foreach ($books as $book) {
        $stmt_check->execute([$book['title']]);
        if ($stmt_check->rowCount() == 0) {
            $stmt_insert->execute([
                $book['title'],
                $book['author'],
                $book['description'],
                $book['total'],
                $book['total']
            ]);
            echo "Added book: {$book['title']}\n";
        }
    }

    echo "Seeding complete.\n";

} catch (PDOException $e) {
    echo "Error seeding database: " . $e->getMessage();
}
?>