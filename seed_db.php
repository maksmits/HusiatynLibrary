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

    // 3. Books are now inserted via SQL query (see insert_books.sql)
    echo "Skipping book seeding (use insert_books.sql to populate books).\n";

    echo "Seeding complete.\n";

} catch (PDOException $e) {
    echo "Error seeding database: " . $e->getMessage();
}
?>