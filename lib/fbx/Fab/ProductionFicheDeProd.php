<?php
/**
 *
 * Created by blond.
 * File: ProductionFicheDeProd.php
 * Date: 28/03/15 - 15:48
 *
 */

namespace fbx\Fab;


class ProductionFicheDeProd extends Select
{
    const ClassPage = 'ProductionFicheDeProd';

    public $_template = "Production/ProductionFicheDeProd.twig";

    //__insert TBL_FICHE_DE_PROD & TBL_FICHE_DE_PROD_TL_CODE_ERREUR & TBL_FICHE_DE_PROD_TL_OPTION
    public function getInsertDataFicheDeProd($args)
    {
        $clause_elementTlOption = null;
        $a_codeErreur = $array_Clause_elementTlOption = array();
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        if (isset($args['Dossier']) && $args['Dossier']!='') {
            if (isset($args['Dossier']) && $args['Dossier'] != '') $psDossier = $args['Dossier']; else $psDossier = 'EmptyRef';
            if (isset($args['IDDossierDeFab']) && $args['IDDossierDeFab'] > '0') $pnIdDossierDeFab = intval($args['IDDossierDeFab']); else $pnIdDossierDeFab = 'null';
            if (isset($args['IDSecteur']) && $args['IDSecteur'] > '0') $pnIdSecteur = intval($args['IDSecteur']); else $pnIdSecteur = '';
            if (isset($args['IDMachine']) && $args['IDMachine'] > '0') $pnIdMachine = intval($args['IDMachine']); else $pnIdMachine = '';
            if (isset($args['Ref']) && $args['Ref'] != '') $psRef = $args['Ref']; else $psRef = '';
            if (isset($args['Quantite']) && $args['Quantite'] > '0') $pnQuantite = intval($args['Quantite']); else $pnQuantite = '';
            if (isset($args['Commentaire']) && $args['Commentaire'] > '0') $psCommentaire = $args['Commentaire']; else $psCommentaire = '';
            if (isset($args['NbPose']) && $args['NbPose'] > '0') $pnNbPose = $args['NbPose']; else $pnNbPose = '1';
            if (isset($args['Element']) && $args['Element'] != '') $psElement = $args['Element']; else $psElement = '';
            if (isset($args['IDElementTlOption']) && $args['IDElementTlOption'] != '') $psElementTlOption = $args['IDElementTlOption'];
            else {
                if (isset($args['IDOption']) && $args['IDOption'] > '0') $psElementTlOption = intval($args['IDOption']); else $psElementTlOption = '';
            }
            if (isset($args['IDSupport']) && $args['IDSupport'] > '0') $pnIdSupport = intval($args['IDSupport']);
            else {
                if (isset($args['IDSupportMano']) && $args['IDSupportMano'] > '0') $pnIdSupport = intval($args['IDSupportMano']); else $pnIdSupport = '';
            }
            if (isset($args['IDFormat']) && $args['IDFormat'] > '0') $pnIdFormat = intval($args['IDFormat']);
            else {
                if (isset($args['IDFormatMano']) && $args['IDFormatMano'] > '0') $pnIdFormat = intval($args['IDFormatMano']); else $pnIdFormat = '';
            }
            if (isset($args['IDImpression']) && $args['IDImpression'] > '0') $pnIdImpression = intval($args['IDImpression']); else $pnIdImpression = '';
            if ($_SESSION['FBX_USER_SU'] != '1') {
                $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            } else {
                if (isset($args['IDSociete']) && $args['IDSociete'] > '0') {
                    $pnIdSociete = intval($args['IDSociete']);
                } else {
                    $qIdSociete = "SELECT IDSociete FROM TBL_MACHINE WHERE EstActif = '1' AND EstSupp = '0' AND IDMachine = $pnIdMachine AND IDSecteur = $pnIdSecteur";
                    $data_IdSociete = \fbx\DBmysql::getInstance()->getSelectData($qIdSociete);
                    $pnIdSociete = $data_IdSociete[0]->IDSociete;
                }
            }
            //$this->printr($args);
            $q_ficheDeProd = "INSERT INTO TBL_FICHE_DE_PROD
  (
      IDMembreAdd,
      IDDossierDeFab,
      DateAdd,
      Dossier,
      Ref,
      Quantite,
      IDSecteur,
      IDMachine,
      IDImpression,
      IDElement,
      IDSupport,
      IDFormat,
      Commentaire,
      IDSociete,
      NbPose
  )
VALUES
  (
    '$pnIdUser',
    $pnIdDossierDeFab,
    NOW(),
    '$psDossier',
    '$psRef',
    '$pnQuantite',
    '$pnIdSecteur',
    '$pnIdMachine',
    '$pnIdImpression',
    '$psElement',
    '$pnIdSupport',
    '$pnIdFormat',
    '$psCommentaire',
    '$pnIdSociete',
    '$pnNbPose'
  )";
            $data_ficheDeProd = \fbx\DBmysql::getInstance()->getInsertData($q_ficheDeProd);
            $this->getWrLog($q_ficheDeProd, "$data_ficheDeProd", __FUNCTION__, __FILE__);
            if (isset($data_ficheDeProd) && $data_ficheDeProd > 0) {
                if (isset($args['IDCodeErreur1']) && $args['IDCodeErreur1'] > '0') {
                    $a_codeErreur["IDCodeErreur1"] = " ('$pnIdUser',NOW(),'$data_ficheDeProd','" . intval($args['IDCodeErreur1']) . "') ";
                }
                if (isset($args['IDCodeErreur2']) && $args['IDCodeErreur2'] > '0') {
                    $a_codeErreur["IDCodeErreur2"] = " ('$pnIdUser',NOW(),'$data_ficheDeProd','" . intval($args['IDCodeErreur2']) . "') ";
                }
                if (count($a_codeErreur) > 0) {
                    $clause_ficheDeProdTlCodeErreur = implode(',', $a_codeErreur);
                    $q_ficheDeProdTlCodeErreur = "INSERT INTO TBL_FICHE_DE_PROD_TL_CODE_ERREUR ( IDMembreAdd,DateAdd,IDFicheDeProd,IDCodeErreur ) VALUES $clause_ficheDeProdTlCodeErreur";
                    $data_ficheDeProdTlCodeErreur = \fbx\DBmysql::getInstance()->getInsertData($q_ficheDeProdTlCodeErreur);
                    $this->getWrLog($q_ficheDeProdTlCodeErreur, "$data_ficheDeProdTlCodeErreur", __FUNCTION__, __FILE__);
                }
                if ($psElementTlOption != '') {
                    if (preg_match('/,/', $psElementTlOption)) {
                        $array_IdElementTlOption = explode(',', $psElementTlOption);
                        foreach ($array_IdElementTlOption AS $clee => $valeur) {
                            $array_Clause_elementTlOption[] = " ('$pnIdUser',NOW(),'$data_ficheDeProd','$valeur') ";
                        }
                        $clause_elementTlOption = implode(',', $array_Clause_elementTlOption);
                    } else {
                        $clause_elementTlOption = " ('$pnIdUser',NOW(),'$data_ficheDeProd','$psElementTlOption') ";
                    }
                    $q_elementTlOption = "INSERT INTO TBL_FICHE_DE_PROD_TL_OPTION (IDMembreAdd, DateAdd, IDFicheDeProd, IDOption) VALUES $clause_elementTlOption";
                    $data_elementTlOption = \fbx\DBmysql::getInstance()->getInsertData($q_elementTlOption);
                    $this->getWrLog($q_elementTlOption, "$data_elementTlOption", __FUNCTION__, __FILE__);
                }
            }
        }
        $this->_data = array("OUT"=>$args);
    }

