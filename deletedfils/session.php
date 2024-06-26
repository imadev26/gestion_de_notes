<?php 
session_start();
// Vérifier si l'utilisateur est connecté en tant que professeur
if (!isset($_SESSION['id'])) {
    // L'utilisateur n'est pas connecté en tant que professeur, rediriger vers la page de connexion par exemple
    header("Location: ../auth-login.php");
    exit();
}
$fullname = $_SESSION['nom'] ." ".$_SESSION['prenom'];
$role = $_SESSION['role'];
$iduser = $_SESSION['id'];
?>