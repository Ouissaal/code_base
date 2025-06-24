<?php
class BesoinAide {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createBesoinTransport($data) {
        $stmt = $this->pdo->prepare("INSERT INTO besoin_transport (utilisateur_id, full_name, ville, telephone, description) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['utilisateur_id'],
            $data['full_name'],
            $data['ville'],
            $data['telephone'],
            $data['description']
        ]);
    }

    public function createBesoinFinancier($data) {
        $stmt = $this->pdo->prepare("INSERT INTO besoin_financier (utilisateur_id, full_name, ville, telephone, description) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['utilisateur_id'],
            $data['full_name'],
            $data['ville'],
            $data['telephone'],
            $data['description']
        ]);
    }
} 