    //__FUNCTION for JS to complete begin row
    public function getDataDossierDeFab($args)
    {
        $psDossier = $args['Dossier'];
        $pnIdLangue = $_SESSION['IDLANGUE'];

        $q = "SELECT DISTINCT
    T1.IDDossierDeFab,
    T1.Dossier,
    T1.Commentaire,
    T1.Ref,
    T1.NbPose
FROM
    TBL_DOSSIER_DE_FAB AS T1
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T2 ON T1.IDDossierDeFab = T2.IDDossierDeFab
WHERE
    T1.Dossier = '$psDossier'
    AND T1.EstSupp = '0'";
        $data_DossierDeFab = \fbx\DBmysql::getInstance()->getSelectData($q);

        $pnIdDossierDeFab = $data_DossierDeFab[0]->IDDossierDeFab;
        $q_option = "SELECT
    T1.IDElement,
    T2.Nom AS Element
FROM 
    TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T1
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T2 ON T1.IDElement = T2.IDElement AND T2.IDLangue = '$pnIdLangue'
WHERE 
    T1.IDDossierDeFab = '$pnIdDossierDeFab'
    AND T1.EstSupp = '0'
ORDER BY 
    T1.IDDossierDeFab_tl_element ASC";
        $data_Option = \fbx\DBmysql::getInstance()->getSelectData($q_option);

        $this->_data = array('OUT'=>$args,'data_DossierDeFab'=>$data_DossierDeFab,"data_Option"=>$data_Option);
    }

