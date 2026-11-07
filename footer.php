</main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-col" data-aos="fade-up">
                    <a href="index.php" class="logo footer-logo">
                        <img src="assets/images/logo.png" alt="07 Printers" class="logo-img">
                        <div class="logo-text">
                            <span class="brand">Printers</span>
                            <span class="tag">Nazimabad, Karachi</span>
                        </div>
                    </a>
                    <p class="footer-desc">
                        Professional Digital Printing, Graphic Designing, Customized Gifts & Corporate Branding services in Nazimabad, Karachi.
                    </p>
                    <div class="social-links">
                        <a href="<?php echo whatsappLink(); ?>" target="_blank" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                        <a href="tel:<?php echo PHONE1; ?>" aria-label="Call"><i class="fas fa-phone"></i></a>
                        <a href="mailto:<?php echo EMAIL; ?>" aria-label="Email"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
                
                <div class="footer-col" data-aos="fade-up" data-aos-delay="100">
                    <h4>Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="services.php">All Services</a></li>
                        <li><a href="products.php">Products & Rates</a></li>
                        <li><a href="about.php">About Us</a></li>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="cart.php">Cart</a></li>
                    </ul>
                </div>
                
                <div class="footer-col" data-aos="fade-up" data-aos-delay="200">
                    <h4>Popular Services</h4>
                    <ul class="footer-links">
                        <li><a href="services.php#printing-photocopy">Printing & Photocopy</a></li>
                        <li><a href="services.php#customized-gifts">Customized Gifts</a></li>
                        <li><a href="services.php#flex-banners">Flex & Banners</a></li>
                        <li><a href="services.php#graphic-designing">Graphic Designing</a></li>
                        <li><a href="services.php#wedding-events">Wedding Posters</a></li>
                        <li><a href="services.php#visiting-cards">Visiting Cards</a></li>
                    </ul>
                </div>
                
                <div class="footer-col" data-aos="fade-up" data-aos-delay="300">
                    <h4>Contact Info</h4>
                    <ul class="footer-contact">
                        <li>
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo ADDRESS; ?></span>
                        </li>
                        <li>
                            <i class="fas fa-phone"></i>
                            <div>
                                <a href="tel:<?php echo PHONE1; ?>"><?php echo PHONE1; ?></a><br>
                                <a href="tel:<?php echo PHONE2; ?>"><?php echo PHONE2; ?></a>
                            </div>
                        </li>
                        <li>
                            <i class="fas fa-user"></i>
                            <span><?php echo OWNER1; ?> & <?php echo OWNER2; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> 07 Printers. All Rights Reserved.</p>
                <p class="payment-methods">
                    <span>We Accept:</span>
                    <i class="fas fa-money-bill-wave" title="Cash"></i>
                    <span class="pay-badge">EasyPaisa</span>
                    <span class="pay-badge">JazzCash</span>
                    <span class="pay-badge">Bank Transfer</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp -->
    <a href="<?php echo whatsappLink('Assalam o Alaikum 07 Printers! I need help with an order.'); ?>" 
       class="floating-whatsapp" target="_blank" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- Back to Top -->
    <button id="backToTop" class="back-to-top" aria-label="Back to top">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- Scripts -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>