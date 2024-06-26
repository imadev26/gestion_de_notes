<?php
include("../connection.php");
$cnx = new Connection();
$cnx->selectDatabase("db_ges_notes");
$mysqli = $cnx->getMysqli();
session_start();

// Function to insert a record into the Enseigner table
function insertIntoEnseigner($idProf, $idGroupe, $idfiliere, $idModule)
{
    global $mysqli;

    $sql = "INSERT INTO Enseigner (idprof, idgrp, idfiliere, idmodule) VALUES (?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iiii", $idProf, $idGroupe, $idfiliere, $idModule);
    $stmt->execute();

    // Return the success status (you may want to add more error handling)
    echo json_encode(['status' => 'success', 'message' => 'Insertion successful']);
}

// Handle the AJAX request for inserting into Enseigner
if (isset($_POST['action']) && $_POST['action'] === 'insert_enseigner') {
    $idProf = intval($_POST['idProf']);
    $idGroupe = intval($_POST['idGroupe']);
    $idfiliere = intval($_POST['idFiliere']);
    $idModule = intval($_POST['idModule']);

    insertIntoEnseigner($idProf, $idGroupe, $idfiliere, $idModule);
    exit;
}
// Function to delete a record from the Enseigner table
function deleteFromEnseigner($idProf, $idGroupe, $idfiliere, $idModule)
{
    global $mysqli;

    $sql = "DELETE FROM Enseigner WHERE idprof = ? AND idgrp = ? AND idfiliere = ? AND idmodule = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iiii", $idProf, $idGroupe, $idfiliere, $idModule);
    $stmt->execute();

    // Return the success status (you may want to add more error handling)
    echo json_encode(['status' => 'success', 'message' => 'Deletion successful']);
}

// Handle the AJAX request for deleting from Enseigner
if (isset($_POST['action']) && $_POST['action'] === 'delete_enseigner') {
    $idProf = intval($_POST['idProf']);
    $idGroupe = intval($_POST['idGroupe']);
    $idfiliere = intval($_POST['idFiliere']);
    $idModule = intval($_POST['idModule']);

    deleteFromEnseigner($idProf, $idGroupe, $idfiliere, $idModule);
    exit;
}

// if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idProf'])) {
//     $idProf = $_POST['idProf'];

//     // Fetch detailed information based on $idProf
//     // Perform your database query or other logic here
    
//     // Return the response (replace this with your actual response)
//     $response = ['status' => 'success', 'message' => 'Details fetched successfully'];
//     echo json_encode($response);
//     exit;
// }

// Vérifiez le type de requête (filières, groupes ou candidats)
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'load_filieres':
            loadFilieres();
            break;
        case 'load_groupes':
            
            
            if (isset($_GET['idfiliere'])) {
                //$idmodule = $_GET['idmodules'];
                $idfiliere = intval($_GET['idfiliere']);
                $idProf = intval($_GET['idProf']);
                loadGroupes($idfiliere);
            }
            break;
        // case 'load_candidats':
        //     if (isset($_GET['idfiliere']) && isset($_GET['idgrp'])) {
        //         $idfiliere = intval($_GET['idfiliere']);
                
        //     }
        //     break;
        case 'load_modules': // Ajout de l'action pour charger les modules
            if (isset($_GET['idfiliere'])) {
                $idfiliere = intval($_GET['idfiliere']);
                $idProf = intval($_GET['idProf']);
                $idgrp = intval($_GET['idgroupe']);
                loadModules($idProf,$idfiliere,$idgrp);
                //loadModules($iduser,$idfiliere);
            }
            break;
        default:
            echo json_encode(['error' => 'Action non valide']);
            break;
    }
} else {
    //echo json_encode(['error' => 'Action non spécifiée']);
}


function loadModules($idProf,$idfiliere,$idgrp)
{
    global $mysqli;

    $sql = "SELECT DISTINCT M.idmodule, M.libelleM
            FROM Modules M
            JOIN Enseigner E ON M.idmodule = E.idmodule
            WHERE E.idprof = ? AND E.idfiliere = ? AND E.idgrp = ?;";

    $sql2 = "SELECT DISTINCT M.idmodule, M.libelleM
    FROM Modules M
    WHERE M.idfiliere = ? 
    AND M.idmodule NOT IN (
        SELECT E.idmodule
        FROM Modules M
        JOIN Enseigner E ON M.idmodule = E.idmodule
        WHERE E.idprof = ? AND E.idgrp = ? 
    );";

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iii", $idProf, $idfiliere, $idgrp);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $stmt = $mysqli->prepare($sql2);
    $stmt->bind_param("iii", $idfiliere, $idProf, $idgrp);
    $stmt->execute();
    $result = $stmt->get_result();

    $dataothers = array();
    while ($row = $result->fetch_assoc()) {
        $dataothers[] = $row;
    }

    // Combine both sets of data into a single array
    $response = array('data' => $data, 'dataothers' => $dataothers);

    // Encode the combined data as JSON and echo it
    echo json_encode($response);
}

// Fonction pour charger les filières
function loadFilieres()
{
    global $mysqli;
    $sql = "SELECT DISTINCT idfiliere,libelleF
    FROM Filieres ";
    $result = $mysqli->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// Fonction pour charger les groupes en fonction de la filière sélectionnée
function loadGroupes($idfiliere)
{
    global $mysqli;

    $sql = "SELECT DISTINCT G.idgrp, G.nomgrp
    FROM Groupes G
    JOIN Filieres F ON G.idfiliere = F.idfiliere
    WHERE F.idfiliere = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i",$idfiliere);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// Fonction pour charger les candidats en fonction de la filière et du groupe sélectionnés
function loadCandidats($idgrp)
{
    global $mysqli;
    $sql = "SELECT e.idedu, CONCAT(e.nom, '&nbsp;', e.prenom) AS NOM_COMPLET, 
    n1.note AS note_devoir, n2.note AS note_controle, n3.note AS note_exam,
    (n1.note + n2.note + n3.note) / 3 AS moyenne
    FROM etudiant e
    LEFT JOIN Notes n1 ON e.idedu = n1.idedu AND n1.type = 'DEVOIRE'
    LEFT JOIN Notes n2 ON e.idedu = n2.idedu AND n2.type = 'CONTROLE'
    LEFT JOIN Notes n3 ON e.idedu = n3.idedu AND n3.type = 'EXAM'
    WHERE e.idgrp = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $idgrp);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