    //__FUNCTION for JS to complete end row
    public function getDataDossierDeFabTlElement($args)
    {
        $psElement = $args['Element'];
        $pnIdDossierDeFab = $args['IDDossierDeFab'];
        $pnIdSecteur = $args['IDSecteur'];
        $pnIdLangue = $_SESSION['IDLANGUE'];

        $q_element = "SELECT
    T1.IDDossierDeFab_tl_element,
    T1.Quantite,
    T1.Commentaire,
    T1.IDSupport,
    T1.IDFormat,
    T6.IDImpression,
    T2.Nom AS NomSupport,
    T3.Nom AS NomFormat,
    T4.Nom AS NomImpression
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2 ON T1.IDSupport = T2.IDSupport AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T3 ON T1.IDFormat = T3.IDFormat AND T3.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T5 ON T1.IDElement = T5.IDElement AND T5.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T6 ON T6.IDDossierDeFab_tl_element = T1.IDDossierDeFab_tl_element AND T6.EstSupp = '0'
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T4 ON T6.IDImpression = T4.IDImpression AND T4.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_MACHINE AS T7 ON T7.IDMachine = T6.IDMachine AND T7.EstSupp = '0'
WHERE
    T1.IDElement = '$psElement'
    AND T1.IDDossierDeFab = '$pnIdDossierDeFab'
    AND T7.IDSecteur = '$pnIdSecteur'";
//        $this->getWrLog($q_element, "mon est ici", __FUNCTION__, __FILE__);
        $data_element = \fbx\DBmysql::getInstance()->getSelectData($q_element);

        $pnIdDossierDeFab_tl_element = $data_element[0]->IDDossierDeFab_tl_element;

        $q_element_tl_option = "SELECT
    T1.IDOption AS ID,
    T2.Nom AS Nom
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR_TL_OPTION AS T3 ON T2.IDOption = T3.IDOption
WHERE
    T1.IDDossierDeFab_tl_element = '$pnIdDossierDeFab_tl_element'
    AND T3.IDSecteur = '$pnIdSecteur'";
        $data_element_tl_option = \fbx\DBmysql::getInstance()->getSelectData($q_element_tl_option);

        $this->_data = array("data_element"=>$data_element,"data_element_tl_option"=>$data_element_tl_option,"Q_element_option"=>$q_element_tl_option);
    }

