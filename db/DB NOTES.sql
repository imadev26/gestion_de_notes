CREATE TABLE Profs (
    idprof INT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    ddn DATE,
    email VARCHAR(100),
    password VARCHAR(100)
);
CREATE TABLE Filieres (
    idfiliere INT PRIMARY KEY,
    libelleF VARCHAR(50)
);
CREATE TABLE Modules (
    idmodule INT PRIMARY KEY,
    libelleM VARCHAR(50),
    idfiliere INT,
    FOREIGN KEY (idfiliere) REFERENCES Filieres(idfiliere)
);
CREATE TABLE Groupes (
    idgrp INT PRIMARY KEY,
    nomgrp VARCHAR(50),
    idfiliere INT,
    FOREIGN KEY (idfiliere) REFERENCES Filieres(idfiliere)
);
CREATE TABLE Etudiant (
    idedu INT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    ddn DATE,
    email VARCHAR(100),
    password VARCHAR(100),
    idgrp INT,
    FOREIGN KEY (idgrp) REFERENCES Groupes(idgrp)
);
CREATE TABLE Notes (
    idNote INT PRIMARY KEY,
    note DECIMAL(5,2),
    type VARCHAR(50),
    idmodule INT,
    idedu INT,
    FOREIGN KEY (idmodule) REFERENCES Modules(idmodule),
    FOREIGN KEY (idedu) REFERENCES Etudiant(idedu)
);
CREATE TABLE Enseigner (
    idprof INT,
    idgrp INT,
    idfiliere INT,
    idmodule INT,
    FOREIGN KEY (idprof) REFERENCES Profs(idprof),
    FOREIGN KEY (idgrp) REFERENCES Groupes(idgrp),
    FOREIGN KEY (idfiliere) REFERENCES Filieres(idfiliere),
    FOREIGN KEY (idmodule) REFERENCES Modules(idmodule),
    PRIMARY KEY (idprof, idgrp, idfiliere, idmodule)
);


INSERT INTO Profs (idprof, nom, prenom, ddn, email, password)
VALUES (1, 'NomProf', 'PrenomProf', '1990-01-01', 'prof@email.com', 'password123');

INSERT INTO Filieres (idfiliere, libelleF)
VALUES (1, 'Informatique'), (2, 'Finance');

INSERT INTO Modules (idmodule, libelleM, idfiliere)
VALUES (1, 'ModuleInfo1', 1), (2, 'ModuleInfo2', 1), (3, 'ModuleFinance1', 2), (4, 'ModuleFinance2', 2);

INSERT INTO Groupes (idgrp, nomgrp, idfiliere)
VALUES (1, 'Groupe1', 1), (2, 'Groupe2', 1), (3, 'Groupe1', 2), (4, 'Groupe2', 2);

INSERT INTO Etudiant (idedu, nom, prenom, ddn, email, password, idgrp)
VALUES (1, 'NomEtudiant', 'PrenomEtudiant', '1995-01-01', 'etudiant@email.com', 'password456', 1);

INSERT INTO Notes (idNote, note, type, idmodule, idedu)
VALUES (1, 15.5, 'Partiel', 1, 1), (2, 14.2, 'TP', 2, 1);

INSERT INTO Enseigner (idprof, idgrp, idfiliere, idmodule)
VALUES (1, 1, 1, 1), (1, 2, 1, 2), (1, 3, 2, 3), (1, 4, 2, 4);

SELECT idprof, idfiliere, GROUP_CONCAT(idgrp ORDER BY idgrp) AS groupes_enseignes
FROM Enseigner
WHERE idprof = 1
GROUP BY idprof, idfiliere;


SELECT P.nom AS nom_prof, F.libelleF AS filiere, GROUP_CONCAT(G.nomgrp ORDER BY G.nomgrp) AS groupes_enseignes
FROM Enseigner E
JOIN Profs P ON E.idprof = P.idprof
JOIN Groupes G ON E.idgrp = G.idgrp
JOIN Filieres F ON E.idfiliere = F.idfiliere
WHERE P.idprof = 1
GROUP BY P.idprof, F.idfiliere;









///VALABLE

-- Créer les tables

CREATE TABLE Profs (
    idprof INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    ddn DATE,
    email VARCHAR(100),
    password VARCHAR(100)
);

CREATE TABLE Etudiant (
    idedu INT PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    ddn DATE,
    email VARCHAR(100),
    password VARCHAR(100),
    idgrp INT
);

CREATE TABLE Groupes (
    idgrp INT PRIMARY KEY AUTO_INCREMENT,
    nomgrp VARCHAR(50),
    idfiliere INT
);

CREATE TABLE Filieres (
    idfiliere INT PRIMARY KEY AUTO_INCREMENT,
    libelleF VARCHAR(50)
);

CREATE TABLE Modules (
    idmodule INT PRIMARY KEY AUTO_INCREMENT,
    libelleM VARCHAR(50),
    idfiliere INT
);

CREATE TABLE Notes (
    idNote INT PRIMARY KEY AUTO_INCREMENT,
    note DECIMAL(5,2),
    type VARCHAR(50),
    idmodule INT,
    idedu INT
);

CREATE TABLE Enseigner (
    idprof INT,
    idgrp INT,
    idfiliere INT,
    idmodule INT
);




-- Ajouter les contraintes

ALTER TABLE Etudiant
ADD FOREIGN KEY (idgrp) REFERENCES Groupes(idgrp);

ALTER TABLE Groupes
ADD FOREIGN KEY (idfiliere) REFERENCES Filieres(idfiliere);

ALTER TABLE Modules
ADD FOREIGN KEY (idfiliere) REFERENCES Filieres(idfiliere);

ALTER TABLE Notes
ADD FOREIGN KEY (idmodule) REFERENCES Modules(idmodule),
ADD FOREIGN KEY (idedu) REFERENCES Etudiant(idedu);

ALTER TABLE Enseigner
ADD FOREIGN KEY (idprof) REFERENCES Profs(idprof),
ADD FOREIGN KEY (idgrp) REFERENCES Groupes(idgrp),
ADD FOREIGN KEY (idfiliere) REFERENCES Filieres(idfiliere),
ADD FOREIGN KEY (idmodule) REFERENCES Modules(idmodule);
