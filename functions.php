<?php
session_start();

function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

function isLibrarian()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'librarian';
}

function redirect($url)
{
    header("Location: $url");
    exit();
}

function flash($name, $message = '', $class = 'success')
{
    if (!empty($message)) {
        $_SESSION[$name] = $message;
        $_SESSION[$name . '_class'] = $class;
    } elseif (empty($message) && isset($_SESSION[$name])) {
        $class = !empty($_SESSION[$name . '_class']) ? $_SESSION[$name . '_class'] : 'success';
        echo '<div class="alert ' . $class . '">' . $_SESSION[$name] . '</div>';
        unset($_SESSION[$name]);
        unset($_SESSION[$name . '_class']);
    }
}
?>