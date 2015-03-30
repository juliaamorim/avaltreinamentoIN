CREATE DATABASE `avaltreinamento` /*!40100 DEFAULT CHARACTER SET latin1 */;

DROP TABLE IF EXISTS `avaltreinamento`.`empresas`;
CREATE TABLE  `avaltreinamento`.`empresas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `avaltreinamento`.`aval`;
CREATE TABLE  `avaltreinamento`.`aval` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `dt_criacao` datetime NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `aberta` tinyint(1) NOT NULL,
  `id_empresa` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_empresa_aval` (`id_empresa`),
  CONSTRAINT `id_empresa_aval` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `avaltreinamento`.`formularios`;
CREATE TABLE  `avaltreinamento`.`formularios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `descricao` varchar(255) NOT NULL,
  `id_aval` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_aval_formulario` (`id_aval`),
  CONSTRAINT `id_aval_formulario` FOREIGN KEY (`id_aval`) REFERENCES `aval` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `avaltreinamento`.`perguntas`;
CREATE TABLE  `avaltreinamento`.`perguntas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `enunciado` varchar(255) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  `id_formulario` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_formulario_perguntas` (`id_formulario`),
  CONSTRAINT `id_formulario_perguntas` FOREIGN KEY (`id_formulario`) REFERENCES `formularios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `avaltreinamento`.`respostas`;
CREATE TABLE  `avaltreinamento`.`respostas` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `resposta` varchar(255) NOT NULL,
  `tipo` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `avaltreinamento`.`usuarios`;
CREATE TABLE  `avaltreinamento`.`usuarios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(45) NOT NULL,
  `email` varchar(45) NOT NULL,
  `senha` varchar(45) NOT NULL,
  `nivel` varchar(45) NOT NULL,
  `id_empresa` int(10) unsigned NOT NULL,
  `ativo` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_empresa_usuario` (`id_empresa`),
  CONSTRAINT `id_empresa_usuario` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `avaltreinamento`.`empresas` (`id`, `nome`) VALUES 
(NULL, 'Empresa A'), 
(NULL, 'Empresa B');

INSERT INTO `avaltreinamento`.`usuarios` (`id`, `nome`, `email`, `senha`, `nivel`, `id_empresa`, `ativo`) VALUES 
(NULL, 'Deus', 'deus@injunior.com.br', '74ace46842e0fb130fa055e5c609dad6de76a208', 'adminDeus', '1', '1'), #senha=deus
(NULL, 'Geral', 'geral@injunior.com.br', '370de8b18c461dff0c7f0ffef315fcfb8a3d7eb7', 'adminGeral', '2', '1'), #senha=geral
(NULL, 'Admin', 'admin@injunior.com.br', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin', '2', '1'), #senha=admin
(NULL, 'Usuário', 'usuario@injunior.com.br', 'b665e217b51994789b02b1838e730d6b93baa30f', 'usuario', '2', '1'); #senha=usuario