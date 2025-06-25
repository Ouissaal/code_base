<?php
require_once 'models/User.php';

class UserController {
    
    public function __construct() {
        // Check if user is logged in for protected actions
        if (!isset($_SESSION['user_id']) && 
            !in_array($_GET['action'] ?? '', ['login', 'register', 'acceuil'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    }
    
    public function dashboard() {
        global $translations, $lang, $pdo;
        
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
        $email = $_SESSION['email'];
        $error = '';
        $total_demandes = 0;
        $total_offres = 0;
        $dernieres_demandes = [];
        $dernieres_offres = [];
        
        try {
            // Nombre total de demandes d'aide
            $stmt = $pdo->prepare(" SELECT COUNT(*) as total_demandes 
                FROM (
                    SELECT id FROM medicament WHERE utilisateur_id = ?
                    UNION ALL
                    SELECT id FROM consultation WHERE utilisateur_id = ?
                    UNION ALL
                    SELECT id FROM besoin_sang WHERE utilisateur_id = ?
                ) as all_demandes
            ");
            $stmt->execute([$user_id, $user_id, $user_id]);
            $total_demandes = $stmt->fetch()['total_demandes'];

            // Nombre total d'offres d'aide
            $stmt = $pdo->prepare("SELECT COUNT(*) as total_offres 
                FROM (
                    SELECT id FROM don_financier WHERE utilisateur_id = ?
                    UNION ALL
                    SELECT id FROM transport WHERE utilisateur_id = ?
                    UNION ALL
                    SELECT id FROM don_sang WHERE utilisateur_id = ?
                ) as all_offres
            ");
            $stmt->execute([$user_id, $user_id, $user_id]);
            $total_offres = $stmt->fetch()['total_offres'];

            // Dernières demandes d'aide
            $stmt = $pdo->prepare(" (SELECT 'medicament' as type, nom_medicament as titre, date_souhaitee as date, urgence, created_at
                FROM medicament WHERE utilisateur_id = ?)
                UNION ALL
                (SELECT 'consultation' as type, specialite_medicale as titre, date_souhaitee as date, urgence, created_at
                FROM consultation WHERE utilisateur_id = ?)
                UNION ALL
                (SELECT 'besoin_sang' as type, groupe_sanguin as titre, date_necessaire as date, urgence, created_at
                FROM besoin_sang WHERE utilisateur_id = ?)
                ORDER BY created_at DESC LIMIT 5
            ");
            $stmt->execute([$user_id, $user_id, $user_id]);
            $dernieres_demandes = $stmt->fetchAll();

            // Dernières offres d'aide
            $stmt = $pdo->prepare("
                (SELECT 'don_financier' as type, type_donateur as titre, created_at
                FROM don_financier WHERE utilisateur_id = ?)
                UNION ALL
                (SELECT 'transport' as type, CONCAT(marque_vehicule, ' ', modele_vehicule) as titre, created_at
                FROM transport WHERE utilisateur_id = ?)
                UNION ALL
                (SELECT 'don_sang' as type, groupe_sanguin as titre, created_at
                FROM don_sang WHERE utilisateur_id = ?)
                ORDER BY created_at DESC LIMIT 5
            ");
            $stmt->execute([$user_id, $user_id, $user_id]);
            $dernieres_offres = $stmt->fetchAll();
        } catch(PDOException $e) {
            $error = $translations[$lang]['dashboard_error'];
        }

        require 'views/tableau_de_bord.php';
    }
    
    public function editProfile() {
        global $translations, $lang, $pdo;
    
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
    
        $user_id = $_SESSION['user_id'];
        $error = '';
        $success = '';
        $user = [];
    
        // Fetch current user info
        try {
            $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();
    
            // Vérification que l'utilisateur existe
            if (!$user) {
                $error = $translations[$lang]['user_not_found'] ?? 'Utilisateur introuvable.';
            }
        } catch (PDOException $e) {
            $error = $translations[$lang]['profile_error'] ?? 'Erreur lors de la récupération du profil.';
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($error)) {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
    
            if (empty($username) || empty($email)) {
                $error = $translations[$lang]['all_fields_required'] ?? 'Tous les champs sont requis.';
            } else {
                try {
                    // Check if username is already used by another user
                    $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE username = ? AND id != ?");
                    $stmt->execute([$username, $user_id]);
                    if ($stmt->fetchColumn() > 0) {
                        $error = $translations[$lang]['username_already_exists'] ?? 'Nom d\'utilisateur déjà utilisé.';
                    } else {
                        // Check if email is already used by another user
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ? AND id != ?");
                        $stmt->execute([$email, $user_id]);
                        if ($stmt->fetchColumn() > 0) {
                            $error = $translations[$lang]['email_already_exists'] ?? 'Email déjà utilisé.';
                        } else {
                            // Si un mot de passe actuel est fourni
                            if (!empty($current_password)) {
                                if (!$user || !isset($user['password'])) {
                                    $error = $translations[$lang]['user_not_found'] ?? 'Utilisateur introuvable.';
                                } elseif (!password_verify($current_password, $user['password'])) {
                                    $error = $translations[$lang]['current_password_incorrect'] ?? 'Mot de passe actuel incorrect.';
                                } elseif (empty($new_password) || empty($confirm_password)) {
                                    $error = $translations[$lang]['new_password_required'] ?? 'Nouveau mot de passe requis.';
                                } elseif ($new_password !== $confirm_password) {
                                    $error = $translations[$lang]['passwords_not_match'] ?? 'Les mots de passe ne correspondent pas.';
                                } elseif (strlen($new_password) < 8) {
                                    $error = $translations[$lang]['password_too_short'] ?? 'Le mot de passe est trop court.';
                                } else {
                                    // Mettre à jour avec nouveau mot de passe
                                    $stmt = $pdo->prepare("
                                        UPDATE utilisateur 
                                        SET username = ?, email = ?, password = ? 
                                        WHERE id = ?
                                    ");
                                    $stmt->execute([
                                        $username,
                                        $email,
                                        password_hash($new_password, PASSWORD_DEFAULT),
                                        $user_id
                                    ]);
                                    $success = $translations[$lang]['profile_updated'] ?? 'Profil mis à jour avec succès.';
                                }
                            } else {
                                // Mise à jour sans mot de passe
                                $stmt = $pdo->prepare("
                                    UPDATE utilisateur 
                                    SET username = ?, email = ? 
                                    WHERE id = ?
                                ");
                                $stmt->execute([
                                    $username,
                                    $email,
                                    $user_id
                                ]);
                                $success = $translations[$lang]['profile_updated'] ?? 'Profil mis à jour avec succès.';
                            }
    
                            // Mise à jour session et utilisateur si tout est OK
                            if (empty($error)) {
                                $_SESSION['username'] = $username;
                                $_SESSION['email'] = $email;
                                $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE id = ?");
                                $stmt->execute([$user_id]);
                                $user = $stmt->fetch();
                            }
                        }
                    }
                } catch (PDOException $e) {
                    $error = $translations[$lang]['update_error'] ?? 'Erreur lors de la mise à jour du profil.';
                }
            }
        }
    
        require 'views/modifier_profil.php';
    }
    
    
    public function changePassword() {
        global $translations, $lang;
        
        if (!isset($_SESSION['user_id'])) {
            header('Location: index.php?controller=auth&action=login');
            exit;
        }
        
        $user_id = $_SESSION['user_id'];
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'];
            $new_password = $_POST['new_password'];
            $confirm_password = $_POST['confirm_password'];
            
            if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
                $error = isset($translations[$lang]['all_fields_required']) ? 
                         $translations[$lang]['all_fields_required'] : 
                         'All fields are required';
            } elseif ($new_password !== $confirm_password) {
                $error = isset($translations[$lang]['passwords_not_match']) ? 
                         $translations[$lang]['passwords_not_match'] : 
                         'New passwords do not match';
            } elseif (strlen($new_password) < 8) {
                $error = isset($translations[$lang]['password_too_short']) ? 
                         $translations[$lang]['password_too_short'] : 
                         'Password must be at least 8 characters long';
            } else {
                try {
                    global $pdo;
                    
                    // Verify current password
                    $stmt = $pdo->prepare("SELECT password FROM utilisateur WHERE id = ?");
                    $stmt->execute([$user_id]);
                    $user = $stmt->fetch();
                    
                    if (!$user || !password_verify($current_password, $user['password'])) {
                        $error = isset($translations[$lang]['current_password_incorrect']) ? 
                                 $translations[$lang]['current_password_incorrect'] : 
                                 'Current password is incorrect';
                    } else {
                        // Update password
                        $stmt = $pdo->prepare("UPDATE utilisateur SET password = ? WHERE id = ?");
                        $stmt->execute([
                            password_hash($new_password, PASSWORD_DEFAULT),
                            $user_id
                        ]);
                        
                        $success = isset($translations[$lang]['password_updated']) ? 
                                   $translations[$lang]['password_updated'] : 
                                   'Password updated successfully';
                    }
                } catch(PDOException $e) {
                    $error = isset($translations[$lang]['update_error']) ? 
                             $translations[$lang]['update_error'] : 
                             'Error updating password. Please try again.';
                    error_log("Password update error: " . $e->getMessage());
                }
            }
        }
        
        require 'views/change_password.php';
    }
}
?>