<?php
/**
 *
 * Created by blond.
 * File: SuiviStat.php
 * Date: 05/06/15 - 16:48
 *
 */

namespace fbx\Fab;


class SuiviStat extends Select
{
    const ClassPage = 'SuiviStat';

    public $_template = "Suivi/SuiviStat.twig";

    public function getDataTableStat($args)
    {
        $this->_template = "table/tableSuiviStat.twig";

        $where = $nbJour = null;
        $pnIdLangue = $_SESSION['IDLANGUE'];

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= " AND T1.IDSociete = '$pnIdSociete'"; }
        else { if (isset($args['IDSociete']) && $args['IDSociete'] != '') {
            $pnIdSociete = $args['IDSociete'];
            $where .= " AND T1.IDSociete = '$pnIdSociete' AND T3.IDSociete = '$pnIdSociete'";
        } }

        $q_secteur= "SELECT
  T1.IDSecteur AS ID
  ,T2.Nom
  ,T3.IDMachine
  ,T4.Nom AS NomMachine
FROM
  TBL_SECTEUR AS T1
  LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T2 ON T1.IDSecteur = T2.IDSecteur AND T2.IDLangue = '$pnIdLangue'
  LEFT OUTER JOIN TBL_MACHINE AS T3 ON T2.IDSecteur = T3.IDSecteur AND T3.EstSupp = '0'
  LEFT OUTER JOIN TBL_MACHINE_TRAD AS T4 ON T3.IDMachine = T4.IDMachine AND T4.IDLangue = '$pnIdLangue'
WHERE
  T1.EstSupp = '0'
  $where
ORDER BY
  T1.IDSecteur";
        $data_secteur = \fbx\DBmysql::getInstance()->getSelectData($q_secteur);
//        $this->getWrLog($q_secteur, "", __FUNCTION__, __FILE__);

        if (isset($args['DateBegin'])) {
            $date = \DateTime::createFromFormat('d/m/Y', $args['DateBegin']);
            if (is_object($date)) $pdDateBegin = $date->format('Ymd'); else $pdDateBegin = '';
            $where .= " AND T1.DateAdd > $pdDateBegin";
        }
        if (isset($args['DateEnd'])) {
            $date = \DateTime::createFromFormat('d/m/Y', $args['DateEnd']);
            if (is_object($date)) $pdDateEnd = $date->format('Ymd'); else $pdDateEnd = '';
            $where .= " AND T1.DateAdd < $pdDateEnd";
        }

        $q = "SELECT
  T1.IDSecteur,
  T1.IDMachine,
  T1.IDMembreAdd,
  SUM(T1.Quantite) AS QuantiteFeuilles,
  SUM(T2.NbCalage) AS NbCalage,
  SUM(T2.NbTour*T1.Quantite) AS NbTour,
  COUNT(T1.IDFicheDeProd) AS nbFicheDeProd,
  (SELECT TT1.Nom FROM TBL_MEMBRE AS TT1 WHERE TT1.IDMembre = T1.IDMembreAdd) AS NomMembre,
  (SELECT TT2.Prenom FROM TBL_MEMBRE AS TT2 WHERE TT2.IDMembre = T1.IDMembreAdd) AS PrenomMembre,
  (SELECT TT3.Nom FROM TBL_SECTEUR_TRAD AS TT3 WHERE TT3.IDSecteur = T1.IDSecteur AND TT3.IDLangue = '$pnIdLangue') AS NomSecteur,
  (SELECT TT4.Nom FROM TBL_MACHINE_TRAD AS TT4 WHERE TT4.IDMachine = T1.IDMachine AND TT4.IDLangue = '1') AS NomMachine
FROM
  TBL_FICHE_DE_PROD AS T1
  LEFT JOIN TBL_IMPRESSION AS T2 ON T1.IDImpression = T2.IDImpression AND T2.EstSupp = '0'
WHERE
  T1.EstSupp = 0 AND T1.IDMembreAdd != 1
  $where
GROUP BY
  T1.IDSecteur,
  T1.IDMachine,
  T1.IDMembreAdd";
        $data_stat = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q, "SQL STAT", __FUNCTION__, __FILE__);

        foreach($data_stat AS $key => $value){
            $pnIdMembreAdd = $value->IDMembreAdd;
            $q_nbJour = "SELECT
    COUNT(T1.IDFicheDeProd) AS total
FROM
    TBL_FICHE_DE_PROD AS T1
WHERE
    T1.IDMembreAdd = '$pnIdMembreAdd'
    /*AND fichesprod.datecrea_fichesprod BETWEEN '' AND ''*/
GROUP BY
    TO_DAYS(T1.DateAdd)";
            $data_nbJour = \fbx\DBmysql::getInstance()->getSelectData($q_nbJour);
            $nbJour[$pnIdMembreAdd] = count($data_nbJour);
        }

        $this->_data = array(
            "OUT"=>$args,
            "DATA_SECTEUR"=>$data_secteur,
            "DATA_STAT"=>$data_stat,
            "DATA_NBJOUR"=>$nbJour,
            "Q"=>$q
        );
    }
}