-- 07 Printers Database Schema
-- Import this into MySQL / phpMyAdmin

CREATE DATABASE IF NOT EXISTS printers07 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE printers07;

-- Categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    icon VARCHAR(50) DEFAULT 'print',
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products / Services
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT NOT NULL,
    name VARCHAR(200) NOT NULL,
    slug VARCHAR(200) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) DEFAULT NULL, -- NULL means "Contact for price"
    price_note VARCHAR(255) DEFAULT NULL,
    image VARCHAR(255) DEFAULT NULL,
    is_featured TINYINT(1) DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Orders (simple)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(20) NOT NULL UNIQUE,
    customer_name VARCHAR(100),
    customer_phone VARCHAR(20),
    customer_email VARCHAR(100),
    customer_address TEXT,
    payment_method ENUM('whatsapp','easypaisa','jazzcash','bank') DEFAULT 'whatsapp',
    payment_status ENUM('pending','paid','cancelled') DEFAULT 'pending',
    total_amount DECIMAL(12,2) DEFAULT 0,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order Items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT,
    product_name VARCHAR(200),
    quantity INT DEFAULT 1,
    unit_price DECIMAL(10,2),
    subtotal DECIMAL(12,2),
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
);

-- Insert Categories
INSERT INTO categories (name, slug, description, icon, sort_order) VALUES
('Printing & Photocopy', 'printing-photocopy', 'Black & White, Color, A4, A3, Document & Bulk Printing', 'print', 1),
('Photo Printing', 'photo-printing', 'Passport Photos, Glossy Prints, Photo Enhancement', 'camera', 2),
('Customized Gifts', 'customized-gifts', 'Mugs, T-Shirts, Cushions, Keychains, Water Bottles & more', 'gift', 3),
('Awards & Certificates', 'awards-certificates', 'Shields, Trophies, Certificates of Achievement', 'award', 4),
('Visiting Cards & Stationery', 'visiting-cards', 'Business Cards, Letterheads, Invoices, Labels', 'id-card', 5),
('Flex, Banners & Stickers', 'flex-banners', 'Panaflex, Roll-ups, Signboards, Stickers, Wall Branding', 'banner', 6),
('Graphic Designing', 'graphic-designing', 'Logo, Posters, Social Media, Video Editing, CV Design', 'palette', 7),
('Binding & Office Supplies', 'binding-lamination', 'Spiral Binding, Lamination, Files, Notebooks', 'book', 8),
('School & Educational', 'school-educational', 'School Copies, Exam Papers, ID Cards, Certificates', 'graduation-cap', 9),
('Wedding & Events', 'wedding-events', 'Nikah, Barat, Valima Posters, Invitation Cards, Boards', 'heart', 10);

-- Sample Products with prices (from your rate list + more)
INSERT INTO products (category_id, name, slug, description, price, price_note, is_featured, sort_order) VALUES
-- Printing
(1, 'A4 Black & White Printing', 'a4-bw-printing', 'High quality A4 B/W printing per page', 10.00, 'Per page', 1, 1),
(1, 'A4 Color Printing', 'a4-color-printing', 'Vibrant A4 color printing per page', 20.00, 'Per page', 1, 2),
(1, 'A3 Black & White Printing', 'a3-bw-printing', 'A3 size B/W printing', 25.00, 'Per page', 0, 3),
(1, 'A3 Color Printing', 'a3-color-printing', 'A3 size color printing', 40.00, 'Per page', 0, 4),
(1, 'A4 B/W Photocopy', 'a4-bw-photocopy', 'Fast A4 black & white photocopy', 6.00, 'Per page', 1, 5),
(1, 'Document Printing (PDF/Word/Excel)', 'document-printing', 'Print your PDF, Word or Excel files', NULL, 'Depends on pages & color', 0, 6),
(1, 'Bulk Printing / Photocopy', 'bulk-printing', 'Large quantity printing with discount', NULL, 'Contact for bulk rates', 0, 7),

-- Photo
(2, 'Passport Size Photos (9 pcs)', 'passport-photos', 'Standard passport size photos with blue/white background', 100.00, '9 pieces', 1, 1),
(2, 'A4 Glossy Photo Print', 'a4-glossy-photo', 'High quality A4 glossy photo print', 50.00, 'Per print', 1, 2),
(2, 'A3 Glossy Photo Print', 'a3-glossy-photo', 'Large A3 glossy photo print', 80.00, 'Per print', 0, 3),
(2, '4×6 Photos (10 pcs)', '4x6-photos', 'Standard 4×6 photo prints', 150.00, '10 pieces', 1, 4),
(2, '5×7 Photos (10 pcs)', '5x7-photos', '5×7 size photo prints', 200.00, '10 pieces', 0, 5),
(2, 'Photo Background Removal', 'photo-bg-removal', 'Professional background removal & enhancement', NULL, 'Per photo', 0, 6),
(2, 'ID Card Size Photos', 'id-card-photos', 'Photos for ID cards and badges', NULL, 'Contact', 0, 7),

