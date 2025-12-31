<?php
session_start();
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['quantity'])) {
    $id = (int)$_POST['id'];
    $quantity = (int)$_POST['quantity'];
    updateCart($id, $quantity);
}

header('Location: cart.php');
exit;
?>