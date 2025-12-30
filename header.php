<?php require_once 'functions.php'; ?>
<!DOCTYPE html>
<html lang="uk">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Гусятинська бібліотека</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

</head>

<body>
    <header>
        <div class="container">
            <nav>
                <a href="index.php" class="logo">
                    Гусятинська бібліотека
                </a>
                <div class="nav-links">
                    <a href="index.php">Catalog</a>
                    <a href="news.php">News & Events</a>



                    <?php if (isLoggedIn()): ?>
                        <?php if (isLibrarian()): ?>
                            <a href="admin_dashboard.php">Dashboard</a>
                            <a href="add_book.php">Add Book</a>
                        <?php else: ?>
                            <a href="profile.php">My Profile</a>
                        <?php endif; ?>
                        <a href="logout.php" class="btn btn-outline">Logout</a>
                    <?php else: ?>
                        <a href="login.php">Login</a>
                        <a href="register.php" class="btn btn-primary">Sign Up</a>
                    <?php endif; ?>
                </div>
            </nav>
        </div>
    </header>
    <main>