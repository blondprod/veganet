<?php
/**
 *
 * Created by blond.
 * File: GestionPlanning.php
 * Date: 26/06/15 - 15:48
 *
 */

namespace fbx\Fab;

class GestionPlanning extends Select
{
    const ClassPage = 'GestionPlanning';

    public $_template = "Gestion/GestionPlanning.twig";

    //__table
    public function getDataTableGestionPlanning($args)
    {
        $where = null;

        $pnIdLangue = $_SESSION['IDLANGUE'];
        $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];

//        if ($_SESSION['FBX_USER_SU'] == '1' ) { if(isset($args['IDSociete']) && $args['IDSociete'] > '0' ) $where .= "AND T7.IDSociete = '{$args['IDSociete']}'"; }
//        else { $where .= "AND T7.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }

        $this->_template = "table/tableGestionPlanning.twig";

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
//        $this->getWrLog($q, "Planning", __FUNCTION__, __FILE__);

        $this->_data = array(
            "data_planning"=>$data_planning
            , "OUT"=>$args
            , "Q"=>$q
        );
    }

    //__update
    public function getUpdatePlanning($args)
    {
        $q_ins_planning = $q_update = null;
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        for($n=0;$n<count($args['array_IDDossierTlElementTlMachine']);$n++) {
            $pnIDDossierTlElementTlMachine = $args['array_IDDossierTlElementTlMachine'][$n];
            $pn_Ordre = $args['array_Ordre'][$n];
            $pn_IDMachine = $args['array_IDMachine'][$n];

            $q_ins_planning[] = "INSERT INTO TBL_PLANNING_TL_ELEMENT_TL_MACHINE
    (IDMembreAdd,DateAdd,IDDossierDeFab_tl_element_tl_machine, Ordre)
VALUES
    ('$pnIdUser',NOW(),'$pnIDDossierTlElementTlMachine', '$pn_Ordre')
    ON DUPLICATE KEY UPDATE IDDossierDeFab_tl_element_tl_machine='$pnIDDossierTlElementTlMachine', Ordre='$pn_Ordre',IDMembreMaj='$pnIdUser',DateMaj=NOW()";
            $q_update[] = "UPDATE TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE SET IDMachine='$pn_IDMachine',DateMaj=NOW(),IDMembreMaj='$pnIdUser' WHERE IDDossierDeFab_tl_element_tl_machine='$pnIDDossierTlElementTlMachine'";
        }

        $q_up = implode(';', $q_update);
        $q = implode(';', $q_ins_planning);
        $pnIdPlanning = \fbx\DBmysql::getInstance()->getInsertData($q.";".$q_up);
        $this->getWrLog($q, "pnIdPlanning=>$pnIdPlanning", __FUNCTION__, __FILE__);

    }

    //__ Export XLS
    public function getExportPlanning($args)
    {
        $where = null;
        $_SESSION["dataArray"] = array();

        $pnIdLangue = $_SESSION['IDLANGUE'];
        $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];

//        if ($_SESSION['FBX_USER_SU'] == '1' ) { if(isset($args['IDSociete']) && $args['IDSociete'] > '0' ) $where .= "AND T7.IDSociete = '{$args['IDSociete']}'"; }
//        else { $where .= "AND T7.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }

        if ( $args['IDSecteur'] > "0" ) $where .= "AND T7.IDSecteur = '{$args['IDSecteur']}'";
        if ( $args['IDMachine'] > "0" ) $where .= "AND T1.IDMachine = '{$args['IDMachine']}'";

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
FROM
  TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T2 ON T1.IDDossierDeFab_tl_element = T2.IDDossierDeFab_tl_element AND T2.EstSupp = '0'
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB AS T3 ON T3.IDDossierDeFab = T2.IDDossierDeFab AND T3.EstSupp = '0'
  LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T4 ON T4.IDElement = T2.IDElement AND T4.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_MACHINE_TRAD AS T5 ON T5.IDMachine = T1.IDMachine AND T5.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_PLANNING_TL_ELEMENT_TL_MACHINE AS T6 ON T6.IDDossierDeFab_tl_element_tl_machine = T1.IDDossierDeFab_tl_element_tl_machine AND T6.EstSupp = '0'
  LEFT OUTER JOIN TBL_MACHINE AS T7 ON T7.IDMachine = T1.IDMachine AND T7.EstSupp = '0' AND T7.IDSociete = '$pnIdSociete'
  LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T8 ON T8.IDImpression = T1.IDImpression AND T8.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T11 ON T11.IDSecteur = T7.IDSecteur AND T11.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_SECTEUR AS T12 ON T12.IDSecteur = T7.IDSecteur AND T12.EstSupp = '0' AND T12.IDSociete = '$pnIdSociete'
  LEFT OUTER JOIN TBL_IMPRESSION AS T13 ON T13.IDImpression = T8.IDImpression AND T13.EstSupp = '0' AND T13.IDSociete = '$pnIdSociete'
WHERE
  T1.EstSupp = '0'
  AND (SELECT TT1.IDFicheDeProd FROM TBL_FICHE_DE_PROD AS TT1 WHERE  TT1.IDElement = T2.IDElement  AND TT1.IDMachine = T1.IDMachine  AND TT1.IDDossierDeFab = T3.IDDossierDeFab AND TT1.EstSupp = '0' LIMIT 0,1) IS NULL
  $where
ORDER BY
  T12.Ordre
  , T7.Ordre
  , IFNULL(T6.Ordre,999)
  , T3.DateExpedition
  , T3.IDDossierDeFab";

        $data_planning = \fbx\DBmysql::getInstance()->getSelectData($q);

//        $this->_data = $data_planning;

        foreach($data_planning as $key => $value) {
            $_SESSION["dataArray"][$key] = array(
                "Machine" => $value->NomMachine,
                "Dossier" => $value->Dossier,
                "Element" => $value->NomElement,
                "Type" => $value->NomImpression,
                "Quantite" => $value->Quantite,
                "Ordre" => $value->Ordre
            );
        }

    }
}