<?php require 'views/includes/header.php'; ?>

<div class="container my-5">
    <h1 class="text-center  fw-bold mb-5"><?php echo $translations[$lang]['want_to_help_title']; ?></h1>

    <?php if (!empty($success)): ?>
    <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
    <?php endif; ?>
    
    <?php if (!empty($error)): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="row justify-content-center p-5">
        <!-- Financial Donation Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="aid-card" data-bs-toggle="modal" data-bs-target="#donModal" style="--card-gradient: linear-gradient(135deg,rgb(216, 192, 144),rgba(119, 75, 75, 0.45));">
                <div class="aid-card-content">
                    <div class="aid-card-icon">
                        <i class="fas fa-hand-holding-usd"></i>
                    </div>
                    <h3 class="aid-card-title"><?php echo $translations[$lang]['financial_donation']; ?></h3>
                    <p class="aid-card-description"><?php echo $translations[$lang]['make_donation']; ?></p>
                </div>
            </div>
        </div>

        <!-- Blood Donation Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="aid-card" data-bs-toggle="modal" data-bs-target="#sangModal" style="--card-gradient: linear-gradient(135deg, #d63031, #e17055);">
                <div class="aid-card-content">
                    <div class="aid-card-icon">
                        <i class="fas fa-tint"></i>
                    </div>
                    <h3 class="aid-card-title"><?php echo $translations[$lang]['blood_donation']; ?></h3>
                    <p class="aid-card-description"><?php echo $translations[$lang]['donate_blood']; ?></p>
                </div>
            </div>
        </div>

        <!-- Transport Card -->
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="aid-card" data-bs-toggle="modal" data-bs-target="#transportModal" style="--card-gradient: linear-gradient(135deg, #00b09b, #96c93d);">
                <div class="aid-card-content">
                    <div class="aid-card-icon">
                        <i class="fas fa-car"></i>
                    </div>
                    <h3 class="aid-card-title"><?php echo $translations[$lang]['transport']; ?></h3>
                    <p class="aid-card-description"><?php echo $translations[$lang]['offer_transport']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!--  Don -->

<div class="modal fade" id="donModal" tabindex="-1">
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
                <h5 class="modal-title"><?php echo $translations[$lang]['financial_donation_title']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <?php csrf_input_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="type" value="don">
                    
                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['donor_type']; ?> *</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="donor_type" id="donorTypePerson" value="personne" checked>
                                <label class="form-check-label" for="donorTypePerson"><?php echo $translations[$lang]['person']; ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="donor_type" id="donorTypeOrganization" value="organisme">
                                <label class="form-check-label" for="donorTypeOrganization"><?php echo $translations[$lang]['organization']; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['message_amount']; ?> *</label>
                        <textarea class="form-control" name="message" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['payment_method']; ?> *</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_method" id="paymentCard" value="carte" checked>
                                <label class="form-check-label" for="paymentCard"><?php echo $translations[$lang]['card']; ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="payment_method" id="paymentPaypal" value="paypal">
                                <label class="form-check-label" for="paymentPaypal"><?php echo $translations[$lang]['paypal']; ?></label>
                            </div>
                        </div>
                    </div>

                    <div id="cardPaymentFields">
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['card_number']; ?></label>
                            <input type="text" class="form-control" name="card_number" pattern="[0-9]{16}" maxlength="16" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $translations[$lang]['expiry_date']; ?></label>
                                    <input type="text" class="form-control" name="expiry_date" pattern="(0[1-9]|1[0-2])\/([0-9]{2})" placeholder="MM/YY">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label"><?php echo $translations[$lang]['cvc']; ?></label>
                                    <input type="text" class="form-control" name="cvc" pattern="[0-9]{3,4}" maxlength="4" placeholder="123">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['anonymity']; ?> *</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="anonymity" id="anonymityPublic" value="don_public" checked>
                                <label class="form-check-label" for="anonymityPublic"><?php echo $translations[$lang]['public_donation']; ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="anonymity" id="anonymityAnonymous" value="don_anonyme">
                                <label class="form-check-label" for="anonymityAnonymous"><?php echo $translations[$lang]['anonymous_donation']; ?></label>
                            </div>
                        </div>
                    </div>

                    <div id="publicDonorFields">
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['full_name']; ?></label>
                            <input type="text" class="form-control" name="full_name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo $translations[$lang]['profile_image']; ?></label>
                            <input type="file" class="form-control" name="profile_image" accept="image/*">
                            <small class="form-text text-muted"><?php echo $translations[$lang]['profile_image_help']; ?></small>
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
                        <input type="email" class="form-control" name="email" required>
                        <small class="form-text text-muted"><?php echo $translations[$lang]['email_help']; ?></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo $translations[$lang]['send_offer']; ?></button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!--  Sang -->
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
                <h5 class="modal-title"><?php echo $translations[$lang]['blood_donation_title']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST">
                <?php csrf_input_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="type" value="sang">
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
                        <label class="form-label"><?php echo $translations[$lang]['relation']; ?></label>
                        <select class="form-select" name="relation" required>
                            <option value="family"><?php echo $translations[$lang]['relation_family']; ?></option>
                            <option value="friend"><?php echo $translations[$lang]['relation_friend']; ?></option>
                            <option value="other"><?php echo $translations[$lang]['relation_other']; ?></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['last_donation_date']; ?></label>
                        <input type="date" class="form-control" name="last_donation_date">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['preferred_donation_center']; ?></label>
                        <input type="text" class="form-control" name="preferred_center">
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['availability']; ?></label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="availability" id="availabilityImmediate" value="immediate" checked>
                                <label class="form-check-label" for="availabilityImmediate"><?php echo $translations[$lang]['immediate']; ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="availability" id="availabilityPlanned" value="planned">
                                <label class="form-check-label" for="availabilityPlanned"><?php echo $translations[$lang]['planned']; ?></label>
                            </div>
                        </div>
                    </div>
                   
                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['city']; ?></label>
                        <input type="text" class="form-control" name="ville" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['phone']; ?></label>
                        <input type="tel" class="form-control" name="telephone" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                    <button type="submit" class="btn btn-danger"><?php echo $translations[$lang]['send_offer']; ?></button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<!--  Transport -->
