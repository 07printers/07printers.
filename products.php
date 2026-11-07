<?php
require_once 'includes/config.php';
$pageTitle = 'Printing Services Karachi | Visiting Cards, Nikkah Frames, Flex, Photo Printing | 07 Printers Nazimabad';
$pageDesc = 'Best printing shop in Nazimabad Karachi. Visiting cards, Nikkah frames, photo printing, flex banners, customized gifts, PVC cards & graphic designing. Order online or WhatsApp.';
require_once 'includes/header.php';

$allProducts = [];
$jsonFile = __DIR__ . '/data/products.json';
if (file_exists($jsonFile)) {
    $allProducts = json_decode(file_get_contents($jsonFile), true) ?: [];
}

// Fix missing images
foreach ($allProducts as &$p) {
    $imgs = $p['images'] ?? [];
    if (empty($imgs) && !empty($p['img'])) $imgs = [$p['img']];
    $valid = [];
    foreach ($imgs as $img) {
        if ($img && (file_exists(__DIR__ . '/' . $img) || strpos($img, 'http') === 0)) {
            $valid[] = $img;
        }
    }
    if (empty($valid)) {
        $valid = ['assets/images/logo.png'];
    }
    $p['images'] = $valid;
    $p['img'] = $valid[0];
}
unset($p);
?>

<section class="page-hero">
    <div class="container">
        <h1>Products & Services</h1>
        <p>Visiting Cards • Nikkah Frames • Photo Printing • Flex • Customized Gifts</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <span>Products</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php if (isset($_GET['added'])): ?>
            <div class="alert alert-success" data-aos="fade-down">
                <i class="fas fa-check-circle"></i> Item added to cart!
            </div>
        <?php endif; ?>
        
        <div class="category-tabs" data-aos="fade-up">
            <button class="cat-tab active" data-cat="all">All</button>
            <button class="cat-tab" data-cat="printing">Printing</button>
            <button class="cat-tab" data-cat="photo">Photo</button>
            <button class="cat-tab" data-cat="cards">Cards & ID</button>
            <button class="cat-tab" data-cat="frames">Nikkah & Frames</button>
            <button class="cat-tab" data-cat="gifts">Gifts</button>
            <button class="cat-tab" data-cat="flex">Flex & Banners</button>
            <button class="cat-tab" data-cat="design">Designing</button>
            <button class="cat-tab" data-cat="stamp">Stamp</button>
        </div>
        
        <div class="products-grid">
            <?php foreach ($allProducts as $i => $p): 
                $imgs = $p['images'];
                $priceText = (isset($p['price']) && $p['price'] !== null) 
                    ? 'Rs. ' . number_format($p['price']) 
                    : 'Contact for Price';
                $waMsg = "Assalam o Alaikum 07 Printers! I want to order: " . $p['name'];
            ?>
            <div class="product-card" 
                 data-cat="<?php echo htmlspecialchars($p['cat'] ?? 'printing'); ?>" 
                 data-aos="fade-up" 
                 data-aos-delay="<?php echo ($i % 8) * 40; ?>"
                 data-id="<?php echo (int)$p['id']; ?>"
                 data-name="<?php echo htmlspecialchars($p['name']); ?>"
                 data-desc="<?php echo htmlspecialchars($p['desc'] ?? ''); ?>"
                 data-price="<?php echo htmlspecialchars($priceText); ?>"
                 data-note="<?php echo htmlspecialchars($p['note'] ?? ''); ?>"
                 data-cat-label="<?php echo htmlspecialchars($p['cat'] ?? ''); ?>"
                 data-images='<?php echo json_encode($imgs); ?>'
                 data-wa="<?php echo htmlspecialchars(whatsappLink($waMsg)); ?>">
                
                <div class="product-link product-open-modal" role="button" tabindex="0">
                    <div class="product-img card-slider" data-images='<?php echo json_encode($imgs); ?>'>
                        <img src="<?php echo htmlspecialchars($imgs[0]); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>" class="slide-img" loading="lazy">
                        <?php if ($i < 4): ?><span class="product-badge">Popular</span><?php endif; ?>
                        
                        <div class="hover-detail">
                            <h4><?php echo htmlspecialchars($p['name']); ?></h4>
                            <p><?php echo htmlspecialchars($p['desc'] ?? ''); ?></p>
                            <div class="hover-price"><?php echo $priceText; ?></div>
                            <span class="hover-btn"><i class="fas fa-eye"></i> Quick View</span>
                        </div>
                    </div>
                    <div class="product-body">
                        <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                        <p><?php echo htmlspecialchars($p['desc'] ?? ''); ?></p>
                        <div class="product-footer">
                            <div class="product-price">
                                <?php if (isset($p['price']) && $p['price'] !== null): ?>
                                    Rs. <?php echo number_format($p['price']); ?>
                                    <small>/ <?php echo htmlspecialchars($p['note'] ?? ''); ?></small>
                                <?php else: ?>
                                    <span style="font-size:0.95rem;">Contact for Price</span>
                                    <small><?php echo htmlspecialchars($p['note'] ?? ''); ?></small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <form action="cart-action.php" method="POST" class="card-cart-form" onclick="event.stopPropagation();">
                    <input type="hidden" name="action" value="add">
                    <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($p['name']); ?>">
                    <input type="hidden" name="price" value="<?php echo $p['price'] ?? ''; ?>">
                    <input type="hidden" name="redirect" value="products.php">
                    <button type="submit" class="btn btn-sm btn-cart" title="Add to Cart">
                        <i class="fas fa-cart-plus"></i>
                    </button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="alert alert-info" style="margin-top:40px;" data-aos="fade-up">
            <strong>Tip:</strong> Product pe click karein — popup mein detail + pictures open hongi (page nahi badlegi). Full page ke liye popup mein "Full Details" dabayein.
        </div>
    </div>
