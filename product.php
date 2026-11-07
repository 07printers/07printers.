<?php
require_once 'includes/config.php';

$id = (int)($_GET['id'] ?? 0);
$products = [];
$jsonFile = __DIR__ . '/data/products.json';
if (file_exists($jsonFile)) {
    $products = json_decode(file_get_contents($jsonFile), true) ?: [];
}

$product = null;
foreach ($products as $p) {
    if ((int)$p['id'] === $id) { $product = $p; break; }
}

if (!$product) {
    header('Location: products.php');
    exit;
}

// Validate images exist
$images = $product['images'] ?? [];
if (empty($images) && !empty($product['img'])) $images = [$product['img']];
$validImages = [];
foreach ($images as $img) {
    if (!$img) continue;
    if (strpos($img, 'http') === 0 || file_exists(__DIR__ . '/' . $img)) {
        $validImages[] = $img;
    }
}
if (empty($validImages)) {
    $validImages = ['assets/images/logo.png'];
}
$images = $validImages;

$pageTitle = $product['name'] . ' | 07 Printers';
$pageDesc = $product['desc'] ?? $product['name'];
require_once 'includes/header.php';

$waMsg = "Assalam o Alaikum 07 Printers! I want to order: " . $product['name'];
?>

<section class="page-hero" style="padding:110px 0 40px;">
    <div class="container">
        <div class="breadcrumb" style="justify-content:flex-start; margin:0;">
            <a href="index.php">Home</a> / <a href="products.php">Products</a> / <span><?php echo htmlspecialchars($product['name']); ?></span>
        </div>
    </div>
</section>

<section class="section" style="padding-top:20px;">
    <div class="container">
        <div class="product-detail-grid">
            
            <!-- Image Gallery -->
            <div class="detail-slider" data-aos="fade-right">
                <div class="slider-main" id="sliderMain">
                    <?php foreach ($images as $i => $img): ?>
                    <div class="slide <?php echo $i === 0 ? 'active' : ''; ?>">
                        <img src="<?php echo htmlspecialchars($img); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?> - <?php echo $i+1; ?>"
                             loading="<?php echo $i === 0 ? 'eager' : 'lazy'; ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if (count($images) > 1): ?>
                <div class="slider-thumbs" id="sliderThumbs">
                    <?php foreach ($images as $i => $img): ?>
                    <button type="button" class="thumb <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>">
                        <img src="<?php echo htmlspecialchars($img); ?>" alt="">
                    </button>
                    <?php endforeach; ?>
                </div>
                <div class="slider-dots" id="sliderDots">
                    <?php foreach ($images as $i => $img): ?>
                    <span class="dot <?php echo $i === 0 ? 'active' : ''; ?>" data-index="<?php echo $i; ?>"></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Details -->
            <div class="detail-info" data-aos="fade-left">
                <span class="section-badge" style="text-transform:capitalize;"><?php echo htmlspecialchars($product['cat'] ?? ''); ?></span>
                <h1><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="product-price detail-price">
                    <?php if (isset($product['price']) && $product['price'] !== null): ?>
                        Rs. <?php echo number_format($product['price']); ?>
                        <small>/ <?php echo htmlspecialchars($product['note'] ?? ''); ?></small>
                    <?php else: ?>
                        Contact for Price
                        <small style="display:block;"><?php echo htmlspecialchars($product['note'] ?? ''); ?></small>
                    <?php endif; ?>
                </div>
                
                <p class="detail-desc">
                    <?php echo htmlspecialchars($product['desc'] ?? ''); ?>
                </p>
                
                <div class="detail-actions">
                    <a href="<?php echo whatsappLink($waMsg); ?>" class="btn btn-whatsapp" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i> Order on WhatsApp
                    </a>
                    <form action="cart-action.php" method="POST" style="display:inline;">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" value="<?php echo (int)$product['id']; ?>">
                        <input type="hidden" name="name" value="<?php echo htmlspecialchars($product['name']); ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price'] ?? ''; ?>">
                        <input type="hidden" name="redirect" value="product.php?id=<?php echo (int)$product['id']; ?>">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </div>
                
                <div class="detail-note">
                    <p>
                        <i class="fas fa-info-circle"></i>
                        Final price for custom items confirmed on WhatsApp. Fast delivery in Karachi.
                    </p>
                </div>

                <ul class="detail-features">
                    <li><i class="fas fa-check"></i> Professional quality print</li>
                    <li><i class="fas fa-check"></i> Same-day options available</li>
                    <li><i class="fas fa-check"></i> WhatsApp order support</li>
                </ul>
            </div>
        </div>

        <div style="margin-top:40px; text-align:center;">
            <a href="products.php" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back to Products</a>
        </div>
    </div>
