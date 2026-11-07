<?php
require_once 'includes/config.php';
$pageTitle = 'Contact Us | 07 Printers';
require_once 'includes/header.php';
?>

<section class="page-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We're here to help with all your printing needs</p>
        <div class="breadcrumb">
            <a href="index.php">Home</a> / <span>Contact</span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div data-aos="fade-right">
                <div class="contact-info-card">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <h4 style="font-weight:600; margin-bottom:4px;">Address</h4>
                        <p style="color:var(--gray); font-size:0.95rem;"><?php echo ADDRESS; ?></p>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <i class="fas fa-phone"></i>
                    <div>
                        <h4 style="font-weight:600; margin-bottom:4px;">Phone</h4>
                        <p style="color:var(--gray);">
                            <a href="tel:<?php echo PHONE1; ?>"><?php echo PHONE1; ?></a> (<?php echo OWNER1; ?>)<br>
                            <a href="tel:<?php echo PHONE2; ?>"><?php echo PHONE2; ?></a> (<?php echo OWNER2; ?>)
                        </p>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <i class="fab fa-whatsapp"></i>
                    <div>
                        <h4 style="font-weight:600; margin-bottom:4px;">WhatsApp</h4>
                        <p style="color:var(--gray);">
                            <a href="<?php echo whatsappLink(); ?>" target="_blank">Chat with <?php echo OWNER1; ?></a><br>
                            <a href="<?php echo whatsappLink('', WHATSAPP2); ?>" target="_blank">Chat with <?php echo OWNER2; ?></a>
                        </p>
                    </div>
                </div>
                
                <div class="contact-info-card">
                    <i class="fas fa-clock"></i>
                    <div>
                        <h4 style="font-weight:600; margin-bottom:4px;">Working Hours</h4>
                        <p style="color:var(--gray); font-size:0.95rem;">
                            Monday – Saturday: 11:00 AM – 11:00 PM<br>
                            Sunday: Open contact my number I response you
                        </p>
                    </div>
                </div>
                
                <div style="margin-top:24px;">
                    <a href="<?php echo whatsappLink('Assalam o Alaikum 07 Printers!'); ?>" 
                       class="btn btn-whatsapp" target="_blank" style="width:100%; justify-content:center; padding:14px;">
                        <i class="fab fa-whatsapp"></i> Start WhatsApp Chat
                    </a>
                </div>
            </div>
            
            <div data-aos="fade-left">
                <div class="contact-form">
                    <h3 style="font-family:var(--font-heading); margin-bottom:8px;">Send a Message</h3>
                    <p style="color:var(--gray); margin-bottom:24px; font-size:0.95rem;">
                        Fill the form and we'll get back to you shortly. For faster response use WhatsApp.
                    </p>
                    
                    <form action="<?php echo whatsappLink(); ?>" method="GET" id="contactForm" 
                          onsubmit="return sendWhatsApp(event);">
                        <div class="form-group">
                            <label>Your Name *</label>
                            <input type="text" id="c_name" required placeholder="Full name">
                        </div>
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <input type="tel" id="c_phone" required placeholder="03XX-XXXXXXX">
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <select id="c_subject">
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Printing Quote">Printing Quote</option>
                                <option value="Custom Design">Custom Design</option>
                                <option value="Bulk Order">Bulk Order</option>
                                <option value="Wedding / Event">Wedding / Event</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message *</label>
                            <textarea id="c_message" rows="4" required placeholder="Tell us what you need..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" style="width:100%; padding:14px;">
                            <i class="fab fa-whatsapp"></i> Send via WhatsApp
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Map Placeholder -->
<section class="section" style="padding-top:0;">
    <div class="container">
        <div data-aos="fade-up" style="background:var(--dark); border-radius:var(--radius-lg); height:300px; display:flex; align-items:center; justify-content:center; color:white; text-align:center;">
            <div>
                <i class="fas fa-map-marked-alt" style="font-size:3rem; margin-bottom:16px; color:var(--primary);"></i>
                <h3 style="font-family:var(--font-heading); margin-bottom:8px;">Nazimabad No. 03, Karachi</h3>
                <p style="opacity:0.7;">Near Abbasi Shaheed Hospital, Opposite HOPES Diagnostics</p>
                <a href="https://maps.app.goo.gl/uMktFL54W9FhEpfj6" 
                   target="_blank" class="btn btn-primary" style="margin-top:16px;">
                    <i class="fas fa-directions"></i> Open in Google Maps
                </a>
            </div>
        </div>
    </div>
</section>

<script>
function sendWhatsApp(e) {
    e.preventDefault();
    const name = document.getElementById('c_name').value.trim();
    const phone = document.getElementById('c_phone').value.trim();
    const subject = document.getElementById('c_subject').value;
    const message = document.getElementById('c_message').value.trim();
    
    if (!name || !phone || !message) {
        alert('Please fill all required fields.');
        return false;
    }
    
    let text = "Assalam o Alaikum 07 Printers!\n\n";
    text += "*Contact Form Message*\n\n";
    text += "Name: " + name + "\n";
    text += "Phone: " + phone + "\n";
    text += "Subject: " + subject + "\n\n";
    text += "Message:\n" + message;
    
    window.open("https://wa.me/<?php echo WHATSAPP1; ?>?text=" + encodeURIComponent(text), '_blank');
    return false;
}
</script>

<?php require_once 'includes/footer.php'; ?>