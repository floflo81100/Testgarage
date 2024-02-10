CREATE TABLE schedules (
  -- un identifiant unique pour chaque créneau horaire, auto-incrémenté
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- le jour de la semaine pour le créneau horaire
  day VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  
  -- l'heure d'ouverture pour le jour spécifié
  opening_hour TIME NOT NULL,
  
  -- l'heure de fermeture pour le jour spécifié
  closing_hour TIME NOT NULL,
  
  -- la date et l'heure de création de l'entrée du créneau horaire avec la valeur par défaut à la date et heure actuelle
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
