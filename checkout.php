<?php
require_once 'includes/config.php';
$pageTitle = 'Checkout | 07 Printers';
require_once 'includes/header.php';

$cart = getCart();
$total = getCartTotal();

if (empty($cart)) {
    header('Location: cart.php');
    exit;
}

// Build WhatsApp message
$waMsg = "Assalam o Alaikum 07 Printers!\n\n*New Order from Website*\n\n";
foreach ($cart as $item) {
    $priceStr = $item['price'] !== null ? 'Rs. ' . number_format($item['price']) : 'Price TBD';
    $waMsg .= "• {$item['name']} x {$item['qty']} ({$priceStr})\n";
}
if ($total > 0) {
    $waMsg .= "\n*Estimated Total: Rs. " . number_format($total) . "*";
}
$waMsg .= "\n\nCustomer details will follow.";
?>

<section class="page-hero">
    <div class="container">
        <h1>Checkout</h1>
        <p>Choose payment method & place your order</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <a href="cart.php">Cart</a> / <span>Checkout</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div style="display:grid; grid-template-columns: 1fr 380px; gap:40px; align-items:start;" class="checkout-grid">
            
            <!-- Left: Form & Payment -->
            <div data-aos="fade-up">
                <div class="contact-form">
                    <h3 style="font-family:var(--font-heading); margin-bottom:24px;">Customer Details</h3>
                    
                    <form action="#" method="POST" id="checkoutForm" onsubmit="return placeOrder(event);">
                        <div class="form-group">
                            <label>Full Name *</label>
                            <input type="text" name="name" id="cust_name" required placeholder="Your full name">
                        </div>
                        <div class="form-group">
                            <label>Phone / WhatsApp *</label>
                            <input type="tel" name="phone" id="cust_phone" required placeholder="03XX-XXXXXXX">
                        </div>
                        <div class="form-group">
                            <label>Email (optional)</label>
                            <input type="email" name="email" id="cust_email" placeholder="you@email.com">
                        </div>
                        <div class="form-group">
                            <label>Address / Delivery Notes</label>
                            <textarea name="address" id="cust_address" rows="3" placeholder="Delivery address or any special instructions"></textarea>
                        </div>
                        
                        <h3 style="font-family:var(--font-heading); margin:30px 0 16px;">Payment Method</h3>
                        
                        <div class="payment-options">
                            <div class="payment-option active" data-method="whatsapp">
                                <i class="fab fa-whatsapp" style="color:var(--whatsapp);"></i>
                                <h4>WhatsApp Order</h4>
                                <p>Recommended</p>
                            </div>
                            <div class="payment-option" data-method="easypaisa">
                                <i class="fas fa-mobile-alt"></i>
                                <h4>EasyPaisa</h4>
                                <p>Mobile Payment</p>
                            </div>
                            <div class="payment-option" data-method="jazzcash">
                                <i class="fas fa-wallet"></i>
                                <h4>JazzCash</h4>
                                <p>Mobile Payment</p>
                            </div>
                            <div class="payment-option" data-method="bank">
                                <i class="fas fa-university"></i>
                                <h4>Bank Transfer</h4>
                                <p>Online / Branch</p>
                            </div>
                        </div>
                        
                        <input type="hidden" name="payment_method" id="payment_method" value="whatsapp">
                        
                        <!-- Payment Details -->
                        <div class="payment-details show" data-method="whatsapp">
                            <div class="alert alert-info">
                                <strong>WhatsApp Order</strong><br>
                                After clicking "Place Order", your complete order details will open in WhatsApp. 
                                Send the message to confirm. We will reply with final price & payment instructions.
                            </div>
                        </div>
                        
                        <div class="payment-details" data-method="easypaisa">
                            <div class="alert alert-info">
                                <strong>EasyPaisa Payment</strong><br>
                                Send payment to: <strong><?php echo EASYPAISA; ?></strong><br>
                                Account Title: <?php echo BANK_TITLE; ?><br><br>
                                After payment, send screenshot on WhatsApp along with your order.
                            </div>
                        </div>
                        
                        <div class="payment-details" data-method="jazzcash">
                            <div class="alert alert-info">
                                <strong>JazzCash Payment</strong><br>
                                Send payment to: <strong><?php echo JAZZCASH; ?></strong><br>
                                Account Title: <?php echo BANK_TITLE; ?><br><br>
                                After payment, send screenshot on WhatsApp along with your order.
                            </div>
                        </div>
                        
                        <div class="payment-details" data-method="bank">
                            <div class="alert alert-info">
                                <strong>Bank Transfer</strong><br>
                                Bank: <strong><?php echo BANK_NAME; ?></strong><br>
                                Account Title: <?php echo BANK_TITLE; ?><br>
                                Account Number: <?php echo BANK_ACCOUNT; ?><br><br>
                                Please contact us on WhatsApp for exact account details before transferring.
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px; margin-top:20px; font-size:1rem;">
                            <i class="fas fa-check-circle"></i> Place Order via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Right: Order Summary -->
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="cart-summary" style="position:sticky; top:100px;">
                    <h3>Order Summary</h3>
                    <?php foreach ($cart as $item): ?>
                    <div class="summary-row">
                        <span><?php echo htmlspecialchars($item['name']); ?> × <?php echo $item['qty']; ?></span>
                        <span>
                            <?php echo $item['price'] !== null ? 'Rs. ' . number_format($item['price'] * $item['qty']) : 'TBD'; ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span><?php echo $total > 0 ? 'Rs. ' . number_format($total) : 'Contact'; ?></span>
                    </div>
                    <p style="font-size:0.85rem; color:var(--gray); margin-top:12px;">
                        Final price confirmed on WhatsApp for custom items.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function placeOrder(e) {
    e.preventDefault();
    
    const name = document.getElementById('cust_name').value.trim();
    const phone = document.getElementById('cust_phone').value.trim();
    const email = document.getElementById('cust_email').value.trim();
    const address = document.getElementById('cust_address').value.trim();
    const method = document.getElementById('payment_method').value;
    
    if (!name || !phone) {
        alert('Please fill name and phone number.');
        return false;
    }
    
    let msg = <?php echo json_encode($waMsg); ?>;
    msg += "\n\n*Customer Details*\n";
    msg += "Name: " + name + "\n";
    msg += "Phone: " + phone + "\n";
    if (email) msg += "Email: " + email + "\n";
    if (address) msg += "Address: " + address + "\n";
    msg += "Payment Method: " + method.toUpperCase() + "\n";
    msg += "\nPlease confirm my order. JazakAllah!";
    
    const waUrl = "https://wa.me/<?php echo WHATSAPP1; ?>?text=" + encodeURIComponent(msg);
    window.open(waUrl, '_blank');
    
    // Optional: clear cart after order
    // window.location.href = 'cart-action.php?action=clear';
    
    return false;
}
</script>

<style>
@media (max-width: 900px) {
    .checkout-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php require_once 'includes/footer.php'; ?>