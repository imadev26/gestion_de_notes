<?php 
//include("connection.php");
//$conn = New Connection();

class Filieres {
public $libele;  

public static $errorMsg = "";
public static $successMsg="";


public function __construct($libele=null){
    if ($libele !== null) {
        $this->libele = $libele;
    }else {
        
    }

}


public function insertfil($tablename,$conn){
    $mysqli = $conn->getMysqli();
    $query = "INSERT INTO $tablename (libelleF) VALUES (?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s",$this->libele);
    if ($stmt->execute()) {
        //header("Location: addfiliere.php");
        self::$successMsg = "la filiere ". $this->libele . " a créé avec succès.";
    }else {
        self::$errorMsg = "Error: <br>" . $stmt->error;
    }

}
public function selectfil($tableName,$conn){
    $mysqli = $conn->getMysqli();
    $sql = "SELECT * FROM $tableName;";
    $result = $mysqli->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
public function selectfilwithGRP($conn){
    $mysqli = $conn->getMysqli();
    $sql = "SELECT DISTINCT F.idfiliere, F.libelleF
    FROM Filieres F
    INNER JOIN Groupes G ON F.idfiliere = G.idfiliere;";
    $result = $mysqli->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
public function updatefil($fil,$tableName,$conn,$id){
    $mysqli = $conn->getMysqli();
    $sql = "UPDATE $tableName SET libelleF = ? WHERE idfiliere = ?";
    $stmt = $mysqli->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("si",$fil,$id);
        if ($stmt->execute()) {
            self::$successMsg = "mise à jour du filiére avec succès.";
            header("Location: editfiliere.php?msgS=".self::$successMsg);
        } else {
            self::$errorMsg = "Échec de la mise à jour du filiére. " . $stmt->error;
            header("Location: editfiliere.php?msgE=".self::$errorMsg);
        }
        $stmt->close();
    } else {
        self::$errorMsg = "Error preparing statement: " . $conn->error;
    }

}
public function returnID($conn) {  
    $query = "SELECT idfiliere
    FROM Filieres
    ORDER BY idfiliere DESC
    LIMIT 1;";
    $mysqli = $conn->getMysqli();
    $stmt = $mysqli->query($query);
    $result = $stmt->fetch_assoc();
    return $result["idfiliere"];
}
/*
public function deletefil($tableName,$conn,$id){
    $mysqli = $conn->getMysqli();
    $sql = "DELETE FROM $tableName WHERE idprof = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      self::$successMsg = "Client deleted successfully.";
    } else {
      self::$errorMsg = "Error deleting client: " . $conn->error;
    }
    $stmt->close();
}*/
 
}























?>