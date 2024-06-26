<?php
include("groupes.php");
include("connection.php");
$cnx = New Connection();
$cnx->selectDatabase("db_ges_notes");
$groupes = new Groupes();
//$cnx->getMysqli();

// getGroupes.php
if(isset($_POST['idfiliere']) && !empty($_POST['idfiliere'])){
    $idfiliere = $_POST['idfiliere'];

    // Effectuez la requête SQL pour récupérer les groupes en fonction de l'id de la filière
    // Assurez-vous de prévenir les attaques par injection SQL (utilisez des requêtes préparées ou échappez correctement les données)

    $groupes = $groupes->getGroupesByFiliereId($idfiliere,$cnx); // Vous devez définir cette fonction en fonction de votre application

    echo '<option value="" disabled selected>Sélectionnez un groupe</option>';
    foreach($groupes as $groupe){
        echo '<option value="'.$groupe['idgrp'].'">'.$groupe['nomgrp'].'</option>';
    }
}
?>