<div class="modal fade" id="transportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $translations[$lang]['transport_offer_title']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="modal-body">
                    <p><?php echo $translations[$lang]['login_required_sang_besoin']; ?></p>
                    <div class="d-grid gap-2">
                        <a href="index.php?action=login" class="btn btn-primary"><?php echo $translations[$lang]['login']; ?></a>
                        <a href="index.php?action=register" class="btn btn-secondary"><?php echo $translations[$lang]['register']; ?></a>
                    </div>
                </div>
            <?php else: ?>
            <form method="POST" enctype="multipart/form-data">
                <?php csrf_input_field(); ?>
                <div class="modal-body">
                    <input type="hidden" name="type" value="transport">
                    
                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['vehicle_brand']; ?> *</label>
                        <input type="text" class="form-control" name="marque_vehicule" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['vehicle_model']; ?> *</label>
                        <input type="text" class="form-control" name="modele_vehicule" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['number_of_seats']; ?> *</label>
                        <input type="number" class="form-control" name="nombre_places" min="1" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['availability_type']; ?> *</label>
                        <div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type_disponibilite" id="availabilityPunctual" value="ponctuel" checked>
                                <label class="form-check-label" for="availabilityPunctual"><?php echo $translations[$lang]['punctual']; ?></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type_disponibilite" id="availabilityRegular" value="regulier">
                                <label class="form-check-label" for="availabilityRegular"><?php echo $translations[$lang]['regular']; ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['available_date']; ?> *</label>
                        <input type="date" class="form-control" name="date_disponible" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?php echo $translations[$lang]['start_time']; ?> *</label>
                                <input type="time" class="form-control" name="heure_debut" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label"><?php echo $translations[$lang]['end_time']; ?> *</label>
                                <input type="time" class="form-control" name="heure_fin" required>
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
                        <label class="form-label"><?php echo $translations[$lang]['medical_certificate']; ?></label>
                        <input type="file" class="form-control" name="certificat_medical" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted"><?php echo $translations[$lang]['medical_certificate_help']; ?></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><?php echo $translations[$lang]['id_card']; ?></label>
                        <input type="file" class="form-control" name="carte_identite" accept=".pdf,.jpg,.jpeg,.png">
                        <small class="form-text text-muted"><?php echo $translations[$lang]['id_card_help']; ?></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo $translations[$lang]['close']; ?></button>
                    <button type="submit" class="btn btn-success"><?php echo $translations[$lang]['send_offer']; ?></button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>



<!-- Donor Testimonials Section -->
<section class="testimonials py-5">
    <div class="container">
        <h2 class="text-center mb-4"><?php echo $translations[$lang]['donor_testimonials_title']; ?></h2>
        <p class="text-center mb-5"><?php echo $translations[$lang]['donor_testimonials_subtitle']; ?></p>
        
        <div class="row">
            <!-- Donor Testimonial 1 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-hand-holding-heart"></i>
                        <?php echo sprintf($translations[$lang]['donation_amount'], $translations[$lang]['donation_1']); ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['donor_testimonial_1']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['donor_author_1']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['donor_location_1']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donor Testimonial 2 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-hand-holding-heart"></i>
                        <?php echo sprintf($translations[$lang]['donation_amount'], $translations[$lang]['donation_2']); ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['donor_testimonial_2']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user-secret"></i>
                            <?php echo $translations[$lang]['donor_author_2']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['donor_location_2']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donor Testimonial 3 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-hand-holding-heart"></i>
                        <?php echo sprintf($translations[$lang]['donation_amount'], $translations[$lang]['donation_3']); ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['donor_testimonial_3']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['donor_author_3']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['donor_location_3']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donor Testimonial 4 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-hand-holding-heart"></i>
                        <?php echo sprintf($translations[$lang]['donation_amount'], $translations[$lang]['donation_4']); ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['donor_testimonial_4']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user-secret"></i>
                            <?php echo $translations[$lang]['donor_author_4']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['donor_location_4']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donor Testimonial 5 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-hand-holding-heart"></i>
                        <?php echo sprintf($translations[$lang]['donation_amount'], $translations[$lang]['donation_5']); ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['donor_testimonial_5']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['donor_author_5']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['donor_location_5']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Donor Testimonial 6 -->
            <div class="col-md-4 mb-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-hand-holding-heart"></i>
                        <?php echo sprintf($translations[$lang]['donation_amount'], $translations[$lang]['donation_6']); ?>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['donor_testimonial_6']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user-secret"></i>
                            <?php echo $translations[$lang]['donor_author_6']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['donor_location_6']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blood Donor Testimonials Section -->
