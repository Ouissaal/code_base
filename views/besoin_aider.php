<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inclure l'autoloader de PHPMailer si besoin
require_once __DIR__ . '/../PHPMailer/src/Exception.php';
require_once __DIR__ . '/../PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['type'] ?? '') === 'consultation') {
    $fullName = $_POST['full_name'] ?? '';
    $userEmail = $_POST['email'] ?? '';
    $adminEmail = 'bouamar.ouissal10@gmail.com'; // Email destinataire (admin)

    $message = "Nouvelle demande de consultation de $fullName\nEmail: $userEmail\n";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'bouamar.ouissal10@gmail.com';
        $mail->Password = 'xaew cxox wgea ovzf'; // Mot de passe d'application
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('bouamar.ouissal10@gmail.com', 'Mon Site');
        $mail->addAddress($adminEmail); // Envoyer à l'admin
        if ($userEmail) {
            $mail->addReplyTo($userEmail, $fullName);
        }
        $mail->Subject = 'Demande de consultation';
        $mail->Body    = $message;
        $mail->send();
        
    } catch (Exception $e) {
        
        // $mailError = $mail->ErrorInfo;
    }
}
?>

<?php require 'views/includes/header.php'; ?>

<script src="https://js.puter.com/v2/"></script>

<?php if (!isset($pending_consultation)) $pending_consultation = null; ?>

<div class="container my-5">
    <h1 class="text-center fw-bold  mb-5"><?php echo $translations[$lang]['need_help_title']; ?></h1>
    <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>

    <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row justify-content-center">
    <!-- Medicine Card -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="request-card" data-bs-toggle="modal" data-bs-target="#medicamentModal">
            <div class="request-card-icon-wrapper" style="--icon-bg: #e3f2fd; --icon-color: #2196f3;">
                <i class="fas fa-pills"></i>
            </div>
            <h3 class="request-card-title"><?php echo $translations[$lang]['medicines']; ?></h3>
            <p class="request-card-action"><?php echo $translations[$lang]['request_medicines']; ?> &rarr;</p>
        </div>
    </div>

    <!-- Blood Donation Card -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="request-card" data-bs-toggle="modal" data-bs-target="#sangModal">
            <div class="request-card-icon-wrapper" style="--icon-bg: #ffebee; --icon-color: #d32f2f;">
                <i class="fas fa-vial"></i>
            </div>
            <h3 class="request-card-title"><?php echo $translations[$lang]['blood_donation']; ?></h3>
            <p class="request-card-action"><?php echo $translations[$lang]['request_blood']; ?> &rarr;</p>
        </div>
    </div>

    <!-- Consultation Card -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="request-card" data-bs-toggle="modal" data-bs-target="#consultationModal">
            <div class="request-card-icon-wrapper" style="--icon-bg: #e8f5e9; --icon-color: #4caf50;">
                <i class="fas fa-user-md"></i>
            </div>
            <h3 class="request-card-title"><?php echo $translations[$lang]['consultation']; ?></h3>
            <p class="request-card-action"><?php echo $translations[$lang]['request_consultation']; ?> &rarr;</p>
        </div>
    </div>

    <!-- Transport Card -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="request-card" data-bs-toggle="modal" data-bs-target="#transportModal">
            <div class="request-card-icon-wrapper" style="--icon-bg: #e3f2fd; --icon-color: #1976d2;">
                <i class="fas fa-shuttle-van"></i>
            </div>
            <h3 class="request-card-title"><?php echo $translations[$lang]['need_transport_title']; ?></h3>
            <p class="request-card-action"><?php echo $translations[$lang]['request_transport']; ?> &rarr;</p>
        </div>
    </div>

    <!-- Financial Help Card -->
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="request-card" data-bs-toggle="modal" data-bs-target="#financialHelpModal">
            <div class="request-card-icon-wrapper" style="--icon-bg: #fff3e0; --icon-color: #ff9800;">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <h3 class="request-card-title"><?php echo $translations[$lang]['need_financial_help_title']; ?></h3>
            <p class="request-card-action"><?php echo $translations[$lang]['send_financial_help_request']; ?> &rarr;</p>
        </div>
    </div>
</div>>
        </div>
    </div>
    </div>
</div>

