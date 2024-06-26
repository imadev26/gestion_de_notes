<?php
include("../connection.php");
$cnx = new Connection();
$cnx->selectDatabase("db_ges_notes");
$mysqli = $cnx->getMysqli();
session_start();
$iduser = $_SESSION['id'];

// Vérifiez le type de requête (filières, groupes ou candidats)
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'load_filieres':
            loadFilieres($iduser);
            break;
        case 'load_groupes':
            if (isset($_GET['idfiliere'])) {
                $idmodule = $_GET['idmodules'];
                $idfiliere = intval($_GET['idfiliere']);
                loadGroupes($iduser,$idfiliere,$idmodule);
            }
            break;
        case 'load_candidats':
            if (isset($_GET['idfiliere']) && isset($_GET['idgrp'])) {
                $idfiliere = intval($_GET['idfiliere']);
                $idgrp = intval($_GET['idgrp']);
                $idmodule = intval($_GET['idgrp']);
                loadCandidats($idgrp,$idfiliere,$idmodule);
            }
            break;
        case 'load_modules': // Ajout de l'action pour charger les modules
            if (isset($_GET['idfiliere'])) {
                $idfiliere = intval($_GET['idfiliere']);
                loadModules($iduser,$idfiliere);
            }
            break;
        case 'list_condidats': // Ajout de l'action pour charger les modules
            if (isset($_GET['idfiliere']) && isset($_GET['idgrp'])) {
                $idfiliere = intval($_GET['idfiliere']);
                $idgrp = intval($_GET['idgrp']);
                $idmodule = intval($_GET['idmodule']);
                listCandidats($idgrp,$idmodule,$idfiliere);
            }
            break;
        default:
            echo json_encode(['error' => 'Action non valide']);
            break;
    }
} else {
    //echo json_encode(['error' => 'Action non spécifiée']);
}


function loadModules($iduser,$idfiliere)
{
    global $mysqli;

    $sql = "SELECT DISTINCT M.idmodule,M.libelleM
    FROM Modules M
    JOIN Enseigner E ON M.idmodule = E.idmodule
    WHERE E.idprof = ? AND E.idfiliere = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii", $iduser,$idfiliere);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// Fonction pour charger les filières
function loadFilieres($iduser)
{
    global $mysqli;

    $sql = "SELECT DISTINCT F.idfiliere,F.libelleF
    FROM Filieres F
    JOIN Enseigner E ON F.idfiliere = E.idfiliere
    WHERE E.idprof = $iduser;";
    $result = $mysqli->query($sql);
    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// Fonction pour charger les groupes en fonction de la filière sélectionnée
function loadGroupes($iduser,$idfiliere,$idmodule)
{
    global $mysqli;

    $sql = "SELECT Enseigner.idgrp, Groupes.nomgrp
    FROM Enseigner
    JOIN Groupes ON Enseigner.idgrp = Groupes.idgrp
    WHERE Enseigner.idprof = ? AND Enseigner.idfiliere = ? AND Enseigner.idmodule = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iii", $iduser,$idfiliere,$idmodule);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}

// Fonction pour charger les candidats en fonction de la filière et du groupe sélectionnés
function loadCandidats($idgrp,$idfiliere,$idmodule)
{
    global $mysqli;
    $sql = "SELECT e.idedu, CONCAT(e.nom, '&nbsp;', e.prenom) AS NOM_COMPLET, 
    n1.note AS note_devoir, n2.note AS note_controle, n3.note AS note_exam,
    (n1.note + n2.note + n3.note) / 3 AS moyenne
    FROM Etudiant e
    LEFT JOIN Notes n1 ON e.idedu = n1.idedu AND n1.type = 'DEVOIRE'  AND n1.idmodule  = ?
    LEFT JOIN Notes n2 ON e.idedu = n2.idedu AND n2.type = 'CONTROLE' AND n2.idmodule  = ?
    LEFT JOIN Notes n3 ON e.idedu = n3.idedu AND n3.type = 'EXAM'     AND n3.idmodule  = ?
    LEFT JOIN Groupes g ON e.idgrp = g.idgrp
    WHERE g.idgrp = ? AND g.idfiliere = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iiiii",$idmodule,$idmodule,$idmodule,$idgrp,$idfiliere);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}


function listCandidats($idgrp,$idmodule,$idfiliere)
{
    global $mysqli;
    $sql = "SELECT e.idedu, CONCAT(e.nom, ' ', e.prenom) AS NOM_COMPLET, 
    n1.note AS note_devoir, n2.note AS note_controle, n3.note AS note_exam,
    (n1.note + n2.note + n3.note) / 3 AS moyenne
    FROM Etudiant e
    LEFT JOIN Notes n1 ON e.idedu = n1.idedu AND n1.type = 'DEVOIRE'
    LEFT JOIN Notes n2 ON e.idedu = n2.idedu AND n2.type = 'CONTROLE'
    LEFT JOIN Notes n3 ON e.idedu = n3.idedu AND n3.type = 'EXAM'
    LEFT JOIN Groupes g ON e.idgrp = g.idgrp
    WHERE e.idgrp = ? AND n1.idmodule = n2.idmodule AND n2.idmodule = n3.idmodule AND n1.idmodule = ? AND g.idfiliere = ?;";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("iii", $idgrp,$idmodule,$idfiliere);
    $stmt->execute();
    $result = $stmt->get_result();

    $datalist = array();
    while ($row = $result->fetch_assoc()) {
        $datalist[] = $row;
    }

    echo json_encode($datalist);
}





?>
