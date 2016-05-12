DROP TABLE  IF EXISTS paniers,commandes, jeux, users, typeJeux, etats;

-- --------------------------------------------------------
-- Structure de la table typejeux
--
CREATE TABLE IF NOT EXISTS typeJeux (
  id int(10) NOT NULL,
  libelle varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
)  DEFAULT CHARSET=utf8;
-- Contenu de la table typejeux
INSERT INTO typejeux (id, libelle) VALUES
(1, 'action'),
(2, 'aventure'),
(3, 'rpg');

-- --------------------------------------------------------
-- Structure de la table etats

CREATE TABLE IF NOT EXISTS etats (
  id int(11) NOT NULL AUTO_INCREMENT,
  libelle varchar(20) NOT NULL,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8 ;
-- Contenu de la table etats
INSERT INTO etats (id, libelle) VALUES
(1, 'A preparer'),
(2, 'Expedition');

-- --------------------------------------------------------
-- Structure de la table jeux

CREATE TABLE IF NOT EXISTS jeux (
  id int(10) NOT NULL AUTO_INCREMENT,
  typeJeux_id int(10) DEFAULT NULL,
  nom varchar(50) DEFAULT NULL,
  prix float(6,2) DEFAULT NULL,
  photo varchar(50) DEFAULT NULL,
  plateforme varchar(50) DEFAULT NULL,
  dispo int(4) NOT NULL,
  stock int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_jeux_typeJeux FOREIGN KEY (typeJeux_id) REFERENCES typeJeux (id)
) DEFAULT CHARSET=utf8 ;

INSERT INTO jeux (id,typeJeux_id,nom,prix,photo,plateforme,dispo,stock) VALUES
(1,1, 'Battlefield 4','40','Battlefield_4.jpeg','PS4',1,5),
(2,2, 'Rise of the Tomb Raider','50','Rise_of_the_Tomb_Raider.jpeg','PC',1,4),
(3,3, 'Dragon Quest 8','30','dragon_quest_8.jpeg','PS2',1,10);


-- --------------------------------------------------------
-- Structure de la table user
-- valide permet de rendre actif le compte (exemple controle par email )

CREATE TABLE IF NOT EXISTS users (
  id int(11) NOT NULL AUTO_INCREMENT,
  email varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  login varchar(255) NOT NULL,
  nom varchar(255) DEFAULT NULL,
  code_postal varchar(255) DEFAULT NULL,
  ville varchar(255) DEFAULT NULL,
  adresse varchar(255) DEFAULT NULL,
  valide tinyint NOT NULL,
  droit varchar(255) NOT NULL,
  PRIMARY KEY (id)
) DEFAULT CHARSET=utf8;

-- Contenu de la table users
INSERT INTO users (id,login,password,email,valide,droit) VALUES
(1, 'admin', 'admin', 'admin@gmail.com',1,'DROITadmin'),
(2, 'vendeur', 'vendeur', 'vendeur@gmail.com',1,'DROITadmin'),
(3, 'client', 'client', 'client@gmail.com',1,'DROITclient'),
(4, 'client2', 'client2', 'client2@gmail.com',1,'DROITclient'),
(5, 'client3', 'client3', 'client3@gmail.com',1,'DROITclient');



-- --------------------------------------------------------
-- Structure de la table commandes
CREATE TABLE IF NOT EXISTS commandes (
  id int(11) NOT NULL AUTO_INCREMENT,
  user_id int(11) NOT NULL,
  prix float(6,2) NOT NULL,
  date_achat date NOT NULL,
  etat_id int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_commandes_users FOREIGN KEY (user_id) REFERENCES users (id),
  CONSTRAINT fk_commandes_etats FOREIGN KEY (etat_id) REFERENCES etats (id)
) DEFAULT CHARSET=utf8 ;



-- --------------------------------------------------------
-- Structure de la table paniers
CREATE TABLE IF NOT EXISTS paniers (
  id int(11) NOT NULL AUTO_INCREMENT,
  quantite int(11) NOT NULL,
  prix float(6,2) NOT NULL,
  dateAjoutPanier timestamp default CURRENT_TIMESTAMP,
  user_id int(11) NOT NULL,
  jeux_id int(11) NOT NULL,
  commande_id int(11) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_paniers_users FOREIGN KEY (user_id) REFERENCES users (id),
  CONSTRAINT fk_paniers_jeux FOREIGN KEY (jeux_id) REFERENCES jeux (id),
  CONSTRAINT fk_paniers_commandes FOREIGN KEY (commande_id) REFERENCES commandes (id)
) DEFAULT CHARSET=utf8 ;

INSERT INTO paniers  (id,quantite,prix,user_id,jeux_id) VALUES
(1,1, '25',1,1);


