<?php
/**
 *
 * Created by blond.
 * File: PrintDossierDeFab.php
 * Date: 21/05/15 - 15:48
 *
 */

namespace fbx\Fab;


class PrintDossierDeFab extends Select
{
    const ClassPage = 'PrintDossierDeFab';

    public $_template = "elements/ficheDossierDeFabToPrint.twig";

    private function getIdDossierDeFab($psDossierDeFab){
        $data_dossier = \fbx\DBmysql::getInstance()->getSelectData("SELECT IDDossierDeFab FROM TBL_DOSSIER_DE_FAB WHERE EstSupp = 0 AND IDMembreAdd != 1 AND Dossier = '$psDossierDeFab'");
        return $data_dossier[0]->IDDossierDeFab;
    }

    public function getDataDossierDeFabForFiche($args)
    {
        $pnIdDossierDeFab_tl_element = null;
        $data_dossier = $q_dossier = $pnIdDossierDeFab = null;
        $data_dossierTlOption = $q_dossierTlOption = null;
        $data_dossierTlElement = $q_dossierTlElement = null;
        $data_dossierTlElementTlOption = $q_dossierTlElementTlOption = null;
        $data_fiche = $q_fiche = null;
        $data_ficheTlCode = $q_ficheTlCode = null;

        echo '<script type="text/javascript">$(function(){$("#mainNavBar").prop("hidden",true);})</script>'; //mainNavBar
        echo '<script type="text/javascript">$(function(){$("#chrono").prop("hidden",true);})</script>'; //chrono
//        $where = $whereSociete = $whereSociete2 = $whereSecteur = $pdDateExpBegin = $pdDateCreaBegin = $pdDateExpEnd = $pdDateCreaEnd = null;
//        $pnIdLangue = $_SESSION['IDLANGUE'];
//
//        echo '<script type="text/javascript">
//    $(function(){
//        $(".collapse").collapse("toggle");
//        $("#divJumbotron").prop("hidden",true);
//    })
//</script>';
//
//        if (isset($args['searchDateDossierExpBegin']) && $args['searchDateDossierExpBegin'])    $pdDateExpBegin = $this->getConvertDate($args['searchDateDossierExpBegin']);
//        if (isset($args['searchDateDossierExpEnd']) && $args['searchDateDossierExpEnd'])        $pdDateExpEnd = $this->getConvertDate($args['searchDateDossierExpEnd']);
//        if ($pdDateExpBegin != '' && $pdDateExpEnd != '')                       $where .= " AND T1.DateExpedition BETWEEN '$pdDateExpBegin' AND '$pdDateExpEnd'";
//        elseif ($pdDateExpBegin != '' && $pdDateExpEnd == '')                   $where .= " AND T1.DateExpedition >= '$pdDateExpBegin'";
//        elseif ($pdDateExpBegin == '' && $pdDateExpEnd != '')                   $where .= " AND T1.DateExpedition <= '$pdDateExpEnd'";
//
//        if (isset($args['searchDateDossierCreaBegin']) && $args['searchDateDossierCreaBegin'])  $pdDateCreaBegin = $this->getConvertDate($args['searchDateDossierCreaBegin']);
//        if (isset($args['searchDateDossierCreaEnd']) && $args['searchDateDossierCreaEnd'])      $pdDateCreaEnd = $this->getConvertDate($args['searchDateDossierCreaEnd']);
//        if ($pdDateCreaBegin != '' && $pdDateCreaEnd != '')                     $where .= " AND T1.DateAdd BETWEEN '$pdDateCreaBegin' AND '$pdDateCreaEnd 23:59:59'";
//        elseif ($pdDateCreaBegin != '' && $pdDateCreaEnd == '')                 $where .= " AND T1.DateAdd >= '$pdDateCreaBegin'";
//        elseif ($pdDateCreaBegin == '' && $pdDateCreaEnd != '')                 $where .= " AND T1.DateAdd <= '$pdDateCreaEnd 23:59:59'";
//
//        if ( isset($args['Dossier']) && $args['Dossier'] != '' )                $where .= " AND T1.Dossier = '{$args['Dossier']}'";
//        if ( isset($args['Ref']) && $args['Ref'] != '' )                        $where .= " AND T1.Ref LIKE '%{$args['Ref']}%'";
//        if ($_SESSION['FBX_USER_SU'] != '1' ) {                                 $whereSociete = " AND TT1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
//        if ($_SESSION['FBX_USER_SU'] != '1' ) {                                 $whereSociete2 = " AND TT2.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
//        if ( isset($args['SelectSecteur']) && $args['SelectSecteur'] >0 )       $where .= " AND (SELECT TT3.IDSecteur FROM TBL_FICHE_DE_PROD AS TT3 WHERE TT3.IDDossierDeFab = T1.IDDossierDeFab AND TT3.EstSupp = '0' ORDER BY TT3.DateAdd DESC LIMIT 0,1 ) = '{$args['SelectSecteur']}'";
//
//        if ( isset($args['typeDossier']) && $args['typeDossier'] >0 ){
//            $pnTypeDossier = $args['typeDossier'];
//            switch ($pnTypeDossier){
//                case 1:
//                    $where .= " AND T1.EstPliable = '0' AND T1.EstAmalgame = '0'";
//                    break;
//                case 2:
//                    $where .= " AND T1.EstPliable = '1'";
//                    break;
//                case 3:
//                    $where .= " AND T1.EstAmalgame = '1'";
//                    break;
//                default:
//                    break;
//            }
//        }
//
//        $q_dossier = "SELECT
//    T1.IDDossierDeFab AS ID,
//    T1.Dossier AS Nom,
//    T1.Ref AS Ref,
//    T1.Quantite AS Quantite,
//    T1.Commentaire AS Commentaire,
//    T1.DateExpedition AS DateExpedition,
//    T1.NbOption AS NbOption,
//    T1.NbElement AS NbElement,
//    T1.IDMembreAdd,
//    T1.DateAdd,
//    T1.DateMaj,
//    (SELECT CONCAT(TT1.Prenom,' ', TT1.Nom) FROM TBL_MEMBRE AS TT1 WHERE TT1.IDMembre = T1.IDMembreAdd $whereSociete) AS NomMembre,
//    (SELECT CONCAT(TT2.Prenom,' ', TT2.Nom) FROM TBL_MEMBRE AS TT2 WHERE TT2.IDMembre = T1.IDMembreMaj $whereSociete2) AS NomMembreMaj,
//    (SELECT TT3.IDSecteur FROM TBL_FICHE_DE_PROD AS TT3 WHERE TT3.IDDossierDeFab = T1.IDDossierDeFab AND TT3.EstSupp = '0' ORDER BY DateAdd DESC LIMIT 0,1 ) AS IDSecteur,
//    T1.EstAmalgame,
//    T1.EstPliable,
//    T1.LargeurFerme,
//    T1.HauteurFerme,
//    T1.LargeurOuvert,
//    T1.HauteurOuvert
//FROM
//    TBL_DOSSIER_DE_FAB AS T1
//WHERE
//    T1.EstSupp = '0'
//    $where
//ORDER BY
//    T1.IDDossierDeFab DESC";
//        $data_dossier = \fbx\DBmysql::getInstance()->getSelectData($q_dossier);
//
//        $q_option = "SELECT
//    T1.IDDossierDeFab_tl_option AS ID,
//    T1.IDDossierDeFab AS IDDossierDeFab,
//    T1.IDOption AS IDOption,
//    T2.Nom AS NomOption
//FROM
//    TBL_DOSSIER_DE_FAB_TL_OPTION AS T1
//    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
//WHERE
//    T1.EstSupp = '0'";
//        $data_option = \fbx\DBmysql::getInstance()->getSelectData($q_option);
//
//        $this->_data = array(
//            "data_dossier"=>$data_dossier,
//            "data_option"=>$data_option,
//            "OUT"=>$args,
//            "Q"=>$q_dossier
//        );

        if (isset($args['IDDossierDeFab']) && $args['IDDossierDeFab'] > '0') { $pnIdDossierDeFab = $args['IDDossierDeFab']; }
        if (isset($args['DossierDeFab']) && $args['DossierDeFab'] > '0') { $pnIdDossierDeFab = $this->getIdDossierDeFab($args['DossierDeFab']); }
//$this->printr($pnIdDossierDeFab);
        if( $pnIdDossierDeFab > '0' ) {

//            $pnIdDossierDeFab = $args['IDDossierDeFab'];
            $pnIdLangue = $_SESSION['IDLANGUE'];

            $q_dossier = "SELECT
    T1.IDDossierDeFab,
    T1.Dossier,
    T1.Ref,
    T1.Commentaire,
    T1.DateExpedition,
    T1.Quantite,
    T1.EstPliable,
    T1.EstAmalgame,
    T1.NbOption,
    T1.NbElement,
    T1.LargeurOuvert,
    T1.LargeurFerme,
    T1.HauteurOuvert,
    T1.HauteurFerme,
    (SELECT CONCAT(TT1.Prenom,' ',TT1.Nom) FROM TBL_MEMBRE AS TT1 WHERE TT1.IDMembre = T1.IDMembreAdd) AS MembreAdd,
    T1.DateAdd,
    (SELECT CONCAT(TT2.Prenom,' ',TT2.Nom) FROM TBL_MEMBRE AS TT2 WHERE TT2.IDMembre = T1.IDMembreMaj) AS MembreMaj,
    T1.DateMaj
FROM
    TBL_DOSSIER_DE_FAB AS T1
WHERE
    T1.EstSupp = '0' AND T1.IDMembreAdd != 1
    AND T1.IDDossierDeFab = '$pnIdDossierDeFab'";
            $data_dossier = \fbx\DBmysql::getInstance()->getSelectData($q_dossier);

            $q_dossierTlOption = "SELECT
    T1.IDOption AS ID,
    T2.Nom
FROM
    TBL_DOSSIER_DE_FAB_TL_OPTION AS T1
     LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0' AND T1.IDMembreAdd != 1
    AND T1.IDDossierDeFab = '$pnIdDossierDeFab'";
            $data_dossierTlOption = \fbx\DBmysql::getInstance()->getSelectData($q_dossierTlOption);

            $q_dossierTlElement = "SELECT
    T1.IDDossierDeFab_tl_element
    , T2.Nom AS NomElement
    , T1.Quantite AS QuantiteElement
    , T1.Commentaire AS CommentaireElement
    , T3.Nom AS NomImpression
    , T4.Nom AS NomSupport
    , T5.Nom AS NomFormat
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T1
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T2 ON T1.IDElement = T2.IDElement AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T3 ON T1.IDImpression = T3.IDImpression AND T3.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T4 ON T1.IDSupport = T4.IDSupport AND T4.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T5 ON T1.IDFormat = T5.IDFormat AND T5.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0' AND T1.IDMembreAdd != 1
    AND T1.IDDossierDeFab = '$pnIdDossierDeFab'
ORDER BY
    T2.IDElement";
            $data_dossierTlElement = \fbx\DBmysql::getInstance()->getSelectData($q_dossierTlElement);

            foreach($data_dossierTlElement as $key => $value){
                $pnIdDossierDeFab_tl_element = $value->IDDossierDeFab_tl_element;
                $q_dossierTlElementTlOption = "SELECT
    T1.IDOption
    , T2.Nom
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0' AND T1.IDMembreAdd != 1
    AND T1.IDDossierDeFab_tl_element = '$pnIdDossierDeFab_tl_element'";
                $data_dossierTlElementTlOption[] = \fbx\DBmysql::getInstance()->getSelectData($q_dossierTlElementTlOption);
            }

            $q_fiche = "SELECT
    T1.IDFicheDeProd AS ID
    , T1.Quantite AS Quantite
    , (SELECT CONCAT(TT1.Prenom,' ',TT1.Nom) FROM TBL_MEMBRE AS TT1 WHERE TT1.IDMembre = T1.IDMembreAdd) AS MembreAdd
    , T1.DateAdd
    , T1.Commentaire
    , T2.Nom AS NomElement
    , T3.Nom AS NomImpression
    , T4.Nom AS NomSupport
    , T5.Nom AS NomFormat
    , T6.Nom AS NomSecteur
    , T7.Nom AS NomMachine
FROM
    TBL_FICHE_DE_PROD AS T1
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T2 ON T1.IDElement = T2.IDElement AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T3 ON T1.IDImpression = T3.IDImpression AND T3.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T4 ON T1.IDSupport = T4.IDSupport AND T4.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T5 ON T1.IDFormat = T5.IDFormat AND T5.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T6 ON T1.IDSecteur = T6.IDSecteur AND T6.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T7 ON T1.IDMachine= T7.IDMachine AND T7.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR AS T8 ON T1.IDSecteur = T8.IDSecteur
    LEFT OUTER JOIN TBL_ELEMENT AS T9 ON T1.IDElement = T9.IDElement
WHERE
    T1.EstSupp = '0' AND T1.IDMembreAdd != 1
    AND T1.IDDossierDeFab = '$pnIdDossierDeFab'
ORDER BY
    T8.Ordre
    , T9.Ordre";
            $data_fiche = \fbx\DBmysql::getInstance()->getSelectData($q_fiche);

            foreach($data_fiche as $clee => $valeur){
                $pnIdFicheDeProd = $valeur->ID;
                $q_ficheTlCode = "SELECT
    T1.IDCodeErreur
    , T2.Nom
FROM
    TBL_FICHE_DE_PROD_TL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2 ON T1.IDCodeErreur = T2.IDCodeErreur AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0' AND T1.IDMembreAdd != 1
    AND T1.IDFicheDeProd = '$pnIdFicheDeProd'";
                $data_ficheTlCode[] = \fbx\DBmysql::getInstance()->getSelectData($q_ficheTlCode);
            }

            if (is_array($data_dossier) && count($data_dossier) > 0) {
                $dossier = $data_dossier[0]->Dossier;
                echo '<script type="text/javascript">$(function(){document.title = "' . $dossier . '"})</script>';
            }
        }

        $this->_data = array(
            "OUT" => $args,
            "DATA_DOSSIER" => $data_dossier,
            "DATA_DOSSIER_TL_OPTION" => $data_dossierTlOption,
            "DATA_DOSSIER_TL_ELEMENT" => $data_dossierTlElement,
            "DATA_DOSSIER_TL_ELEMENT_TL_OPTION" => $data_dossierTlElementTlOption,
            "DATA_FICHE" => $data_fiche,
            "DATA_FICHE_TL_CODE_ERREUR" => $data_ficheTlCode,
            "Q_DOSSIER" => $q_dossier,
            "Q_DOSSIER_TL_OPTION" => $q_dossierTlOption,
            "Q_DOSSIER_TL_ELEMENT" => $q_dossierTlElement,
            "Q_FICHE" => $q_fiche
        );
    }
}