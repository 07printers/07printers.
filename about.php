<?php
require_once 'includes/config.php';
$pageTitle = 'About Us | 07 Printers';
require_once 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>About 07 Printers</h1>
        <p>Your trusted printing partner in Nazimabad, Karachi</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <span>About</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="about-content">
            <div class="about-img" data-aos="fade-right" style="background:#fff; padding:30px;">
                <img src="assets/images/logo.png" alt="07 Printers" style="max-width:220px; width:100%; object-fit:contain;">
            </div>
            <div data-aos="fade-left">
                <span class="section-badge">Who We Are</span>
                <h2 style="font-family:var(--font-heading); font-size:1.8rem; margin:12px 0 20px;">
                    More Than Just a Photocopy Shop
                </h2>
                <p style="color:var(--gray); margin-bottom:16px; line-height:1.8;">
                    <strong>07 Printers</strong> is a complete Digital Printing, Graphic Designing, 
                    Customized Gifts and Corporate Branding solution based in Nazimabad No. 03, Karachi.
                </p>
                <p style="color:var(--gray); margin-bottom:16px; line-height:1.8;">
                    Owned by <strong><?php echo OWNER1; ?></strong> and <strong><?php echo OWNER2; ?></strong>, 
                    we serve schools, colleges, businesses, event organizers and individual customers 
                    with professional quality and competitive rates.
                </p>
                <p style="color:var(--gray); margin-bottom:24px; line-height:1.8;">
                    From a single passport photo to bulk flex banners, from visiting cards to 
                    customized wedding posters — we handle it all under one roof.
                </p>
                
                <div style="display:flex; gap:16px; flex-wrap:wrap;">
                    <a href="contact.php" class="btn btn-primary">Contact Us</a>
                    <a href="<?php echo whatsappLink(); ?>" class="btn btn-whatsapp" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section" style="background:white;">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Our Equipment</span>
            <h2>Professional Machinery</h2>
            <p>We use industry-grade machines for consistent, high-quality results</p>
        </div>
        
        <table class="machine-table" data-aos="fade-up">
            <thead>
                <tr>
                    <th>Machine</th>
                    <th>Purpose</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Konica Minolta 808</strong></td>
                    <td>Color Printing</td>
                </tr>
                <tr>
                    <td><strong>Konica Minolta Bizhub Pro 950</strong></td>
                    <td>Heavy B/W Production Printing</td>
                </tr>
                <tr>
                    <td><strong>Konica Minolta 654e</strong></td>
                    <td>Color Printing & Photocopy</td>
                </tr>
                <tr>
                    <td><strong>Epson L310</strong></td>
                    <td>Sublimation Printing</td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <span class="section-badge">Software We Use</span>
            <h2>Design & Production Tools</h2>
        </div>
        
        <div class="why-grid">
            <div class="why-card" data-aos="fade-up">
                <div class="why-icon"><i class="fas fa-vector-square"></i></div>
                <h3>CorelDRAW 2018</h3>
                <p>Vector design & layout</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="50">
                <div class="why-icon"><i class="fas fa-image"></i></div>
                <h3>Adobe Photoshop</h3>
                <p>Photo editing & restoration</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="100">
                <div class="why-icon"><i class="fas fa-pen-fancy"></i></div>
                <h3>Adobe Illustrator</h3>
                <p>Logo & illustration design</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="150">
                <div class="why-icon"><i class="fas fa-file-word"></i></div>
                <h3>MS Office</h3>
                <p>Word & Excel document work</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="200">
                <div class="why-icon"><i class="fas fa-paint-brush"></i></div>
                <h3>Canva</h3>
                <p>Quick social media designs</p>
            </div>
            <div class="why-card" data-aos="fade-up" data-aos-delay="250">
                <div class="why-icon"><i class="fas fa-video"></i></div>
                <h3>Video Editing Tools</h3>
                <p>Promotional video production</p>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>