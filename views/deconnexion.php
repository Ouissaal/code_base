<?php
session_start();
session_destroy();

setcookie('email_utilisateur', '', time() - 3600);
setcookie('psw_utilisateur', '', time() - 3600);

header('Location: index.php');
exit;
?>
