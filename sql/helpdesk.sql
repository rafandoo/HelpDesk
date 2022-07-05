-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema helpdesk
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema helpdesk
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `helpdesk` DEFAULT CHARACTER SET utf8 ;
USE `helpdesk` ;

-- -----------------------------------------------------
-- Table `helpdesk`.`cidade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`cidade` (
    `idCidade` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(45) NOT NULL,
    `idEstado` INT NOT NULL,
    PRIMARY KEY (`idCidade`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`estado`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`estado` (
    `idEstado` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(45) NOT NULL,
    `sigla` VARCHAR(2) NOT NULL,
    PRIMARY KEY (`idEstado`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`cliente`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`cliente` (
    `idCliente` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(100) NOT NULL,
    `nomeFantasia` VARCHAR(100) NULL,
    `cpfCnpj` VARCHAR(18) NOT NULL,
    `endereco` VARCHAR(100) NULL,
    `idCidade` INT NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `telefone` VARCHAR(15) NULL,
    `observacoes` LONGTEXT NULL,
    `idUsuario` INT NOT NULL,
    `situacao` TINYINT NOT NULL,
    PRIMARY KEY (`idCliente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`usuario` (
    `idUsuario` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(20) NOT NULL,
    `sobrenome` VARCHAR(100) NULL,
    `email` VARCHAR(100) NOT NULL,
    `login` VARCHAR(50) NOT NULL,
    `senha` VARCHAR(40) NOT NULL,
    `nivelAcesso` INT NOT NULL,
    `setor` INT NOT NULL,
    `situacao` TINYINT NOT NULL,
    PRIMARY KEY (`idUsuario`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`ticket`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`ticket` (
    `idTicket` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `titulo` VARCHAR(100) NOT NULL,
    `descricao` LONGTEXT NULL,
    `dataAbertura` DATETIME NULL,
    `dataAtualizacao` DATETIME NULL,
    `dataFinalizacao` DATETIME NULL,
    `categoria` INT NOT NULL,
    `prioridade` INT NOT NULL,
    `status` INT NOT NULL,
    `idCliente` INT NOT NULL,
    `setor` INT NOT NULL,
    PRIMARY KEY (`idTicket`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`tramite`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`tramite` (
    `idTramite` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `horaInicial` TIME NULL,
    `horaFinal` TIME NULL,
    `descricao` LONGTEXT NULL,
    `idTicket` INT NOT NULL,
    PRIMARY KEY (`idTramite`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`nivelAcesso`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`nivelAcesso` (
    `idNivelAcesso` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(20) NOT NULL,
    PRIMARY KEY (`idNivelAcesso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`categoria`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`categoria` (
    `idCategoria` INT NOT NULL,
    `descricao` VARCHAR(30) NOT NULL,
    `situacao` TINYINT NOT NULL,
    PRIMARY KEY (`idCategoria`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`status`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`status` (
    `idStatus` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(15) NOT NULL,
    `situacao` TINYINT NOT NULL,
    PRIMARY KEY (`idStatus`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`prioridade`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`prioridade` (
    `idPrioridade` INT NOT NULL AUTO_INCREMENT,
    `descricao` VARCHAR(15) NOT NULL,
    `situacao` TINYINT NOT NULL,
    PRIMARY KEY (`idPrioridade`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`ordemServico`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`ordemServico` (
    `idOrdemServico` INT NOT NULL AUTO_INCREMENT,
    `valor` DOUBLE NULL,
    `idTicket` INT NOT NULL,
    PRIMARY KEY (`idOrdemServico`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `helpdesk`.`setor`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `helpdesk`.`setor` (
    `idSetor` INT NOT NULL,
    `descricao` VARCHAR(30) NOT NULL,
    `situacao` TINYINT NOT NULL,
    PRIMARY KEY (`idSetor`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
