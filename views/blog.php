<?php
require_once 'includes/header.php';
?>

<div class="container my-5">
   
    <div class="stories-section mb-5">
        <h1 class="text-center mb-5" style="color: rgb(83, 28, 28);">
            <i class="fas fa-book-reader me-2"></i>
            <?php echo $translations[$lang]['success_stories']; ?>
        </h1>
        
        <div class="row g-4">
            <!-- Ibrahim's Story Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow">
                    <img src="assets/images/ibrahim.jpg" class="card-img-top" alt="Ibrahim's story" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color: rgb(83, 28, 28);"><?php echo $translations[$lang]['ibrahim_story_title']; ?></h5>
                        <p class="card-text text-muted small mb-2"><?php echo $translations[$lang]['story_date']; ?>: 15/03/2025</p>
                        <p class="card-text flex-grow-1"><?php echo $translations[$lang]['ibrahim_story_content']; ?></p>
                        <blockquote class="blockquote mb-0 mt-3">
                            <p class="small"><em><i class="fas fa-quote-left me-2"></i><?php echo $translations[$lang]['ibrahim_story_conclusion']; ?></em></p>
                        </blockquote>
                    </div>
                </div>
            </div>

            <!-- Leila's Story Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow">
                    <img src="assets/images/leila_.jpg" class="card-img-top" alt="Leila's story" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color: rgb(83, 28, 28);"><?php echo $translations[$lang]['leila_story_title']; ?></h5>
                        <p class="card-text text-muted small mb-2"><?php echo $translations[$lang]['story_date']; ?>: 29/04/2025</p>
                        <p class="card-text flex-grow-1"><?php echo $translations[$lang]['leila_story_content']; ?></p>
                        <blockquote class="blockquote mb-0 mt-3">
                            <p class="small"><em><i class="fas fa-quote-left me-2"></i><?php echo $translations[$lang]['leila_story_conclusion']; ?></em></p>
                        </blockquote>
                    </div>
                </div>
            </div>

            <!-- Aicha's Story Card -->
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 shadow">
                    <img src="assets/images/aicha.jpg" class="card-img-top" alt="Aicha's story" style="height: 250px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title" style="color: rgb(83, 28, 28);"><?php echo $translations[$lang]['aicha_story_title']; ?></h5>
                        <p class="card-text text-muted small mb-2"><?php echo $translations[$lang]['story_date']; ?>: 09/10/2024</p>
                        <p class="card-text flex-grow-1"><?php echo $translations[$lang]['aicha_story_content']; ?></p>
                        <blockquote class="blockquote mb-0 mt-3">
                            <p class="small"><em><i class="fas fa-quote-left me-2"></i><?php echo $translations[$lang]['aicha_story_conclusion']; ?></em></p>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 p-5">
    <!-- Mini-formations solidaires -->
    <h2 class="mb-5 text-center "><?php echo $translations[$lang]['solidarity_tutorials']; ?></h2>
    <div class="row">
        <!-- Tutorial Card 1 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="tutorial-card" data-bs-toggle="modal" data-bs-target="#elderlyModal">
                <div class="tutorial-card-header" style="--card-color:rgb(83, 28, 28);">
                    <i class="fas fa-wheelchair"></i>
                </div>
                <div class="tutorial-card-body">
                    <h3 class="tutorial-card-title"><?php echo $translations[$lang]['help_elderly_title']; ?></h3>
                    <p class="tutorial-card-text"><?php echo $translations[$lang]['help_elderly_content']; ?></p>
                </div>
                <div class="tutorial-card-footer">
                    <span><?php echo $translations[$lang]['read_more']; ?> &rarr;</span>
                </div>
            </div>
        </div>

        <!-- Tutorial Card 2 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="tutorial-card" data-bs-toggle="modal" data-bs-target="#homelessModal">
                <div class="tutorial-card-header" style="--card-color:rgb(83, 28, 28);">
                    <i class="fas fa-home"></i>
                </div>
                <div class="tutorial-card-body">
                    <h3 class="tutorial-card-title"><?php echo $translations[$lang]['help_homeless_title']; ?></h3>
                    <p class="tutorial-card-text"><?php echo $translations[$lang]['help_homeless_content']; ?></p>
                </div>
                <div class="tutorial-card-footer">
                    <span><?php echo $translations[$lang]['read_more']; ?> &rarr;</span>
                </div>
            </div>
        </div>

        <!-- Tutorial Card 3 -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="tutorial-card" data-bs-toggle="modal" data-bs-target="#firstAidModal">
                <div class="tutorial-card-header" style="--card-color:rgb(83, 28, 28);">
                    <i class="fas fa-first-aid"></i>
                </div>
                <div class="tutorial-card-body">
                    <h3 class="tutorial-card-title"><?php echo $translations[$lang]['first_aid_title']; ?></h3>
                    <p class="tutorial-card-text"><?php echo $translations[$lang]['first_aid_content']; ?></p>
                </div>
                <div class="tutorial-card-footer">
                    <span><?php echo $translations[$lang]['read_more']; ?> &rarr;</span>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal pour Aider les personnes âgées -->
<div class="modal fade" id="elderlyModal" tabindex="-1" aria-labelledby="elderlyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="elderlyModalLabel"><?php echo $translations[$lang]['elderly_tips_title']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3"><?php echo $translations[$lang]['elderly_communication_title']; ?></h6>
                        <p><?php echo $translations[$lang]['elderly_communication_content']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-3"><?php echo $translations[$lang]['tips']; ?></h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?php echo $translations[$lang]['elderly_tip_1']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?php echo $translations[$lang]['elderly_tip_2']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?php echo $translations[$lang]['elderly_tip_3']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i><?php echo $translations[$lang]['elderly_tip_4']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Aider les sans-abri -->
<div class="modal fade" id="homelessModal" tabindex="-1" aria-labelledby="homelessModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="homelessModalLabel"><?php echo $translations[$lang]['homeless_essentials_title']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3"><?php echo $translations[$lang]['homeless_approach_title']; ?></h6>
                        <p><?php echo $translations[$lang]['homeless_approach_content']; ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-3"><?php echo $translations[$lang]['essentials']; ?></h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i><?php echo $translations[$lang]['homeless_essential_1']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i><?php echo $translations[$lang]['homeless_essential_2']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i><?php echo $translations[$lang]['homeless_essential_3']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-info me-2"></i><?php echo $translations[$lang]['homeless_essential_4']; ?></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal pour Premiers secours -->
<div class="modal fade" id="firstAidModal" tabindex="-1" aria-labelledby="firstAidModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="firstAidModalLabel"><?php echo $translations[$lang]['first_aid_basics_title']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-3"><?php echo $translations[$lang]['basics']; ?></h6>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i><?php echo $translations[$lang]['first_aid_basic_1']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i><?php echo $translations[$lang]['first_aid_basic_2']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i><?php echo $translations[$lang]['first_aid_basic_3']; ?></li>
                            <li class="mb-2"><i class="fas fa-check text-warning me-2"></i><?php echo $translations[$lang]['first_aid_basic_4']; ?></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="mb-3"><?php echo $translations[$lang]['emergency_numbers_title']; ?></h6>
                        <p class="text-danger fw-bold"><?php echo $translations[$lang]['emergency_numbers_content']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>

<?php require_once 'includes/footer.php';?>

