-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 15-Jan-2023 às 23:36
-- Versão do servidor: 5.6.12-log
-- versão do PHP: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `teste_quality_php`
--
CREATE DATABASE IF NOT EXISTS `teste_quality_php` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `teste_quality_php`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `idUsuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `DataHoraCadastro` datetime NOT NULL,
  `Codigo` varchar(15) NOT NULL,
  `Nome` varchar(150) NOT NULL,
  `CPF_CNPJ` varchar(20) NOT NULL,
  `CEP` int(11) NOT NULL,
  `Logradouro` varchar(100) NOT NULL,
  `Endereco` varchar(120) NOT NULL,
  `Numero` varchar(20) NOT NULL,
  `Bairro` varchar(50) NOT NULL,
  `Cidade` varchar(60) NOT NULL,
  `UF` varchar(2) NOT NULL,
  `Complemento` varchar(150) NOT NULL,
  `Fone` varchar(15) NOT NULL,
  `LimiteCredito` float(9,2) NOT NULL,
  `Validade` date NOT NULL,
  PRIMARY KEY (`idUsuario`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`idUsuario`, `DataHoraCadastro`, `Codigo`, `Nome`, `CPF_CNPJ`, `CEP`, `Logradouro`, `Endereco`, `Numero`, `Bairro`, `Cidade`, `UF`, `Complemento`, `Fone`, `LimiteCredito`, `Validade`) VALUES
(1, '2023-01-15 17:47:55', '001', 'teste 01', '058.015.343-69', 63107, 'Rua Padre Arnaldo de Melo', '', '455', 'Sossego', 'Crato', 'CE', 'casa', '(88) 88888-8888', 230000.00, '2023-10-05'),
(2, '2023-01-15 18:03:08', '002', 'teste 03', '121.545.487-74', 63107310, 'Rua Padre Arnaldo de Melo', '', '545', 'Sossego', 'Crato', 'CE', 'FDDSF', '(87) 87787-8888', 1200.00, '2023-02-10');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarioslogin`
--

CREATE TABLE IF NOT EXISTS `usuarioslogin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(250) NOT NULL,
  `login` varchar(250) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `nivel` int(2) NOT NULL,
  `ativo` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `usuarioslogin`
--

INSERT INTO `usuarioslogin` (`id`, `nome`, `login`, `senha`, `nivel`, `ativo`) VALUES
(1, 'Teste', 'teste@email.com', '4406285f2336d66c4e74dadbd8ba3d645a6d1de1', 1, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
