<?php
// If there is no active session, start a new session.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['lang'])) {
    $_SESSION['lang'] = $_GET['lang'];
}
if (!isset($_SESSION['lang'])) {
    $_SESSION['lang'] = 'fr';
}
$lang = $_SESSION['lang'];
require_once 'languages.php';

if (!isset($translations[$lang])) {
    $lang = 'fr';
}

// We use a CSRF token to prevent unauthorized commands from being transmitted from a user that the web application trusts, protecting against CSRF attacks.
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

function csrf_input_field() {
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($_SESSION['csrf_token']) . '">';
    // Affiche un champ <input> caché dans le formulaire
}
?>
<!DOCTYPE html>
<html lang="<?php echo $lang; ?>" dir="<?php echo ($lang === 'ar') ? 'rtl' : 'ltr'; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DIR LKHIR - <?php echo $translations[$lang]['help_platform']; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="assets/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                 <img src="assets/images/DL_logo.png" alt="DIR LKHIR Logo" class="img-fluid" width="60px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link " href="index.php?controller=auth&action=acceuil"><?php echo $translations[$lang]['home']; ?></a>
                    </li>
                   
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=aid&action=besoinAide"><?php echo $translations[$lang]['need_help']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=aid&action=envieAider"><?php echo $translations[$lang]['want_to_help']; ?></a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="index.php?controller=auth&action=blog"><?php  echo $translations[$lang]['blog']; ?></a>
                    </li>

                </ul>
                <ul class="navbar-nav">
                    
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user"></i> <?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="index.php?controller=user&action=dashboard"><?php  echo $translations[$lang]['my_account']; ?></a></li>
                                <li><a class="dropdown-item" href="index.php?controller=user&action=editProfile"><?php echo $translations[$lang]['edit_profile']; ?></a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item bg-danger" href="index.php?controller=auth&action=logout"><?php echo $translations[$lang]['logout']; ?></a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=auth&action=login"><?php echo $translations[$lang]['login'];?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?controller=auth&action=register"><?php echo $translations[$lang]['register']; ?></a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item dropdown language-selector">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <?php
                            $currentLang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'fr';
                            $langNames = [
                                'fr' => 'Français',
                                'ar' => 'العربية',
                                'en' => 'English'
                            ];
                            echo $langNames[$currentLang];
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="?lang=fr">Français</a></li>
                            <li><a class="dropdown-item" href="?lang=ar">العربية</a></li>
                            <li><a class="dropdown-item" href="?lang=en">English</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
<script src="/assets/css/bootstrap/js/bootstrap.bundle.js"></script>

</body>
</html> 