<?php
require_once 'includes/config.php';
$pageTitle = 'All Services | 07 Printers';
require_once 'includes/header.php';

$services = [
    [
        'id' => 'printing-photocopy',
        'icon' => 'fa-print',
        'title' => 'Printing & Photocopy Services',
        'items' => [
            'Black & White Printing', 'Color Printing', 'A4 & A3 Printing',
            'Black & White Photocopy', 'Color Photocopy', 'Single / Double Side Printing',
            'Document Printing (PDF, Word, Excel)', 'Legal Size Document Printing', 'Bulk Photocopy & Printing'
        ]
    ],
    [
        'id' => 'photo-printing',
        'icon' => 'fa-camera',
        'title' => 'Photo Printing & Passport Photos',
        'items' => [
            'Passport Size Photos', 'Blue & White Background Photos', 'Digital Photo Printing',
            'A4 & A3 Photo Printing', '4×6 & 5×7 Photo Printing', 'Glossy Photo Printing',
            'Photo Background Removal', 'Photo Recovery & Enhancement', 'Photo Resize & Cropping',
            'ID Card Size Photos', 'School Passport Photos'
        ]
    ],
    [
        'id' => 'customized-gifts',
        'icon' => 'fa-gift',
        'title' => 'Customized Gifts & Personalized Products',
        'items' => [
            'Customized Photo Mugs', 'Customized Cushions', 'Customized T-Shirts',
            'Customized Keychains', 'Name Engraving Pens', 'Customized Water Bottles',
            'Customized Gift Combos', 'Personalized Photo Frames', 'Name Printing & Engraving',
            'Customized Bracelets', 'Birthday & Anniversary Gifts', 'Wedding & Couple Gifts',
            'Corporate Gift Items'
        ]
    ],
    [
        'id' => 'awards-certificates',
        'icon' => 'fa-award',
        'title' => 'Award Shields, Trophies & Certificates',
        'items' => [
            'Glass Award Shields', 'Wooden Award Shields', 'Metal Award Shields',
            'Customized Appreciation Shields', 'School & College Awards', 'Sports Competition Shields',
            'Certificate of Achievement', 'Certificate of Appreciation', 'Academic & Attendance Certificates',
            'Customized Award Designing'
        ]
    ],
    [
        'id' => 'visiting-cards',
        'icon' => 'fa-id-card',
        'title' => 'Visiting Cards & Business Stationery',
        'items' => [
            'Visiting Cards', 'Business Cards Designing', 'Letterheads',
            'Invoice / Bill Printing', 'A5 Invoice Printing', 'Receipt & Voucher Designing',
            'Company File Folders', 'Business Forms', 'Shop Price Lists',
            'Product Labels', 'Official Documents', 'Company Profile Designing'
        ]
    ],
    [
        'id' => 'flex-banners',
        'icon' => 'fa-flag',
        'title' => 'Flex, Banners, Stickers & Advertising',
        'items' => [
            'Flex / Panaflex Printing', 'Advertising Banners', 'Roll-up Standees',
            'Shop Signboard Designing', 'Outdoor & Indoor Advertising', 'Promotional Posters',
            'Event Welcome Boards', 'Product Stickers', 'Sticker Cutting (Plotter)',
            'Logo Stickers', 'Wall Branding Designs', 'Indoor Glow Sign Designs'
        ]
    ],
    [
        'id' => 'graphic-designing',
        'icon' => 'fa-palette',
        'title' => 'Graphic Designing & Digital Services',
        'items' => [
            'Professional Graphic Designing', 'Logo Designing', 'Visiting Card Designing',
            'Poster & Flyer Designing', 'Social Media Post Designing', 'Instagram & TikTok Thumbnails',
            'Wedding & Event Poster Designing',
            'Urdu & English Typing', 'CV / Resume Designing', 'Document Formatting',
            'Photo Editing', 'Image Restoration', 'Certificate Designing'
        ]
    ],
    [
        'id' => 'binding-lamination',
        'icon' => 'fa-book',
        'title' => 'Binding, Lamination & Office Supplies',
        'items' => [
            'Spiral Binding', 'Thesis Binding', 'Hard Lamination', 'Soft Lamination',
            'Plastic Coating', 'File Folders', 'Stick Files', 'Clip Files',
            'School Copies', 'School Diaries', 'Calendars', 'Notebooks & Office Documents'
        ]
    ],
    [
        'id' => 'school-educational',
        'icon' => 'fa-graduation-cap',
        'title' => 'School, College & Educational Printing',
        'items' => [
            'School Copies & Diaries', 'School Examination Papers', 'Single / Double Side Printing',
            'School Worksheets', 'Student ID / PVC Cards', 'School Badges',
            'School Certificates', 'Result Cards Designing', 'Attendance Certificates',
            'Academic Achievement Certificates', 'Student Passport Size Photos',
            'School Event Posters', 'Annual Function Banners', 'School & College Award Shields',
            'Project & Assignment Printing', 'Thesis & Report Binding'
        ]
    ],
    [
        'id' => 'wedding-events',
        'icon' => 'fa-heart',
        'title' => 'Wedding & Event Designing',
        'items' => [
            'Nikkah Frames & Nikkah Nama', 'Nikah Ceremony Posters', 'Barat Ceremony Posters', 'Valima Ceremony Posters',
            'Mayoon & Mehndi Posters', 'Engagement Ceremony Posters', 'Shalima Ceremony Posters',
            'Nikah Signing Boards', 'Welcome Boards', 'Birthday Posters',
            'Anniversary Posters', 'Event Banners', 'Invitation Card Designs',
            'Event Photo Frames'
        ]
    ],
];
?>