<!-- Médicaments -->
<div class="modal fade" id="medicamentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['login_required_title']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $translations[$lang]['login_required_medicament']; ?></p>
                    <div class="d-grid gap-2">
                        <a href="index.php?action=login" class="btn btn-primary"><?php echo $translations[$lang]['login']; ?></a>
                        <a href="index.php?action=register" class="btn btn-secondary"><?php echo $translations[$lang]['register']; ?></a>
                    </div>
                </div>
            <?php else: ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['medicine_request']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <?php csrf_input_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="medicament">
                        
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['full_name']; ?> *</label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['medication_name']; ?> *</label>
                            <input type="text" class="form-control" name="medication_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['required_quantity']; ?> *</label>
                            <input type="number" class="form-control" name="quantity" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['urgency']; ?> *</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="urgency" id="urgencyNormal" value="normal" checked>
                                    <label class="form-check-label" for="urgencyNormal"><?php echo $translations[$lang]['normal']; ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="urgency" id="urgencyUrgent" value="urgence">
                                    <label class="form-check-label" for="urgencyUrgent"><?php echo $translations[$lang]['urgent']; ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="urgency" id="urgencyVeryUrgent" value="tres_urgence">
                                    <label class="form-check-label" for="urgencyVeryUrgent"><?php echo $translations[$lang]['very_urgent']; ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['city']; ?> *</label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['phone']; ?> *</label>
                            <input type="tel" class="form-control" name="telephone" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['email']; ?> *</label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" required>
                            <small class="form-text text-muted"><?php echo $translations[$lang]['email_help']; ?></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['desired_date']; ?> *</label>
                            <input type="date" class="form-control" name="date_souhaitee" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['need_description']; ?></label>
                            <textarea class="form-control" name="description" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['prescription_upload']; ?> *</label>
                            <input type="file" class="form-control" name="prescription" accept=".pdf,.jpg,.jpeg,.png" required>
                            <small class="form-text text-muted"><?php echo $translations[$lang]['prescription_upload_help']; ?></small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['send_request']; ?></button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>


<!-- Sang -->
<div class="modal fade" id="sangModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['login_required_title']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $translations[$lang]['login_required_sang_besoin']; ?></p>
                    <div class="d-grid gap-2">
                        <a href="index.php?action=login" class="btn btn-primary"><?php echo $translations[$lang]['login']; ?></a>
                        <a href="index.php?action=register" class="btn btn-secondary"><?php echo $translations[$lang]['register']; ?></a>
                    </div>
                </div>
            <?php else: ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['blood_request']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <?php csrf_input_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="sang">
                        
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['full_name']; ?></label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>


                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['blood_group']; ?></label>
                            <select class="form-select" name="blood_group" required>
                                <option value="A+"><?php echo $translations[$lang]['blood_type_a_pos']; ?></option>
                                <option value="A-"><?php echo $translations[$lang]['blood_type_a_neg']; ?></option>
                                <option value="B+"><?php echo $translations[$lang]['blood_type_b_pos']; ?></option>
                                <option value="B-"><?php echo $translations[$lang]['blood_type_b_neg']; ?></option>
                                <option value="AB+"><?php echo $translations[$lang]['blood_type_ab_pos']; ?></option>
                                <option value="AB-"><?php echo $translations[$lang]['blood_type_ab_neg']; ?></option>
                                <option value="O+"><?php echo $translations[$lang]['blood_type_o_pos']; ?></option>
                                <option value="O-"><?php echo $translations[$lang]['blood_type_o_neg']; ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['hospital']; ?></label>
                            <input type="text" class="form-control" name="hospital" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['city']; ?></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['needed_date']; ?></label>
                            <input type="date" class="form-control" name="needed_date" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['preferred_time']; ?></label>
                            <input type="time" class="form-control" name="preferred_time">
                            <small class="form-text text-muted"><?php echo $translations[$lang]['preferred_time_help']; ?></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['phone']; ?></label>
                            <input type="tel" class="form-control" name="telephone" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['email']; ?></label>
                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($_SESSION['user_email'] ?? '') ?>" required>
                            <small class="form-text text-muted"><?php echo $translations[$lang]['email_help']; ?></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['urgency']; ?></label>
                            <select class="form-select" name="urgency" required>
                                <option value="normal"><?php echo $translations[$lang]['normal']; ?></option>
                                <option value="urgent"><?php echo $translations[$lang]['urgent']; ?></option>
                                <option value="very_urgent"><?php echo $translations[$lang]['very_urgent']; ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['need_description']; ?></label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                        <button type="submit" class="btn btn-danger"><?php echo $translations[$lang]['send_request']; ?></button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Consultation -->
