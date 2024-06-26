<?php

class Utilisateurs{

//public $id;
public $nom;
public $prenom;
public $ddn;
public $email;
public $mdp; 


public $informationsFusionnees;

public static $errorMsg = "";

public static $successMsg="";


public function __construct($nom = null,$prenom = null,$ddn = null,$email = null,$mdp = null){
    if ($nom !== null && $prenom !== null && $ddn !== null && $email !== null && $mdp !== null){
        $this->nom =$nom;
        $this->prenom =$prenom;
        $this->ddn =$ddn;
        $this->email =$email;
        $this->mdp = password_hash($mdp, PASSWORD_BCRYPT);
        $this->informationsFusionnees = "Nom: $nom, Prénom: $prenom, Date de naissance: $ddn";
    }else{

    };
}

public function insertuser($tableName,$conn){
    $mysqli = $conn->getMysqli();
    $query = " INSERT INTO $tableName (nom, prenom, ddn, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("sssss", $this->nom, $this->prenom, $this->ddn, $this->email, $this->mdp);
    if ($stmt->execute()) {
        self::$successMsg = "Enseignant créé avec succès." . $this->informationsFusionnees;
        //header("Location: dashboard.php");
    } else {
        self::$errorMsg = "Error: <br>" . $stmt->error;
    }

    /*
    $query = "
    INSERT INTO $tableName (Nom, Prenom, ddn, email, password) 
VALUES 
('$this->nom', '$this->prenom', '$this->ddn', '$this->email', '$this->mdp')";
    if (mysqli_query($conn,$query)) {
      $this->successMsg = "Enseignant créé avec succès." . $this->informationsFusionnees ;
      mysqli_close($conn);
      // header("Location:login.php");
    }
    else{
        $this->errorMsg = "Error: <br>".mysqli_error($conn);
    }*/
    

}
/*
public static function selectAllEtudiants($conn){
    $mysqli = $conn->getMysqli();
    $sql = "SELECT 
    Etudiants.ID AS EtudiantID,
    Utilisateurs.Nom,
    Utilisateurs.Prenom,
    Utilisateurs.DateNaissance,
    Utilisateurs.Email,
    Groupes.NomGroupe,
    Filieres.NomFiliere
FROM 
    Etudiants
JOIN 
    Utilisateurs ON Etudiants.IDUtilisateur = Utilisateurs.ID
JOIN 
    Groupes ON Etudiants.IDGroupe = Groupes.ID
JOIN 
    Filieres ON Groupes.IDFiliere = Filieres.ID;";
    $result = $mysqli->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}*/

//data Dashboard
public static function retDATA($conn,$table){
    $mysqli = $conn->getMysqli();
    $sql = "SELECT COUNT(*) as count FROM $table";
    $result = $mysqli->query($sql);
    $row = $result->fetch_assoc();
    return $row['count'];
}

//table Enseignant
public static function selectAllProf($conn){
    $mysqli = $conn->getMysqli();
    $sql = "SELECT  P.idprof,P.nom,P.prenom,P.email,F.libelleF AS filiere,GROUP_CONCAT(DISTINCT G.nomgrp ORDER BY G.nomgrp) AS groupesenseigner
    FROM Enseigner E
    JOIN Profs P ON E.idprof = P.idprof
    JOIN Groupes G ON E.idgrp = G.idgrp
    JOIN Filieres F ON E.idfiliere = F.idfiliere
    GROUP BY P.idprof, F.idfiliere;";
    $result = $mysqli->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

public function select($tableName,$conn){
    //$mysqli = $conn->getMysqli();
    $sql = "SELECT * FROM $tableName;";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
public function selectID($tableName,$conn){
    //$mysqli = $conn->getMysqli();
    $sql = "SELECT idprof AS ID,nom,prenom,ddn AS DATE_DE_NAISSANCE,email FROM $tableName;";
    $result = $conn->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
/*
static function selectClientById($tableName,$conn,$id){
    $mysqli = $conn->getMysqli();
    $sql = "SELECT * FROM $tableName WHERE idprof = $id;";
    $result = $mysqli->query($sql);
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}*/

static function updateUser($prof,$tableName,$conn){
    // Check if the password contains only asterisks
    $isDefaultPassword = (strlen($prof->mdp) > 0 && preg_match('/^\*+$/', $prof->mdp));
    if ($isDefaultPassword) {
        // If the password is "*", do not update the password
        $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ? WHERE idprof = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssssi", $prof->nom, $prof->prenom, $prof->ddn, $prof->email, $prof->idprof);

            if ($stmt->execute()) {
                self::$successMsg = "mise à jour d'enseignant avec succès.";
                header("Location: editenseignant.php?msgS=" . self::$successMsg);
            } else {
                self::$errorMsg = "Échec de la mise à jour d'enseignant : " . $stmt->error;
                header("Location: editenseignant.php?msgS=" . self::$errorMsg);
            }

            $stmt->close();
        } else {
            self::$errorMsg = "Erreur de préparation de la requête : " . $conn->error;
        }
    } else {
        // If the password is not "*", update the password
        $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ?, password = ? WHERE idprof = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $hashedPassword = password_hash($prof->mdp, PASSWORD_BCRYPT);
            $stmt->bind_param("sssssi", $prof->nom, $prof->prenom, $prof->ddn, $prof->email, $hashedPassword, $prof->idprof);

            if ($stmt->execute()) {
                self::$successMsg = "Mise à jour d'utilisateur avec succès.";
                header("Location: editenseignant.php?msgS=" . self::$successMsg);
            } else {
                self::$errorMsg = "Échec de la mise à jour d'utilisateur : " . $stmt->error;
                header("Location: editenseignant.php?msgS=" . self::$errorMsg);
            }

            $stmt->close();
        } else {
            self::$errorMsg = "Erreur de préparation de la requête : " . $conn->error;
        }
    }
    /*
        if (get_object_vars($prof) > 5) {
            //$mysqli = $conn->getMysqli();
            $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ?,password = ? WHERE idprof = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssssi", $prof->nom, $prof->prenom, $prof->ddn, $prof->email, password_hash($prof->mdp,PASSWORD_BCRYPT) , $id);

                if ($stmt->execute()) {
                    self::$successMsg = "mise à jour d'enseignant avec succès.";
                    header("Location: editenseignant.php?msgS=".self::$successMsg);
                } else {
                    self::$errorMsg = "Échec de la mise à jour d'enseignant : " . $stmt->error;
                    header("Location: editenseignant.php?msgS=".self::$errorMsg);
                }

                $stmt->close();
            } else {
                self::$errorMsg = "Error preparing statement: " . $conn->error;
            }
        }else {
            //$mysqli = $conn->getMysqli();
            $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ?WHERE idprof = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssssi", $prof->nom, $prof->prenom, $prof->ddn, $prof->email, $id);

                if ($stmt->execute()) {
                    self::$successMsg = "mise à jour d'enseignant avec succès.";
                    //header("Location: dashboard.php");
                } else {
                    self::$errorMsg = "Échec de la mise à jour d'enseignant : " . $stmt->error;
                }

                $stmt->close();
            } else {
                self::$errorMsg = "Error preparing statement: " . $conn->error;
            }
        }*/
        
}

static function deleteClient($tableName,$conn,$id,$idname){
        //$mysqli = $conn->getMysqli();
        $sql = "DELETE FROM $tableName WHERE $idname = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
          self::$successMsg = "Client deleted successfully.";
        } else {
          self::$errorMsg = "Error deleting client: " . $conn->error;
        }
        $stmt->close();
    }

}

?>