    //__FUNCTION for JS table fiche de prod
    public function getDataTableProductionFicheDeProd($args)
    {
        $this->_template = "table/tableProductionFicheDeProd.twig";

        $where = $data_code = null;

        $pnIdLangue = $_SESSION['IDLANGUE'];

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if (isset($args['IDSecteur']) && $args['IDSecteur']>'0') {
            $pnIdSecteur = intval($args['IDSecteur']);
            $where .= " AND T1.IDSecteur = '$pnIdSecteur'";
        }
        if (isset($args['IDMachine']) && $args['IDMachine']>'0') {
            $pnIdMachine = intval($args['IDMachine']);
            $where .= " AND T1.IDMachine = '$pnIdMachine'";
        }
        if(isset($args['searchDate'])) {
            $date = \DateTime::createFromFormat('d/m/Y', $args['searchDate']);
            if (is_object($date)) $pdDateSearch = $date->format('Y-m-d');
            $where .= " AND T1.DateAdd LIKE '$pdDateSearch%'";
        }

        $q = "SELECT DISTINCT
    T1.IDFicheDeProd,
    T1.Dossier,
    T1.Ref,
    T1.Quantite,
    T1.Commentaire,
    T1.IDElement,
    T1.NbPose,
    T9.Nom AS Element,
    T1.IDSecteur,
    T1.IDMachine,
    T1.IDImpression,
    T1.DateAdd,
    T2.Nom AS NomSupport,
    T3.Nom AS NomFormat,
    T4.Nom AS NomImpression,
    T5.Commentaire AS CommentaireDossier,
    T5.IDDossierDeFab AS IDDossierDeFab,
    T6.Commentaire AS CommentaireElement,
    T7.Nom AS NomMachine,
    T8.Nom AS NomSecteur
FROM
    TBL_FICHE_DE_PROD AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2 ON T1.IDSupport = T2.IDSupport AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T3 ON T1.IDFormat = T3.IDFormat AND T3.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T4 ON T1.IDImpression = T4.IDImpression AND T4.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB AS T5 ON T1.Dossier = T5.Dossier AND T5.EstSupp = '0'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T6 ON T5.IDDossierDeFab = T6.IDDossierDeFab AND T1.IDElement = T6.IDElement
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T7 ON T1.IDMachine = T7.IDMachine AND T7.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T8 ON T1.IDSecteur = T8.IDSecteur AND T8.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T9 ON T1.IDElement = T9.IDElement AND T9.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.IDMembreAdd = '$pnIdUser'
    $where
ORDER BY
    T1.DateAdd DESC";
        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $q_code = "SELECT
    T1.IDFicheDeProd,
    T1.IDCodeErreur,
    T2.Nom AS NomCodeErreur
FROM
    TBL_FICHE_DE_PROD_TL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2 ON T1.IDCodeErreur = T2.IDCodeErreur AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.IDMembreAdd = '$pnIdUser'
ORDER BY
    T1.DateAdd DESC";
        $resu_code = \fbx\DBmysql::getInstance()->getSelectData($q_code);
        foreach($resu_code AS $key => $value){
            $data_code[$value->IDFicheDeProd]['IDFicheDeProd'][] = $value->IDFicheDeProd;
            $data_code[$value->IDFicheDeProd]['IDCodeErreur'][] = $value->IDCodeErreur;
            $data_code[$value->IDFicheDeProd]['NomCodeErreur'][] = $value->NomCodeErreur;
        }

        $q_option = "SELECT
    T1.IDFicheDeProd,
    T2.Nom AS NomOption
FROM
    TBL_FICHE_DE_PROD_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.IDMembreAdd = '$pnIdUser'
ORDER BY
    T1.DateAdd DESC";
        $data_option = \fbx\DBmysql::getInstance()->getSelectData($q_option);

        $this->_data = array(
            "OUT"=>$args,
            "DATA"=>$data,
            "DATA_CODE"=>$data_code,
            "DATA_OPTION"=>$data_option,
            "Q"=>$q
        );
    }

