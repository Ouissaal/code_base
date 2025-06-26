<?php
require_once 'includes/header.php';
require_once __DIR__ . '/../models/db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}


$total_offres = $total_offres ?? 0;
$total_demandes = $total_demandes ?? 0;
$dernieres_demandes = $dernieres_demandes ?? [];
$dernieres_offres = $dernieres_offres ?? [];

?>

<style>
body, #dashboard-container {
    background:rgb(31, 32, 33) !important;
    color: #f8f9fa !important;
}
.nav-tabs .nav-link {
    font-size: 1.2rem;
    border-radius: 2rem 2rem 0 0;
    padding: 0.75rem 2rem;
    margin: 0 0.25rem;
    transition: background 0.2s, color 0.2s;
    color:rgb(217, 216, 186);
    background: #232b3e;
    border: none;
    letter-spacing: 0.5px;
}
.nav-tabs .nav-link.active {
    background: linear-gradient(90deg, #ff416c 0%, #ff4b2b 100%);
    color: #fff !important;
    border: none;
    box-shadow: 0 4px 16px 0 rgba(255, 65, 108, 0.15);
}
.nav-tabs {
    border-bottom: none;
}
.card, .list-group-item {
    background: #232b3e !important;
    color: #f8f9fa !important;
    border-color: #2c3550 !important;
}
.card .card-title, .card .display-5, .list-group-item {
    color: #fff !important;
}
.btn-outline-primary, .btn-outline-success {
    color: #fff;
    border-color:rgb(217, 216, 186);
}
.btn-outline-primary:hover, .btn-outline-success:hover {
    background:rgb(217, 216, 186);
    color: rgb(217, 216, 186) ;
}
.card-body i, .card-title i {
    color: rgb(217, 216, 186) !important;
}
.list-group-item .text-muted {
    color: #fff !important;
}
</style>

<div class="container mt-4" id="dashboard-container">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card <?php echo ($total_offres >= 10) ? 'bg-warning' : 'bg-danger'; ?> text-white border-0">
                <div class="card-body text-center py-5">
                    <h1 class="display-4 mb-3">
                        <?php echo $translations[$lang]['bon_retour']; ?>, <?php echo htmlspecialchars($_SESSION['username']); ?>
                        <?php if ($total_offres >= 10): ?>
                            <span class="ms-2 text-light" title="Vous êtes un héros de la solidarité !">
                                <i class="fas fa-crown text-white" style="font-size: 1.2rem;"></i>
                            </span>
                        <?php endif; ?>
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <ul class="nav nav-tabs justify-content-center mb-4" id="helpTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="need-help-tab" data-bs-toggle="tab" data-bs-target="#need-help" type="button" role="tab">
            <?php echo $translations[$lang]['besoin_aide']; ?> 
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="want-help-tab" data-bs-toggle="tab" data-bs-target="#want-help" type="button" role="tab">
            <?php echo $translations[$lang]['envie_aide']; ?>
            </button>
        </li>
    </ul>

    <div class="tab-content" id="helpTabContent">
        <!-- Besoin d'aide -->
        <div class="tab-pane fade show active" id="need-help" role="tabpanel">
            <div class="row mb-4 g-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-handshake fa-3x mb-3"></i>
                            <h4 class="card-title"><?php echo $translations[$lang]['demande_aide']; ?></h4>
                            <div class="display-5 fw-bold"><?php echo $total_demandes; ?></div>
                            <div class="text-light small"><?php echo $translations[$lang]['totale_demande_aide']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Demandes récentes -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3 fw-bold"><i class="fas fa-history me-1"></i><?php echo $translations[$lang]['Demandes_récentes']; ?></h5>
                            <?php if (empty($dernieres_demandes)): ?>
                                <div class="text-light text-center py-3"><?php echo $translations[$lang]['Aucun_demande']; ?></div>
                            <?php else: ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($dernieres_demandes as $demande): ?>
                                        <li class="list-group-item d-flex align-items-center">
                                            <?php
                                            $icon_class = '';
                                            switch($demande['type']) {
                                                case 'medicament':
                                                    $icon_class = 'fas fa-pills text-warning';
                                                    break;
                                                case 'consultation':
                                                    $icon_class = 'fas fa-stethoscope text-primary';
                                                    break;
                                                case 'besoin_sang':
                                                    $icon_class = 'fas fa-tint text-danger';
                                                    break;
                                                case 'besoin_transport':
                                                    $icon_class = 'fas fa-shuttle-van text-info';
                                                    break;
                                                case 'besoin_financier':
                                                    $icon_class = 'fas fa-hand-holding-usd text-success';
                                                    break;
                                                default:
                                                    $icon_class = 'fas fa-question-circle text-secondary';
                                            }
                                            ?>
                                            <i class="<?php echo $icon_class; ?> me-2"></i>
                                            <span class="fw-semibold flex-grow-1"><?php echo htmlspecialchars($demande['titre']); ?></span>
                                            <span class="text-light small ms-2"><?php echo date('d/m/Y', strtotime($demande['date'])); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Je veux aider -->
        <div class="tab-pane fade" id="want-help" role="tabpanel">
            <div class="row mb-4 g-4">
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body text-center">
                            <i class="fas fa-hand-holding-heart fa-3x mb-3"></i>
                            <h4 class="card-title"><?php echo $translations[$lang]['offre_aide']; ?></h4>
                            <div class="display-5 fw-bold"><?php echo $total_offres; ?></div>
                            <div class="text-light small"><?php echo $translations[$lang]['dashboard_total_offres_description']; ?></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Offres récentes -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3 fw-bold"><i class="fas fa-hands-helping me-1"></i><?php echo $translations[$lang]['offre_récentes']; ?></h5>
                            <?php if (empty($dernieres_offres)): ?>
                                <div class="text-light text-center py-3"><?php echo $translations[$lang]['dashboard_no_recent_offer']; ?></div>
                            <?php else: ?>
                                <ul class="list-group list-group-flush">
                                    <?php foreach ($dernieres_offres as $offre): ?>
                                        <li class="list-group-item d-flex align-items-center">
                                            <?php
                                            switch($offre['type']) {
                                                case 'don_financier':
                                                    echo '<i class="fas fa-hand-holding-usd text-success me-2"></i>';
                                                    break;
                                                case 'transport':
                                                    echo '<i class="fas fa-car text-info me-2"></i>';
                                                    break;
                                                case 'don_sang':
                                                    echo '<i class="fas fa-tint text-danger me-2"></i>';
                                                    break;
                                            }
                                            ?>
                                            <span class="fw-semibold flex-grow-1"><?php echo htmlspecialchars($offre['titre']); ?></span>
                                            <span class="text-muted small ms-2"><?php echo date('d/m/Y', strtotime($offre['created_at'])); ?></span>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php require_once 'includes/footer.php'; ?> 