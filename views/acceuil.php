<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'includes/languages.php';

if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'fr';
}

// Récupérer la langue depuis la session
$lang = $_SESSION['lang'];
?>

<!DOCTYPE html>
<html lang="<?php echo htmlspecialchars($lang); ?>" dir="<?php echo $lang === 'ar' ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIR LKHIR - <?php echo $translations[$lang]['help_platform']; ?></title>

    <link href="assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet"> <!-- lien importe la police Tajawal depuis Google Fonts-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <section class="hero" style="background-image: url('assets/images/lastbg.png'); color: white; padding: 100px 0; position: relative;">
        <div class="container">
            <div class="hero-content text-center">
            <h1 class="display-1 fw-bold text-center "> <?php echo $translations[$lang]['help_platform']; ?></h1>

                <div class="hero-circle text-center mx-auto">
                    <?php echo $translations[$lang]['hero_description_1']; ?>
                </div>
                <h4 class="text-danger mt-4"><?php echo $translations[$lang]['hero_subtitle']; ?></h4>

                <p class="mt-3">
                    <strong><?php echo $translations[$lang]['together']; ?></strong>, <?php echo $translations[$lang]['hero_description_2']; ?><br>
                    <?php echo $translations[$lang]['hero_description_3']; ?>
                </p>

                <div class="hero-buttons mt-4" >
                    <a href="index.php?controller=aid&action=besoinAide" class="btn btn-danger" id="handhover">
                        <?php echo $translations[$lang]['need_help']; ?>
                    </a>
                    <a href="index.php?controller=aid&action=envieAider" class="btn btn-outline-light">
                        <?php echo $translations[$lang]['help_others']; ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" >
        <div class="container p-5">
            <div class="section-header">
                <h1 class="fw-bold"><?php echo $translations[$lang]['how_it_works']; ?></h1>
                <p><?php echo $translations[$lang]['how_it_works_subtitle']; ?></p>
            </div>
            <div class="features-grid ">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-comment-medical"></i>
                    </div>
                    <h3><?php echo $translations[$lang]['feature_1_title']; ?></h3>
                    <p><?php echo $translations[$lang]['feature_1_desc']; ?></p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3><?php echo $translations[$lang]['feature_2_title']; ?></h3>
                    <p><?php echo $translations[$lang]['feature_2_desc']; ?></p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-hands-helping"></i>
                    </div>
                    <h3><?php echo $translations[$lang]['feature_3_title']; ?></h3>
                    <p><?php echo $translations[$lang]['feature_3_desc']; ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- Impact Section -->
    <section class="impact" >
        <div class="container p-3">
            <div class="impact-content">
                <div class="impact-text">
                    <h2><?php echo $translations[$lang]['our_impact']; ?></h2>
                    <p><?php echo $translations[$lang]['impact_description']; ?></p>
                </div>
                <div class="impact-stats">
                    <div class="stat-item">
                        <span class="stat-number" data-target="1000">0</span><span>+</span>
                        <span class="stat-label"><?php echo $translations[$lang]['people_helped']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="500">0</span><span>+</span>
                        <span class="stat-label"><?php echo $translations[$lang]['active_volunteers']; ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number" data-target="98">0</span><span>%</span>
                        <span class="stat-label"><?php echo $translations[$lang]['satisfaction_rate']; ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section py-5">
        <div class="container">
            <h2 class="text-center mb-4 faq-title"><?php echo $translations[$lang]['faq_title']; ?></h2>
            <p class="text-center mb-5 faq-subtitle"><?php echo $translations[$lang]['faq_subtitle']; ?></p>
            <div class="accordion" id="faqAccordion">
                <!-- FAQ Item 1 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <?php echo $translations[$lang]['faq_q1']; ?>
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?php echo $translations[$lang]['faq_a1']; ?>
                        </div>
                    </div>
                </div>
                <!-- FAQ Item 2 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            <?php echo $translations[$lang]['faq_q2']; ?>
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?php echo $translations[$lang]['faq_a2']; ?>
                        </div>
                    </div>
                </div>
                <!-- FAQ Item 3 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            <?php echo $translations[$lang]['faq_q3' ]; ?>
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?php echo $translations[$lang]['faq_a3']; ?>
                        </div>
                    </div>
                </div>
                <!-- FAQ Item 4 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            <?php echo $translations[$lang]['faq_q4']; ?>
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?php echo $translations[$lang]['faq_a4']; ?>
                        </div>
                    </div>
                </div>
                <!-- FAQ Item 5 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            <?php echo $translations[$lang]['faq_q5']; ?>
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?php echo $translations[$lang]['faq_a5']; ?>
                        </div>
                    </div>
                </div>
                <!-- FAQ Item 6 -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            <?php echo $translations[$lang]['faq_q6']; ?>
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#faqAccordion">
                        <div class="accordion-body">
                            <?php echo $translations[$lang]['faq_a6']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <div class="cta-text">
                    <h2 class="cta-title"><?php echo $translations[$lang]['ready_to_join']; ?></h2>
                    <p class="cta-description"><?php echo $translations[$lang]['cta_description']; ?></p>
                </div>
                <div class="cta-buttons">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="index.php?controller=user&action=dashboard" class="btn btn-cta-primary">
                            <?php echo $translations[$lang]['my_account']; ?>
                        </a>
                    <?php else: ?>
                        <a href="index.php?controller=auth&action=register" class="btn btn-cta-primary">
                            <?php echo $translations[$lang]['register']; ?>
                        </a>
                        <a href="index.php?controller=auth&action=login" class="btn btn-cta-secondary">
                            <?php echo $translations[$lang]['login']; ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <script src="/assets/css/bootstrap/js/bootstrap.bundle.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stats = document.querySelectorAll('.stat-number');
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const target = parseInt(entry.target.getAttribute('data-target'));
                    const duration = 4000; 
                    const step = target / (duration / 16); 
                    let current = 0;
                    
                    const updateCount = () => {
                        current += step;
                        if (current < target) {
                            entry.target.textContent = Math.floor(current);
                            requestAnimationFrame(updateCount);
                        } else {
                            entry.target.textContent = target;
                        }
                    };
                    
                    updateCount();
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });
        
        stats.forEach(stat => observer.observe(stat));
    });
    </script>

 
</body>
</html> 