    public function getUpdateFicheDeProd($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if (isset($args['IDFicheDeProd']) && $args['IDFicheDeProd'] > 0)    $pnIdFicheDeProd = $args['IDFicheDeProd'];  else $pnIdFicheDeProd = '';
        if (isset($args['Quantite']) && $args['Quantite'] > 0)              $pnQuantite = $args['Quantite'];            else $pnQuantite = '';
        if (isset($args['IDImpression']) && $args['IDImpression'] > 0)      $pnIdImpression = $args['IDImpression'];    else $pnIdImpression = '';
        if (isset($args['IDCode1']) && $args['IDCode1'] > 0)                $pnIdCode1 = $args['IDCode1'];              else $pnIdCode1 = '';
        if (isset($args['OldCode1']) && $args['OldCode1'] > 0)              $pnOldCode1 = $args['OldCode1'];            else $pnOldCode1 = '';
        if (isset($args['IDCode2']) && $args['IDCode2'] > 0)                $pnIdCode2 = $args['IDCode2'];              else $pnIdCode2 = '';
        if (isset($args['OldCode2']) && $args['OldCode2'] > 0)              $pnOldCode2 = $args['OldCode2'];            else $pnOldCode2 = '';
        if (isset($args['NbPose']) && $args['NbPose'] > 0)                  $pnNbPose = $args['NbPose'];                else $pnNbPose = '1';
        if (isset($args['Commentaire']) && $args['Commentaire'] != '')      $psCommentaire = $args['Commentaire'];      else $psCommentaire = '';

        $this->getWrLog("IDFicheDeProd", "$pnIdFicheDeProd", __FUNCTION__, __FILE__);

        if ($pnIdFicheDeProd != '' && $pnIdFicheDeProd > '0'){
            $q = "UPDATE TBL_FICHE_DE_PROD AS T1
SET
    T1.Quantite = '$pnQuantite',
    T1.IDImpression = '$pnIdImpression',
    T1.Commentaire = '$psCommentaire',
    T1.DateMaj = NOW(),
    T1.IDMembreMaj = '$pnIdUser',
    T1.NbPose = '$pnNbPose'
WHERE
    T1.EstSupp = '0'
    AND T1.IDFicheDeProd = '$pnIdFicheDeProd'";
            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
            $this->getWrLog($q, "$data", __FUNCTION__, __FILE__);

            for($k=1;$k<=2;$k++){
                if ($args['IDCode'.$k] != ''){
                    $pnIdCode = $args['IDCode'.$k];
                    $pnOldIdCode = $args['OldCode'.$k];

                    $q_IdCode = "SELECT
    T1.IDFicheDeProd_tl_code_erreur AS id
FROM
    TBL_FICHE_DE_PROD_TL_CODE_ERREUR AS T1
WHERE
    T1.EstSupp = '0'
    AND T1.IDFicheDeProd = '$pnIdFicheDeProd'
    AND T1.IDCodeErreur = '$pnOldIdCode'";
                    $data_Idcode = \fbx\DBmysql::getInstance()->getSelectData($q_IdCode);

                    if( is_array($data_Idcode) && count($data_Idcode) > '0') {
                        $resuCode = $data_Idcode[0]->id;
//                        $this->getWrLog($q_IdCode, "$resuCode", __FUNCTION__, __FILE__);

                        if ($args['IDCode'.$k] > '0') {
                            $q_update = "UPDATE TBL_FICHE_DE_PROD_TL_CODE_ERREUR AS T1
SET
    T1.DateMaj = NOW(),
    T1.IDMembreMaj = '$pnIdUser',
    T1.IDCodeErreur = '$pnIdCode'
WHERE
    T1.EstSupp = '0'
    AND T1.IDFicheDeProd = '$pnIdFicheDeProd'
    AND T1.IDCodeErreur = '$pnOldIdCode'";
                            $data_update = \fbx\DBmysql::getInstance()->getUpdateData($q_update);
                            $this->getWrLog($q_update, "$data_update", __FUNCTION__, __FILE__);
                        } else {
                            $q_delete = "UPDATE TBL_FICHE_DE_PROD_TL_CODE_ERREUR AS T1 #EstSupp = '1'
SET
    T1.DateSupp = NOW(),
    T1.IDMembreSupp = '$pnIdUser',
    T1.EstSupp = '1'
WHERE
    T1.IDFicheDeProd = '$pnIdFicheDeProd'
    AND T1.IDCodeErreur = '$pnOldIdCode'";
                            $data_delete = \fbx\DBmysql::getInstance()->getUpdateData($q_delete);
                            $this->getWrLog($q_delete, "$data_delete", __FUNCTION__, __FILE__);
                        }
                    }
                    else {
                        $q_insert = "INSERT INTO TBL_FICHE_DE_PROD_TL_CODE_ERREUR
    (IDMembreAdd, DateAdd, IDFicheDeProd, IDCodeErreur)
VALUES
    ('$pnIdUser',NOW(),'$pnIdFicheDeProd','$pnIdCode')";
                        $data_insert = \fbx\DBmysql::getInstance()->getInsertData($q_insert);
                        $this->getWrLog($q_insert, "$data_insert", __FUNCTION__, __FILE__);
                    }
                }

            }
        }
    }

