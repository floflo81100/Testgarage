CREATE TABLE users (
  -- un identifiant unique pour chaque utilisateur, auto-incrémenté
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- le prénom de l'utilisateur
  prenom VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- le nom de famille de l'utilisateur
  nom VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- le nom d'utilisateur pour l'authentification
  username VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- le mot de passe pour l'authentification
  password VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- la profession ou le poste de l'utilisateur; peut être NULL
  job VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- le rôle de l'utilisateur dans le système
  role VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
