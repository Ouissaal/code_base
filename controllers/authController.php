<?php
require_once 'models/db.php';
require_once 'models/User.php';

class AuthController {
    
    public function acceuil() {
        require 'views/acceuil.php';
    }
    
    public function blog() {
        require 'views/blog.php';
    }

    public function login() {
        global $translations, $lang;
        require_once 'views/includes/languages.php';
        $error = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $error = 'Invalid CSRF token.';
            } else {
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                
                $user = User::findByEmail($email);
                
                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] === 'admin') {
                        header('Location: index.php?controller=admin&action=dashboard');
                    } else {
                        header('Location: index.php?controller=user&action=dashboard');
                    }
                    exit;
                } else {
                    $error = isset($translations[$lang]['invalid_credentials']) 
                           ? $translations[$lang]['invalid_credentials'] 
                           : 'Invalid email or password.';
                }
            }
        }
        require 'views/login.php';
    }

    public function register() {
        global $pdo, $translations, $lang;
        $error = '';
        $success = '';
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
                $error = 'Invalid CSRF token.';
            } else {
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
                $password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];
                
                // Validation
                if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
                    $error = isset($translations[$lang]['all_fields_required']) ? 
                             $translations[$lang]['all_fields_required'] : 
                             'All fields are required';
                } elseif ($password !== $confirm_password) {
                    $error = isset($translations[$lang]['passwords_not_match']) ? 
                             $translations[$lang]['passwords_not_match'] : 
                             'Passwords do not match';
                } elseif (strlen($password) < 8) {
                    $error = isset($translations[$lang]['password_too_short']) ? 
                             $translations[$lang]['password_too_short'] : 
                             'Password must be at least 8 characters long';
                } else {
                    try {
                        // Check if email exists
                        $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE email = ?");
                        $stmt->execute([$email]);
                        
                        if ($stmt->fetchColumn() > 0) {
                            $error = isset($translations[$lang]['email_already_exists']) ? 
                                     $translations[$lang]['email_already_exists'] : 
                                     'Email already exists';
                        } else {
                            // Check if username exists
                            $stmt = $pdo->prepare("SELECT COUNT(*) FROM utilisateur WHERE username = ?");
                            $stmt->execute([$username]);
                            
                            if ($stmt->fetchColumn() > 0) {
                                $error = isset($translations[$lang]['username_already_exists']) ? 
                                         $translations[$lang]['username_already_exists'] : 
                                         'Username already exists';
                            } else {
                                // Create new user
                                $stmt = $pdo->prepare("INSERT INTO utilisateur (username, email, password) VALUES (?, ?, ?)");
                                $stmt->execute([
                                    $username,
                                    $email,
                                    password_hash($password, PASSWORD_DEFAULT)
                                ]);
                                
                                $user_id = $pdo->lastInsertId();
                                
                                $_SESSION['user_id'] = $user_id;
                                $_SESSION['username'] = $username;
                                $_SESSION['email'] = $email;
                                
                                $success = isset($translations[$lang]['registration_success']) ? 
                                           $translations[$lang]['registration_success'] : 
                                           'Registration successful! Redirecting to home...';
                                
                                 header('Location: index.php');
                                 exit;
                            }
                        }
                    } catch(PDOException $e) {
                        $error = isset($translations[$lang]['registration_error']) ? 
                                 $translations[$lang]['registration_error'] : 
                                 'Registration error occurred. Please try again.';
                        // Optional: Log the actual error for debugging
                        error_log("Registration error: " . $e->getMessage());
                    }
                }
            }
        }
        
        require 'views/inscription.php';
    }

    public function logout() {
        session_start();
        session_destroy();
        header('Location: index.php?controller=auth&action=login');
        exit;
    }
}
?>