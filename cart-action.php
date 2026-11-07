<?php
require_once 'includes/config.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'add') {
    $id = (int)($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $price = isset($_POST['price']) && $_POST['price'] !== '' ? (float)$_POST['price'] : null;
    $qty = max(1, (int)($_POST['qty'] ?? 1));
    
    if ($id && $name) {
        addToCart($id, $name, $price, $qty);
    }
    
    $redirect = $_POST['redirect'] ?? 'products.php';
    header('Location: ' . $redirect . '?added=1');
    exit;
}

if ($action === 'remove') {
    $id = (int)($_GET['id'] ?? 0);
    removeFromCart($id);
    header('Location: cart.php');
    exit;
}

if ($action === 'update') {
    $id = (int)($_POST['id'] ?? 0);
    $qty = (int)($_POST['qty'] ?? 1);
    updateCartQty($id, $qty);
    header('Location: cart.php');
    exit;
}

if ($action === 'clear') {
    clearCart();
    header('Location: cart.php');
    exit;
}

header('Location: index.php');
exit;