</section>

<style>
.product-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: start;
}
.detail-slider {
    position: relative;
    background: #faf7f2;
    border-radius: var(--radius-lg, 14px);
    overflow: hidden;
    border: 1px solid var(--beige-dark, #e8dfd0);
}
.slider-main {
    position: relative;
    height: 420px;
}
.slider-main .slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.55s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px;
}
.slider-main .slide.active {
    opacity: 1;
    z-index: 1;
}
.slider-main .slide img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    border-radius: 8px;
}
.slider-thumbs {
    display: flex;
    gap: 8px;
    padding: 12px 14px;
    background: #fff;
    justify-content: center;
    flex-wrap: wrap;
}
.slider-thumbs .thumb {
    width: 58px;
    height: 58px;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 0;
    overflow: hidden;
    background: #f5f0e6;
    cursor: pointer;
    transition: 0.2s;
}
.slider-thumbs .thumb.active {
    border-color: var(--primary, #9d174d);
}
.slider-thumbs .thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.slider-dots {
    display: none;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    background: white;
}
.slider-dots .dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #ddd;
    cursor: pointer;
    transition: 0.3s;
}
.slider-dots .dot.active {
    background: var(--primary, #9d174d);
    transform: scale(1.2);
}

.detail-info h1 {
    font-family: var(--font-heading, inherit);
    font-size: 1.9rem;
    margin: 10px 0 14px;
    line-height: 1.25;
}
.detail-price {
    font-size: 1.5rem;
    margin-bottom: 18px;
}
.detail-price small {
    font-size: 0.9rem;
    color: var(--gray, #78716c);
}
.detail-desc {
    color: var(--gray, #57534e);
    line-height: 1.75;
    margin-bottom: 24px;
    font-size: 1.05rem;
}
.detail-actions {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 24px;
}
.detail-actions .btn {
    padding: 14px 24px;
}
.detail-note {
    background: var(--beige, #faf7f2);
    padding: 16px 18px;
    border-radius: var(--radius, 10px);
    border: 1px solid var(--beige-dark, #e8dfd0);
    margin-bottom: 20px;
}
.detail-note p {
    font-size: 0.9rem;
    color: var(--gray, #57534e);
    margin: 0;
}
.detail-note i {
    color: var(--primary, #9d174d);
}
.detail-features {
    list-style: none;
    padding: 0;
    margin: 0;
}
.detail-features li {
    padding: 6px 0;
    color: #44403c;
    font-size: 0.95rem;
}
.detail-features i {
    color: #16a34a;
    margin-right: 8px;
}

@media (max-width: 768px) {
    .product-detail-grid {
        grid-template-columns: 1fr !important;
        gap: 24px;
    }
    .slider-main {
        height: 280px;
    }
    .slider-thumbs {
        display: none;
    }
    .slider-dots {
        display: flex;
    }
    .detail-info h1 {
        font-size: 1.45rem;
    }
}
</style>

<script>
(function(){
    const slides = document.querySelectorAll('#sliderMain .slide');
    const dots = document.querySelectorAll('#sliderDots .dot');
    const thumbs = document.querySelectorAll('#sliderThumbs .thumb');
    if (slides.length <= 1) return;

    let idx = 0;
    let timer = null;

    function show(i) {
        idx = ((i % slides.length) + slides.length) % slides.length;
        slides.forEach((s, n) => s.classList.toggle('active', n === idx));
        dots.forEach((d, n) => d.classList.toggle('active', n === idx));
        thumbs.forEach((t, n) => t.classList.toggle('active', n === idx));
    }

    function start() {
        stop();
        timer = setInterval(() => show(idx + 1), 2800);
    }
    function stop() {
        if (timer) clearInterval(timer);
    }

    dots.forEach(d => d.addEventListener('click', () => { show(+d.dataset.index); start(); }));
    thumbs.forEach(t => t.addEventListener('click', () => { show(+t.dataset.index); start(); }));

    const slider = document.querySelector('.detail-slider');
    if (slider) {
        slider.addEventListener('mouseenter', stop);
        slider.addEventListener('mouseleave', start);
    }
    start();
})();
</script>

<?php require_once 'includes/footer.php'; ?>
