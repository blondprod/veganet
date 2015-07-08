<?php
/**
 *
 * Created by blond.
 * File: PrintDossierDeFab.php
 * Date: 21/05/15 - 15:48
 *
 */

namespace fbx\Fab;


class Production extends Select
{
    const ClassPage = 'Production';

    public $_template = "elements/ficheDossierDeFabToPrint.twig";

    public function imp($args)
    {
        $pnIdDossierDeFab_tl_element = null;
        $data_dossier = $q_dossier = $pnIdDossierDeFab = null;
        $data_dossierTlOption = $q_dossierTlOption = null;
        $data_dossierTlElement = $q_dossierTlElement = null;
        $data_dossierTlElementTlOption = $q_dossierTlElementTlOption = null;
        $data_fiche = $q_fiche = null;
        $data_ficheTlCode = $q_ficheTlCode = null;
        $q_dossierTlElementTlMachine = $data_dossierTlElementTlMachine = null;

        echo '<script type="text/javascript">$(function(){$("#mainNavBar").prop("hidden",true);})</script>'; //mainNavBar
        echo '<script type="text/javascript">$(function(){$("#chrono").prop("hidden",true);})</script>';

        if (isset($args['Dossier']) && $args['Dossier'] > '0') {
            $data_dossier = \fbx\DBmysql::getInstance()->getSelectData("SELECT IDDossierDeFab FROM TBL_DOSSIER_DE_FAB WHERE EstSupp = 0 AND IDMembreAdd != 1 AND Dossier = '{$args['Dossier']}'");
            $pnIdDossierDeFab = $data_dossier[0]->IDDossierDeFab;
        }
        if (isset($args['IDDossierDeFab']) && $args['IDDossierDeFab'] > '0') { $pnIdDossierDeFab = $args['IDDossierDeFab']; }

        if( $pnIdDossierDeFab > '0' ) {
            $pnIdLangue = $_SESSION['IDLANGUE'];

            //_ SQL DOSSIER DE FAB
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

            //_ SQL DOSSIER TL OPTION
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

            //_ SQL DOSSIER TL ELEMENT
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

            //_ SQL DOSSIER TL ELEMENT TL OTHER
            foreach($data_dossierTlElement as $key => $value){
                $pnIdDossierDeFab_tl_element = $value->IDDossierDeFab_tl_element;

                //_ SQL DOSSIER TL ELEMENT TL OPTION
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

                //_ SQL DOSSIER TL ELEMENT TL MACHINE
                $q_dossierTlElementTlMachine = "SELECT DISTINCT
  T1.IDMachine
, T3.Nom AS NomMachine
, T1.IDImpression
, T6.Nom AS NomImpression
FROM
  TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
  LEFT OUTER JOIN TBL_MACHINE AS T2 ON T1.IDMachine = T2.IDMachine AND T2.EstSupp = '0'
  LEFT OUTER JOIN TBL_MACHINE_TRAD AS T3 ON T3.IDMachine = T2.IDMachine AND T3.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_SECTEUR AS T5 ON T5.IDSecteur = T2.IDSecteur AND T5.EstSupp = '0'
  LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T6 ON T6.IDImpression = T1.IDImpression AND T6.IDLangue = '$pnIdLangue'
WHERE
  T1.EstSupp = '0' AND T1.IDMembreAdd != 1
  AND T1.IDDossierDeFab_tl_element = '$pnIdDossierDeFab_tl_element'
ORDER BY
  T5.Ordre";
                $data_dossierTlElementTlMachine[] = \fbx\DBmysql::getInstance()->getSelectData($q_dossierTlElementTlMachine);
            }

            //_ SQL FICHE DE PROD
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

            //_ SQL FICHE TL CODE ERREUR
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
            "DATA_DOSSIER_TL_ELEMENT_TL_MACHINE" => $data_dossierTlElementTlMachine,
            "DATA_FICHE" => $data_fiche,
            "DATA_FICHE_TL_CODE_ERREUR" => $data_ficheTlCode
        );
    }
}