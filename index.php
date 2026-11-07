<?php
session_start();
$ADMIN_PASS = '07printers';

if (isset($_GET['logout'])) { session_destroy(); header('Location: index.php'); exit; }

if (!isset($_SESSION['admin_logged'])) {
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $ADMIN_PASS) {
            $_SESSION['admin_logged'] = true;
            header('Location: index.php'); exit;
        } else { $error = 'Wrong password!'; }
    }
    ?>
    <!DOCTYPE html><html><head><title>Admin Login</title><meta name="viewport" content="width=device-width,initial-scale=1">
    <style>body{font-family:system-ui;background:#f5f0e6;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0}
    .box{background:#fff;padding:40px;border-radius:12px;box-shadow:0 4px 20px rgba(0,0,0,.08);width:100%;max-width:360px;text-align:center}
    h2{color:#9d174d;margin-bottom:24px}input{width:100%;padding:12px;border:1px solid #ddd;border-radius:8px;margin-bottom:16px;font-size:15px;box-sizing:border-box}
    button{width:100%;padding:12px;background:#9d174d;color:#fff;border:none;border-radius:8px;font-size:15px;cursor:pointer;font-weight:600}
    .err{color:#b91c1c;margin-bottom:12px;font-size:14px}</style></head><body>
    <div class="box"><h2>07 Printers Admin</h2>
    <?php if(!empty($error)) echo "<p class='err'>$error</p>"; ?>
    <form method="POST"><input type="password" name="password" placeholder="Password" required autofocus>
    <button type="submit">Login</button></form>
    <p style="margin-top:16px;font-size:13px;color:#888">Password: 07printers</p></div></body></html>
    <?php exit;
}

// Paths
$dataFile = __DIR__ . '/../data/products.json';
$adsFile  = __DIR__ . '/../data/ads.json';
$uploadDir = __DIR__ . '/../assets/images/products/';
$adsUpload = __DIR__ . '/../assets/images/ads/';
@mkdir($uploadDir, 0755, true);
@mkdir($adsUpload, 0755, true);

$products = file_exists($dataFile) ? (json_decode(file_get_contents($dataFile), true) ?: []) : [];
$ads = file_exists($adsFile) ? (json_decode(file_get_contents($adsFile), true) ?: []) : [];
$tab = $_GET['tab'] ?? 'products';

// ========== PRODUCT ACTIONS ==========
if (isset($_POST['action'])) {
    $act = $_POST['action'];

    // ADD / EDIT PRODUCT
    if ($act === 'save_product') {
        $id = (int)($_POST['id'] ?? 0);
        $name = trim($_POST['name'] ?? '');
        $price = trim($_POST['price'] ?? '');
        $desc = trim($_POST['desc'] ?? '');
        $cat = trim($_POST['category'] ?? 'printing');
        $note = trim($_POST['note'] ?? '');

        $images = [];
        // Keep existing images if editing
        if ($id > 0) {
            foreach ($products as $p) {
                if ($p['id'] == $id) { $images = $p['images'] ?? []; break; }
            }
        }
        // Upload up to 3 new images
        for ($i = 1; $i <= 3; $i++) {
            $key = "image$i";
            if (!empty($_FILES[$key]['name'])) {
                $ext = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg','jpeg','png','webp','gif'])) {
                    $fname = 'prod_' . time() . "_{$i}_" . rand(100,999) . '.' . $ext;
                    move_uploaded_file($_FILES[$key]['tmp_name'], $uploadDir . $fname);
                    // replace or append
                    if (isset($images[$i-1])) {
                        $old = __DIR__ . '/../' . $images[$i-1];
                        if (file_exists($old) && strpos($images[$i-1], 'prod_') !== false) @unlink($old);
                        $images[$i-1] = 'assets/images/products/' . $fname;
                    } else {
                        $images[] = 'assets/images/products/' . $fname;
                    }
                }
            }
        }
        $images = array_values(array_filter($images));

        if ($name !== '') {
            if ($id > 0) {
                // Edit
                foreach ($products as &$p) {
                    if ($p['id'] == $id) {
                        $p['name'] = $name;
                        $p['price'] = $price === '' ? null : (float)$price;
                        $p['desc'] = $desc;
                        $p['cat'] = $cat;
                        $p['note'] = $note;
                        if (!empty($images)) {
                            $p['images'] = $images;
                            $p['img'] = $images[0];
                        }
                        break;
                    }
                }
                unset($p);
            } else {
                // Add new
                $newId = empty($products) ? 100 : (max(array_column($products, 'id')) + 1);
                $products[] = [
                    'id' => $newId,
                    'name' => $name,
                    'price' => $price === '' ? null : (float)$price,
                    'desc' => $desc,
                    'cat' => $cat,
                    'note' => $note ?: ($price === '' ? 'Contact for Price' : 'Per item'),
                    'img' => $images[0] ?? '',
                    'images' => $images
                ];
            }
            file_put_contents($dataFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            header('Location: index.php?tab=products&ok=1'); exit;
        }
    }

    // DELETE PRODUCT
    if ($act === 'delete_product') {
        $delId = (int)($_POST['id'] ?? 0);
        $products = array_values(array_filter($products, function($p) use ($delId) {
            if ($p['id'] == $delId) {
                foreach (($p['images'] ?? []) as $im) {
                    $path = __DIR__ . '/../' . $im;
                    if (file_exists($path) && strpos($im, 'prod_') !== false) @unlink($path);
                }
                return false;
            }
            return true;
        }));
        file_put_contents($dataFile, json_encode($products, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header('Location: index.php?tab=products&deleted=1'); exit;
    }

    // SAVE AD
    if ($act === 'save_ad') {
        $adId = (int)($_POST['ad_id'] ?? 0);
        $title = trim($_POST['ad_title'] ?? '');
        $link = trim($_POST['ad_link'] ?? '');
        $img = '';
        if (!empty($_FILES['ad_image']['name'])) {
            $ext = strtolower(pathinfo($_FILES['ad_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','webp','gif'])) {
                $fname = 'ad_' . time() . '.' . $ext;
                move_uploaded_file($_FILES['ad_image']['tmp_name'], $adsUpload . $fname);
                $img = 'assets/images/ads/' . $fname;
            }
        }
        if ($adId > 0) {
            foreach ($ads as &$a) {
                if ($a['id'] == $adId) {
                    $a['title'] = $title;
                    $a['link'] = $link;
                    if ($img) $a['img'] = $img;
                    break;
                }
            }
            unset($a);
        } else {
            $newId = empty($ads) ? 1 : (max(array_column($ads, 'id')) + 1);
            $ads[] = ['id'=>$newId, 'title'=>$title, 'link'=>$link, 'img'=>$img];
        }
        file_put_contents($adsFile, json_encode($ads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header('Location: index.php?tab=ads&ok=1'); exit;
    }

    // DELETE AD
    if ($act === 'delete_ad') {
        $delId = (int)($_POST['id'] ?? 0);
        $ads = array_values(array_filter($ads, function($a) use ($delId) {
            if ($a['id'] == $delId) {
                if (!empty($a['img'])) {
                    $path = __DIR__ . '/../' . $a['img'];
                    if (file_exists($path)) @unlink($path);
                }
                return false;
            }
            return true;
        }));
        file_put_contents($adsFile, json_encode($ads, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        header('Location: index.php?tab=ads&deleted=1'); exit;
    }
}

// Edit mode
$editProduct = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    foreach ($products as $p) { if ($p['id'] == $eid) { $editProduct = $p; break; } }
}
$editAd = null;
if (isset($_GET['edit_ad'])) {
    $eid = (int)$_GET['edit_ad'];
    foreach ($ads as $a) { if ($a['id'] == $eid) { $editAd = $a; break; } }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - 07 Printers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:system-ui,sans-serif;background:#f7f1e8;color:#1c1917}
        .header{background:#1c1917;color:#fff;padding:14px 24px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px}
        .header h1{font-size:1.15rem}
        .header a{color:#d4a373;text-decoration:none;font-size:.9rem;margin-left:14px}
        .tabs{display:flex;gap:0;background:#fff;border-bottom:2px solid #eee}
        .tabs a{padding:14px 24px;text-decoration:none;color:#666;font-weight:600;border-bottom:3px solid transparent}
        .tabs a.active{color:#9d174d;border-bottom-color:#9d174d}
        .wrap{max-width:1200px;margin:0 auto;padding:24px 16px}
        .grid{display:grid;grid-template-columns:1fr 1.4fr;gap:24px}
        @media(max-width:900px){.grid{grid-template-columns:1fr}}
        .card{background:#fff;border-radius:12px;padding:24px;box-shadow:0 2px 12px rgba(0,0,0,.06)}
        .card h2{font-size:1.1rem;margin-bottom:18px;color:#9d174d}
        label{display:block;font-size:.85rem;font-weight:600;margin-bottom:5px;color:#444}
        input,select,textarea{width:100%;padding:10px 12px;border:1px solid #e0d6c8;border-radius:8px;font-size:.95rem;margin-bottom:14px;background:#faf7f2}
        input:focus,select:focus,textarea:focus{outline:none;border-color:#9d174d}
        .btn{padding:11px 18px;border:none;border-radius:8px;font-size:.95rem;font-weight:600;cursor:pointer}
        .btn-primary{background:#9d174d;color:#fff;width:100%}
        .btn-primary:hover{background:#831843}
        .btn-sm{padding:6px 12px;font-size:.8rem;border-radius:6px}
        .btn-edit{background:#fef3c7;color:#92400e}
        .btn-del{background:#fee2e2;color:#b91c1c}
        .msg{padding:10px 14px;border-radius:8px;margin-bottom:16px;font-size:.9rem}
        .msg.ok{background:#dcfce7;color:#166534}
        .msg.del{background:#fee2e2;color:#991b1b}
        .list{display:flex;flex-direction:column;gap:10px;max-height:75vh;overflow-y:auto}
        .item{display:flex;gap:12px;align-items:center;padding:12px;border:1px solid #eee;border-radius:10px;background:#fafafa}
        .item img{width:56px;height:56px;object-fit:cover;border-radius:8px;background:#eee}
        .item .info{flex:1;min-width:0}
        .item .info h4{font-size:.92rem;margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .item .info p{font-size:.78rem;color:#666}
        .item .price{font-weight:700;color:#9d174d;font-size:.88rem}
        .item .acts{display:flex;gap:6px}
        .empty{text-align:center;color:#999;padding:30px}
        .img-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:14px}
        .img-row label{font-size:.8rem}
    </style>
</head>
<body>
<div class="header">
    <h1>07 Printers — Admin Panel</h1>
    <div>
        <a href="../index.php" target="_blank">View Website</a>
        <a href="?logout=1">Logout</a>
    </div>
</div>
<div class="tabs">
    <a href="?tab=products" class="<?php echo $tab==='products'?'active':''; ?>">Products (<?php echo count($products); ?>)</a>
    <a href="?tab=ads" class="<?php echo $tab==='ads'?'active':''; ?>">Ads / Banner (<?php echo count($ads); ?>)</a>
</div>

<div class="wrap">
<?php if (isset($_GET['ok'])): ?><div class="msg ok">Saved successfully!</div><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><div class="msg del">Deleted.</div><?php endif; ?>

<?php if ($tab === 'products'): ?>
<div class="grid">
    <!-- FORM -->
    <div class="card">
        <h2><?php echo $editProduct ? '✏️ Edit Product' : '➕ Add Product'; ?></h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="save_product">
            <input type="hidden" name="id" value="<?php echo $editProduct['id'] ?? 0; ?>">
            
            <label>Product Name *</label>
            <input type="text" name="name" required value="<?php echo htmlspecialchars($editProduct['name'] ?? ''); ?>" placeholder="e.g. Visiting Cards">
            
            <label>Price (empty = Contact for Price)</label>
            <input type="number" name="price" min="0" step="1" value="<?php echo $editProduct['price'] ?? ''; ?>" placeholder="1600">
            
            <label>Price Note</label>
            <input type="text" name="note" value="<?php echo htmlspecialchars($editProduct['note'] ?? ''); ?>" placeholder="Per page / 1000 pcs">
            
            <label>Description</label>
            <textarea name="desc" rows="2"><?php echo htmlspecialchars($editProduct['desc'] ?? ''); ?></textarea>
            
            <label>Category</label>
            <select name="category">
                <?php
                $cats = ['printing'=>'Printing','photo'=>'Photo','cards'=>'Cards & ID','frames'=>'Nikkah & Frames','gifts'=>'Gifts','flex'=>'Flex & Banners','design'=>'Designing','stamp'=>'Stamp'];
                $cur = $editProduct['cat'] ?? 'printing';
                foreach ($cats as $k=>$v) echo '<option value="'.$k.'"'.($cur===$k?' selected':'').'>'.$v.'</option>';
                ?>
            </select>
            
            <label>Images (up to 3 — name them 1, 2, 3)</label>
            <div class="img-row">
                <div>
                    <label>Image 1</label>
                    <input type="file" name="image1" accept="image/*">
                    <?php if (!empty($editProduct['images'][0])): ?>
                    <img src="../<?php echo $editProduct['images'][0]; ?>" style="width:100%;height:60px;object-fit:cover;border-radius:6px;margin-top:4px">
                    <?php endif; ?>
                </div>
                <div>
                    <label>Image 2</label>
                    <input type="file" name="image2" accept="image/*">
                    <?php if (!empty($editProduct['images'][1])): ?>
                    <img src="../<?php echo $editProduct['images'][1]; ?>" style="width:100%;height:60px;object-fit:cover;border-radius:6px;margin-top:4px">
                    <?php endif; ?>
                </div>
                <div>
                    <label>Image 3</label>
                    <input type="file" name="image3" accept="image/*">
                    <?php if (!empty($editProduct['images'][2])): ?>
                    <img src="../<?php echo $editProduct['images'][2]; ?>" style="width:100%;height:60px;object-fit:cover;border-radius:6px;margin-top:4px">
                    <?php endif; ?>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary"><?php echo $editProduct ? 'Update Product' : 'Add Product'; ?></button>
            <?php if ($editProduct): ?>
            <a href="?tab=products" style="display:block;text-align:center;margin-top:10px;color:#666;font-size:.9rem">Cancel Edit</a>
            <?php endif; ?>
        </form>
    </div>
    
    <!-- LIST -->
    <div class="card">
        <h2>📦 All Products (<?php echo count($products); ?>)</h2>
        <div class="list">
            <?php if (empty($products)): ?>
            <div class="empty">No products yet</div>
            <?php else: foreach (array_reverse($products) as $p): ?>
            <div class="item">
                <?php $im = $p['images'][0] ?? $p['img'] ?? ''; ?>
                <?php if ($im): ?><img src="../<?php echo htmlspecialchars($im); ?>" alt=""><?php else: ?><div style="width:56px;height:56px;background:#eee;border-radius:8px"></div><?php endif; ?>
                <div class="info">
                    <h4><?php echo htmlspecialchars($p['name']); ?></h4>
                    <p><?php echo htmlspecialchars($p['cat'] ?? ''); ?> • <?php echo count($p['images'] ?? []); ?> img</p>
                    <div class="price"><?php echo isset($p['price']) && $p['price'] !== null ? 'Rs. '.number_format($p['price']) : 'Contact'; ?></div>
                </div>
                <div class="acts">
                    <a href="?tab=products&edit=<?php echo $p['id']; ?>" class="btn btn-sm btn-edit">Edit</a>
                    <form method="POST" style="display:inline" onsubmit="return confirm('Delete this product?')">
                        <input type="hidden" name="action" value="delete_product">
                        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-del">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>

<?php else: /* ADS TAB */ ?>
<div class="grid">
    <div class="card">
        <h2><?php echo $editAd ? '✏️ Edit Ad' : '➕ Add Ad / Banner'; ?></h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="action" value="save_ad">
            <input type="hidden" name="ad_id" value="<?php echo $editAd['id'] ?? 0; ?>">
            
            <label>Ad Title</label>
            <input type="text" name="ad_title" value="<?php echo htmlspecialchars($editAd['title'] ?? ''); ?>" placeholder="Summer Sale / New Frames">
            
            <label>Link (product page or WhatsApp or any URL)</label>
            <input type="text" name="ad_link" value="<?php echo htmlspecialchars($editAd['link'] ?? ''); ?>" placeholder="product.php?id=60 or https://wa.me/...">
            
            <label>Ad Image *</label>
            <input type="file" name="ad_image" accept="image/*" <?php echo $editAd ? '' : 'required'; ?>>
            <?php if (!empty($editAd['img'])): ?>
            <img src="../<?php echo $editAd['img']; ?>" style="width:100%;max-height:120px;object-fit:contain;border-radius:8px;margin-bottom:12px">
            <?php endif; ?>
            
            <button type="submit" class="btn btn-primary"><?php echo $editAd ? 'Update Ad' : 'Add Ad'; ?></button>
            <?php if ($editAd): ?><a href="?tab=ads" style="display:block;text-align:center;margin-top:10px;color:#666;font-size:.9rem">Cancel</a><?php endif; ?>
        </form>
    </div>
    
    <div class="card">
        <h2>📢 Current Ads (<?php echo count($ads); ?>)</h2>
        <div class="list">
            <?php if (empty($ads)): ?>
            <div class="empty">No ads yet. Add from left form.<br>Ads will auto-slide on homepage every 4 seconds.</div>
            <?php else: foreach (array_reverse($ads) as $a): ?>
            <div class="item">
                <?php if (!empty($a['img'])): ?><img src="../<?php echo htmlspecialchars($a['img']); ?>" alt=""><?php else: ?><div style="width:56px;height:56px;background:#eee;border-radius:8px"></div><?php endif; ?>
                <div class="info">
                    <h4><?php echo htmlspecialchars($a['title'] ?: 'Ad #'.$a['id']); ?></h4>
                    <p style="word-break:break-all"><?php echo htmlspecialchars($a['link'] ?? ''); ?></p>
                </div>
                <div class="acts">
                    <a href="?tab=ads&edit_ad=<?php echo $a['id']; ?>" class="btn btn-sm btn-edit">Edit</a>
                    <form method="POST" style="display:inline" onsubmit="return confirm('Delete this ad?')">
                        <input type="hidden" name="action" value="delete_ad">
                        <input type="hidden" name="id" value="<?php echo $a['id']; ?>">
                        <button type="submit" class="btn btn-sm btn-del">Delete</button>
                    </form>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
    </div>
</div>
<?php endif; ?>
</div>
</body>
</html>
