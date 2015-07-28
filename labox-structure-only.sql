/*
 Navicat Premium Data Transfer

 Source Server         : imac
 Source Server Type    : MySQL
 Source Server Version : 50624
 Source Host           : 88.167.74.237
 Source Database       : labox

 Target Server Type    : MySQL
 Target Server Version : 50624
 File Encoding         : utf-8

 Date: 07/29/2015 00:11:18 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `TBL_CODE_ERREUR`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_CODE_ERREUR`;
CREATE TABLE `TBL_CODE_ERREUR` (
  `IDCodeErreur` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDCodeErreur`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_CODE_ERREUR_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_CODE_ERREUR_TRAD`;
CREATE TABLE `TBL_CODE_ERREUR_TRAD` (
  `IDCodeErreur` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_DOSSIER_DE_FAB`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_DOSSIER_DE_FAB`;
CREATE TABLE `TBL_DOSSIER_DE_FAB` (
  `IDDossierDeFab` int(11) NOT NULL AUTO_INCREMENT,
  `Dossier` varchar(255) DEFAULT NULL,
  `Ref` varchar(255) DEFAULT NULL,
  `Quantite` int(11) DEFAULT NULL,
  `Commentaire` varchar(255) DEFAULT NULL,
  `DateExpedition` datetime DEFAULT NULL,
  `NbOption` int(11) DEFAULT NULL,
  `NbElement` int(11) DEFAULT NULL,
  `NbPose` int(11) DEFAULT '1',
  `NbMachine` int(11) DEFAULT '1',
  `EstAmalgame` int(1) NOT NULL DEFAULT '0',
  `EstPliable` int(1) NOT NULL DEFAULT '0',
  `EstCloture` int(1) NOT NULL DEFAULT '0',
  `LargeurOuvert` int(11) DEFAULT NULL,
  `HauteurOuvert` int(11) DEFAULT NULL,
  `LargeurFerme` int(11) DEFAULT NULL,
  `HauteurFerme` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDDossierDeFab`)
) ENGINE=InnoDB AUTO_INCREMENT=145 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_DOSSIER_DE_FAB_TL_ELEMENT`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_DOSSIER_DE_FAB_TL_ELEMENT`;
CREATE TABLE `TBL_DOSSIER_DE_FAB_TL_ELEMENT` (
  `IDDossierDeFab_tl_element` int(11) NOT NULL AUTO_INCREMENT,
  `IDDossierDeFab` int(11) DEFAULT NULL,
  `IDElement` varchar(11) DEFAULT NULL,
  `Quantite` int(11) DEFAULT NULL,
  `IDSupport` int(11) DEFAULT NULL,
  `IDFormat` int(11) DEFAULT NULL,
  `Commentaire` varchar(255) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  `IDImpression` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDDossierDeFab_tl_element`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE`;
CREATE TABLE `TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE` (
  `IDDossierDeFab_tl_element_tl_machine` int(11) NOT NULL AUTO_INCREMENT,
  `IDDossierDeFab_tl_element` int(11) DEFAULT NULL,
  `IDMachine` int(11) DEFAULT NULL,
  `IDImpression` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDDossierDeFab_tl_element_tl_machine`)
) ENGINE=InnoDB AUTO_INCREMENT=390 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION`;
CREATE TABLE `TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION` (
  `IDDossierDeFab_tl_element_tl_option` int(11) NOT NULL AUTO_INCREMENT,
  `IDDossierDeFab_tl_element` int(11) DEFAULT NULL,
  `IDOption` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDDossierDeFab_tl_element_tl_option`)
) ENGINE=InnoDB AUTO_INCREMENT=73 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_DOSSIER_DE_FAB_TL_OPTION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_DOSSIER_DE_FAB_TL_OPTION`;
CREATE TABLE `TBL_DOSSIER_DE_FAB_TL_OPTION` (
  `IDDossierDeFab_tl_option` int(11) NOT NULL AUTO_INCREMENT,
  `IDDossierDeFab` int(11) DEFAULT NULL,
  `IDOption` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDDossierDeFab_tl_option`)
) ENGINE=InnoDB AUTO_INCREMENT=81 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_ELEMENT`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_ELEMENT`;
CREATE TABLE `TBL_ELEMENT` (
  `IDElement` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDElement`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_ELEMENT_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_ELEMENT_TRAD`;
CREATE TABLE `TBL_ELEMENT_TRAD` (
  `IDElement` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FICHE_DE_PROD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FICHE_DE_PROD`;
CREATE TABLE `TBL_FICHE_DE_PROD` (
  `IDFicheDeProd` int(11) NOT NULL AUTO_INCREMENT,
  `IDDossierDeFab` int(11) DEFAULT NULL,
  `Dossier` varchar(255) DEFAULT NULL,
  `Ref` varchar(255) DEFAULT NULL,
  `Quantite` int(11) DEFAULT NULL,
  `Commentaire` varchar(255) DEFAULT NULL,
  `NbPose` int(11) DEFAULT '1',
  `IDSecteur` int(11) DEFAULT NULL,
  `IDMachine` int(11) DEFAULT NULL,
  `IDImpression` int(11) DEFAULT NULL,
  `IDElement` varchar(255) DEFAULT NULL,
  `IDSupport` int(11) DEFAULT NULL,
  `IDFormat` int(11) DEFAULT NULL,
  `IDSociete` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFicheDeProd`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FICHE_DE_PROD_TL_CODE_ERREUR`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FICHE_DE_PROD_TL_CODE_ERREUR`;
CREATE TABLE `TBL_FICHE_DE_PROD_TL_CODE_ERREUR` (
  `IDFicheDeProd_tl_code_erreur` int(11) NOT NULL AUTO_INCREMENT,
  `IDFicheDeProd` int(11) DEFAULT NULL,
  `IDCodeErreur` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFicheDeProd_tl_code_erreur`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FICHE_DE_PROD_TL_OPTION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FICHE_DE_PROD_TL_OPTION`;
CREATE TABLE `TBL_FICHE_DE_PROD_TL_OPTION` (
  `IDFicheDeProd_tl_option` int(11) NOT NULL AUTO_INCREMENT,
  `IDFicheDeProd` int(11) DEFAULT NULL,
  `IDOption` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFicheDeProd_tl_option`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FONCTION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FONCTION`;
CREATE TABLE `TBL_FONCTION` (
  `IDFonction` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFonction`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FONCTION_PT_PAGE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FONCTION_PT_PAGE`;
CREATE TABLE `TBL_FONCTION_PT_PAGE` (
  `IDFonction_pt_page` int(11) NOT NULL AUTO_INCREMENT,
  `IDFonction` int(11) DEFAULT NULL,
  `IDPage` int(11) DEFAULT NULL,
  `Permit` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFonction_pt_page`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FONCTION_TL_PAGE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FONCTION_TL_PAGE`;
CREATE TABLE `TBL_FONCTION_TL_PAGE` (
  `IDFonction_tl_page` int(11) NOT NULL AUTO_INCREMENT,
  `IDFonction` int(11) DEFAULT NULL,
  `IDPage` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFonction_tl_page`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FONCTION_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FONCTION_TRAD`;
CREATE TABLE `TBL_FONCTION_TRAD` (
  `IDFonction` int(11) NOT NULL,
  `Nom` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FORMAT`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FORMAT`;
CREATE TABLE `TBL_FORMAT` (
  `IDFormat` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFormat`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FORMAT_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FORMAT_TRAD`;
CREATE TABLE `TBL_FORMAT_TRAD` (
  `IDFormat` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FOURNISSEUR`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FOURNISSEUR`;
CREATE TABLE `TBL_FOURNISSEUR` (
  `IDFournisseur` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Adresse1` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Adresse2` varchar(255) DEFAULT NULL,
  `CodePostal` int(8) DEFAULT NULL,
  `Ville` varchar(255) DEFAULT NULL,
  `Pays` varchar(255) DEFAULT NULL,
  `Telephone` varchar(255) DEFAULT NULL,
  `Fax` varchar(255) DEFAULT NULL,
  `Mail` varchar(255) DEFAULT NULL,
  `Certification` varchar(255) DEFAULT NULL,
  `Activite` varchar(255) DEFAULT NULL,
  `CodeClient` varchar(255) DEFAULT NULL,
  `IDFournisseurType` int(11) DEFAULT NULL,
  `EstFournisseur` int(1) NOT NULL DEFAULT '0',
  `EstSousTraitant` int(1) NOT NULL DEFAULT '0',
  `EstPrestataire` int(1) NOT NULL DEFAULT '0',
  `ContactNom` varchar(255) DEFAULT NULL,
  `ContactPrenom` varchar(255) DEFAULT NULL,
  `ContactFonction` varchar(255) DEFAULT NULL,
  `ContactTelephone` varchar(255) DEFAULT NULL,
  `ContactFax` varchar(255) DEFAULT NULL,
  `ContactMail` varchar(255) DEFAULT NULL,
  `IDSociete` int(11) DEFAULT NULL,
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFournisseur`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FOURNISSEUR_TYPE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FOURNISSEUR_TYPE`;
CREATE TABLE `TBL_FOURNISSEUR_TYPE` (
  `IDFournisseurType` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDFournisseurType`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_FOURNISSEUR_TYPE_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_FOURNISSEUR_TYPE_TRAD`;
CREATE TABLE `TBL_FOURNISSEUR_TYPE_TRAD` (
  `IDFournisseurType` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_GROUPE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_GROUPE`;
CREATE TABLE `TBL_GROUPE` (
  `IDGroupe` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDGroupe`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_GROUPE_PT_MENU`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_GROUPE_PT_MENU`;
CREATE TABLE `TBL_GROUPE_PT_MENU` (
  `IDGroupe_pt_menu` int(11) NOT NULL AUTO_INCREMENT,
  `IDGroupe` int(11) DEFAULT NULL,
  `IDMenu` int(11) DEFAULT NULL,
  `Permit` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDGroupe_pt_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_GROUPE_TL_FONCTION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_GROUPE_TL_FONCTION`;
CREATE TABLE `TBL_GROUPE_TL_FONCTION` (
  `IDGroupe_tl_fonction` int(11) NOT NULL AUTO_INCREMENT,
  `IDGroupe` int(11) DEFAULT NULL,
  `IDFonction` int(11) DEFAULT NULL,
  `IDMembeAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDGroupe_tl_fonction`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_GROUPE_TL_MENU`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_GROUPE_TL_MENU`;
CREATE TABLE `TBL_GROUPE_TL_MENU` (
  `IDGroupe_tl_menu` int(11) NOT NULL AUTO_INCREMENT,
  `IDGroupe` int(11) DEFAULT NULL,
  `IDMenu` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDGroupe_tl_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_GROUPE_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_GROUPE_TRAD`;
CREATE TABLE `TBL_GROUPE_TRAD` (
  `IDGroupe` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_IMPRESSION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_IMPRESSION`;
CREATE TABLE `TBL_IMPRESSION` (
  `IDImpression` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `NbCalage` int(11) DEFAULT NULL,
  `NbTour` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDImpression`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_IMPRESSION_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_IMPRESSION_TRAD`;
CREATE TABLE `TBL_IMPRESSION_TRAD` (
  `IDImpression` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(11) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_LANGUE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_LANGUE`;
CREATE TABLE `TBL_LANGUE` (
  `IDLangue` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) DEFAULT NULL,
  `CodeBCP` varchar(255) DEFAULT NULL,
  `EstActif` int(1) DEFAULT '0',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDLangue`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_MACHINE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_MACHINE`;
CREATE TABLE `TBL_MACHINE` (
  `IDMachine` int(11) NOT NULL AUTO_INCREMENT,
  `CalageMin` int(11) NOT NULL DEFAULT '0',
  `CalageFeuilles` int(11) NOT NULL DEFAULT '0',
  `GachePour1000Feuilles` int(11) NOT NULL DEFAULT '0',
  `CadenceTourMin` int(11) NOT NULL DEFAULT '0',
  `2passages` int(1) NOT NULL DEFAULT '0',
  `IDSecteur` int(11) DEFAULT NULL,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDMachine`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_MACHINE_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_MACHINE_TRAD`;
CREATE TABLE `TBL_MACHINE_TRAD` (
  `IDMachine` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_MEMBRE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_MEMBRE`;
CREATE TABLE `TBL_MEMBRE` (
  `IDMembre` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Prenom` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Login` varchar(255) DEFAULT NULL,
  `Mail` varchar(255) DEFAULT NULL,
  `Telephone` varchar(14) DEFAULT NULL,
  `Pwd` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `IDFonction` int(11) DEFAULT '1',
  `IDSociete` int(11) DEFAULT NULL,
  `IDLangue` int(11) DEFAULT '1',
  `EstSu` int(1) NOT NULL DEFAULT '0',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDMembre`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_MEMBRE_ROW_PAGE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_MEMBRE_ROW_PAGE`;
CREATE TABLE `TBL_MEMBRE_ROW_PAGE` (
  `IDMembre` int(11) DEFAULT NULL,
  `IDPage` int(11) DEFAULT NULL,
  `NbRow` int(11) NOT NULL DEFAULT '10',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  KEY `IDMembre` (`IDMembre`),
  CONSTRAINT `tbl_membre_row_page_ibfk_2` FOREIGN KEY (`IDMembre`) REFERENCES `MEMBRE` (`IDMembre`) ON DELETE SET NULL ON UPDATE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_MENU`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_MENU`;
CREATE TABLE `TBL_MENU` (
  `IDMenu` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_MENU_TL_PAGE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_MENU_TL_PAGE`;
CREATE TABLE `TBL_MENU_TL_PAGE` (
  `IDMenu_tl_page` int(11) NOT NULL AUTO_INCREMENT,
  `IDMenu` int(11) DEFAULT NULL,
  `IDPage` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDMenu_tl_page`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_MENU_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_MENU_TRAD`;
CREATE TABLE `TBL_MENU_TRAD` (
  `IDMenu` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_OPTION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_OPTION`;
CREATE TABLE `TBL_OPTION` (
  `IDOption` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDOption`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_OPTION_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_OPTION_TRAD`;
CREATE TABLE `TBL_OPTION_TRAD` (
  `IDOption` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_PAGE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_PAGE`;
CREATE TABLE `TBL_PAGE` (
  `IDPage` int(11) NOT NULL AUTO_INCREMENT,
  `Classe` varchar(255) DEFAULT NULL,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '1',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDPage`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_PAGE_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_PAGE_TRAD`;
CREATE TABLE `TBL_PAGE_TRAD` (
  `IDPage` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_PLANNING_TL_ELEMENT_TL_MACHINE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_PLANNING_TL_ELEMENT_TL_MACHINE`;
CREATE TABLE `TBL_PLANNING_TL_ELEMENT_TL_MACHINE` (
  `IDDossierDeFab_tl_element_tl_machine` int(11) NOT NULL,
  `Ordre` int(5) DEFAULT '999',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDDossierDeFab_tl_element_tl_machine`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_RECLAME`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_RECLAME`;
CREATE TABLE `TBL_RECLAME` (
  `IDReclame` int(11) NOT NULL AUTO_INCREMENT,
  `IDReclameEtat` int(11) NOT NULL DEFAULT '1',
  `Dossier` varchar(255) DEFAULT NULL,
  `Ref` varchar(255) DEFAULT NULL,
  `Quantite` int(11) DEFAULT NULL,
  `DateExpedition` datetime DEFAULT NULL,
  `Demande` varchar(255) DEFAULT NULL,
  `Reponse` varchar(255) DEFAULT NULL,
  `IDMembreReponse` int(11) DEFAULT NULL,
  `DateReponse` datetime DEFAULT NULL,
  `IDSociete` int(11) DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDReclame`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_RECLAME_ETAT`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_RECLAME_ETAT`;
CREATE TABLE `TBL_RECLAME_ETAT` (
  `IDReclameEtat` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDReclameEtat`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_RECLAME_ETAT_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_RECLAME_ETAT_TRAD`;
CREATE TABLE `TBL_RECLAME_ETAT_TRAD` (
  `IDReclameEtat` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SECTEUR`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SECTEUR`;
CREATE TABLE `TBL_SECTEUR` (
  `IDSecteur` int(11) NOT NULL AUTO_INCREMENT,
  `Code` int(11) DEFAULT NULL,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSecteur`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SECTEUR_TL_CODE_ERREUR`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SECTEUR_TL_CODE_ERREUR`;
CREATE TABLE `TBL_SECTEUR_TL_CODE_ERREUR` (
  `IDSecteur_tl_code_erreur` int(11) NOT NULL AUTO_INCREMENT,
  `IDSecteur` int(11) DEFAULT NULL,
  `IDCodeErreur` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSecteur_tl_code_erreur`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SECTEUR_TL_IMPRESSION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SECTEUR_TL_IMPRESSION`;
CREATE TABLE `TBL_SECTEUR_TL_IMPRESSION` (
  `IDSecteur_tl_impression` int(11) NOT NULL AUTO_INCREMENT,
  `IDSecteur` int(11) DEFAULT NULL,
  `IDImpression` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSecteur_tl_impression`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SECTEUR_TL_OPTION`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SECTEUR_TL_OPTION`;
CREATE TABLE `TBL_SECTEUR_TL_OPTION` (
  `IDSecteur_tl_option` int(11) NOT NULL AUTO_INCREMENT,
  `IDSecteur` int(11) DEFAULT NULL,
  `IDOption` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSecteur_tl_option`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SECTEUR_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SECTEUR_TRAD`;
CREATE TABLE `TBL_SECTEUR_TRAD` (
  `IDSecteur` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SLOGAN`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SLOGAN`;
CREATE TABLE `TBL_SLOGAN` (
  `IDSlogan` int(11) NOT NULL AUTO_INCREMENT,
  `Slogan` varchar(255) DEFAULT NULL,
  `IDSociete` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSlogan`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SOCIETE`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SOCIETE`;
CREATE TABLE `TBL_SOCIETE` (
  `IDSociete` int(11) NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Adresse1` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `Adresse2` varchar(255) DEFAULT NULL,
  `CodePostal` int(8) DEFAULT NULL,
  `Ville` varchar(255) DEFAULT NULL,
  `Pays` varchar(255) DEFAULT NULL,
  `Mail` varchar(255) DEFAULT NULL,
  `Telephone` varchar(14) DEFAULT NULL,
  `IDMembreContact` int(11) DEFAULT NULL,
  `IDLangue` int(11) DEFAULT '1',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSociete`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SUPPORT`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SUPPORT`;
CREATE TABLE `TBL_SUPPORT` (
  `IDSupport` int(11) NOT NULL AUTO_INCREMENT,
  `IDSociete` int(11) DEFAULT NULL,
  `Ordre` int(11) NOT NULL DEFAULT '99',
  `EstActif` int(1) NOT NULL DEFAULT '1',
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSupport`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SUPPORT_TL_FORMAT`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SUPPORT_TL_FORMAT`;
CREATE TABLE `TBL_SUPPORT_TL_FORMAT` (
  `IDSupport_tl_format` int(11) NOT NULL AUTO_INCREMENT,
  `IDSupport` int(11) DEFAULT NULL,
  `IDFormat` int(11) DEFAULT NULL,
  `IDMembreAdd` int(11) DEFAULT NULL,
  `DateAdd` datetime DEFAULT NULL,
  `IDMembreMaj` int(11) DEFAULT NULL,
  `DateMaj` datetime DEFAULT NULL,
  `IDMembreSupp` int(11) DEFAULT NULL,
  `DateSupp` datetime DEFAULT NULL,
  `EstSupp` int(1) NOT NULL DEFAULT '0',
  `EstProtected` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`IDSupport_tl_format`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- ----------------------------
--  Table structure for `TBL_SUPPORT_TRAD`
-- ----------------------------
DROP TABLE IF EXISTS `TBL_SUPPORT_TRAD`;
CREATE TABLE `TBL_SUPPORT_TRAD` (
  `IDSupport` int(11) NOT NULL,
  `Nom` varchar(255) DEFAULT NULL,
  `IDLangue` int(4) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

SET FOREIGN_KEY_CHECKS = 1;
