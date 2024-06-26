<?php 
class Groupes{
    public $nomgrp;
    public $idfiliere;

    public static $errorMsg = "";
    public static $successMsg="";


    public function __construct($nomgrp=null, $idfiliere=null ){
        if ($nomgrp!==null && $idfiliere!==null) {
            $this->nomgrp=$nomgrp;
            $this->idfiliere=$idfiliere;
        }else {
            
        }
    
    }
    
    
    public function insertfil($tablename,$conn){
        $mysqli = $conn->getMysqli();
        $query = "INSERT INTO $tablename (nomgrp,idfiliere) VALUES (?,?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ss",$this->nomgrp,$this->idfiliere);
        if ($stmt->execute()) {
            //header("Location: addfiliere.php");
            self::$successMsg = "groupe ". $this->nomgrp . " a créé avec succès.";
        }else {
            self::$errorMsg = "Error: <br>" . $stmt->error;
        }
    
    }
    public function selectfil($tableName,$conn){
        $mysqli = $conn->getMysqli();
        $sql = "SELECT $tableName.idgrp,$tableName.nomgrp,$tableName.idfiliere AS filiére FROM $tableName ORDER BY filiére;";
        $result = $mysqli->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function updategrp($fil,$tableName,$conn,$id){
        $mysqli = $conn->getMysqli();
        $sql = "UPDATE $tableName SET nomgrp  = ? , idfiliere = ? WHERE idgrp = ?";
        $stmt = $mysqli->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("ssi",$fil->nomGRP,$fil->idFil,$id);
            if ($stmt->execute()) {
                self::$successMsg = "mise à jour du Groupe avec succès.";
                header("Location: editgroupe.php?msgS=".self::$successMsg);
            } else {
                self::$errorMsg = "Échec de la mise à jour du filiére. " . $stmt->error;
                header("Location: editgroupe.php?msgE=".self::$errorMsg);
            }
            $stmt->close();
        } else {
            self::$errorMsg = "Error preparing statement: " . $conn->error;
            header("Location: editgroupe.php?msgE=".self::$errorMsg);
        }
    
    }
    public function returnID($conn,$filID) {  
        $query = "SELECT libelleF
        FROM Filieres
        WHERE idfiliere = $filID;";
        $mysqli = $conn->getMysqli();
        $stmt = $mysqli->query($query);
        $result = $stmt->fetch_assoc();
        return $result["libelleF"];
    }

    public function getGroupesByFiliereId($idfiliere,$conn){
        $sql = "SELECT idgrp, nomgrp FROM Groupes WHERE idfiliere = $idfiliere;";
        $mysqli = $conn->getMysqli();
        $result = $mysqli->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    
}





?>