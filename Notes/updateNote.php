<?php 
require_once("../connection.php");
$cnx = new Connection();
$cnx->selectDatabase("db_ges_notes");
$mysqli = $cnx->getMysqli();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idedu = $_POST['idedu'];
    $type = $_POST['type'];
    $value = $_POST['value'];
    $idmodule = $_POST['idmodule'];

    // Check if the note already exists
    $checkSql = "SELECT * FROM Notes WHERE idedu = ? AND type = ? AND idmodule = ?";
    $checkStmt = $mysqli->prepare($checkSql);
    $checkStmt->bind_param("isi", $idedu, $type,$idmodule);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();

    if ($checkResult->num_rows > 0) {
        // Note exists, update it
        $updateSql = "UPDATE Notes SET note = ? WHERE idedu = ? AND type = ? AND idmodule = ?";
        $updateStmt = $mysqli->prepare($updateSql);
        $updateStmt->bind_param("disi", $value, $idedu, $type,$idmodule);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Note doesn't exist, insert it
        $insertSql = "INSERT INTO Notes (note, type, idedu,idmodule) VALUES (?, ?, ?, ?)";
        $insertStmt = $mysqli->prepare($insertSql);
        $insertStmt->bind_param("dsii", $value, $type, $idedu,$idmodule);
        $insertStmt->execute();
        $insertStmt->close();
    }

    // Close statements
    $checkStmt->close();

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['error' => 'Invalid request method']);
}






?>