</section>

<!-- ========== PRODUCT QUICK VIEW MODAL (Phone-style popup) ========== -->
<div id="productModal" class="pq-modal" aria-hidden="true">
    <div class="pq-backdrop"></div>
    <div class="pq-dialog" role="dialog" aria-modal="true" aria-labelledby="pqTitle">
        <button type="button" class="pq-close" id="pqClose" aria-label="Close">&times;</button>
        
        <div class="pq-body">
            <!-- LEFT: Images -->
            <div class="pq-gallery">
                <div class="pq-main-img" id="pqMainImg">
                    <img src="" alt="" id="pqImg">
                    <div class="pq-img-loader" id="pqLoader"><i class="fas fa-spinner fa-spin"></i></div>
                </div>
                <div class="pq-thumbs" id="pqThumbs"></div>
                <div class="pq-dots" id="pqDots"></div>
            </div>
            
            <!-- RIGHT: Details -->
            <div class="pq-info">
                <span class="pq-cat" id="pqCat"></span>
                <h2 id="pqTitle"></h2>
                <div class="pq-price" id="pqPrice"></div>
                <p class="pq-note" id="pqNote"></p>
                <p class="pq-desc" id="pqDesc"></p>
                
                <div class="pq-actions">
                    <a href="#" id="pqWhatsApp" class="btn btn-whatsapp" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i> Order on WhatsApp
                    </a>
                    <form action="cart-action.php" method="POST" id="pqCartForm" style="display:inline;">
                        <input type="hidden" name="action" value="add">
                        <input type="hidden" name="id" id="pqCartId" value="">
                        <input type="hidden" name="name" id="pqCartName" value="">
                        <input type="hidden" name="price" id="pqCartPrice" value="">
                        <input type="hidden" name="redirect" value="products.php">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-cart-plus"></i> Add to Cart
                        </button>
                    </form>
                </div>
                
                <a href="#" id="pqFullLink" class="pq-full-link">
                    <i class="fas fa-external-link-alt"></i> Full Details Page →
                </a>
                
                <div class="pq-trust">
                    <span><i class="fas fa-bolt"></i> Fast delivery in Karachi</span>
                    <span><i class="fas fa-check-circle"></i> Quality guaranteed</span>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Product card hover already exists */
