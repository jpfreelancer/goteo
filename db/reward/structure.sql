CREATE TABLE IF NOT EXISTS reward (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  project varchar(50) NOT NULL,
  reward varchar(256),
  description tinytext,
  `type` varchar(50) DEFAULT NULL,
  icon varchar(50) DEFAULT NULL,
  license varchar(50) DEFAULT NULL,
  amount int(5) DEFAULT NULL,
  units int(5) DEFAULT NULL,
  `fulfilled` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Retorno cumplido',
  PRIMARY KEY (id),
  UNIQUE KEY id (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Retornos colectivos e individuales';



-- Alteraciones de la tabla original por si no se puede pasar el create de arriba
ALTER TABLE `reward` ADD `description` TINYTEXT NULL AFTER `reward` ;
ALTER TABLE `reward` CHANGE `reward` `reward` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

-- Cambiando ids numéricos por SERIAL
ALTER TABLE `reward` CHANGE `id` `id` SERIAL NOT NULL AUTO_INCREMENT;

-- Para marcar retornos colectivos como cumplidos
ALTER TABLE `reward` ADD `fulfilled` BOOLEAN NOT NULL DEFAULT '0' COMMENT 'Retorno cumplido';