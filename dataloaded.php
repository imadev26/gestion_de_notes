<?php
include("connection.php");
$cnx = new Connection();
$cnx->selectDatabase("db_ges_notes");
$mysqli = $cnx->getMysqli();
session_start();

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
                $idrow = intval($_GET['idrow']);
                loadGroupes($idrow,$idfiliere);
            }
            break;
        case 'load_candidats':
            if (isset($_GET['idfiliere']) && isset($_GET['idgrp'])) {
                $idfiliere = intval($_GET['idfiliere']);
                $idgrp = intval($_GET['idgrp']);
                loadCandidats($idgrp);
            }
            break;
        case 'load_modules': // Ajout de l'action pour charger les modules
            if (isset($_GET['idfiliere'])) {
                $idfiliere = intval($_GET['idfiliere']);
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
function loadGroupes($idrow,$idfiliere)
{
    global $mysqli;

    $sql = "SELECT DISTINCT G.idgrp, G.nomgrp
    FROM Groupes G
    JOIN Filieres F ON G.idfiliere = F.idfiliere
    WHERE F.idfiliere = ? -- Assuming the filiere ID is 1
    AND G.idgrp NOT IN (
        SELECT E.idgrp
        FROM Enseigner E
        WHERE E.idprof = ?
    );";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ii",$idfiliere,$idrow);
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