-- Customized Gifts
(3, 'Customized Photo Mug', 'custom-photo-mug', 'Personalized photo coffee mug', NULL, 'Design + quantity based', 1, 1),
(3, 'Customized Cushion', 'custom-cushion', 'Photo cushion / personalized pillow', NULL, 'Size & design based', 1, 2),
(3, 'Customized T-Shirt', 'custom-tshirt', 'Unisex cotton T-shirt with photo/text print', NULL, 'Size & quantity based', 1, 3),
(3, 'Customized Keychain', 'custom-keychain', 'Laser cut / engraved keyring', NULL, 'Design based', 0, 4),
(3, 'Name Engraving Pen', 'engraved-pen', 'Personalized metal pen with name/logo', NULL, 'Per piece', 0, 5),
(3, 'Customized Water Bottle', 'custom-water-bottle', 'Insulated personalized water bottle', NULL, 'Design based', 0, 6),
(3, 'Customized Gift Combo', 'gift-combo', 'Custom gift packages for events', NULL, 'Contact for package', 0, 7),
(3, 'Personalized Photo Frame 5×7', 'photo-frame-5x7', 'Custom photo frame', 350.00, '5×7 size', 1, 8),
(3, 'Photo Frame 8×12', 'photo-frame-8x12', 'Medium photo frame', 500.00, '8×12 size', 0, 9),
(3, 'Photo Frame 12×16', 'photo-frame-12x16', 'Large photo frame', 1000.00, '12×16 size', 0, 10),

-- Awards
(4, 'Glass Award Shield', 'glass-shield', 'Premium glass award shield', NULL, 'Size & design based', 1, 1),
(4, 'Wooden Award Shield', 'wooden-shield', 'Classic wooden appreciation shield', NULL, 'Size based', 0, 2),
(4, 'Metal Award Shield', 'metal-shield', 'Durable metal award shield', NULL, 'Size based', 0, 3),
(4, 'Certificate of Achievement', 'certificate-achievement', 'Professionally designed certificate', NULL, 'Quantity based', 1, 4),
(4, 'Certificate of Appreciation', 'certificate-appreciation', 'Custom appreciation certificate', NULL, 'Quantity based', 0, 5),
(4, 'School / College Awards', 'school-awards', 'Academic and sports awards', NULL, 'Contact', 0, 6),

-- Visiting Cards
(5, 'Visiting Cards (1000 pcs)', 'visiting-cards-1000', 'Premium quality visiting cards', 1600.00, '1000 pieces', 1, 1),
(5, 'Business Card Designing', 'business-card-design', 'Professional visiting card design', NULL, 'One-time design fee', 0, 2),
(5, 'Letterheads', 'letterheads', 'Company letterhead printing', NULL, 'Quantity based', 0, 3),
(5, 'A5 Invoice / Bill Printing', 'invoice-printing', 'Professional invoice and bill books', NULL, 'Quantity based', 0, 4),
(5, 'Company File Folders', 'file-folders', 'Custom company file folders', 50.00, 'Per folder', 0, 5),
(5, 'Stick File', 'stick-file', 'Standard stick file', 40.00, 'Per piece', 0, 6),
(5, 'Clip File', 'clip-file', 'Clip file for documents', 180.00, 'Per piece', 0, 7),
(5, 'PVC Card / Student ID', 'pvc-card', 'PVC ID cards and badges', 150.00, 'Per card', 1, 8),
(5, 'Customized Badge', 'custom-badge', 'Name / school / company badge', 99.00, 'Per badge', 1, 9),

-- Flex & Banners
(6, 'Flex / Panaflex Printing', 'flex-printing', 'High quality outdoor flex printing', NULL, 'Per sq ft', 1, 1),
(6, 'Advertising Banner', 'advertising-banner', 'Custom advertising banners', NULL, 'Size based', 1, 2),
(6, 'Roll-up Standee', 'rollup-standee', 'Portable roll-up banner standee', NULL, 'Standard size', 0, 3),
(6, 'Shop Signboard Designing', 'signboard', 'Indoor / outdoor shop signboards', NULL, 'Size & material based', 0, 4),
(6, 'Product Stickers', 'product-stickers', 'Custom product labels and stickers', NULL, 'Quantity based', 0, 5),
(6, 'Sticker Cutting (Plotter)', 'sticker-cutting', 'Vinyl sticker cutting service', NULL, 'Per design', 0, 6),
(6, 'Event Welcome Board', 'welcome-board', 'Welcome boards for events', NULL, 'Size based', 0, 7),

