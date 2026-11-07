<?php
// 07 Printers - Configuration
session_start();

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'printers07');
define('DB_USER', 'root');
define('DB_PASS', ''); // Change this in production

// Shop Info
define('SHOP_NAME', '07 Printers');
define('SHOP_TAGLINE', 'Professional Printing • Graphic Designing • Customized Gifts');
define('OWNER1', 'M. Anas Mughal');
define('OWNER2', 'Hussain Faisal');
define('PHONE1', '0312-1223711');
define('PHONE2', '0347-0777597');
define('WHATSAPP1', '923121223711'); // without +
define('WHATSAPP2', '923470777597');
define('ADDRESS', 'Shop No.03, 3-D, 9/39, Near Abbasi Shaheed Hospital St, opposite Hopes Lab, Block 3 Nazimabad, Karachi, 74600, Pakistan');
define('EMAIL', 'info@07printers.com');

// Payment (update with real numbers)
define('EASYPAISA', '0347-1242207');
define('JAZZCASH', '0347-1242207');
define('BANK_NAME', 'HBL / Meezan Bank');
define('BANK_TITLE', 'M. Anas Mughal / 07 Printers');
define('BANK_ACCOUNT', 'Contact us for account number');

// Site URL (change when deployed)
define('SITE_URL', ''); // e.g. https://yourdomain.com

// Database Connection
try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
} catch (PDOException $e) {
    // For demo / if DB not connected, set to null
    $pdo = null;
}

// Helper: Format Price
function formatPrice($price, $note = null) {
    if ($price === null || $price == 0) {
        return $note ? $note : 'Contact for Price';
    }
    return 'Rs. ' . number_format($price, 0);
}

// Helper: WhatsApp Link
function whatsappLink($message = '', $number = WHATSAPP1) {
    $msg = urlencode($message);
    return "https://wa.me/{$number}?text={$msg}";
}

// Cart helpers
function getCart() {
    return isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
}

function getCartCount() {
    $cart = getCart();
    $count = 0;
    foreach ($cart as $item) {
        $count += $item['qty'];
    }
    return $count;
}

function getCartTotal() {
    $cart = getCart();
    $total = 0;
    foreach ($cart as $item) {
        if ($item['price'] !== null) {
            $total += $item['price'] * $item['qty'];
        }
    }
    return $total;
}

function addToCart($id, $name, $price, $qty = 1) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['qty'] += $qty;
    } else {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'name' => $name,
            'price' => $price,
            'qty' => $qty
        ];
    }
}

function removeFromCart($id) {
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
}

function updateCartQty($id, $qty) {
    if (isset($_SESSION['cart'][$id])) {
        if ($qty <= 0) {
            removeFromCart($id);
        } else {
            $_SESSION['cart'][$id]['qty'] = $qty;
        }
    }
}

function clearCart() {
    unset($_SESSION['cart']);
}
?>