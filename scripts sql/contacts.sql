CREATE TABLE contacts (
  -- un identifiant unique pour chaque contact, auto-incrémenté
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- l'identifiant du visiteur qui a soumis le contact; peut être NULL
  visitor_id INT(11) DEFAULT NULL,
  
  -- le nom de la personne à contacter; ne peut pas être NULL
  name VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- l'email de la personne à contacter; ne peut pas être NULL
  email VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- le message laissé par la personne à contacter; ne peut pas être NULL
  message TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- la date et l'heure de création du contact avec la valeur par défaut à la date et heure actuelle
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