.product-card { position:relative; cursor:pointer; }
.product-card .product-link { text-decoration:none; color:inherit; display:flex; flex-direction:column; flex:1; cursor:pointer; }
.product-img { position:relative; overflow:hidden; }
.hover-detail {
    position:absolute; inset:0; background:rgba(28,25,23,0.88); color:white;
    display:flex; flex-direction:column; justify-content:center; align-items:center;
    padding:20px; text-align:center; opacity:0; transition:opacity 0.3s; z-index:3;
}
.product-card:hover .hover-detail { opacity:1; }
.hover-detail h4 { font-size:1.05rem; margin-bottom:8px; }
.hover-detail p { font-size:0.85rem; opacity:0.85; margin-bottom:10px; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden; }
.hover-price { font-weight:700; color:var(--accent,#fbbf24); font-size:1.1rem; margin-bottom:12px; }
.hover-btn { background:var(--primary,#9d174d); color:white; padding:8px 16px; border-radius:6px; font-size:0.85rem; font-weight:600; }
.card-cart-form { position:absolute; bottom:14px; right:14px; z-index:5; }

/* ========== QUICK VIEW MODAL ========== */
.pq-modal {
    position: fixed; inset: 0; z-index: 9999;
    display: flex; align-items: center; justify-content: center;
    visibility: hidden; opacity: 0; transition: opacity 0.28s ease, visibility 0.28s;
    padding: 16px;
}
.pq-modal.open {
    visibility: visible; opacity: 1;
}
.pq-backdrop {
    position: absolute; inset: 0;
    background: rgba(15, 12, 10, 0.72);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
}
.pq-dialog {
    position: relative;
    background: #fff;
    border-radius: 18px;
    width: 100%;
    max-width: 920px;
    max-height: 92vh;
    overflow: hidden;
    box-shadow: 0 25px 80px rgba(0,0,0,0.35);
    transform: translateY(24px) scale(0.96);
    transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
    display: flex;
    flex-direction: column;
}
.pq-modal.open .pq-dialog {
    transform: translateY(0) scale(1);
}
.pq-close {
    position: absolute;
    top: 12px; right: 14px;
    z-index: 20;
    width: 40px; height: 40px;
    border: none; border-radius: 50%;
    background: rgba(0,0,0,0.55);
    color: #fff; font-size: 1.6rem; line-height: 1;
    cursor: pointer;
    display: flex; align-items: center; justify-content: center;
    transition: background 0.2s;
}
.pq-close:hover { background: var(--primary, #9d174d); }

.pq-body {
    display: grid;
    grid-template-columns: 1.05fr 1fr;
    min-height: 420px;
    max-height: 92vh;
}

/* Gallery */
.pq-gallery {
    background: #f8f4ef;
    display: flex;
    flex-direction: column;
    border-right: 1px solid #eee;
    min-height: 360px;
}
.pq-main-img {
    flex: 1;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 28px 20px 12px;
    min-height: 300px;
}
.pq-main-img img {
    max-width: 100%;
    max-height: 340px;
    object-fit: contain;
    border-radius: 10px;
    transition: opacity 0.35s ease;
    box-shadow: 0 8px 28px rgba(0,0,0,0.08);
}
.pq-img-loader {
    position: absolute;
    inset: 0;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    color: var(--primary, #9d174d);
}
.pq-img-loader.show { display: flex; }

.pq-thumbs {
    display: flex;
    gap: 8px;
    padding: 10px 16px 14px;
    justify-content: center;
    flex-wrap: wrap;
}
.pq-thumbs button {
    width: 56px; height: 56px;
    border: 2px solid transparent;
    border-radius: 8px;
    padding: 0; overflow: hidden;
    background: #fff;
    cursor: pointer;
    transition: border-color 0.2s, transform 0.2s;
}
.pq-thumbs button.active {
    border-color: var(--primary, #9d174d);
    transform: scale(1.05);
}
.pq-thumbs button img {
    width: 100%; height: 100%;
    object-fit: cover;
}

.pq-dots {
    display: none;
    justify-content: center;
    gap: 7px;
    padding-bottom: 14px;
}
.pq-dots span {
    width: 8px; height: 8px;
    border-radius: 50%;
    background: #ccc;
    cursor: pointer;
    transition: 0.2s;
}
.pq-dots span.active {
    background: var(--primary, #9d174d);
    transform: scale(1.25);
}

/* Info panel */
.pq-info {
    padding: 32px 28px 28px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}
.pq-cat {
    display: inline-block;
    background: #fdf2f8;
    color: var(--primary, #9d174d);
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    padding: 4px 10px;
    border-radius: 20px;
    margin-bottom: 10px;
    width: fit-content;
}
.pq-info h2 {
    font-family: var(--font-heading, inherit);
    font-size: 1.55rem;
    margin: 0 0 12px;
    line-height: 1.3;
    color: #1c1917;
}
.pq-price {
    font-size: 1.45rem;
    font-weight: 700;
    color: var(--primary, #9d174d);
    margin-bottom: 4px;
}
.pq-note {
    font-size: 0.88rem;
    color: #78716c;
    margin: 0 0 16px;
}
.pq-desc {
    color: #57534e;
    line-height: 1.7;
    font-size: 0.98rem;
    margin: 0 0 22px;
    flex: 1;
}

.pq-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 18px;
}
.pq-actions .btn {
    padding: 12px 18px;
    font-size: 0.92rem;
}

.pq-full-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--primary, #9d174d);
    font-weight: 600;
    font-size: 0.92rem;
    text-decoration: none;
    margin-bottom: 18px;
}
.pq-full-link:hover { text-decoration: underline; }

.pq-trust {
    display: flex;
    flex-wrap: wrap;
    gap: 14px;
    font-size: 0.82rem;
    color: #78716c;
    padding-top: 14px;
    border-top: 1px solid #f0ebe3;
}
.pq-trust span { display: flex; align-items: center; gap: 6px; }
.pq-trust i { color: var(--primary, #9d174d); }

/* Mobile: stack */
@media (max-width: 720px) {
    .pq-body {
        grid-template-columns: 1fr;
        max-height: 90vh;
        overflow-y: auto;
    }
    .pq-gallery {
        border-right: none;
        border-bottom: 1px solid #eee;
        min-height: 260px;
    }
    .pq-main-img {
        min-height: 220px;
        padding: 20px 16px 8px;
    }
    .pq-main-img img { max-height: 220px; }
    .pq-info { padding: 20px 18px 24px; }
    .pq-info h2 { font-size: 1.3rem; }
    .pq-thumbs { display: none; }
    .pq-dots { display: flex; }
    .pq-close { top: 8px; right: 8px; width: 36px; height: 36px; }
}

body.pq-open { overflow: hidden; }
</style>

<script>
(function(){
    // --- Card image auto-rotate (existing) ---
    document.querySelectorAll('.card-slider').forEach(function(el){
        let imgs = [];
        try { imgs = JSON.parse(el.dataset.images || '[]'); } catch(e){}
        if (imgs.length <= 1) return;
        let idx = 0;
        const imgEl = el.querySelector('.slide-img');
        if (!imgEl) return;
        setInterval(function(){
            idx = (idx + 1) % imgs.length;
            imgEl.style.opacity = '0';
            setTimeout(function(){
                imgEl.src = imgs[idx];
                imgEl.style.opacity = '1';
            }, 280);
        }, 2400);
        imgEl.style.transition = 'opacity 0.35s ease';
    });

    // --- Quick View Modal ---
    const modal = document.getElementById('productModal');
    if (!modal) return;

    const pqImg = document.getElementById('pqImg');
    const pqLoader = document.getElementById('pqLoader');
    const pqThumbs = document.getElementById('pqThumbs');
    const pqDots = document.getElementById('pqDots');
    const pqTitle = document.getElementById('pqTitle');
    const pqCat = document.getElementById('pqCat');
    const pqPrice = document.getElementById('pqPrice');
    const pqNote = document.getElementById('pqNote');
    const pqDesc = document.getElementById('pqDesc');
    const pqWhatsApp = document.getElementById('pqWhatsApp');
    const pqFullLink = document.getElementById('pqFullLink');
    const pqCartId = document.getElementById('pqCartId');
    const pqCartName = document.getElementById('pqCartName');
    const pqCartPrice = document.getElementById('pqCartPrice');

    let currentImages = [];
    let currentIdx = 0;
    let autoTimer = null;

    function showImage(i) {
        if (!currentImages.length) return;
        currentIdx = ((i % currentImages.length) + currentImages.length) % currentImages.length;
        const src = currentImages[currentIdx];
        pqLoader.classList.add('show');
        pqImg.style.opacity = '0';
        const tmp = new Image();
        tmp.onload = function(){
            pqImg.src = src;
            pqImg.style.opacity = '1';
            pqLoader.classList.remove('show');
        };
        tmp.onerror = function(){
            pqImg.src = 'assets/images/logo.png';
            pqImg.style.opacity = '1';
            pqLoader.classList.remove('show');
        };
        tmp.src = src;

        pqThumbs.querySelectorAll('button').forEach((b, n) => b.classList.toggle('active', n === currentIdx));
        pqDots.querySelectorAll('span').forEach((d, n) => d.classList.toggle('active', n === currentIdx));
    }

    function startAuto() {
        stopAuto();
        if (currentImages.length <= 1) return;
        autoTimer = setInterval(function(){
            showImage(currentIdx + 1);
        }, 2800);
    }
    function stopAuto() {
        if (autoTimer) { clearInterval(autoTimer); autoTimer = null; }
    }

    function openModal(card) {
        const id = card.dataset.id;
        const name = card.dataset.name || '';
        const desc = card.dataset.desc || '';
        const price = card.dataset.price || '';
        const note = card.dataset.note || '';
        const cat = card.dataset.catLabel || card.dataset.cat || '';
        const wa = card.dataset.wa || '#';
        let images = [];
        try { images = JSON.parse(card.dataset.images || '[]'); } catch(e){}
        if (!images.length) images = ['assets/images/logo.png'];

        currentImages = images;
        currentIdx = 0;

        pqTitle.textContent = name;
        pqCat.textContent = cat;
        pqPrice.textContent = price;
        pqNote.textContent = note ? ('/ ' + note) : '';
        pqDesc.textContent = desc;
        pqWhatsApp.href = wa;
        pqFullLink.href = 'product.php?id=' + encodeURIComponent(id);
        pqCartId.value = id;
        pqCartName.value = name;
        // price numeric not available in data-price text — leave empty or parse; cart uses name mainly
        pqCartPrice.value = '';

        // thumbs
        pqThumbs.innerHTML = '';
        pqDots.innerHTML = '';
        images.forEach(function(src, i){
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.innerHTML = '<img src="'+src+'" alt="">';
            btn.addEventListener('click', function(e){
                e.stopPropagation();
                showImage(i);
                startAuto();
            });
            pqThumbs.appendChild(btn);

            const dot = document.createElement('span');
            if (i === 0) dot.classList.add('active');
            dot.addEventListener('click', function(){
                showImage(i);
                startAuto();
            });
            pqDots.appendChild(dot);
        });

        showImage(0);
        startAuto();

        modal.classList.add('open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('pq-open');
    }

    function closeModal() {
        modal.classList.remove('open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('pq-open');
        stopAuto();
    }

    // Open on card click
    document.querySelectorAll('.product-card').forEach(function(card){
        const openEl = card.querySelector('.product-open-modal');
        if (openEl) {
            openEl.addEventListener('click', function(e){
                e.preventDefault();
                openModal(card);
            });
            openEl.addEventListener('keydown', function(e){
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    openModal(card);
                }
            });
        }
    });

    document.getElementById('pqClose').addEventListener('click', closeModal);
    modal.querySelector('.pq-backdrop').addEventListener('click', closeModal);
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
    });

    // Pause auto on hover gallery
    const gallery = modal.querySelector('.pq-gallery');
    if (gallery) {
        gallery.addEventListener('mouseenter', stopAuto);
        gallery.addEventListener('mouseleave', startAuto);
    }
})();
</script>

<?php require_once 'includes/footer.php'; ?>