<section class="testimonials py-5">
    <div class="container">

        
        <div class="row g-4">
            <!-- Blood Donor 1 -->
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-tint"></i>
                        <span title="<?php echo $translations[$lang]['blood_donations_clarification']; ?>">
                            <?php echo sprintf($translations[$lang]['blood_donations_count'], $translations[$lang]['blood_donations_1']); ?>
                        </span>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['blood_donor_testimonial_1']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['blood_donor_author_1']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['blood_donor_location_1']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Donor 2 -->
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-tint"></i>
                        <span title="<?php echo $translations[$lang]['blood_donations_clarification']; ?>">
                            <?php echo sprintf($translations[$lang]['blood_donations_count'], $translations[$lang]['blood_donations_2']); ?>
                        </span>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['blood_donor_testimonial_2']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user-secret"></i>
                            <?php echo $translations[$lang]['blood_donor_author_2']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['blood_donor_location_2']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Donor 3 -->
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-tint"></i>
                        <span title="<?php echo $translations[$lang]['blood_donations_clarification']; ?>">
                            <?php echo sprintf($translations[$lang]['blood_donations_count'], $translations[$lang]['blood_donations_3']); ?>
                        </span>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['blood_donor_testimonial_3']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['blood_donor_author_3']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['blood_donor_location_3']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Donor 4 -->
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-tint"></i>
                        <span title="<?php echo $translations[$lang]['blood_donations_clarification']; ?>">
                            <?php echo sprintf($translations[$lang]['blood_donations_count'], $translations[$lang]['blood_donations_4']); ?>
                        </span>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['blood_donor_testimonial_4']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user-secret"></i>
                            <?php echo $translations[$lang]['blood_donor_author_4']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['blood_donor_location_4']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Donor 5 -->
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-tint"></i>
                        <span title="<?php echo $translations[$lang]['blood_donations_clarification']; ?>">
                            <?php echo sprintf($translations[$lang]['blood_donations_count'], $translations[$lang]['blood_donations_5']); ?>
                        </span>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['blood_donor_testimonial_5']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user"></i>
                            <?php echo $translations[$lang]['blood_donor_author_5']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['blood_donor_location_5']; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blood Donor 6 -->
            <div class="col-md-6 col-lg-4">
                <div class="testimonial-card">
                    <div class="testimonial-category">
                        <i class="fas fa-tint"></i>
                        <span title="<?php echo $translations[$lang]['blood_donations_clarification']; ?>">
                            <?php echo sprintf($translations[$lang]['blood_donations_count'], $translations[$lang]['blood_donations_6']); ?>
                        </span>
                    </div>
                    <div class="testimonial-content">
                        <p><?php echo $translations[$lang]['blood_donor_testimonial_6']; ?></p>
                    </div>
                    <div class="testimonial-footer">
                        <div class="testimonial-author">
                            <i class="fas fa-user-secret"></i>
                            <?php echo $translations[$lang]['blood_donor_author_6']; ?>
                        </div>
                        <div class="testimonial-location">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo $translations[$lang]['blood_donor_location_6']; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Affichage dynamique des champs selon le mode de paiement
function toggleCardFields() {
    const cardFields = document.getElementById('cardPaymentFields');
    const paymentCard = document.getElementById('paymentCard');
    if (paymentCard.checked) {
        cardFields.style.display = '';
    } else {
        cardFields.style.display = 'none';
    }
}

// Affichage dynamique des champs selon l'anonymat
function togglePublicDonorFields() {
    const publicFields = document.getElementById('publicDonorFields');
    const anonymityPublic = document.getElementById('anonymityPublic');
    if (anonymityPublic.checked) {
        publicFields.style.display = '';
    } else {
        publicFields.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialisation
    toggleCardFields();
    togglePublicDonorFields();
    // Écouteurs d'événements
    document.getElementById('paymentCard').addEventListener('change', toggleCardFields);
    document.getElementById('paymentPaypal').addEventListener('change', toggleCardFields);
    document.getElementById('anonymityPublic').addEventListener('change', togglePublicDonorFields);
    document.getElementById('anonymityAnonymous').addEventListener('change', togglePublicDonorFields);
});
</script>

<?php require 'views/includes/footer.php'; ?>
</body>
</html> 