<?php
require_once 'includes/config.php';
$pageTitle = 'Shopping Cart | 07 Printers';
require_once 'includes/header.php';

$cart = getCart();
$total = getCartTotal();
?>

<section class="page-hero">
    <div class="container">
        <h1>Your Cart</h1>
        <p>Review your items and proceed to order</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <span>Cart</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (empty($cart)): ?>
            <div class="empty-state" data-aos="fade-up">
                <i class="fas fa-shopping-cart"></i>
                <h3>Your cart is empty</h3>
                <p>Browse our services and add items to get started.</p>
                <a href="products.php" class="btn btn-primary">Browse Products</a>
            </div>
        <?php else: ?>
            <div class="cart-table-wrapper" data-aos="fade-up">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product / Service</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): 
                            $sub = $item['price'] !== null ? $item['price'] * $item['qty'] : null;
                        ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                            </td>
                            <td>
                                <?php echo $item['price'] !== null ? 'Rs. ' . number_format($item['price']) : 'Contact'; ?>
                            </td>
                            <td>
                                <form action="cart-action.php" method="POST" id="qty-form-<?php echo $item['id']; ?>" style="display:inline;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                                    <div class="qty-control">
                                        <button type="button" onclick="updateQty(<?php echo $item['id']; ?>, -1)">−</button>
                                        <input type="number" name="qty" value="<?php echo $item['qty']; ?>" min="1" 
                                               style="width:50px; text-align:center; border:1px solid #e2e8f0; border-radius:6px; padding:6px;" 
                                               onchange="this.form.submit()">
                                        <button type="button" onclick="updateQty(<?php echo $item['id']; ?>, 1)">+</button>
                                    </div>
                                </form>
                            </td>
                            <td>
                                <?php echo $sub !== null ? 'Rs. ' . number_format($sub) : '—'; ?>
                            </td>
                            <td>
                                <a href="cart-action.php?action=remove&id=<?php echo $item['id']; ?>" 
                                   style="color:var(--danger);" title="Remove">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="cart-summary" data-aos="fade-up" data-aos-delay="100">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Items</span>
                    <span><?php echo getCartCount(); ?></span>
                </div>
                <div class="summary-row total">
                    <span>Estimated Total</span>
                    <span>
                        <?php 
                        if ($total > 0) {
                            echo 'Rs. ' . number_format($total);
                        } else {
                            echo 'Contact for Price';
                        }
                        ?>
                    </span>
                </div>
                <p style="font-size:0.85rem; color:var(--gray); margin:12px 0 20px;">
                    * Some items require custom pricing. Final amount will be confirmed on WhatsApp.
                </p>
                
                <div style="display:flex; gap:12px; flex-wrap:wrap;">
                    <a href="checkout.php" class="btn btn-primary" style="flex:1; justify-content:center;">
                        <i class="fas fa-credit-card"></i> Proceed to Checkout
                    </a>
                    <?php
                    // Build WhatsApp message
                    $waMsg = "Assalam o Alaikum 07 Printers!\n\nI want to order the following:\n\n";
                    foreach ($cart as $item) {
                        $priceStr = $item['price'] !== null ? 'Rs. ' . number_format($item['price']) : 'Price TBD';
                        $waMsg .= "• {$item['name']} x {$item['qty']} ({$priceStr})\n";
                    }
                    if ($total > 0) {
                        $waMsg .= "\nEstimated Total: Rs. " . number_format($total);
                    }
                    $waMsg .= "\n\nPlease confirm availability and final price.";
                    ?>
                    <a href="<?php echo whatsappLink($waMsg); ?>" class="btn btn-whatsapp" target="_blank" style="flex:1; justify-content:center;">
                        <i class="fab fa-whatsapp"></i> Order via WhatsApp
                    </a>
                </div>
                
                <div style="margin-top:16px; text-align:center;">
                    <a href="cart-action.php?action=clear" style="color:var(--gray); font-size:0.9rem;">
                        <i class="fas fa-trash"></i> Clear Cart
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>