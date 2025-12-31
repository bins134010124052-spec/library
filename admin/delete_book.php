<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

require_once '../includes/functions.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    if (deleteBook($_GET['id'])) {
        header('Location: books.php?deleted=1');
    } else {
        header('Location: books.php?error=1');
    }
} else {
    header('Location: books.php');
}
exit;
?>