    public function getDataPlanning($args)
    {
        $pnIdLangue = $_SESSION['IDLANGUE'];

        if ( isset($args['IDMachine']) && $args['IDMachine'] > "0" ) $pnIdMachine = intval($args['IDMachine']);
        else $pnIdMachine = null;

        if ( is_numeric($pnIdMachine) && $pnIdMachine != '' ){
            $this->_template = "elements/modalPlanning.twig";

            $q_planning = "SELECT
  T3.Dossier
  , T4.Nom AS NomElement
  , T5.Nom AS NomMachine
  , T2.IDElement
  , T3.IDDossierDeFab
  , T1.IDDossierDeFab_tl_element
FROM
  TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T2 ON T1.IDDossierDeFab_tl_element = T2.IDDossierDeFab_tl_element AND T2.EstSupp = '0'
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB AS T3 ON T3.IDDossierDeFab = T2.IDDossierDeFab #AND T3.EstSupp = '0'
  LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T4 ON T4.IDElement = T2.IDElement AND T4.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_MACHINE_TRAD AS T5 ON T5.IDMachine = T1.IDMachine AND T5.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_PLANNING_TL_ELEMENT_TL_MACHINE AS T6 ON T6.IDDossierDeFab_tl_element_tl_machine = T1.IDDossierDeFab_tl_element_tl_machine AND T6.EstSupp = '0'
  LEFT OUTER JOIN TBL_ELEMENT AS T14 ON T14.IDElement = T2.IDElement AND T14.EstSupp = '0'
WHERE
  T1.EstSupp = '0' AND T3.EstSupp = '0'
  AND (SELECT TT1.IDFicheDeProd FROM TBL_FICHE_DE_PROD AS TT1 WHERE  TT1.IDElement = T2.IDElement  AND TT1.IDMachine = T1.IDMachine  AND TT1.IDDossierDeFab = T3.IDDossierDeFab AND TT1.EstSupp = '0' LIMIT 0,1) IS NULL
  AND T1.IDMachine = '$pnIdMachine'
ORDER BY
  IFNULL(T6.Ordre,999)
  , T3.DateExpedition
  , T3.IDDossierDeFab
  , T14.Ordre";
            $data_planning = \fbx\DBmysql::getInstance()->getSelectData($q_planning);

            $this->_data = array("OUT"=>$args,"DATA_PLANNING"=>$data_planning);
        }
    }
}