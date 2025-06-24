<?php
require_once 'models/AidRequest.php';
require_once 'models/BesoinAide.php';
require_once 'models/db.php';
require_once 'models/EmailService.php';

class AidController {

// Cette fonction vérifie si tous les champs obligatoires sont remplis.
    private function validateRequired($fields, $data) {
        $missing = [];
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $missing[] = $field;
            }
        }
        return $missing;
    }

    public function envieAider() {   
        $error = '';
        $success = '';
        $emailService = new EmailService();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $error = 'Invalid CSRF token.';
            } else {
                $type = $_POST['type'] ?? '';
                if ($type === 'don') {
                    $required = ['donor_type', 'message', 'payment_method', 'anonymity', 'ville', 'telephone', 'email'];
                    $missing = $this->validateRequired($required, $_POST);
                    if ($missing) {
                        $error = 'Veuillez remplir tous les champs obligatoires.';
                    } else {
                        $result = AidRequest::create($_POST, $_FILES);
                        if ($result === true) {
                            $success = 'Offre enregistrée avec succès!';
                            $emailService->sendOfferNotification([
                                'email' => $_POST['email'],
                                'full_name' => $_POST['full_name'] ?? '',
                            ], 'Don financier');
                        } else {
                            $error = $result;
                        }
                    }
                } elseif ($type === 'transport') {
                    $required = ['marque_vehicule', 'modele_vehicule', 'nombre_places', 'type_disponibilite', 'date_disponible', 'heure_debut', 'heure_fin', 'ville', 'telephone'];
                    $missing = $this->validateRequired($required, $_POST);
                    if ($missing) {
                        $error = 'Veuillez remplir tous les champs obligatoires.';
                    } else {
                        $result = AidRequest::create($_POST, $_FILES);
                        if ($result === true) {
                            $success = 'Offre de transport enregistrée!';
                            $emailService->sendOfferNotification([
                                'email' => $_POST['email'] ?? '',
                                'full_name' => $_POST['full_name'] ?? '',
                            ], 'Transport');
                        } else {
                            $error = $result;
                        }
                    }
                } elseif ($type === 'sang') {
                    $required = ['blood_group', 'relation', 'ville', 'telephone'];
                    $missing = $this->validateRequired($required, $_POST);
                    if ($missing) {
                        $error = 'Veuillez remplir tous les champs obligatoires.';
                    } else {
                        $result = AidRequest::create($_POST, $_FILES);
                        if ($result === true) {
                            $success = 'Offre de don de sang enregistrée!';
                            $emailService->sendOfferNotification([
                                'email' => $_POST['email'] ?? '',
                                'full_name' => $_POST['full_name'] ?? '',
                            ], 'Don de sang');
                        } else {
                            $error = $result;
                        }
                    }
                }
            }
        }
        require 'views/envie_aider.php';
    }

        public function besoinAide() {
            global $pdo; 
            $error = '';
            $success = '';
            $besoinAide = new BesoinAide($pdo);
            $emailService = new EmailService();
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                    $error = 'Invalid CSRF token.';
                } else {
                    $type = $_POST['type'] ?? '';
                    if ($type === 'medicament') {
                        $required = ['medication_name', 'quantity', 'urgency', 'ville', 'telephone', 'date_souhaitee', 'email', 'full_name'];
                        $missing = $this->validateRequired($required, $_POST);
                        if ($missing) {
                            $error = 'Veuillez remplir tous les champs obligatoires.';
                        } else {
                            $result = AidRequest::create($_POST, $_FILES);
                            if ($result === true) {
                                $success = 'Demande de médicament enregistrée!';
                                $emailService->sendMedicamentRequest([
                                    'email' => $_POST['email'],
                                    'full_name' => $_POST['full_name'],
                                    'medication_name' => $_POST['medication_name'],
                                    'quantity' => $_POST['quantity'],
                                    'urgency' => $_POST['urgency'],
                                    'ville' => $_POST['ville'],
                                    'telephone' => $_POST['telephone'],
                                    'date_souhaitee' => $_POST['date_souhaitee']
                                ]);
                            } else {
                                $error = $result;
                            }
                        }
                    } elseif ($type === 'sang') {
                        $required = ['full_name', 'blood_group', 'hospital', 'ville', 'needed_date', 'telephone', 'email', 'urgency', 'description'];
                        $missing = $this->validateRequired($required, $_POST);
                        if ($missing) {
                            $error = 'Veuillez remplir tous les champs obligatoires.';
                        } else {
                            $result = AidRequest::create($_POST, $_FILES);
                            if ($result === true) {
                                $success = 'Demande de sang enregistrée!';
                                $emailService->sendBloodRequest([
                                    'email' => $_POST['email'],
                                    'full_name' => $_POST['full_name'],
                                    'blood_group' => $_POST['blood_group'],
                                    'hospital' => $_POST['hospital'],
                                    'ville' => $_POST['ville'],
                                    'needed_date' => $_POST['needed_date'],
                                    'urgency' => $_POST['urgency']
                                ]);
                            } else {
                                $error = $result;
                            }
                        }
                    } elseif ($type === 'consultation') {
                        $required = ['full_name', 'cin', 'gender', 'birth_date', 'specialty', 'ville', 'telephone', 'consultation_type', 'desired_date', 'urgency', 'email'];
                        $missing = $this->validateRequired($required, $_POST);
                        if ($missing) {
                            $error = 'Veuillez remplir tous les champs obligatoires.';
                        } else {
                            $result = AidRequest::create($_POST, $_FILES);
                            if ($result === true) {
                                $success = 'Demande de consultation enregistrée!';
                                $emailService->sendConsultationRequest([
                                    'email' => $_POST['email'],
                                    'full_name' => $_POST['full_name'],
                                    'specialty' => $_POST['specialty'],
                                    'consultation_type' => $_POST['consultation_type'],
                                    'urgency' => $_POST['urgency'],
                                    'ville' => $_POST['ville'],
                                    'desired_date' => $_POST['desired_date'],
                                    'consultation_number' => uniqid('CONS-')
                                ]);
                            } else {
                                $error = $result;
                            }
                        }
                    } elseif ($type === 'transport') {
                        $required = ['full_name', 'ville', 'telephone', 'description', 'email'];
                        $missing = $this->validateRequired($required, $_POST);
                        if ($missing) {
                            $error = 'Veuillez remplir tous les champs obligatoires.';
                        } else {
                            $data = [
                                'utilisateur_id' => $_SESSION['user_id'],
                                'full_name' => trim($_POST['full_name']),
                                'ville' => trim($_POST['ville']),
                                'telephone' => trim($_POST['telephone']),
                                'description' => trim($_POST['description'])
                            ];
                            $result = $besoinAide->createBesoinTransport($data);
                            if ($result) {
                                $success = 'Demande de transport enregistrée!';
                                $emailService->sendOfferNotification([
                                    'email' => $_POST['email'],
                                    'full_name' => $_POST['full_name']
                                ], 'Transport');
                            } else {
                                $error = 'Erreur lors de l\'enregistrement de la demande de transport.';
                            }
                        }
                    } elseif ($type === 'financial') {
                        $required = ['full_name', 'ville', 'telephone', 'description', 'email'];
                        $missing = $this->validateRequired($required, $_POST);
                        if ($missing) {
                            $error = 'Veuillez remplir tous les champs obligatoires.';
                        } else {
                            $data = [
                                'utilisateur_id' => $_SESSION['user_id'],
                                'full_name' => trim($_POST['full_name']),
                                'ville' => trim($_POST['ville']),
                                'telephone' => trim($_POST['telephone']),
                                'description' => trim($_POST['description'])
                            ];
                            $result = $besoinAide->createBesoinFinancier($data);
                            if ($result) {
                                $success = 'Demande d\'aide financière enregistrée!';
                                $emailService->sendOfferNotification([
                                    'email' => $_POST['email'],
                                    'full_name' => $_POST['full_name']
                                ], 'Aide financière');
                            } else {
                                $error = 'Erreur lors de l\'enregistrement de la demande d\'aide financière.';
                            }
                        }
                    }
                }
            }
            require 'views/besoin_aider.php';
        }



}
