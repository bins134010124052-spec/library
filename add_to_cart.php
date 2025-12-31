<?php
session_start();
require_once 'includes/functions.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

addToCart($_GET['id']);
header('Location: cart.php');
exit;
?>