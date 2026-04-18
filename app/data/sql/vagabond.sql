CREATE TABLE role(
   id_role INT AUTO_INCREMENT,
   libelle VARCHAR(50),
   PRIMARY KEY(id_role)
);

CREATE TABLE destinations(
   id_destination INT AUTO_INCREMENT,
   nom_destination VARCHAR(50) NOT NULL,
   PRIMARY KEY(id_destination)
);

CREATE TABLE utilisateurs(
   id_utilisateur INT AUTO_INCREMENT,
   nom VARCHAR(50) NOT NULL,
   prenom VARCHAR(50) NOT NULL,
   email VARCHAR(100) NOT NULL,
   password VARCHAR(250) NOT NULL,
   token VARCHAR(255),
   token_expiration DATETIME,
   id_role INT NOT NULL,
   PRIMARY KEY(id_utilisateur),
   UNIQUE(email),
   FOREIGN KEY(id_role) REFERENCES role(id_role)
);

CREATE TABLE recits(
   id_recit INT AUTO_INCREMENT,
   titre VARCHAR(50) NOT NULL,
   ville VARCHAR(100) NOT NULL,
   contenu TEXT NOT NULL,
   image VARCHAR(50),
   date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
   id_destination INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_recit),
   FOREIGN KEY(id_destination) REFERENCES destinations(id_destination),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

CREATE TABLE commentaires(
   id_commentaire INT AUTO_INCREMENT,
   commentaire TEXT NOT NULL,
   date_commentaire DATETIME,
   id_recit INT NOT NULL,
   id_utilisateur INT NOT NULL,
   PRIMARY KEY(id_commentaire),
   FOREIGN KEY(id_recit) REFERENCES recits(id_recit),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateurs(id_utilisateur)
);

CREATE TABLE favoris(
   id_utilisateur INT,
   id_recit INT,
   date_ajout DATETIME NOT NULL,
   PRIMARY KEY(id_utilisateur, id_recit),
   FOREIGN KEY(id_utilisateur) REFERENCES utilisateurs(id_utilisateur),
   FOREIGN KEY(id_recit) REFERENCES recits(id_recit)
);