<div class="modal fade" id="consultationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $translations[$lang]['consultation_request']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="apiResponse" class="alert alert-info mt-3 text-center" style="display: none;"></div>
                <form method="POST" enctype="multipart/form-data" id="consultationForm">
                    <?php csrf_input_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="consultation">
                        
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['full_name']; ?></label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['cin']; ?></label>
                            <input type="text" class="form-control" name="cin" required>
                            <small class="form-text text-muted"><?php echo $translations[$lang]['cin_help']; ?></small>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_child" id="isChild">
                                <label class="form-check-label" for="isChild">
                                    <?php echo $translations[$lang]['is_child']; ?>
                                </label>
                            </div>
                        </div>

                        <div id="parentInfo" class="mb-3" style="display: none;">
                            <label class="form-label"><?php echo $translations[$lang]['parent_name']; ?></label>
                            <input type="text" class="form-control" name="parent_name">
                            <small class="form-text text-muted"><?php echo $translations[$lang]['parent_name_help']; ?></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['gender']; ?></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderF" value="F" required>
                                    <label class="form-check-label" for="genderF">F</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="genderM" value="M" required>
                                    <label class="form-check-label" for="genderM">M</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['birth_date']; ?></label>
                            <input type="date" class="form-control" name="birth_date" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['medical_specialty']; ?></label>
                            <select class="form-select" name="specialty" required>
                                <option value="general_medicine"><?php echo $translations[$lang]['general_medicine']; ?></option>
                                <option value="pediatrics"><?php echo $translations[$lang]['pediatrics']; ?></option>
                                <option value="dermatology"><?php echo $translations[$lang]['dermatology']; ?></option>
                                <option value="cardiology"><?php echo $translations[$lang]['cardiology']; ?></option>
                                <option value="neurology"><?php echo $translations[$lang]['neurology']; ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['city']; ?></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['phone']; ?></label>
                            <input type="tel" class="form-control" name="telephone" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['consultation_type']; ?></label>
                            <select class="form-select" name="consultation_type" required>
                                <option value="in_person"><?php echo $translations[$lang]['in_person']; ?></option>
                                <option value="teleconsultation"><?php echo $translations[$lang]['teleconsultation']; ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['desired_date']; ?></label>
                            <input type="date" class="form-control" name="desired_date" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['urgency']; ?></label>
                            <select class="form-select" name="urgency" required>
                                <option value="normal"><?php echo $translations[$lang]['normal']; ?></option>
                                <option value="urgent"><?php echo $translations[$lang]['urgent']; ?></option>
                                <option value="very_urgent"><?php echo $translations[$lang]['very_urgent']; ?></option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['medical_document']; ?></label>
                            <input type="file" class="form-control" name="document_medical" accept=".pdf,.jpg,.jpeg,.png">
                            <small class="form-text text-muted"><?php echo $translations[$lang]['medical_document_help']; ?></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['availability']; ?></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="availability[]" value="morning">
                                    <label class="form-check-label"><?php echo $translations[$lang]['morning']; ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="availability[]" value="afternoon">
                                    <label class="form-check-label"><?php echo $translations[$lang]['afternoon']; ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="availability[]" value="evening">
                                    <label class="form-check-label"><?php echo $translations[$lang]['evening']; ?></label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label"> <?php echo $translations[$lang]['need_description']; ?></label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                        <button type="submit" class="btn btn-success"><?php echo $translations[$lang]['send_request']; ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Transport Modal -->
<div class="modal fade" id="transportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['login_required_title']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $translations[$lang]['login_required_transport']; ?></p>
                    <div class="d-grid gap-2">
                        <a href="index.php?action=login" class="btn btn-primary"><?php echo $translations[$lang]['login']; ?></a>
                        <a href="index.php?action=register" class="btn btn-secondary"><?php echo $translations[$lang]['register']; ?></a>
                    </div>
                </div>
            <?php else: ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['need_transport_title']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <?php csrf_input_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="transport">
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['full_name']; ?></label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['city']; ?></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['phone']; ?></label>
                            <input type="tel" class="form-control" name="telephone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['need_description']; ?></label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['send_request']; ?></button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Financial Help Modal -->