-- Graphic Designing
(7, 'Logo Designing', 'logo-design', 'Professional logo design', NULL, 'Package based', 1, 1),
(7, 'Visiting Card Designing', 'visiting-card-design', 'Creative visiting card design', NULL, 'One-time', 0, 2),
(7, 'Poster & Flyer Designing', 'poster-design', 'Event and promotional posters', NULL, 'Per design', 1, 3),
(7, 'Social Media Post Designing', 'social-media-design', 'Instagram, Facebook, TikTok posts', NULL, 'Per post / package', 1, 4),
(7, 'CV / Resume Designing', 'cv-design', 'Professional CV and resume design', NULL, 'Per CV', 0, 5),
(7, 'Photo Editing & Restoration', 'photo-editing', 'Advanced photo editing and recovery', NULL, 'Per photo', 0, 6),
(7, 'Video Editing', 'video-editing', 'Promotional and event video editing', NULL, 'Duration based', 0, 7),
(7, 'Urdu & English Typing', 'typing-service', 'Professional document typing', NULL, 'Per page', 0, 8),

-- Binding
(8, 'Spiral Binding', 'spiral-binding', 'Spiral binding for reports and theses', NULL, 'Depends on pages', 1, 1),
(8, 'Thesis Binding', 'thesis-binding', 'Hard cover thesis binding', NULL, 'Depends on pages', 1, 2),
(8, 'Hard Lamination', 'hard-lamination', 'Hard plastic lamination', NULL, 'Per sheet', 0, 3),
(8, 'Soft Lamination', 'soft-lamination', 'Soft lamination service', NULL, 'Per sheet', 0, 4),
(8, 'School Copies & Diaries', 'school-copies', 'Custom school copies and diaries', NULL, 'Quantity based', 0, 5),
(8, 'Notebooks', 'notebooks', 'Custom notebooks', NULL, 'Quantity based', 0, 6),

-- School
(9, 'School Examination Papers', 'exam-papers', 'Printing of school exam papers', NULL, 'Quantity based', 0, 1),
(9, 'Student ID / PVC Cards', 'student-id-card', 'School student PVC ID cards', 150.00, 'Per card', 1, 2),
(9, 'School Certificates', 'school-certificates', 'Academic and attendance certificates', NULL, 'Quantity based', 0, 3),
(9, 'Result Cards Designing', 'result-cards', 'Custom result cards', NULL, 'Design + print', 0, 4),
(9, 'School Event Posters', 'school-posters', 'Posters for school functions', NULL, 'Size based', 0, 5),
(9, 'Annual Function Banners', 'annual-function-banner', 'Large banners for annual day', NULL, 'Size based', 0, 6),

-- Wedding
(10, 'Nikah Ceremony Poster', 'nikah-poster', 'Beautiful Nikah ceremony posters', NULL, 'Size based', 1, 1),
(10, 'Barat Ceremony Poster', 'barat-poster', 'Elegant Barat posters', NULL, 'Size based', 1, 2),
(10, 'Valima Ceremony Poster', 'valima-poster', 'Valima event posters', NULL, 'Size based', 0, 3),
(10, 'Mayoon & Mehndi Poster', 'mehndi-poster', 'Mayoon and Mehndi ceremony designs', NULL, 'Size based', 0, 4),
(10, 'Wedding Invitation Cards', 'wedding-invitation', 'Custom wedding invitation card design & print', NULL, 'Quantity based', 1, 5),
(10, 'Nikah Signing Board', 'nikah-board', 'Nikah signing board', NULL, 'Size based', 0, 6),
(10, 'Event Welcome Board', 'event-welcome-board', 'Welcome boards for wedding events', NULL, 'Size based', 0, 7),
(10, 'Birthday / Anniversary Poster', 'birthday-poster', 'Custom birthday and anniversary posters', NULL, 'Size based', 0, 8);

-- Shop Settings (optional)
CREATE TABLE settings (
    setting_key VARCHAR(50) PRIMARY KEY,
    setting_value TEXT
);

INSERT INTO settings (setting_key, setting_value) VALUES
('shop_name', '07 Printers'),
('owner1', 'M. Anas Mughal'),
('owner2', 'Hussain Faisal'),
('phone1', '0312-1223711'),
('phone2', '0347-0777597'),
('whatsapp1', '923121223711'),
('whatsapp2', '923470777597'),
('address', 'Block 3-D, No. 39, Nazimabad No. 03, Near Abbasi Shaheed Hospital, Opposite HOPES Diagnostics / Laboratory, Karachi'),
('email', 'info@07printers.com'),
('easypaisa_number', '0312-1223711'),
('jazzcash_number', '0347-0777597'),
('bank_name', 'HBL / Meezan / JazzCash Bank'),
('bank_account_title', '07 Printers / M. Anas Mughal'),
('bank_account_number', 'Please contact for account details');