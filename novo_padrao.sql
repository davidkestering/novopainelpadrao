-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 13-Abr-2020 às 20:27
-- Versão do servidor: 10.1.37-MariaDB
-- versão do PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `novo_padrao`
--
CREATE DATABASE IF NOT EXISTS `novo_padrao` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `novo_padrao`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_categoria_tipo_transacao`
--

DROP TABLE IF EXISTS `seg_categoria_tipo_transacao`;
CREATE TABLE IF NOT EXISTS `seg_categoria_tipo_transacao` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descricao` varchar(255) NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `descricao` (`descricao`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `seg_categoria_tipo_transacao`
--

INSERT INTO `seg_categoria_tipo_transacao` (`id`, `descricao`, `dt_cadastro`, `publicado`, `ativo`) VALUES
(1, 'Permissao', '2020-02-09 14:50:51', 1, 1),
(2, 'Acesso', '2020-02-09 14:50:11', 1, 1),
(3, 'Grupos', '2020-02-09 14:50:33', 1, 1),
(4, 'Usuario', '2011-12-22 10:00:00', 1, 1),
(5, 'Transacao', '2020-02-09 14:51:03', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_erros_mysql`
--

DROP TABLE IF EXISTS `seg_erros_mysql`;
CREATE TABLE IF NOT EXISTS `seg_erros_mysql` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `erro` longtext NOT NULL,
  `id_usuario` int(11) UNSIGNED DEFAULT NULL,
  `ip` longtext,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_grupo_usuario`
--

DROP TABLE IF EXISTS `seg_grupo_usuario`;
CREATE TABLE IF NOT EXISTS `seg_grupo_usuario` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nm_grupo_usuario` varchar(255) NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `nm_grupo_usuario` (`nm_grupo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `seg_grupo_usuario`
--

INSERT INTO `seg_grupo_usuario` (`id`, `nm_grupo_usuario`, `dt_cadastro`, `publicado`, `ativo`) VALUES
(1, 'Administrador', '2011-12-22 10:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_permissao`
--

DROP TABLE IF EXISTS `seg_permissao`;
CREATE TABLE IF NOT EXISTS `seg_permissao` (
  `id_tipo_transacao` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_grupo_usuario` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_tipo_transacao`,`id_grupo_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `seg_permissao`
--

INSERT INTO `seg_permissao` (`id_tipo_transacao`, `id_grupo_usuario`, `dt_cadastro`, `publicado`, `ativo`) VALUES
(1, 1, '2011-12-22 10:00:00', 1, 1),
(2, 1, '2011-12-22 10:00:00', 1, 1),
(3, 1, '2011-12-22 10:00:00', 1, 1),
(4, 1, '2011-12-22 10:00:00', 1, 1),
(5, 1, '2011-12-22 10:00:00', 1, 1),
(6, 1, '2011-12-22 10:00:00', 1, 1),
(7, 1, '2011-12-22 10:00:00', 1, 1),
(8, 1, '2011-12-22 10:00:00', 1, 1),
(9, 1, '2011-12-22 10:00:00', 1, 1),
(10, 1, '2011-12-22 10:00:00', 1, 1),
(11, 1, '2011-12-22 10:00:00', 1, 1),
(12, 1, '2011-12-22 10:00:00', 1, 1),
(13, 1, '2011-12-22 10:00:00', 1, 1),
(14, 1, '2011-12-22 10:00:00', 1, 1),
(15, 1, '2011-12-22 10:00:00', 1, 1),
(16, 1, '2011-12-22 10:00:00', 1, 1),
(17, 1, '2011-12-22 10:00:00', 1, 1),
(18, 1, '2011-12-22 10:00:00', 1, 1),
(19, 1, '2011-12-22 10:00:00', 1, 1),
(20, 1, '2011-12-22 10:00:00', 1, 1),
(21, 1, '2011-12-22 10:00:00', 1, 1),
(22, 1, '2011-12-22 10:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_tipo_transacao`
--

DROP TABLE IF EXISTS `seg_tipo_transacao`;
CREATE TABLE IF NOT EXISTS `seg_tipo_transacao` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_categoria_tipo_transacao` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `transacao` varchar(255) NOT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `categoria_tipo_transacao` (`id_categoria_tipo_transacao`,`transacao`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `seg_tipo_transacao`
--

INSERT INTO `seg_tipo_transacao` (`id`, `id_categoria_tipo_transacao`, `transacao`, `dt_cadastro`, `publicado`, `ativo`) VALUES
(1, 1, 'Alterar', '2011-12-22 10:00:00', 1, 1),
(2, 2, 'Login', '2011-12-22 10:00:00', 1, 1),
(3, 2, 'Logout', '2011-12-22 10:00:00', 1, 1),
(4, 3, 'Visualizar', '2011-12-22 10:00:00', 1, 1),
(5, 3, 'Alterar', '2011-12-22 10:00:00', 1, 1),
(6, 3, 'Cadastrar', '2011-12-22 10:00:00', 1, 1),
(7, 3, 'Excluir', '2011-12-22 10:00:00', 1, 1),
(8, 3, 'Desativar', '2011-12-22 10:00:00', 1, 1),
(9, 4, 'Visualizar', '2011-12-22 10:00:00', 1, 1),
(10, 4, 'Alterar', '2011-12-22 10:00:00', 1, 1),
(11, 4, 'AlterarSenha', '2011-12-22 10:00:00', 1, 1),
(12, 4, 'Cadastrar', '2011-12-22 10:00:00', 1, 1),
(13, 4, 'Excluir', '2011-12-22 10:00:00', 1, 1),
(14, 4, 'Desativar', '2011-12-22 10:00:00', 1, 1),
(15, 5, 'Visualizar', '2011-12-22 10:00:00', 1, 1),
(16, 5, 'Alterar', '2011-12-22 10:00:00', 1, 1),
(17, 5, 'Cadastrar', '2011-12-22 10:00:00', 1, 1),
(18, 5, 'Excluir', '2011-12-22 10:00:00', 1, 1),
(19, 5, 'Desativar', '2011-12-22 10:00:00', 1, 1),
(20, 5, 'VerLog', '2011-12-22 10:00:00', 1, 1),
(21, 5, 'VerErro', '2011-12-22 10:00:00', 1, 1),
(22, 5, 'VerErrosMySQL', '2011-12-22 10:00:00', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_transacao`
--

DROP TABLE IF EXISTS `seg_transacao`;
CREATE TABLE IF NOT EXISTS `seg_transacao` (
  `id` bigint(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tipo_transacao` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_usuario` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_objeto` varchar(255) NOT NULL,
  `campo` longtext NOT NULL,
  `valor_antigo` longtext NOT NULL,
  `valor_novo` longtext NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_transacao_acesso`
--

DROP TABLE IF EXISTS `seg_transacao_acesso`;
CREATE TABLE IF NOT EXISTS `seg_transacao_acesso` (
  `id` bigint(50) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tipo_transacao` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_usuario` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `id_objeto` varchar(255) NOT NULL,
  `objeto` longtext NOT NULL,
  `campo` longtext NOT NULL,
  `valor_antigo` longtext NOT NULL,
  `valor_novo` longtext NOT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `seg_transacao_acesso`
--

INSERT INTO `seg_transacao_acesso` (`id`, `id_tipo_transacao`, `id_usuario`, `id_objeto`, `objeto`, `campo`, `valor_antigo`, `valor_novo`, `ip`, `dt_cadastro`, `publicado`, `ativo`) VALUES
(1, 2, 1, '0', 'Login efetuado com sucesso. Login do usuário: david', '', '', '', '127.0.0.1', '2020-02-11 11:26:32', 1, 1),
(2, 4, 1, '0', 'ACESSO PERMITIDO', '', '', '', '127.0.0.1', '2020-02-11 11:26:50', 1, 1),
(3, 15, 1, '0', 'ACESSO PERMITIDO', '', '', '', '127.0.0.1', '2020-02-11 11:26:57', 1, 1),
(4, 4, 1, '0', 'ACESSO PERMITIDO', '', '', '', '127.0.0.1', '2020-02-11 11:27:01', 1, 1),
(5, 1, 1, '1', 'ACESSO PERMITIDO', '', '', '', '127.0.0.1', '2020-02-11 11:27:03', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `seg_usuario`
--

DROP TABLE IF EXISTS `seg_usuario`;
CREATE TABLE IF NOT EXISTS `seg_usuario` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_grupo_usuario` int(11) UNSIGNED NOT NULL DEFAULT '0',
  `nm_usuario` varchar(255) NOT NULL,
  `login` varchar(255) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `logado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `dt_cadastro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `publicado` tinyint(1) UNSIGNED NOT NULL DEFAULT '0',
  `ativo` tinyint(1) UNSIGNED NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `seg_usuario`
--

INSERT INTO `seg_usuario` (`id`, `id_grupo_usuario`, `nm_usuario`, `login`, `senha`, `email`, `logado`, `dt_cadastro`, `publicado`, `ativo`) VALUES
(1, 1, 'Dávìd Këstêrîng', 'david', '123456', 'davidkestering@gmail.com', 1, '2011-12-22 10:20:34', 1, 1),
(2, 1, 'Teste', 'teste', '123456', 'teste@gmail.com', 0, '2020-02-11 10:42:59', 1, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
