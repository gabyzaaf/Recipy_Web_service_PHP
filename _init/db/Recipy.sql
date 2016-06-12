/**
-- DATABASE RECIPY
 */
CREATE DATABASE IF NOT EXISTS recipy;

USE recipy;

/**
-- Table user
 */
CREATE TABLE IF NOT EXISTS utilisateur (
  id INT NOT NULL AUTO_INCREMENT,
  nom VARCHAR(255),
  prenom VARCHAR(255),
  admin BOOLEAN DEFAULT FALSE,
  actif BOOLEAN DEFAULT TRUE,
  logins VARCHAR(255),
  pwd VARCHAR(255),
  email VARCHAR(255),
  naissance DATE,
  compte VARCHAR(100) DEFAULT 'autre',
  token VARCHAR(255),

  PRIMARY KEY (id)
);

/**
-- Table Recipy
TODO: une recette ne doit pas être supprimé en automatique
 */
CREATE TABLE IF NOT EXISTS recette (
  id INTEGER NOT NULL AUTO_INCREMENT,
  title VARCHAR(255),
  contenu TEXT,
  image_lien VARCHAR(255),
  visible BOOLEAN DEFAULT TRUE,
  partage BOOLEAN DEFAULT FALSE,
  fid INT NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (fid) REFERENCES utilisateur(id) ON DELETE CASCADE
);

/**
-- TABLE Favorite
 */

CREATE TABLE  IF NOT EXISTS favoris (
  id INTEGER NOT NULL AUTO_INCREMENT,
  fidutilisateur INT NOT NULL,
  fidrecette INT NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (fidutilisateur) REFERENCES utilisateur(id) ON DELETE CASCADE,
  FOREIGN KEY (fidrecette) REFERENCES recette(id) ON DELETE CASCADE
);

/**
-- Table comment
 */
CREATE TABLE IF NOT EXISTS commenter (
  id INT NOT NULL AUTO_INCREMENT,
  heure_saisie DATETIME,
  fidutilisateur INT NOT NULL,
  fidrecette INT NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (fidutilisateur) REFERENCES utilisateur(id) ON DELETE CASCADE,
  FOREIGN KEY (fidrecette) REFERENCES recette(id) ON DELETE CASCADE
);

/**
-- Table notation
 */
CREATE TABLE IF NOT EXISTS noter (
  id INT NOT NULL AUTO_INCREMENT,
  score DOUBLE DEFAULT 0,
  fidutilisateur INT NOT NULL,
  fidrecette INT NOT NULL,

  PRIMARY KEY (id),
  FOREIGN KEY (fidutilisateur) REFERENCES utilisateur(id) ON DELETE CASCADE,
  FOREIGN KEY (fidrecette) REFERENCES recette(id) ON DELETE CASCADE
);

SET SQL_SAFE_UPDATES = 0;
