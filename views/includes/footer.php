<?php
require_once 'languages.php';
$currentYear = date('Y');
?>

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <h3><?php echo $translations[$lang]['help_platform']; ?></h3>
                <img src="assets/images/DL_logo.png" alt="DIR LKHIR Logo" class="img-fluid" width="100px;">
            </div>

            <div class="footer-links">
                <div class="footer-section">
                    <h4><?php echo $translations[$lang]['quick_links']; ?></h4>
                    <ul>
                        <li><a href="index.php"><?php echo $translations[$lang]['home']; ?></a></li>
                        <li><a  href="index.php?controller=auth&action=blog"><?php echo $translations[$lang]['blog']; ?></a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h4><?php echo $translations[$lang]['connect_with_us']; ?></h4>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo $currentYear; ?> DIR LKHIR. <?php echo $translations[$lang]['all_rights_reserved']; ?></p>
        </div>
    </div>
</footer>



<script src="assets/css/bootstrap/js/bootstrap.bundle.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
