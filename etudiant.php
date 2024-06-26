<?php 
class Etudiant
{
    public $nom;
    public $prenom;
    public $ddn;
    public $email;
    public $mdp; 
    public $grp;
    public $informationsFusionnees;
    public static $errorMsg = "";

public static $successMsg="";

    public function __construct($nom = null, $prenom= null, $ddn = null,$email = null, $mdp= null, $grp = null){
        if ($nom !== null && $prenom !== null && $ddn !== null && $email  !== null && $mdp !== null && $grp  !== null) {
            $this->nom = $nom;
            $this->prenom = $prenom;
            $this->ddn = $ddn;
            $this->email = $email;
            $this->mdp = password_hash($mdp, PASSWORD_BCRYPT);
            $this->grp = $grp;
            $this->informationsFusionnees = "Nom: $nom, Prénom: $prenom, Date de naissance: $ddn, Groupe : $grp";
        }else {
            
        }
    }
    public function insertuser($tableName,$conn){
        $mysqli = $conn->getMysqli();
        $query = " INSERT INTO $tableName (nom, prenom, ddn, email, password,idgrp) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("sssssi", $this->nom, $this->prenom, $this->ddn, $this->email, $this->mdp,$this->grp);
        if ($stmt->execute()) {
            self::$successMsg = "Etudiant créé avec succès." . $this->informationsFusionnees;
            //header("Location: dashboard.php");
        } else {
            self::$errorMsg = "Error: <br>" . $stmt->error;
        }
    }
    static function select($conn){
        //$mysqli = $conn->getMysqli();
        $sql = "SELECT e.idedu AS NUMERO, e.nom, e.prenom, e.ddn AS DATE_DE_NAISSANCE, e.email, e.password AS MOTS_DE_PASSE, f.libelleF AS FILIERE, g.nomgrp AS GROUPE
        FROM Etudiant e
        LEFT JOIN Groupes g ON e.idgrp = g.idgrp
        LEFT JOIN Filieres f ON g.idfiliere = f.idfiliere;";
        $result = $conn->query($sql);
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    static function updateUser($etud,$tableName,$conn){
        // Check if the password contains only asterisks
        $isDefaultPassword = (strlen($etud->mdp) > 0 && preg_match('/^\*+$/', $etud->mdp));
        if ($isDefaultPassword) {
            // If the password is "*", do not update the password
            $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ?, idgrp = ? WHERE idedu = ?";
            $stmt = $conn->prepare($sql);
    
            if ($stmt) {
                $stmt->bind_param("ssssii", $etud->nom, $etud->prenom, $etud->ddn, $etud->email, $etud->idgrp, $etud->idedu);
    
                if ($stmt->execute()) {
                    self::$successMsg = "Mise à jour d'étudiant avec succès.";
                    header("Location: editetudiant.php?msgS=" . self::$successMsg);
                } else {
                    self::$errorMsg = "Échec de la mise à jour d'étudiant : " . $stmt->error;
                    header("Location: editetudiant.php?msgS=" . self::$errorMsg);
                }
    
                $stmt->close();
            } else {
                self::$errorMsg = "Erreur de préparation de la requête : " . $conn->error;
            }
        } else {
            // If the password is not "*", update the password
            $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ?, password = ?, idgrp = ? WHERE idedu = ?";
            $stmt = $conn->prepare($sql);
    
            if ($stmt) {
                $hashedPassword = password_hash($etud->mdp, PASSWORD_BCRYPT);
                $stmt->bind_param("sssssii", $etud->nom, $etud->prenom, $etud->ddn, $etud->email, $hashedPassword, $etud->idgrp, $etud->idedu);
    
                if ($stmt->execute()) {
                    self::$successMsg = "Mise à jour d'utilisateur avec succès.";
                    header("Location: editetudiant.php?msgS=" . self::$successMsg);
                } else {
                    self::$errorMsg = "Échec de la mise à jour d'utilisateur : " . $stmt->error;
                    header("Location: editetudiant.php?msgS=" . self::$errorMsg);
                }
    
                $stmt->close();
            } else {
                self::$errorMsg = "Erreur de préparation de la requête : " . $conn->error;
            }
        }




        /*
        if ($etud->mdp == "") {
            //$mysqli = $conn->getMysqli();
            $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ?,password = ?,idgrp = ? WHERE idedu = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssssii", $etud->nom, $etud->prenom, $etud->ddn, $etud->email, password_hash($etud->mdp,PASSWORD_BCRYPT),$etud->idgrp , $id);

                if ($stmt->execute()) {
                    self::$successMsg = "mise à jour d'utilisateur avec succès.";
                    header("Location: editetudiant.php?msgS=".self::$successMsg);
                } else {
                    self::$errorMsg = "Échec de la mise à jour d'utilisateur : " . $stmt->error;
                    header("Location: editetudiant.php?msgS=".self::$errorMsg);
                }

                $stmt->close();
            } else {
                self::$errorMsg = "Error preparing statement: " . $conn->error;
            }
        }else { if ($etud->mdp !== "") {
            
            # code...
        }
            //$mysqli = $conn->getMysqli();
            $sql = "UPDATE $tableName SET nom = ?, prenom = ?, ddn = ?, email = ? , idgrp = ? WHERE idedu = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("sssssi", $etud->nom, $etud->prenom, $etud->ddn, $etud->email,$etud->idgrp, $id);

                if ($stmt->execute()) {
                    self::$successMsg = "mise à jour d'etudiant avec succès.";
                    header("Location: editetudiant.php?msgS=".self::$successMsg);

                } else {
                    self::$errorMsg = "Échec de la mise à jour d'etudiant :  " . $stmt->error;
                    header("Location: editetudiant.php?msgS=".self::$errorMsg);
                }

                $stmt->close();
            } else {
                self::$errorMsg = "Error preparing statement: " . $conn->error;
            }
        }
        */

}


    public function returnID($conn,$grpID) {  
        $query = "SELECT G.nomgrp, F.libelleF 
        FROM Groupes G
        INNER JOIN Filieres F ON G.idfiliere = F.idfiliere
        WHERE G.idgrp = $grpID;";
        $mysqli = $conn->getMysqli();
        $stmt = $mysqli->query($query);
        $result = $stmt->fetch_assoc();
        return $result;
    }







}









?>