<div class="modal fade" id="financialHelpModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['login_required_title']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $translations[$lang]['login_required_financial']; ?></p>
                    <div class="d-grid gap-2">
                        <a href="index.php?action=login" class="btn btn-primary"><?php echo $translations[$lang]['login']; ?></a>
                        <a href="index.php?action=register" class="btn btn-secondary"><?php echo $translations[$lang]['register']; ?></a>
                    </div>
                </div>
            <?php else: ?>
                <div class="modal-header">
                    <h5 class="modal-title"><?php echo $translations[$lang]['need_financial_help_title']; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST">
                    <?php csrf_input_field(); ?>
                    <div class="modal-body">
                        <input type="hidden" name="type" value="financial">
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['full_name']; ?></label>
                            <input type="text" class="form-control" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['city']; ?></label>
                            <input type="text" class="form-control" name="ville" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['phone']; ?></label>
                            <input type="tel" class="form-control" name="telephone" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['describe_your_situation']; ?></label>
                            <textarea class="form-control" name="description" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                        <button type="submit" class="btn btn-success"><?php echo $translations[$lang]['send_financial_help_request']; ?></button>
                    </div>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Testimonials Section -->
<section class="testimonials py-5">
    <div class="container">
        <h2 class="text-center mb-4"><?php echo $translations[$lang]['testimonials_title']; ?></h2>
        <p class="text-center mb-5"><?php echo $translations[$lang]['testimonials_subtitle']; ?></p>
        
        <div class="row">
            <!-- Medication Testimonials -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-pills"></i>
                        <?php echo $translations[$lang]['category_medication']; ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['testimonial_1']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['author_1']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['location_1']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultation Testimonial -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-stethoscope"></i>
                        <?php echo $translations[$lang]['category_consultation']; ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['testimonial_2']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['author_2']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['location_2']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Donation Testimonial -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-heartbeat"></i>
                        <?php echo $translations[$lang]['category_blood']; ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['testimonial_3']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['author_3']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['location_3']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Medication Testimonial 2 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-pills"></i>
                        <?php echo $translations[$lang]['category_medication']; ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['testimonial_4']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['author_4']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['location_4']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Consultation Testimonial 2 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-stethoscope"></i>
                        <?php echo $translations[$lang]['category_consultation']; ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['testimonial_5']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['author_5']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['location_5']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Donation Testimonial 2 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-heartbeat"></i>
                        <?php echo $translations[$lang]['category_blood']; ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['testimonial_6']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['author_6']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['location_6']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
    <!--  if he is a child then show input to enter the name of his parent or guardian-->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const isChildCheckbox = document.getElementById('isChild');
    const parentInfo = document.getElementById('parentInfo');

    if(isChildCheckbox) {
        isChildCheckbox.addEventListener('change', function () {
            parentInfo.style.display = this.checked ? 'block' : 'none';
        });
    }

    // Handle consultation form submission
    const consultationForm = document.getElementById('consultationForm');
    if(consultationForm) {
        consultationForm.addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent normal submission

            const form = event.target;
            const formData = new FormData(form);

            // Show loading message
            const apiResponse = document.getElementById("apiResponse");
            apiResponse.style.display = "block";
            apiResponse.className = "alert alert-info mt-3";
            apiResponse.innerText = "Envoi de votre demande...";

            // Submit to current page (since form action is not set)
            fetch(window.location.href, {
                method: "POST",
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error("Erreur réseau");
                return response.text();
            })
            .then(data => {
                // Call Puter.ai API for thank you message
                if (typeof puter !== 'undefined' && puter.ai) {
                    puter.ai.chat(consultationThankYou)
                        .then(res => {
                            apiResponse.className = "alert alert-success mt-3";
                            apiResponse.innerText = res;
                        })
                        .catch(err => {
                            apiResponse.className = "alert alert-success mt-3";
                            apiResponse.innerText = consultationThankYou;
                        });
                } else {
                    apiResponse.className = "alert alert-success mt-3";
                    apiResponse.innerText = consultationThankYou;
                }
                
                // Reset form after successful submission
                setTimeout(() => {
                    form.reset();
                    parentInfo.style.display = 'none';
                    const modal = bootstrap.Modal.getInstance(document.getElementById('consultationModal'));
                    if (modal) modal.hide();
                }, 2500);
            })
            .catch(err => {
                apiResponse.className = "alert alert-danger mt-3";
                apiResponse.innerText = "Une erreur s'est produite : " + err.message;
            });
        });
    }
});
</script>

<script>
const consultationThankYou = <?php echo json_encode($translations[$lang]['consultation_thank_you']); ?>;
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html> 