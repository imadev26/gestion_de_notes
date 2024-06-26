<?php 
class Modules 
{
    public $nomModule;
    public $idfiliere;
    public static $errorMsg = "";
    public static $successMsg="";

    public function __construct($nomModule = null,$idfiliere = null){
        if ($nomModule !== null && $idfiliere !== null) {
            $this->nomModule = $nomModule;
            $this->idfiliere = $idfiliere;
        }else {
            //method acces without any parametres
        }
        
    }
    public function insertModule($tablename,$conn){
        $mysqli = $conn->getMysqli();
        $query = "INSERT INTO $tablename (libelleM,idfiliere) VALUES (?,?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ss",$this->nomModule,$this->idfiliere);
        if ($stmt->execute()) {
            //header("Location: addfiliere.php");
            self::$successMsg = "Module ". $this->nomModule . " a créé avec succès.";
        }else {
            self::$errorMsg = "Error: <br>" . $stmt->error;
        }
    
    }
    public function selectModules($tableName,$conn){
        $mysqli = $conn->getMysqli();
        $sql = "SELECT idmodule,libelleM AS Module ,idfiliere AS filiére FROM $tableName ORDER BY filiére;";
        $result = $mysqli->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
    public function updateModule($fil,$tableName,$conn,$id){
        $mysqli = $conn->getMysqli();
        $sql = "UPDATE $tableName SET libelleM  = ? , idfiliere = ? WHERE idmodule = ?";
        $stmt = $mysqli->prepare($sql);
    
        if ($stmt) {
            $stmt->bind_param("ssi",$fil->libM,$fil->idFil,$id);
            if ($stmt->execute()) {
                self::$successMsg = "mise à jour du Module avec succès.";
                header("Location: editmodule.php?msgS=".self::$successMsg);
            } else {
                self::$errorMsg = "Échec de la mise à jour du Module. " . $stmt->error;
                header("Location: editmodule.php?msgE=".self::$errorMsg);
            }
            $stmt->close();
        } else {
            self::$errorMsg = "Error preparing statement: " . $conn->error;
            header("Location: editmodule.php?msgE=".self::$errorMsg);
        }
    
    }

}








?>