<?php

try {
    $pdo = new PDO("mysql:host=localhost", "root", "");
    $pdo->exec("CREATE DATABASE IF NOT EXISTS dir_lkhir4");
    
    $pdo = new PDO("mysql:host=localhost;dbname=dir_lkhir4", "root", "");
    
    // Create tables
    $pdo->exec("
        -- 1. Table utilisateur
        CREATE TABLE IF NOT EXISTS utilisateur (
            id INT PRIMARY KEY AUTO_INCREMENT,
            username VARCHAR(50) UNIQUE NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(255) NOT NULL DEFAULT 'user',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        );

        --  médicament
        CREATE TABLE IF NOT EXISTS medicament (
            id INT PRIMARY KEY AUTO_INCREMENT,
            utilisateur_id INT NOT NULL,
            nom_medicament VARCHAR(200) NOT NULL,
            quantite VARCHAR(100) NOT NULL,
            urgence ENUM('normal', 'urgence', 'tres_urgence') NOT NULL,
            ville VARCHAR(100) NOT NULL,
            telephone VARCHAR(20) NOT NULL,
            date_souhaitee DATE NOT NULL,
            ordonnance_medicale VARCHAR(255),
            description_besoin TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );

        -- don_sang
        CREATE TABLE IF NOT EXISTS don_sang (
            id INT PRIMARY KEY AUTO_INCREMENT,
            utilisateur_id INT NOT NULL,
            groupe_sanguin ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
            relation VARCHAR(50) NOT NULL,
            hopital VARCHAR(200) NOT NULL,
            ville VARCHAR(100) NOT NULL,
            date_necessaire DATE NOT NULL,
            date_derniere_don DATE NOT NULL,
            heure_souhaitee TIME,
            telephone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            centre_prefere VARCHAR(255) DEFAULT NULL,
            description_besoin TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );

        -- consultation
        CREATE TABLE IF NOT EXISTS consultation (
            id INT PRIMARY KEY AUTO_INCREMENT,
            utilisateur_id INT NOT NULL,
            nom_complet VARCHAR(100) NOT NULL,
            numero_cin VARCHAR(20) NOT NULL,
            est_enfant BOOLEAN DEFAULT FALSE,
            nom_parent_tuteur VARCHAR(100),
            sexe ENUM('F', 'M') NOT NULL,
            date_naissance DATE NOT NULL,
            specialite_medicale ENUM('medecine_generale', 'pediatrie', 'dermatologie', 'cardiologie', 'neurologie') NOT NULL,
            ville VARCHAR(100) NOT NULL,
            telephone VARCHAR(20) NOT NULL,
            type_consultation ENUM('presentiel', 'teleconsultation') NOT NULL,
            date_souhaitee DATE NOT NULL,
            urgence ENUM('normale', 'urgente', 'tres_urgente') NOT NULL,
            statut ENUM('en_attente', 'confirme', 'annule') NOT NULL DEFAULT 'en_attente',
            document_medical VARCHAR(255),
            disponibilite_matin BOOLEAN DEFAULT FALSE,
            disponibilite_apres_midi BOOLEAN DEFAULT FALSE,
            disponibilite_soir BOOLEAN DEFAULT FALSE,
            description_besoin TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );

        -- don_financier
        CREATE TABLE IF NOT EXISTS don_financier (
            id INT PRIMARY KEY AUTO_INCREMENT,
            utilisateur_id INT NOT NULL,
            type_donateur ENUM('personne', 'organisme') NOT NULL,
            message TEXT,
            mode_paiement ENUM('carte', 'paypal') NOT NULL,
            numero_carte VARCHAR(20),
            date_expiration VARCHAR(7),
            code_securite VARCHAR(4),
            anonymat ENUM('don_public', 'don_anonyme') NOT NULL,
            nom_complet VARCHAR(100) NOT NULL,
            photo_profil VARCHAR(255),
            ville VARCHAR(100) NOT NULL,
            telephone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );

        -- transport
        CREATE TABLE IF NOT EXISTS transport (
            id INT PRIMARY KEY AUTO_INCREMENT,
            utilisateur_id INT NOT NULL,
            marque_vehicule VARCHAR(50) NOT NULL,
            modele_vehicule VARCHAR(50) NOT NULL,
            nombre_places INT NOT NULL,
            type_disponibilite ENUM('ponctuel', 'regulier') NOT NULL,
            date_disponible DATE NOT NULL,
            heure_debut TIME NOT NULL,
            heure_fin TIME NOT NULL,
            ville VARCHAR(100) NOT NULL,
            telephone VARCHAR(20) NOT NULL,
            certificat_medical VARCHAR(255),
            carte_identite VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );

        --  besoin_sang
        CREATE TABLE IF NOT EXISTS besoin_sang (
            id INT PRIMARY KEY AUTO_INCREMENT,
            utilisateur_id INT NOT NULL,
            nom_complet VARCHAR(100) NOT NULL,
            groupe_sanguin ENUM('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-') NOT NULL,
            hopital VARCHAR(200) NOT NULL,
            ville VARCHAR(100) NOT NULL,
            date_necessaire DATE NOT NULL,
            heure_souhaitee TIME NULL,
            telephone VARCHAR(20) NOT NULL,
            email VARCHAR(100) NOT NULL,
            urgence ENUM('normal', 'urgent', 'very_urgent') NOT NULL,
            description_besoin TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );

        -- besoin_transport
        CREATE TABLE IF NOT EXISTS besoin_transport (
            id INT AUTO_INCREMENT PRIMARY KEY,
            utilisateur_id INT NOT NULL,
            full_name VARCHAR(255) NOT NULL,
            ville VARCHAR(255) NOT NULL,
            telephone VARCHAR(20) NOT NULL,
            description TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );

        -- besoin_financier
        CREATE TABLE IF NOT EXISTS besoin_financier (
            id INT AUTO_INCREMENT PRIMARY KEY,
            utilisateur_id INT NOT NULL,
            full_name VARCHAR(255) NOT NULL,
            ville VARCHAR(255) NOT NULL,
            telephone VARCHAR(20) NOT NULL,
            description TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (utilisateur_id) REFERENCES utilisateur(id) ON DELETE CASCADE
        );
    ");

} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}



// Fonction pour exécuter une requête SELECT avec gestion des erreurs
function query($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erreur de requête : " . $e->getMessage());
        throw new Exception("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }
}

// Fonction pour exécuter une requête INSERT/UPDATE/DELETE avec gestion des erreurs
function execute($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log("Erreur d'exécution : " . $e->getMessage());
        throw new Exception("Erreur lors de l'exécution de la requête : " . $e->getMessage());
    }
}

// Fonction pour récupérer une seule ligne avec gestion des erreurs
function fetch($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Erreur de récupération : " . $e->getMessage());
        throw new Exception("Erreur lors de la récupération des données : " . $e->getMessage());
    }
}

// Fonction pour récupérer une seule valeur avec gestion des erreurs
function fetchColumn($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Erreur de récupération de colonne : " . $e->getMessage());
        throw new Exception("Erreur lors de la récupération de la valeur : " . $e->getMessage());
    }
}

// Fonction pour récupérer le dernier ID inséré
function lastInsertId() {
    global $pdo;
    return $pdo->lastInsertId();
}

// Fonction pour vérifier si une valeur existe déjà
function exists($table, $column, $value, $excludeId = null) {
    $sql = "SELECT COUNT(*) FROM $table WHERE $column = ?";
    $params = [$value];
    
    if ($excludeId !== null) {
        $sql .= " AND id != ?";
        $params[] = $excludeId;
    }
    
    return fetchColumn($sql, $params) > 0;
}


?> 

