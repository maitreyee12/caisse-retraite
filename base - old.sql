-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Mer 08 Juin 2011 à 20:11
-- Version du serveur: 5.1.36
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Base de données: `caisse-retraite`
--

-- --------------------------------------------------------

--
-- Structure de la table `adherent`
--

CREATE TABLE IF NOT EXISTS `adherent` (
  `Id_utilisateur` int(11) NOT NULL,
  `Id_carriere` int(11) DEFAULT NULL,
  `Nom` varchar(254) DEFAULT NULL,
  `Prenom` varchar(254) DEFAULT NULL,
  `NumSS` int(15) DEFAULT NULL,
  `Telephone` int(11) DEFAULT NULL,
  `E_mail` varchar(254) DEFAULT NULL,
  `Adresse` varchar(254) DEFAULT NULL,
  `Statut` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `adherent`
--

INSERT INTO `adherent` (`Id_utilisateur`, `Id_carriere`, `Nom`, `Prenom`, `NumSS`, `Telephone`, `E_mail`, `Adresse`, `Statut`) VALUES
(4, 1, 'Tilendier', 'Pierre', 2147483647, 674320263, 'pierre_tilendier@bro.org', '3 rue Claude Bernard 77000 LA ROCHETTE', 'salarie');

-- --------------------------------------------------------

--
-- Structure de la table `caisse`
--

CREATE TABLE IF NOT EXISTS `caisse` (
  `Id_utilisateur` int(11) NOT NULL,
  `Nom_caisse` varchar(254) DEFAULT NULL,
  `Adresse` varchar(254) DEFAULT NULL,
  `Num_tel` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `caisse`
--


-- --------------------------------------------------------

--
-- Structure de la table `carriere`
--

CREATE TABLE IF NOT EXISTS `carriere` (
  `Id_carriere` int(11) NOT NULL,
  `Id_utilisateur` int(11) NOT NULL,
  `Trimestre_cumul` int(11) DEFAULT NULL,
  `Points_cumul` int(11) DEFAULT NULL,
  `Droit_depart` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`Id_carriere`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `carriere`
--


-- --------------------------------------------------------

--
-- Structure de la table `courrier`
--

CREATE TABLE IF NOT EXISTS `courrier` (
  `Id_courrier` int(11) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `Type` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`Id_courrier`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `courrier`
--


-- --------------------------------------------------------

--
-- Structure de la table `declaration`
--

CREATE TABLE IF NOT EXISTS `declaration` (
  `Id_declaration` int(11) NOT NULL,
  `Id_utilisateur` int(11) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_declaration`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `declaration`
--


-- --------------------------------------------------------

--
-- Structure de la table `demande`
--

CREATE TABLE IF NOT EXISTS `demande` (
  `Id_demande` int(11) NOT NULL AUTO_INCREMENT,
  `Id_courrier` int(11) DEFAULT NULL,
  `Id_utilisateur` int(11) DEFAULT NULL,
  `Commentaires` varchar(254) DEFAULT NULL,
  `Date_demande` datetime DEFAULT NULL,
  `Etat` int(11) NOT NULL DEFAULT '0',
  `Type` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`Id_demande`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `demande`
--

INSERT INTO `demande` (`Id_demande`, `Id_courrier`, `Id_utilisateur`, `Commentaires`, `Date_demande`, `Etat`, `Type`) VALUES
(1, NULL, NULL, '', '2011-05-28 11:49:42', 0, 'demande affiliation');

-- --------------------------------------------------------

--
-- Structure de la table `demande_affiliation`
--

CREATE TABLE IF NOT EXISTS `demande_affiliation` (
  `Id_demande` int(11) NOT NULL,
  `Nom` varchar(250) NOT NULL,
  `Num_siret` int(14) DEFAULT NULL,
  `E_mail` varchar(254) DEFAULT NULL,
  `Password` varchar(254) DEFAULT NULL,
  `Adresse` varchar(254) DEFAULT NULL,
  `Telephone` int(10) DEFAULT NULL,
  `Nombre_employes` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_demande`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `demande_affiliation`
--

INSERT INTO `demande_affiliation` (`Id_demande`, `Nom`, `Num_siret`, `E_mail`, `Password`, `Adresse`, `Telephone`, `Nombre_employes`) VALUES
(1, 'BPRD', 2147483647, 'intendance@bprd.fr', 'c2c978831301ebad4838d62b2c13b20e', '42 avenue des champs elysee 75016 PAris', 123456789, 14);

-- --------------------------------------------------------

--
-- Structure de la table `demande_modification_carriere`
--

CREATE TABLE IF NOT EXISTS `demande_modification_carriere` (
  `Id_demande` int(11) NOT NULL,
  `Periode` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`Id_demande`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `demande_modification_carriere`
--


-- --------------------------------------------------------

--
-- Structure de la table `demande_rachat`
--

CREATE TABLE IF NOT EXISTS `demande_rachat` (
  `Id_demande` int(11) NOT NULL,
  `Nombre_trimestre` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_demande`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `demande_rachat`
--


-- --------------------------------------------------------

--
-- Structure de la table `demande_reversion`
--

CREATE TABLE IF NOT EXISTS `demande_reversion` (
  `Id_demande` int(11) NOT NULL,
  `Id_reversion` int(11) DEFAULT NULL,
  `Num_SS_conjoint` int(11) DEFAULT NULL,
  `Nom_conjoint` varchar(254) DEFAULT NULL,
  `Date_mariage` datetime DEFAULT NULL,
  `Date_divorse` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_demande`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `demande_reversion`
--


-- --------------------------------------------------------

--
-- Structure de la table `documents`
--

CREATE TABLE IF NOT EXISTS `documents` (
  `Id_document` int(11) NOT NULL,
  `Id_courrier` int(11) NOT NULL,
  `Id_periode` int(11) NOT NULL,
  `Id_demande` int(11) DEFAULT NULL,
  `Nom_document` varchar(254) DEFAULT NULL,
  `Date_ajout` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_document`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `documents`
--


-- --------------------------------------------------------

--
-- Structure de la table `employe_caisse`
--

CREATE TABLE IF NOT EXISTS `employe_caisse` (
  `Id_utilisateur` int(11) NOT NULL,
  `Nom` varchar(254) DEFAULT NULL,
  `Prenom` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `employe_caisse`
--

INSERT INTO `employe_caisse` (`Id_utilisateur`, `Nom`, `Prenom`) VALUES
(3, 'Santus', 'Brice'),
(1, 'Chapel', 'Jean-Philippe'),
(2, 'Domingues', 'Nicolas');

-- --------------------------------------------------------

--
-- Structure de la table `entreprise`
--

CREATE TABLE IF NOT EXISTS `entreprise` (
  `Id_utilisateur` int(11) NOT NULL,
  `Num_siret` varchar(254) DEFAULT NULL,
  `Nom_entreprise` varchar(254) DEFAULT NULL,
  `Nombre_salarie` int(11) DEFAULT NULL,
  `Nombre_cadre` int(11) DEFAULT NULL,
  `Adresse` varchar(254) DEFAULT NULL,
  `Num_tel` int(11) DEFAULT NULL,
  `E_mail` varchar(254) DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `entreprise`
--

INSERT INTO `entreprise` (`Id_utilisateur`, `Num_siret`, `Nom_entreprise`, `Nombre_salarie`, `Nombre_cadre`, `Adresse`, `Num_tel`, `E_mail`) VALUES
(5, '12342536782351', 'Entreprise test', 5, 3, 'adresse de l''entreprise', 123627381, 'entreprise@mail.com');

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `Id_note` int(11) NOT NULL AUTO_INCREMENT,
  `Id_demande` int(11) NOT NULL,
  `Id_utilisateur` int(11) NOT NULL,
  `Date_soumission` datetime NOT NULL,
  `Contenu` text NOT NULL,
  PRIMARY KEY (`Id_note`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `note`
--


-- --------------------------------------------------------

--
-- Structure de la table `periode`
--

CREATE TABLE IF NOT EXISTS `periode` (
  `Id_periode` int(11) NOT NULL,
  `Id_carriere` int(11) NOT NULL,
  `Date_debut` datetime DEFAULT NULL,
  `Date_fin` datetime DEFAULT NULL,
  `Nom_Entreprise` varchar(254) DEFAULT NULL,
  `Salaire_percu` float DEFAULT NULL,
  `Points_ARRCO` int(11) DEFAULT NULL,
  `Points_AGIRC` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_periode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `periode`
--


-- --------------------------------------------------------

--
-- Structure de la table `prelevement`
--

CREATE TABLE IF NOT EXISTS `prelevement` (
  `Id_prelevement` int(11) NOT NULL,
  `Id_utilisateur` int(11) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Montant` float DEFAULT NULL,
  PRIMARY KEY (`Id_prelevement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `prelevement`
--


-- --------------------------------------------------------

--
-- Structure de la table `retraite`
--

CREATE TABLE IF NOT EXISTS `retraite` (
  `Id_retraite` int(11) NOT NULL,
  `Montant_mensuel` int(11) DEFAULT NULL,
  `Date_de_debut` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_retraite`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `retraite`
--


-- --------------------------------------------------------

--
-- Structure de la table `retraites`
--

CREATE TABLE IF NOT EXISTS `retraites` (
  `Id_utilisateur` int(11) NOT NULL,
  `Id_retraite` int(11) DEFAULT NULL,
  `Date_depart_retraite` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `retraites`
--


-- --------------------------------------------------------

--
-- Structure de la table `reversion`
--

CREATE TABLE IF NOT EXISTS `reversion` (
  `Id_reversion` int(11) NOT NULL AUTO_INCREMENT,
  `Id_demande` int(11) DEFAULT NULL,
  `Id_utilisateur` int(11) NOT NULL,
  `Id_retraite` int(11) NOT NULL,
  `Date_debut` datetime DEFAULT NULL,
  `Montant` float DEFAULT NULL,
  PRIMARY KEY (`Id_reversion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `reversion`
--


-- --------------------------------------------------------

--
-- Structure de la table `rib`
--

CREATE TABLE IF NOT EXISTS `rib` (
  `Id_RIB` int(11) NOT NULL AUTO_INCREMENT,
  `Id_courrier` int(11) NOT NULL,
  `Num_compte` int(11) DEFAULT NULL,
  `ID_banque` int(11) DEFAULT NULL,
  `Num_guichet` int(11) DEFAULT NULL,
  `Nom_banque` varchar(254) DEFAULT NULL,
  `Nom_titulaire` varchar(254) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  PRIMARY KEY (`Id_RIB`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `rib`
--


-- --------------------------------------------------------

--
-- Structure de la table `salarie`
--

CREATE TABLE IF NOT EXISTS `salarie` (
  `Id_utilisateur` int(11) NOT NULL,
  `Id_entreprise` int(11) NOT NULL,
  `Salaire` float DEFAULT NULL,
  `Nombre_trimestre` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `salarie`
--

INSERT INTO `salarie` (`Id_utilisateur`, `Id_entreprise`, `Salaire`, `Nombre_trimestre`) VALUES
(4, 5, 2500, 45);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE IF NOT EXISTS `utilisateur` (
  `Id_utilisateur` int(11) NOT NULL,
  `Login` varchar(254) DEFAULT NULL,
  `Password` varchar(254) DEFAULT NULL,
  `Droits` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id_utilisateur`),
  UNIQUE KEY `Login` (`Login`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`Id_utilisateur`, `Login`, `Password`, `Droits`) VALUES
(1, 'jpc', 'uown9n', 3),
(2, 'nico', 'caisse', 3),
(3, 'brice', 'brice', 3),
(4, 'salarie', 'salarie', 0),
(5, 'entreprise', 'entreprise', 2);

-- --------------------------------------------------------

--
-- Structure de la table `versement`
--

CREATE TABLE IF NOT EXISTS `versement` (
  `Id_versement` int(11) NOT NULL AUTO_INCREMENT,
  `Id_retraite` int(11) NOT NULL,
  `Id_reversion` int(11) NOT NULL,
  `Date` datetime DEFAULT NULL,
  `Montant` float DEFAULT NULL,
  PRIMARY KEY (`Id_versement`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `versement`
--

