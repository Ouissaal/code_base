<?php
require_once 'models/db.php';

class AidRequest {
    public static function create($data, $files = []) {
        global $pdo;
        $type = $data['type'] ?? '';
        try {
            $user_id = $_SESSION['user_id'] ?? null;
            if (!$user_id) return 'Utilisateur non connecté.';
            if ($type === 'don') {
                // Handle profile image upload
                $photo_path = 'assets/images/default-avatar.svg';
                if (!empty($files['profile_image']) && $files['profile_image']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/profiles/';
                    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
                    $ext = strtolower(pathinfo($files['profile_image']['name'], PATHINFO_EXTENSION));
                    $allowed = ['jpg','jpeg','png'];
                    if (!in_array($ext, $allowed)) return 'Type de fichier non autorisé.';
                    $file_name = uniqid() . '.' . $ext;
                    $file_path = $upload_dir . $file_name;
                    if (!move_uploaded_file($files['profile_image']['tmp_name'], $file_path)) return 'Erreur lors de l\'upload.';
                    $photo_path = $file_path;
                }
                $stmt = $pdo->prepare("INSERT INTO don_financier (utilisateur_id, type_donateur, message, mode_paiement, numero_carte, date_expiration, code_securite, anonymat, nom_complet, photo_profil, ville, telephone, email) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $user_id,
                    $data['donor_type'],
                    $data['message'],
                    $data['payment_method'],
                    $data['card_number'] ?? null,
                    $data['expiry_date'] ?? null,
                    $data['cvc'] ?? null,
                    $data['anonymity'],
                    $data['full_name'] ?? null,
                    $photo_path,
                    $data['ville'],
                    $data['telephone'],
                    $data['email']
                ]);
                return true;
            } elseif ($type === 'transport') {
                // Handle file uploads
                $certificat_path = null;
                $carte_identite_path = null;
                if (!empty($files['certificat_medical']) && $files['certificat_medical']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/certificats/';
                    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
                    $ext = strtolower(pathinfo($files['certificat_medical']['name'], PATHINFO_EXTENSION));
                    $allowed = ['pdf','jpg','jpeg','png'];
                    if (!in_array($ext, $allowed)) return 'Type de fichier non autorisé.';
                    $file_name = uniqid() . '.' . $ext;
                    $file_path = $upload_dir . $file_name;
                    if (!move_uploaded_file($files['certificat_medical']['tmp_name'], $file_path)) return 'Erreur lors de l\'upload.';
                    $certificat_path = $file_path;
                }
                if (!empty($files['carte_identite']) && $files['carte_identite']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/identites/';
                    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
                    $ext = strtolower(pathinfo($files['carte_identite']['name'], PATHINFO_EXTENSION));
                    $allowed = ['pdf','jpg','jpeg','png'];
                    if (!in_array($ext, $allowed)) return 'Type de fichier non autorisé.';
                    $file_name = uniqid() . '.' . $ext;
                    $file_path = $upload_dir . $file_name;
                    if (!move_uploaded_file($files['carte_identite']['tmp_name'], $file_path)) return 'Erreur lors de l\'upload.';
                    $carte_identite_path = $file_path;
                }
                $stmt = $pdo->prepare("INSERT INTO transport (utilisateur_id, marque_vehicule, modele_vehicule, nombre_places, type_disponibilite, date_disponible, heure_debut, heure_fin, ville, telephone, certificat_medical, carte_identite) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $user_id,
                    $data['marque_vehicule'],
                    $data['modele_vehicule'],
                    $data['nombre_places'],
                    $data['type_disponibilite'],
                    $data['date_disponible'],
                    $data['heure_debut'],
                    $data['heure_fin'],
                    $data['ville'],
                    $data['telephone'],
                    $certificat_path,
                    $carte_identite_path
                ]);
                return true;
            } elseif ($type === 'sang') {
                // For envie_aider: don_sang
                if (isset($data['relation'])) { // envie_aider
                    $stmt = $pdo->prepare("INSERT INTO don_sang (utilisateur_id, groupe_sanguin, relation, date_derniere_don, centre_prefere, disponibilite, ville, telephone) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->execute([
                        $user_id,
                        $data['blood_group'],
                        $data['relation'],
                        $data['last_donation_date'] ?? null,
                        $data['preferred_center'] ?? null,
                        $data['availability'] ?? null,
                        $data['ville'],
                        $data['telephone']
                    ]);
                } else { // besoin_aide
                    $stmt = $pdo->prepare("INSERT INTO besoin_sang (utilisateur_id, groupe_sanguin, hopital, ville, date_necessaire, heure_souhaitee, telephone, email, description_besoin, nom_complet, urgence, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->execute([
                        $user_id,
                        $data['blood_group'],
                        $data['hospital'],
                        $data['ville'],
                        $data['needed_date'],
                        $data['preferred_time'] ?? null,
                        $data['telephone'],
                        $data['email'],
                        $data['description'],
                        $data['full_name'],
                        $data['urgency']
                    ]);
                }
                return true;
            } elseif ($type === 'medicament') {
                // Handle ordonnance upload
                $ordonnance_path = null;
                if (!empty($files['prescription']) && $files['prescription']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/prescriptions/';
                    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
                    $ext = strtolower(pathinfo($files['prescription']['name'], PATHINFO_EXTENSION));
                    $allowed = ['pdf','jpg','jpeg','png'];
                    if (!in_array($ext, $allowed)) return 'Type de fichier non autorisé.';
                    $file_name = uniqid() . '.' . $ext;
                    $file_path = $upload_dir . $file_name;
                    if (!move_uploaded_file($files['prescription']['tmp_name'], $file_path)) return 'Erreur lors de l\'upload.';
                    $ordonnance_path = $file_path;
                }
                $stmt = $pdo->prepare("INSERT INTO medicament (utilisateur_id, nom_medicament, quantite, urgence, ville, telephone, date_souhaitee, ordonnance_medicale, description_besoin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $user_id,
                    $data['medication_name'],
                    $data['quantity'],
                    $data['urgency'],
                    $data['ville'],
                    $data['telephone'],
                    $data['date_souhaitee'],
                    $ordonnance_path,
                    $data['description'] ?? null
                ]);
                return true;
            } elseif ($type === 'consultation') {
                // Handle document_medical upload
                $document_medical = null;
                if (!empty($files['document_medical']) && $files['document_medical']['error'] === UPLOAD_ERR_OK) {
                    $upload_dir = 'uploads/documents_medicaux/';
                    if (!file_exists($upload_dir)) mkdir($upload_dir, 0777, true);
                    $ext = strtolower(pathinfo($files['document_medical']['name'], PATHINFO_EXTENSION));
                    $file_path = $upload_dir . uniqid() . '.' . $ext;
                    if (!move_uploaded_file($files['document_medical']['tmp_name'], $file_path)) return 'Erreur lors de l\'upload.';
                    $document_medical = $file_path;
                }
                $stmt = $pdo->prepare("INSERT INTO consultation (utilisateur_id, nom_complet, numero_cin, est_enfant, nom_parent_tuteur, sexe, date_naissance, specialite_medicale, ville, telephone, type_consultation, date_souhaitee, urgence, document_medical, disponibilite_matin, disponibilite_apres_midi, disponibilite_soir, description_besoin, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                $stmt->execute([
                    $user_id,
                    $data['full_name'],
                    $data['cin'],
                    isset($data['is_child']) ? 1 : 0,
                    $data['parent_name'] ?? null,
                    $data['gender'],
                    $data['birth_date'],
                    $data['specialty'],
                    $data['ville'],
                    $data['telephone'],
                    $data['consultation_type'],
                    $data['desired_date'],
                    $data['urgency'],
                    $document_medical,
                    (isset($data['availability']) && in_array('morning', $data['availability'])) ? 1 : 0,
                    (isset($data['availability']) && in_array('afternoon', $data['availability'])) ? 1 : 0,
                    (isset($data['availability']) && in_array('evening', $data['availability'])) ? 1 : 0,
                    $data['description'] ?? null
                ]);
                return true;
            }
            return 'Type de demande inconnu.';
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }



    public static function getAllMedicaments() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM medicament ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllSang() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM besoin_sang ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllConsultations() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM consultation ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllTransports() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM transport ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getAllDonFinancier() {
        global $pdo;
        $stmt = $pdo->query('SELECT * FROM don_financier ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
