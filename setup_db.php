<?php
$host = 'localhost';
$username = 'root';
$password = '';

try {
    // Connect without database selected
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS husyatyn_library");
    echo "Database created or already exists.\n";

    // Select database
    $pdo->exec("USE husyatyn_library");

    // Run schema
    $sql = file_get_contents('schema.sql');
    $pdo->exec($sql);
    echo "Schema imported successfully.\n";

} catch (PDOException $e) {
    die("Setup failed: " . $e->getMessage());
}
?>