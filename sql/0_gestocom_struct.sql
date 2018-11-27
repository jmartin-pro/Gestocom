-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Jeu 22 Novembre 2018 à 23:37
-- Version du serveur :  5.6.17-log
-- Version de PHP :  5.5.12
-- Auteur : Zakina Annouche

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  'gestocom'
--

-- --------------------------------------------------------
--
-- Structure de la table 'typedechet'
--

CREATE TABLE typedechet (
  TDEC_CODE varchar(1) NOT NULL DEFAULT '',
  TDEC_LIBELLE varchar(30) DEFAULT NULL,
  TDEC_TARIF decimal(8,5) DEFAULT NULL,
  CONSTRAINT PK_TYPEDECHET PRIMARY KEY (TDEC_CODE)
) ;

-- --------------------------------------------------------
--
-- Structure de la table 'usager'
--

CREATE TABLE usager (
  USG_ID int(11) NOT NULL AUTO_INCREMENT,
  USG_NOM varchar(30) NOT NULL,
  USG_PRENOM varchar(30) NOT NULL,
  USG_ADRESSE1 varchar(50) NOT NULL,
  USG_ADRESSE2 varchar(50) NOT NULL,
  USG_COPOS varchar(5) NOT NULL,
  USG_VILLE varchar(40) NOT NULL,
  USG_MAIL varchar(60) DEFAULT NULL,
  CONSTRAINT PK_USAGER PRIMARY KEY (USG_ID)
) ;

-- --------------------------------------------------------
--
-- Structure de la table 'habitation'
--

CREATE TABLE habitation (
  HAB_ID int(11) NOT NULL,
  HAB_ADRESSE1 varchar(50) NOT NULL,
  HAB_ADRESSE2 varchar(50) NOT NULL,
  HAB_COPOS varchar(5) NOT NULL,
  HAB_VILLE varchar(40) NOT NULL,
  HAB_USAGER int(11) DEFAULT NULL,
  CONSTRAINT PK_HABITATION PRIMARY KEY (HAB_ID)
) ;

-- --------------------------------------------------------
--
-- Structure de la table 'container'
--

CREATE TABLE container (
  CTN_HABITATION int(11) NOT NULL,
  CTN_ID int(11) NOT NULL,
  CTN_VOLUME decimal(7,2) DEFAULT NULL,
  CTN_POIDSBRUT decimal(7,2) DEFAULT NULL,
  CTN_CHARGEUTILE decimal(7,2) DEFAULT NULL,
  CTN_TYPEDECHET varchar(1) DEFAULT NULL,
  CONSTRAINT PK_CONTAINER PRIMARY KEY (CTN_HABITATION,CTN_ID)
);

-- --------------------------------------------------------
--
-- Structure de la table 'levee'
--

CREATE TABLE levee (
  LEV_HABITATION int(11) NOT NULL ,
  LEV_ID int(11) NOT NULL ,
  LEV_DATE date NOT NULL DEFAULT '0000-00-00',
  LEV_POIDS decimal(7,2) DEFAULT NULL,
  CONSTRAINT PRIMARY KEY (LEV_HABITATION,LEV_ID,LEV_DATE)
) ;


ALTER TABLE habitation 
ADD CONSTRAINT FK_HAB_USG FOREIGN KEY (HAB_USAGER) REFERENCES gestocom.usager(USG_ID) ;

ALTER TABLE container 
ADD CONSTRAINT FK_CTN_TYPEDECHET FOREIGN KEY (CTN_TYPEDECHET) REFERENCES gestocom.typedechet(TDEC_CODE) ;

ALTER TABLE levee 
ADD CONSTRAINT FK_LEV_CTN FOREIGN KEY (LEV_HABITATION,LEV_ID) REFERENCES gestocom.container(CTN_HABITATION, CTN_ID) ;