<section class="page-hero">
    <div class="container">
        <h1>Complete Services</h1>
        <p>100+ products and services under one roof</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <span>Services</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <?php foreach ($services as $index => $svc): ?>
        <div id="<?php echo $svc['id']; ?>" class="service-detail" style="margin-bottom:50px;" data-aos="fade-up">
            <div style="display:flex; align-items:center; gap:16px; margin-bottom:24px;">
                <div class="service-icon" style="margin:0;">
                    <i class="fas <?php echo $svc['icon']; ?>"></i>
                </div>
                <h2 style="font-family:var(--font-heading); font-size:1.5rem; margin:0;">
                    <?php echo $svc['title']; ?>
                </h2>
            </div>
            
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(220px, 1fr)); gap:12px;">
                <?php foreach ($svc['items'] as $item): ?>
                <div style="background:white; padding:14px 18px; border-radius:10px; box-shadow:var(--shadow); display:flex; align-items:center; gap:10px; transition:var(--transition);"
                     onmouseover="this.style.transform='translateX(6px)'; this.style.borderLeft='3px solid var(--primary)'"
                     onmouseout="this.style.transform=''; this.style.borderLeft='none'">
                    <i class="fas fa-check-circle" style="color:var(--success); font-size:0.9rem;"></i>
                    <span style="font-size:0.95rem;"><?php echo $item; ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div style="margin-top:20px;">
                <a href="<?php echo whatsappLink('Assalam o Alaikum! I am interested in: ' . $svc['title']); ?>" 
                   class="btn btn-whatsapp" target="_blank">
                    <i class="fab fa-whatsapp"></i> Inquire on WhatsApp
                </a>
                <a href="products.php" class="btn btn-outline" style="margin-left:10px;">
                    View Rates
                </a>
            </div>
        </div>
        
        <?php if ($index < count($services) - 1): ?>
        <hr style="border:none; border-top:1px solid #e2e8f0; margin:40px 0;">
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content" data-aos="zoom-in">
            <h2>Need Something Custom?</h2>
            <p>Tell us your requirement — we design and print almost everything.</p>
            <a href="<?php echo whatsappLink('Assalam o Alaikum 07 Printers! I have a custom requirement.'); ?>" 
               class="btn btn-whatsapp" target="_blank" style="padding:14px 28px;">
                <i class="fab fa-whatsapp"></i> Chat with Us
            </a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>