<?php
/**
 *
 * Created by blond.
 * File: SuiviPlanning.php
 * Date: 26/06/15 - 15:48
 *
 */

namespace fbx\Fab;

class SuiviPlanning extends Select
{
    const ClassPage = 'SuiviPlanning';

    public $_template = "Suivi/SuiviPlanning.twig";

    //__table
    public function getDataTableSuiviPlanning($args)
    {
        $where = null;

        $pnIdLangue = $_SESSION['IDLANGUE'];
        $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];

//        if ($_SESSION['FBX_USER_SU'] == '1' ) { if(isset($args['IDSociete']) && $args['IDSociete'] > '0' ) $where .= "AND T7.IDSociete = '{$args['IDSociete']}'"; }
//        else { $where .= "AND T7.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }

        $this->_template = "table/tableSuiviPlanning.twig";

        if ( $args['IDSecteur'] > "0" ) $where .= "AND T7.IDSecteur = '{$args['IDSecteur']}'";
        if ( $args['IDMachine'] > "0" ) $where .= "AND T1.IDMachine = '{$args['IDMachine']}'";
        if ( $args['Dossier'] != "" )   $where .= "AND T3.Dossier = '{$args['Dossier']}'";
        if ( $args['Ref'] != "" )       $where .= "AND T3.Ref LIKE '%{$args['Ref']}%'";

        $q = "SELECT
  T1.IDDossierDeFab_tl_element_tl_machine
  , T1.IDMachine
  , T3.Dossier
  , T4.Nom AS NomElement
  , T5.Nom AS NomMachine
  , T3.IDDossierDeFab
  , T3.DateExpedition
  , IFNULL(T6.Ordre,999) AS Ordre
  , T2.Quantite
  , T8.Nom AS NomImpression
  , T11.Nom AS NomSecteur
  , T7.IDSecteur
  , T13.NbTour
  , T13.NbCalage
  , T7.CadenceTourMin
  , T7.CalageMin
  , T7.CalageFeuilles
  , T7.GachePour1000Feuilles
#  , ( T13.NbCalage * T7.CalageFeuilles ) AS NbFeuillesCalage
#  , ( ( T2.Quantite / 1000 ) * T7.GachePour1000Feuilles ) AS NbFeuilleGache
  , ( T2.Quantite + ( ( T2.Quantite / 1000 ) * T7.GachePour1000Feuilles ) + ( T13.NbCalage * T7.CalageFeuilles ) ) AS NbTotalFeuillesAreserver
  , ( ( T2.Quantite + ( ( T2.Quantite / 1000 ) * T7.GachePour1000Feuilles ) + ( T13.NbCalage * T7.CalageFeuilles ) ) * T13.NbTour ) AS NbTotalTours
#  , ( T7.CalageMin * T13.NbCalage ) AS TmpCalageEnMinutes
#  , ( ( ( T2.Quantite * T13.NbTour ) / T7.CadenceTourMin ) * 60 ) AS TmpRouleEnMinutes
  , ( ( ( ( T2.Quantite * T13.NbTour ) / T7.CadenceTourMin ) * 60 ) + ( T7.CalageMin * T13.NbCalage ) ) AS tmpTotalEnMin
FROM
  TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T2 ON T1.IDDossierDeFab_tl_element = T2.IDDossierDeFab_tl_element AND T2.EstSupp = '0'
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB AS T3 ON T3.IDDossierDeFab = T2.IDDossierDeFab #AND T3.EstSupp = '0'
  LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T4 ON T4.IDElement = T2.IDElement AND T4.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_MACHINE_TRAD AS T5 ON T5.IDMachine = T1.IDMachine AND T5.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_PLANNING_TL_ELEMENT_TL_MACHINE AS T6 ON T6.IDDossierDeFab_tl_element_tl_machine = T1.IDDossierDeFab_tl_element_tl_machine AND T6.EstSupp = '0'
  LEFT OUTER JOIN TBL_MACHINE AS T7 ON T7.IDMachine = T1.IDMachine AND T7.EstSupp = '0' AND T7.IDSociete = '$pnIdSociete'
  LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T8 ON T8.IDImpression = T1.IDImpression AND T8.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T11 ON T11.IDSecteur = T7.IDSecteur AND T11.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_SECTEUR AS T12 ON T12.IDSecteur = T7.IDSecteur AND T12.EstSupp = '0' AND T12.IDSociete = '$pnIdSociete'
  LEFT OUTER JOIN TBL_IMPRESSION AS T13 ON T13.IDImpression = T8.IDImpression AND T13.EstSupp = '0' AND T13.IDSociete = '$pnIdSociete'
  LEFT OUTER JOIN TBL_ELEMENT AS T14 ON T14.IDElement = T2.IDElement AND T14.EstSupp = '0' AND T14.IDSociete = '$pnIdSociete'
WHERE
  T1.EstSupp = '0' AND T3.EstSupp = '0'
  AND (SELECT TT1.IDFicheDeProd FROM TBL_FICHE_DE_PROD AS TT1 WHERE  TT1.IDElement = T2.IDElement  AND TT1.IDMachine = T1.IDMachine  AND TT1.IDDossierDeFab = T3.IDDossierDeFab AND TT1.EstSupp = '0' LIMIT 0,1) IS NULL
  $where
ORDER BY
  T12.Ordre
  , T7.Ordre
  , IFNULL(T6.Ordre,999)
  , T3.DateExpedition
  , T3.IDDossierDeFab
  , T14.Ordre";

        $data_planning = \fbx\DBmysql::getInstance()->getSelectData($q);
        $this->getWrLog($q, "suivi Planning", __FUNCTION__, __FILE__);

        $this->_data = array(
            "data_planning"=>$data_planning
            , "OUT"=>$args
            , "Q"=>$q
        );
    }
}