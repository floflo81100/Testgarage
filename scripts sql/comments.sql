CREATE TABLE comments (
  -- un identifiant unique pour chaque commentaire, auto-incrémenté
  id INT(11) NOT NULL AUTO_INCREMENT,
  
  -- l'identifiant du visiteur qui a laissé le commentaire; peut être NULL
  visitor_id INT(11) DEFAULT NULL,
  
  -- le contenu du commentaire; peut être NULL
  content TEXT CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  
  -- la date et l'heure de soumission du commentaire avec la valeur par défaut à la date et heure actuelle
  submitted_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  
  -- un petit entier pour indiquer si le commentaire est approuvé (1) ou non (0) avec une valeur par défaut de 0
  is_approved TINYINT(1) DEFAULT 0,
  
  -- une note ou évaluation donnée avec le commentaire; peut être NULL
  rating INT(11) DEFAULT NULL,
  
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
