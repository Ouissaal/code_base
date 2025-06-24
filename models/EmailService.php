<?php
// Include PHPMailer files directly
require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

class EmailService {
    private $mailer;
    
    public function __construct() {
        $this->mailer = new PHPMailer\PHPMailer\PHPMailer(true);
        
        // Configuration SMTP
        $this->mailer->isSMTP();
        $this->mailer->Host       = 'smtp.gmail.com'; 
        $this->mailer->SMTPAuth   = true;
     
        $this->mailer->Username   = getenv('SMTP_USER') ?: 'bouamar.ouissal10@gmail.com'; 
        $this->mailer->Password   = getenv('SMTP_PASS') ?: 'xaew cxox wgea ovzf';
        $this->mailer->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port       = 465;
        $this->mailer->CharSet    = 'UTF-8';
        
        // Expéditeur par défaut
        $this->mailer->setFrom('bouamar.ouissal10@gmail.com', 'dir_lkhir');
    }
    
    public function sendMedicamentRequest($data) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($data['email'], $data['full_name']);
            
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "Demande de médicaments - DIR LKHIR";
            
            $body = "
            <h2>Demande de médicaments enregistrée</h2>
            <p><strong>Bonjour {$data['full_name']},</strong></p>
            <p>Votre demande de médicaments a été enregistrée avec succès.</p>
            
            <h3>Détails de votre demande :</h3>
            <ul>
                <li><strong>Médicament :</strong> {$data['medication_name']}</li>
                <li><strong>Quantité :</strong> {$data['quantity']}</li>
                <li><strong>Urgence :</strong> {$data['urgency']}</li>
                <li><strong>Ville :</strong> {$data['ville']}</li>
                <li><strong>Téléphone :</strong> {$data['telephone']}</li>
                <li><strong>Date souhaitée :</strong> {$data['date_souhaitee']}</li>
            </ul>
            
            <p>Nous vous contacterons bientôt pour confirmer la disponibilité.</p>
            <p>Cordialement,<br>L'équipe DIR LKHIR</p>";
            
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            
            $this->mailer->send();
            return true;
        } catch (PHPMailer\PHPMailer\Exception $e) {
            error_log("Erreur email médicament: " . $e->getMessage());
            return false;
        }
    }
    
    public function sendConsultationRequest($data) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($data['email'], $data['full_name']);
            
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "Demande de consultation - DIR LKHIR";
            
            $body = "
            <h2>Demande de consultation enregistrée</h2>
            <p><strong>Bonjour {$data['full_name']},</strong></p>
            <p>Votre demande de consultation a été enregistrée avec succès.</p>
            
            <h3>Détails de votre demande :</h3>
            <ul>
                <li><strong>Spécialité :</strong> {$data['specialty']}</li>
                <li><strong>Type de consultation :</strong> {$data['consultation_type']}</li>
                <li><strong>Urgence :</strong> {$data['urgency']}</li>
                <li><strong>Ville :</strong> {$data['ville']}</li>
                <li><strong>Date souhaitée :</strong> {$data['desired_date']}</li>
                <li><strong>Numéro de consultation :</strong> {$data['consultation_number']}</li>
            </ul>
            
            <p>Un médecin vous contactera bientôt pour confirmer le rendez-vous.</p>
            <p>Cordialement,<br>L'équipe DIR LKHIR</p>";
            
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            
            $this->mailer->send();
            return true;
        } catch (PHPMailer\PHPMailer\Exception $e) {
            error_log("Erreur email consultation: " . $e->getMessage());
            return false;
        }
    }
    
    public function sendBloodRequest($data) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($data['email'], $data['full_name']);
            
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "Demande de don de sang - DIR LKHIR";
            
            $body = "
            <h2>Demande de don de sang enregistrée</h2>
            <p><strong>Bonjour {$data['full_name']},</strong></p>
            <p>Votre demande de don de sang a été enregistrée avec succès.</p>
            
            <h3>Détails de votre demande :</h3>
            <ul>
                <li><strong>Groupe sanguin :</strong> {$data['blood_group']}</li>
                <li><strong>Hôpital :</strong> {$data['hospital']}</li>
                <li><strong>Ville :</strong> {$data['ville']}</li>
                <li><strong>Date nécessaire :</strong> {$data['needed_date']}</li>
                <li><strong>Urgence :</strong> {$data['urgency']}</li>
            </ul>
            
            <p>Nous recherchons activement des donneurs compatibles.</p>
            <p>Cordialement,<br>L'équipe DIR LKHIR</p>";
            
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            
            $this->mailer->send();
            return true;
        } catch (PHPMailer\PHPMailer\Exception $e) {
            error_log("Erreur email sang: " . $e->getMessage());
            return false;
        }
    }
    
    public function sendOfferNotification($data, $type) {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($data['email'], $data['full_name']);
            
            $this->mailer->isHTML(true);
            $this->mailer->Subject = "Offre d'aide enregistrée - DIR LKHIR";
            
            $body = "
            <h2>Offre d'aide enregistrée</h2>
            <p><strong>Bonjour {$data['full_name']},</strong></p>
            <p>Votre offre d'aide a été enregistrée avec succès.</p>
            
            <h3>Type d'offre :</h3>
            <p><strong>{$type}</strong></p>
            
            <p>Nous vous contacterons dès qu'une personne aura besoin de votre aide.</p>
            <p>Cordialement,<br>L'équipe DIR LKHIR</p>";
            
            $this->mailer->Body = $body;
            $this->mailer->AltBody = strip_tags($body);
            
            $this->mailer->send();
            return true;
        } catch (PHPMailer\PHPMailer\Exception $e) {
            error_log("Erreur email offre: " . $e->getMessage());
            return false;
        }
    }
}
?> 