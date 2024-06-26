<?php 
        // Include client file
require_once "utilisateurs.php";




if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get entity type and ID from the GET parameters
    $type = isset($_GET['type']) ? $_GET['type'] : null;
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    if (!$type || !$id) {
        // Handle the case where the entity type or ID is not provided
        echo "Entity type or ID is not provided.";
    } else {
        // Include connection file
        require_once "connection.php";

        // Create an instance of class Connection
        $conn = new Connection();
        
        // Call the selectDatabase method
        $conn->selectDatabase("db_ges_notes");

        $mysqli = $conn->getMysqli();

        // Use a switch case to determine the entity type
        switch ($type) {
            case 'enseignant':
                Utilisateurs::deleteClient('profs', $mysqli, $id,"idprof");
                $redirect = "Enseignants/editenseignant.php";
                break;
            case 'etudiant':
                Utilisateurs::deleteClient('Etudiant', $mysqli, $id,"idedu");
                $redirect = "Etudiants/editetudiant.php";
                break;
            case 'fililere':
                Utilisateurs::deleteClient('Filieres', $mysqli, $id,"idfiliere");
                $redirect = "Filieres/editfiliere.php";
                break;
            case 'groupe':
                Utilisateurs::deleteClient('Groupes', $mysqli, $id,"idgrp");
                $redirect = "Groupes/editgroupe.php";
                break;
            case 'module':
                Utilisateurs::deleteClient('Modules', $mysqli, $id,"idmodule");
                $redirect = "Modules/editmodule.php";
                break;
            default:
                // Handle the case where an invalid entity type is provided
                echo "Invalid entity type.";
                exit;
        }

        // Check for success or error messages
        if (!empty(Utilisateurs::$successMsg)) {
            header("Location: $redirect");
        } else {
            echo "Error deleting client: " . Client::$errorMsg;
        }
    }
}


?>