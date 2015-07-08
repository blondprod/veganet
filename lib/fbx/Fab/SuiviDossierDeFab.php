<?php
/**
 *
 * Created by blond.
 * File: SuiviDossierDeFab.php
 * Date: 21/05/15 - 15:48
 *
 */

namespace fbx\Fab;


class SuiviDossierDeFab extends Select
{
    const ClassPage = 'SuiviDossierDeFab';

    public $_template = "Suivi/SuiviDossierDeFab.twig";

    public function getDataDossierDeFab($args)
    {
        $where = $whereSociete = $whereSociete2 = $whereSecteur = $pdDateExpBegin = $pdDateCreaBegin = $pdDateExpEnd = $pdDateCreaEnd = $resu = null;
        $pnIdLangue = $_SESSION['IDLANGUE'];

        echo '<script type="text/javascript">
    $(function(){
        $(".collapse").collapse("toggle");
        $("#divJumbotron").prop("hidden",true);
    })
</script>';

        if (isset($args['searchDateDossierExpBegin']) && $args['searchDateDossierExpBegin'])    $pdDateExpBegin = $this->getConvertDate($args['searchDateDossierExpBegin']);
        if (isset($args['searchDateDossierExpEnd']) && $args['searchDateDossierExpEnd'])        $pdDateExpEnd = $this->getConvertDate($args['searchDateDossierExpEnd']);
        if ($pdDateExpBegin != '' && $pdDateExpEnd != '')                       $where .= " AND T1.DateExpedition BETWEEN '$pdDateExpBegin' AND '$pdDateExpEnd'";
        elseif ($pdDateExpBegin != '' && $pdDateExpEnd == '')                   $where .= " AND T1.DateExpedition >= '$pdDateExpBegin'";
        elseif ($pdDateExpBegin == '' && $pdDateExpEnd != '')                   $where .= " AND T1.DateExpedition <= '$pdDateExpEnd'";

        if (isset($args['searchDateDossierCreaBegin']) && $args['searchDateDossierCreaBegin'])  $pdDateCreaBegin = $this->getConvertDate($args['searchDateDossierCreaBegin']);
        if (isset($args['searchDateDossierCreaEnd']) && $args['searchDateDossierCreaEnd'])      $pdDateCreaEnd = $this->getConvertDate($args['searchDateDossierCreaEnd']);
        if ($pdDateCreaBegin != '' && $pdDateCreaEnd != '')                     $where .= " AND T1.DateAdd BETWEEN '$pdDateCreaBegin' AND '$pdDateCreaEnd 23:59:59'";
        elseif ($pdDateCreaBegin != '' && $pdDateCreaEnd == '')                 $where .= " AND T1.DateAdd >= '$pdDateCreaBegin'";
        elseif ($pdDateCreaBegin == '' && $pdDateCreaEnd != '')                 $where .= " AND T1.DateAdd <= '$pdDateCreaEnd 23:59:59'";

        if ( isset($args['SelectSecteur']) && $args['SelectSecteur'] >0 )       $where .= " AND (SELECT TT3.IDSecteur FROM TBL_FICHE_DE_PROD AS TT3 WHERE TT3.IDDossierDeFab = T1.IDDossierDeFab AND TT3.EstSupp = '0' ORDER BY TT3.DateAdd DESC LIMIT 0,1 ) = '{$args['SelectSecteur']}'";
        if ( isset($args['Dossier']) && $args['Dossier'] != '' )                $where .= " AND T1.Dossier = '{$args['Dossier']}'";
        if ( isset($args['Ref']) && $args['Ref'] != '' )                        $where .= " AND T1.Ref LIKE '%{$args['Ref']}%'";
        if ($_SESSION['FBX_USER_SU'] != '1' ) {                                 $whereSociete = " AND TT1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        if ($_SESSION['FBX_USER_SU'] != '1' ) {                                 $whereSociete2 = " AND TT2.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }

        if ( isset($args['typeDossier']) && $args['typeDossier'] >0 ){
            $pnTypeDossier = $args['typeDossier'];
            switch ($pnTypeDossier){
                case 1:
                    $where .= " AND T1.EstPliable = '0' AND T1.EstAmalgame = '0'";
                    break;
                case 2:
                    $where .= " AND T1.EstPliable = '1'";
                    break;
                case 3:
                    $where .= " AND T1.EstAmalgame = '1'";
                    break;
                default:
                    break;
            }
        }

        $q_dossier = "SELECT
    T1.IDDossierDeFab AS ID,
    T1.Dossier AS Nom,
    T1.Ref AS Ref,
    T1.Quantite AS Quantite,
    T1.Commentaire AS Commentaire,
    T1.DateExpedition AS DateExpedition,
    T1.NbOption AS NbOption,
    T1.NbElement AS NbElement,
    T1.IDMembreAdd,
    T1.DateAdd,
    T1.DateMaj,
    T1.NbPose,
    T1.NbMachine,
    (SELECT CONCAT(TT1.Prenom,' ', TT1.Nom) FROM TBL_MEMBRE AS TT1 WHERE TT1.IDMembre = T1.IDMembreAdd $whereSociete) AS NomMembre,
    (SELECT CONCAT(TT2.Prenom,' ', TT2.Nom) FROM TBL_MEMBRE AS TT2 WHERE TT2.IDMembre = T1.IDMembreMaj $whereSociete2) AS NomMembreMaj,
    (SELECT TT3.IDSecteur FROM TBL_FICHE_DE_PROD AS TT3 WHERE TT3.IDDossierDeFab = T1.IDDossierDeFab AND TT3.EstSupp = '0' ORDER BY DateAdd DESC LIMIT 0,1 ) AS IDSecteur,
    T1.EstAmalgame,
    T1.EstPliable,
    T1.LargeurFerme,
    T1.HauteurFerme,
    T1.LargeurOuvert,
    T1.HauteurOuvert
FROM
    TBL_DOSSIER_DE_FAB AS T1
WHERE
    T1.EstSupp = '0'
    $where
ORDER BY
    T1.IDDossierDeFab DESC";
        $data_dossier = \fbx\DBmysql::getInstance()->getSelectData($q_dossier);

        $q_option = "SELECT
    T1.IDDossierDeFab_tl_option AS ID,
    T1.IDDossierDeFab AS IDDossierDeFab,
    T1.IDOption AS IDOption,
    T2.Nom AS NomOption
FROM
    TBL_DOSSIER_DE_FAB_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'";
        $data_option = \fbx\DBmysql::getInstance()->getSelectData($q_option);

        for($i=0;$i<=count($data_dossier)-1;$i++){
            $pnIdDossierDeFab = $data_dossier[$i]->ID;
            $q_dossierTlElementTlMachine = "SELECT DISTINCT
  T1.IDDossierDeFab_tl_element_tl_machine
  , T1.IDDossierDeFab_tl_element
  , T1.IDMachine
  , T1.IDImpression
  , T2.Quantite
  , T3.CadenceTourMin AS CadenceHr
  , T3.CalageMin
  , T3.CalageFeuilles
  , T3.GachePour1000Feuilles
  , T5.NbCalage
  , T5.NbTour
  , T6.NbElement
  , ( T5.NbCalage * T3.CalageFeuilles ) AS NbFeuillesCalage
  , ( ( T2.Quantite / 1000 ) * T3.GachePour1000Feuilles ) AS NbFeuilleGache
  , ( T2.Quantite + ( ( T2.Quantite / 1000 ) * T3.GachePour1000Feuilles ) + ( T5.NbCalage * T3.CalageFeuilles ) ) AS NbTotalFeuillesAreserver
  , ( T2.Quantite * T5.NbTour ) AS NbTotalTours
  , ( T3.CalageMin * T5.NbCalage ) AS TmpCalageEnMinutes
  , ( ( ( T2.Quantite * T5.NbTour ) / T3.CadenceTourMin ) * 60 ) AS TmpRouleEnMinutes
  , ( ( ( ( T2.Quantite * T5.NbTour ) / T3.CadenceTourMin ) * 60 ) + ( T3.CalageMin * T5.NbCalage ) ) AS tmpTotalEnMin
FROM
  TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T2 ON T1.IDDossierDeFab_tl_element = T2.IDDossierDeFab_tl_element AND T2.EstSupp = '0'
  LEFT OUTER JOIN TBL_MACHINE AS T3 ON T1.IDMachine = T3.IDMachine AND T3.EstSupp = '0'
  LEFT OUTER JOIN TBL_SECTEUR_TL_IMPRESSION AS T4 ON T4.IDSecteur= T3.IDSecteur AND T4.EstSupp = '0'
  LEFT OUTER JOIN TBL_IMPRESSION AS T5 ON T1.IDImpression = T5.IDImpression AND T5.EstSupp = '0'
  LEFT OUTER JOIN TBL_DOSSIER_DE_FAB AS T6 ON T2.IDDossierDeFab = T6.IDDossierDeFab AND T6.EstSupp = '0'
WHERE
  T1.EstSupp = '0'
  AND T2.IDDossierDeFab = '$pnIdDossierDeFab'";
            $data_dossierTlElementTlMachine = \fbx\DBmysql::getInstance()->getSelectData($q_dossierTlElementTlMachine);
            $NbFeuillesCalage = 0;
            $NbFeuilleGache = 0;
            $Quantite = 0;
//            $NbElement = 0;
            $tmpCalage = 0;
            $tmpRoule = 0;
            foreach($data_dossierTlElementTlMachine AS $key => $val){
                $Quantite = $val->Quantite;
//                $NbElement = $val->NbElement;
//                $NbFeuillesCalage = $val->NbFeuillesCalage + $NbFeuillesCalage;
//                $NbFeuilleGache = $val->NbFeuilleGache + $NbFeuilleGache;
                $tmpCalage = $tmpCalage + ($val->NbCalage * $val->CalageMin);
                if ($val->CadenceHr > 0) $tmpRoule = $tmpRoule + ( ($Quantite * $val->NbTour) / $val->CadenceHr * 60 );
                else $tmpRoule = $tmpRoule + 0;
            }
//            $resu[$pnIdDossierDeFab]['NbFeuillesCalage'] = intval($NbFeuillesCalage);
//            $resu[$pnIdDossierDeFab]['NbFeuilleGache'] = intval($NbFeuilleGache);
//            $resu[$pnIdDossierDeFab]['Quantite'] = intval($Quantite);
//            $resu[$pnIdDossierDeFab]['tmpCalage'] = intval($tmpCalage);
//            $resu[$pnIdDossierDeFab]['tmpRoule'] = intval($tmpRoule);
            $resu[$pnIdDossierDeFab]['tmpTotal'] = intval($tmpCalage+$tmpRoule);
//            $resu[$pnIdDossierDeFab]['NbTotalFeuillesAreserver'] = intval($NbFeuillesCalage+$NbFeuilleGache+($Quantite*$NbElement));
        }

        $this->_data = array(
            "data_option"=>$data_option,
            "data_dossier"=>$data_dossier,
            "data_dossierTlElementTlMachine"=>$resu,
            "OUT"=>$args
        );

//        $this->printr($_SESSION);

    }

    public function getDossierDeFabElement($args)
    {
        $pnIdLangue = $_SESSION['IDLANGUE'];
        $this->_template = "elements/listeElementsDossiersDeFab.twig";
        $pnIdDossierDeFab = $args['IDDossierDeFab'];

        //__ SELECT DOSSIER_TL_ELEMENT
        $q = "SELECT DISTINCT
    T1.IDDossierDeFab_tl_element AS ID,
    T1.IDDossierDeFab AS IDDossierDeFab,
    T1.IDSupport AS IDSupport,
    T1.IDFormat AS IDFormat,
    T1.IDImpression AS IDImpression,
    T1.Quantite AS Quantite,
    T1.Commentaire AS Commentaire,
    T1.IDElement AS IDElement,
    T2.Nom AS NomSupport,
    T3.Nom AS NomFormat,
#    T4.Nom AS NomImpression,
    T5.Nom AS Element
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2 ON T1.IDSupport = T2.IDSupport AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T3 ON T1.IDFormat = T3.IDFormat AND T3.IDLangue = '$pnIdLangue'
#    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T4 ON T1.IDImpression = T4.IDImpression AND T4.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T5 ON T1.IDElement = T5.IDElement AND T5.IDLangue = '$pnIdLangue'
WHERE
    T1.IDDossierDeFab = '$pnIdDossierDeFab'
    AND T1.EstSupp = '0'
ORDER BY
    T1.IDDossierDeFab_tl_element";
        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        //__ SELECT DOSSIER_TL_ELEMENT_TL_OPTION
        $q_option = "SELECT
    T1.IDDossierDeFab_tl_element,
    T2.Nom
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T3 ON T3.IDDossierDeFab_tl_element = T1.IDDossierDeFab_tl_element AND T3.EstSupp = '0'
WHERE
    T1.EstSupp = '0'
    AND T3.IDDossierDeFab = '$pnIdDossierDeFab'";
        $data_option = \fbx\DBmysql::getInstance()->getSelectData($q_option);

        //__ SELECT DOSSIER_TL_ELEMENT_TL_MACHINE
        $q_machine = "SELECT
    T1.IDDossierDeFab_tl_element,
    T1.DateAdd,
    T2.Nom,
    T3.Nom AS NomImpression,
    T7.NbTour,
    T8.Quantite
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T2 ON T1.IDMachine = T2.IDMachine AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T3 ON T1.IDImpression = T3.IDImpression AND T3.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_MACHINE AS T4 ON T2.IDMachine = T4.IDMachine AND T4.EstSupp = '0'
    LEFT OUTER JOIN TBL_SECTEUR AS T5 ON T4.IDSecteur = T5.IDSecteur AND T5.EstSupp = '0'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T6 ON T6.IDDossierDeFab_tl_element = T1.IDDossierDeFab_tl_element AND T6.EstSupp = '0'
    LEFT OUTER JOIN TBL_IMPRESSION AS T7 ON T7.IDImpression = T1.IDImpression AND T7.EstSupp = '0'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T8 ON T8.IDDossierDeFab_tl_element = T1.IDDossierDeFab_tl_element #AND T8.EstSupp = '0'
WHERE
    T1.EstSupp = '0' AND T8.EstSupp = '0'
    AND T6.IDDossierDeFab = '$pnIdDossierDeFab'
ORDER BY
    IFNULL(T5.Ordre,9999)";
        $data_machine = \fbx\DBmysql::getInstance()->getSelectData($q_machine);

        //__ SELECT FICHE_DE_PROD
        $q_ficheDeProd = "SELECT
	T2.IDDossierDeFab,
	T1.Dossier,
	T1.IDElement,
    T1.IDSecteur,
	T1.IDMachine,
	T1.IDMembreAdd,
	T1.DateAdd,
	T3.Nom AS NomSecteur,
	T4.Nom AS NomMachine,
	CONCAT(T5.Prenom,' ', T5.Nom) AS NomMembre,
	T6.Nom AS Element,
	T7.Nom AS NomImpression
FROM
    TBL_FICHE_DE_PROD AS T1
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB AS T2 ON T1.IDDossierDeFab = T2.IDDossierDeFab #AND T2.EstSupp = '0'
	LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T3 ON T1.IDSecteur = T3.IDSecteur AND T3.IDLangue = '$pnIdLangue'
	LEFT OUTER JOIN TBL_MACHINE_TRAD AS T4 ON T1.IDMachine = T4.IDMachine AND T4.IDLangue = '$pnIdLangue'
	LEFT OUTER JOIN TBL_MEMBRE AS T5 ON T1.IDMembreAdd = T5.IDMembre AND T5.EstSupp = '0'
	LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T6 ON T1.IDElement = T6.IDElement AND T6.IDLangue = '$pnIdLangue'
	LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T7 ON T1.IDImpression = T7.IDImpression AND T7.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0' AND T2.EstSupp = '0'
    AND T2.IDDossierDeFab = '$pnIdDossierDeFab'
ORDER BY
    T1.DateAdd ASC";
        $data_ficheDeProd = \fbx\DBmysql::getInstance()->getSelectData($q_ficheDeProd);

        $this->_data = array(
            "OUT"=>$args,
            "DATA"=>$data,
            "OPTION"=>$data_option,
            "MACHINE"=>$data_machine,
            "FICHE"=>$data_ficheDeProd
        );
    }

    public function getData2EditDossierDeFabElement($args)
    {
        $this->_template = "elements/modalEditDossierDeFab.twig";

        $pnIdDossierDeFab = $args['IDDossierDeFab'];
        $pnIdLangue = $_SESSION['IDLANGUE'];

        //__ SQL DOSSIER DE FAB
        $q = "SELECT
    T1.IDDossierDeFab,
    T1.Dossier,
    T1.Ref,
    T1.Quantite,
    T1.Commentaire,
    T1.DateExpedition,
    T1.NbOption,
    T1.NbElement,
    T1.NbMachine,
    T1.EstPliable,
    T1.EstAmalgame,
    T1.LargeurOuvert,
    T1.HauteurOuvert,
    T1.LargeurFerme,
    T1.HauteurFerme,
    T1.NbPose
FROM
    TBL_DOSSIER_DE_FAB AS T1
WHERE
    T1.IDDossierDeFab = '$pnIdDossierDeFab'";
        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        //__ SQL DOSSIER DE FAB TL OPTION
        $q_option = "SELECT
    T1.IDDossierDeFab_tl_option,
    T1.IDOption,
    T2.Nom
FROM
    TBL_DOSSIER_DE_FAB_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.IDDossierDeFab = '$pnIdDossierDeFab'";
        $data_option = \fbx\DBmysql::getInstance()->getSelectData($q_option);

        //__ SQL DOSSIER DE FAB TL ELEMENT
        $q_element = "SELECT
    T1.IDDossierDeFab_tl_element,
    T1.IDDossierDeFab,
    T1.IDElement,
    T6.Nom AS Element,
    T1.Quantite,
    T1.IDSupport,
    T1.IDFormat,
    T1.IDImpression,
    T1.Commentaire
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T1
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T6 ON T1.IDElement = T6.IDElement AND T6.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.IDDossierDeFab = '$pnIdDossierDeFab'";
        $data_element = \fbx\DBmysql::getInstance()->getSelectData($q_element);

        //__ SQL DOSSIER DE FAB TL ELEMENT TL OPTION
        $q_element_tl_option = "SELECT
    T1.IDDossierDeFab_tl_element_tl_option AS IDElement_tl_option,
    T1.IDOption,
    T2.Nom,
    T6.Nom AS Element,
    T3.IDElement
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T3 ON T1.IDDossierDeFab_tl_element = T3.IDDossierDeFab_tl_element AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T6 ON T3.IDElement = T6.IDElement AND T6.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T3.IDDossierDeFab = '$pnIdDossierDeFab'";
        $data_element_tl_option = \fbx\DBmysql::getInstance()->getSelectData($q_element_tl_option);

        //__ SQL DOSSIER DE FAB TL ELEMENT TL MACHINE
        $q_element_tl_machine = "SELECT
    T1.IDDossierDeFab_tl_element_tl_machine AS IDElement_tl_machine,
    T1.IDDossierDeFab_tl_element,
    T1.IDMachine,
    T1.IDImpression,
    T2.Nom,
    T6.Nom AS Element,
    T3.IDElement
FROM
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T2 ON T1.IDMachine = T2.IDMachine AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T3 ON T1.IDDossierDeFab_tl_element = T3.IDDossierDeFab_tl_element AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T6 ON T3.IDElement = T6.IDElement AND T6.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T3.IDDossierDeFab = '$pnIdDossierDeFab'";
        $data_element_tl_machine = \fbx\DBmysql::getInstance()->getSelectData($q_element_tl_machine);

        $this->_data = array(
            "OUT"=>$args
            ,"DATA"=>$data
            ,"DATA_OPTION"=>$data_option
            ,"DATA_ELEMENT"=>$data_element
            ,"DATA_ELEMENT_TL_OPTION"=>$data_element_tl_option
            ,"DATA_ELEMENT_TL_MACHINE"=>$data_element_tl_machine
            ,"Q"=>$q
            ,"Q_OPTION"=>$q_option
            ,"Q_ELEMENT"=>$q_element
            ,"Q_ELEMENT_TL_OPTION"=>$q_element_tl_option
            ,"Q_ELEMENT_TL_MACHINE"=>$q_element_tl_machine
        );
    }

    public function getUpdateDataDossierDeFab($args)
    {
//        $this->printr($args);

        $array_up_dossierTlOption = $array_up_dossierTlElement = $array_up_dossierTlElementTlOption = $array_ins_dossierTlElementTlOption = $array_up_dossierTlElementTlMachine = null;
        $up_dossierTlOption = $up_dossierTlElement = $up_dossierTlElementTlOption = $up_dossierTlElementTlMachine = null;
        $insert_option = $jnsert_element_TL_option = $jnsert_element_TL_machine = null;

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if ( isset($args['IDDossierDeFab']) && $args['IDDossierDeFab'] != '' )      $pnIdDossierDeFab = $args['IDDossierDeFab'];else $pnIdDossierDeFab = '0';
        if ( isset($args['DossierModal']) && $args['DossierModal'] != '' )          $psDossier = $args['DossierModal'];         else $psDossier = '';
        if ( isset($args['RefModal']) && $args['RefModal'] != '' )                  $psRef = $args['RefModal'];                 else $psRef = '';
        if ( isset($args['CommentaireModal']) && $args['CommentaireModal'] != '' )  $psCommentaire = $args['CommentaireModal']; else $psCommentaire = '';
        if ( isset($args['QuantiteModal']) && $args['QuantiteModal'] != '' )        $pnQuantite = $args['QuantiteModal'];       else $pnQuantite = '0';
        if ( isset($args['Amalgame']) )                                             $pbAmalgame = '1';                          else $pbAmalgame = '0';
        if ( isset($args['NbPoseModal']) && $args['NbPoseModal'] != '' )            $pnNbPose = $args['NbPoseModal'];                else $pnNbPose = '1';
        if ( isset($args['LargeurOuvert']) && $args['LargeurOuvert'] != '' )        $pnLargeurOuvert = $args['LargeurOuvert'];  else $pnLargeurOuvert = '0';
        if ( isset($args['LargeurFerme']) && $args['LargeurFerme'] != '' )          $pnLargeurFerme = $args['LargeurFerme'];    else $pnLargeurFerme = '0';
        if ( isset($args['HauteurOuvert']) && $args['HauteurOuvert'] != '' )        $pnHauteurOuvert = $args['HauteurOuvert'];  else $pnHauteurOuvert = '0';
        if ( isset($args['HauteurFerme']) && $args['HauteurFerme'] != '' )          $pnHauteurFerme = $args['HauteurFerme'];    else $pnHauteurFerme = '0';
        if ( isset($args['NbOptionModal']) && $args['NbOptionModal'] != '' )        $pnNbOption = $args['NbOptionModal'];            else $pnNbOption = '0';
        if ( isset($args['NbElementModal']) && $args['NbElementModal'] != '' )      $pnNbElement = $args['NbElementModal'];          else $pnNbElement = '0';
        if ( isset($args['NbMachineModal']) && $args['NbMachineModal'] != '' )      $pnNbMachine = $args['NbMachineModal'];     else $pnNbMachine = '0';
        if ( isset($args['Pliage']) )                                               $pbPliage = '1';                            else $pbPliage = '0';
        if ( isset($args['DateExpeditionModal']) ) {
            $date=\DateTime::createFromFormat('d/m/Y',$args['DateExpeditionModal']);
            if (is_object($date))                                                   $pdDateExpedition = $date->format('Ymd');   else $pdDateExpedition = '';
        }                                                                                                                       else $pdDateExpedition = '';

        if ( $pnIdDossierDeFab > '0' ) {

            //__CREATE CODE BARRE
            $path = ($_SESSION['BARCODE']['PATH']);
            $link = ($_SESSION['BARCODE']['IMG'])."/dossier";
            $contenu_barcode = "%%".$psDossier;
            $url = "$path?$contenu_barcode&dossier-$pnIdDossierDeFab&$link";
            $this->cURLexec($url);
//            $this->getWrLog("CodeBarre Dossier", "$url", __FUNCTION__, __FILE__);

            //__CREATE QRcode
            $path= $_SESSION['QR']['PATH'];
            $link= $_SESSION['QR']['IMG']."/dossier";
            $ref = $_SESSION['QR']['DOSSIER']."?action=getDataDossierDeFabForFiche&IDDossierDeFab=$pnIdDossierDeFab";
            $url = "$path?dossier-$pnIdDossierDeFab&$link&$ref";
            $this->cURLexec($url);
//            $this->getWrLog("QRcode Dossier", "$url", __FUNCTION__, __FILE__);

            //__ up tbl_dossier_defab
            $up_dossier = "UPDATE
    TBL_DOSSIER_DE_FAB AS T1
SET
    T1.Dossier = '$psDossier',
    T1.Ref = '$psRef',
    T1.Commentaire = '$psCommentaire',
    T1.EstPliable = '$pbPliage',
    T1.EstAmalgame = '$pbAmalgame',
    T1.LargeurOuvert = '$pnLargeurOuvert',
    T1.HauteurOuvert = '$pnHauteurOuvert',
    T1.LargeurFerme = '$pnLargeurFerme',
    T1.HauteurFerme = '$pnHauteurFerme',
    T1.Quantite = '$pnQuantite',
    T1.DateExpedition = '$pdDateExpedition',
    T1.IDMembreMaj = '$pnIdUser',
    T1.NbPose = '$pnNbPose',
    T1.DateMaj = NOW(),
    T1.NbMachine = '$pnNbMachine',
    T1.NbElement = '$pnNbElement',
    T1.NbOption = '$pnNbOption'
WHERE
    T1.IDDossierDeFab = '$pnIdDossierDeFab' ";
            \fbx\DBmysql::getInstance()->getUpdateData($up_dossier);
            $this->getWrLog($up_dossier, "up dossier $pnIdDossierDeFab", __FUNCTION__, __FILE__);

            //__ up tbl_dossier_de_fab_tl_option
            if ($pnNbOption>0) {
                $qdelete_dossierTlOption = "UPDATE TBL_DOSSIER_DE_FAB_TL_OPTION SET EstSupp = '1', IDMembreSupp = '$pnIdUser', DateSupp = NOW() WHERE IDDossierDeFab = '$pnIdDossierDeFab'";
                \fbx\DBmysql::getInstance()->getUpdateData($qdelete_dossierTlOption);
                $this->getWrLog($qdelete_dossierTlOption, "delete dossier tl option", __FUNCTION__, __FILE__);

                //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_OPTION
                for ($i = 1; $i <= $pnNbOption; $i++) {
                    if (isset($args['Option' . ($i)]) && $args['Option' . ($i)] > '0') {
                        $insert_option[] = "('$pnIdDossierDeFab','" . intval($args['Option' . ($i)]) . "','$pnIdUser',NOW())";
                    }
                }
                if (count($insert_option) >= 1) {
                    $q_ins_dossier_option = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_OPTION
  (IDDossierDeFab, IDOption, IDMembreAdd, DateAdd)
VALUES
  " . implode(',', $insert_option) . "";
                    $pnIdDossierDeFabTlOption = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_option);
                    $this->getWrLog($q_ins_dossier_option, "pnIdDossierDeFabTlOption=>$pnIdDossierDeFabTlOption", __FUNCTION__, __FILE__);
                }
            }

            //__ up tbl_dossier_de_fab_tl_element
            if ($pnNbElement>0) {
                $qdelete_dossierTlElement = "UPDATE TBL_DOSSIER_DE_FAB_TL_ELEMENT SET EstSupp = '1', IDMembreSupp = '$pnIdUser', DateSupp = NOW() WHERE IDDossierDeFab = '$pnIdDossierDeFab'";
                \fbx\DBmysql::getInstance()->getUpdateData($qdelete_dossierTlElement);
                $this->getWrLog($qdelete_dossierTlElement, "delete dossier tl element", __FUNCTION__, __FILE__);

                for ($j = 1; $j <= $pnNbElement; $j++) {
                    if ( isset($args["Element".$j]) && $args["Element".$j] != '' )        $pn_elementElement = $args["Element".$j];          else $pn_elementElement = '0';
                    if ( isset($args["Quantite".$j]) && $args["Quantite".$j] != '' )      $pn_elementQuantite = $args["Quantite".$j];        else $pn_elementQuantite = '0';
                    if ( isset($args["Support".$j]) && $args["Support".$j] != '' )        $pn_elementSupport = $args["Support".$j];          else $pn_elementSupport = '0';
                    if ( isset($args["Format".$j]) && $args["Format".$j] != '' )          $pn_elementFormat = $args["Format".$j];            else $pn_elementFormat = '0';
                    if ( isset($args["Commentaire".$j]) && $args["Commentaire".$j] != '' )$ps_elementCommentaire = $args["Commentaire".$j];  else $ps_elementCommentaire = '';

                    //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT
                    $q_ins_dossier_element = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT
  (IDMembreAdd, DateAdd,IDDossierDeFab, IDElement, Quantite, IDSupport, IDFormat, Commentaire)
VALUES
  ('$pnIdUser',NOW(),'$pnIdDossierDeFab','$pn_elementElement','$pn_elementQuantite','$pn_elementSupport','$pn_elementFormat','$ps_elementCommentaire')";
                    $pnIdDossierDeFab_tl_element = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_element);
                    $this->getWrLog($q_ins_dossier_element, "pnIdDossierDeFabTlElement=>$pnIdDossierDeFab_tl_element", __FUNCTION__, __FILE__);

                    //__ QUERY TO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
                    for ($n = 1; $n <= $pnNbOption; $n++) {
                        if (isset($pnIdDossierDeFab_tl_element) && $pnIdDossierDeFab_tl_element > '0') {
                            if (isset($args['Option' . $j . 'Element' . $n]) && $args['Option' . $j . 'Element' . $n] > '0') {
                                $jnsert_element_TL_option[] = "('$pnIdUser',NOW(),'$pnIdDossierDeFab_tl_element','" . $args['Option' . $j . 'Element' . $n] . "')";
                            }
                        }
                    }

                    //__ QUERY TO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE
                    for ($x = 1; $x <= $pnNbMachine; $x++) {
                        if (isset($pnIdDossierDeFab_tl_element) && $pnIdDossierDeFab_tl_element > '0') {
                            if (isset($args['Element' . $j . 'Machine' . $x]) && $args['Element' . $j . 'Machine' . $x] > '0') {
                                if (isset($args['Element' . $j . 'MachineImpression' . $x]) && $args['Element' . $j . 'MachineImpression' . $x] > '0') { $pnElementTlMachineImpression = $args['Element' . $j . 'MachineImpression' . $x]; } else { $pnElementTlMachineImpression = '0'; }
                                $pnElementTlMachine = $args['Element' . $j . 'Machine' . $x];
                                $jnsert_element_TL_machine[] = "('$pnIdUser',NOW(),'$pnIdDossierDeFab_tl_element','$pnElementTlMachine','$pnElementTlMachineImpression')";
                            }
                        }
                    }

                    //__CREATE CODE BARRE
                    $path = ($_SESSION['BARCODE']['PATH']);
                    $link = ($_SESSION['BARCODE']['IMG'])."/dossier";
                    $contenu_barcode = "(($pnIdDossierDeFab(($pn_elementElement";
                    $url = "$path?$contenu_barcode&dossiertlement-$pnIdDossierDeFab_tl_element&$link";
                    $this->cURLexec($url);
                }
                //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
                if (count($jnsert_element_TL_option) >= 1) {
                    $q_ins_dossier_element_tl_option = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
    (IDMembreAdd, DateAdd, IDDossierDeFab_tl_element, IDOption)
VALUES
    " . implode(',', $jnsert_element_TL_option) . "";
                    $pnIdElementTlOption = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_element_tl_option);
                    $this->getWrLog($q_ins_dossier_element_tl_option, "pnIdElementTlOption=>$pnIdElementTlOption", __FUNCTION__, __FILE__);
                }

                //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE
                if (count($jnsert_element_TL_machine) >= 1) {
                    $q_ins_dossier_element_tl_machine = "INSERT INTO
TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE
    (IDMembreAdd, DateAdd, IDDossierDeFab_tl_element, IDMachine, IDImpression)
VALUES
    " . implode(',', $jnsert_element_TL_machine) . "";
                    $pnIdElementTlMachine = \fbx\DBmysql::getInstance()->getInsertData($q_ins_dossier_element_tl_machine);
                    $this->getWrLog($q_ins_dossier_element_tl_machine, "pnIdElementTlMachine=>$pnIdElementTlMachine", __FUNCTION__, __FILE__);
                }
            }
        }

//        $this->printr($args);

        $this->_data = array("OUT"=>$args);

        $this->getDataDossierDeFab($args);
    }

    public function Save_getUpdateDataDossierDeFab($args)
    {
//        $this->printr($args);
        $array_up_dossierTlOption = $array_up_dossierTlElement = $array_up_dossierTlElementTlOption = $array_ins_dossierTlElementTlOption = $array_up_dossierTlElementTlMachine = null;
        $up_dossierTlOption = $up_dossierTlElement = $up_dossierTlElementTlOption = $up_dossierTlElementTlMachine = null;
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        if ( isset($args['IDDossierDeFab']) && $args['IDDossierDeFab'] != '' )      $pnIdDossierDeFab = $args['IDDossierDeFab'];else $pnIdDossierDeFab = '0';
        if ( isset($args['DossierModal']) && $args['DossierModal'] != '' )          $psDossier = $args['DossierModal'];         else $psDossier = '';
        if ( isset($args['RefModal']) && $args['RefModal'] != '' )                  $psRef = $args['RefModal'];                 else $psRef = '';
        if ( isset($args['CommentaireModal']) && $args['CommentaireModal'] != '' )  $psCommentaire = $args['CommentaireModal']; else $psCommentaire = '';
        if ( isset($args['Pliage']) )                                               $pbPliage = '1';                            else $pbPliage = '0';
        if ( isset($args['Amalgame']) )                                             $pbAmalgame = '1';                          else $pbAmalgame = '0';
        if ( isset($args['LargeurOuvert']) && $args['LargeurOuvert'] != '' )        $pnLargeurOuvert = $args['LargeurOuvert'];  else $pnLargeurOuvert = '0';
        if ( isset($args['HauteurOuvert']) && $args['HauteurOuvert'] != '' )        $pnHauteurOuvert = $args['HauteurOuvert'];  else $pnHauteurOuvert = '0';
        if ( isset($args['LargeurFerme']) && $args['LargeurFerme'] != '' )          $pnLargeurFerme = $args['LargeurFerme'];    else $pnLargeurFerme = '0';
        if ( isset($args['HauteurFerme']) && $args['HauteurFerme'] != '' )          $pnHauteurFerme = $args['HauteurFerme'];    else $pnHauteurFerme = '0';
        if ( isset($args['QuantiteModal']) && $args['QuantiteModal'] != '' )        $pnQuantite = $args['QuantiteModal'];       else $pnQuantite = '0';
        if ( isset($args['NbOption']) && $args['NbOption'] != '' )                  $pnNbOption = $args['NbOption'];            else $pnNbOption = '0';
        if ( isset($args['NbElement']) && $args['NbElement'] != '' )                $pnNbElement = $args['NbElement'];          else $pnNbElement = '0';
        if ( isset($args['NbPose']) && $args['NbPose'] != '' )                      $pnNbPose = $args['NbPose'];                else $pnNbPose = '1';
        if ( isset($args['DateExpeditionModal']) ) {
            $date=\DateTime::createFromFormat('d/m/Y',$args['DateExpeditionModal']);
            if (is_object($date))                                                   $pdDateExpedition = $date->format('Ymd');   else $pdDateExpedition = '';
        }                                                                                                                       else $pdDateExpedition = '';

        if ( $pnIdDossierDeFab > '0' ) {

            //__CREATE CODE BARRE
            $path = ($_SESSION['BARCODE']['PATH']);
            $link = ($_SESSION['BARCODE']['IMG'])."/dossier";
            $contenu_barcode = "%%".$psDossier;
            $url = "$path?$contenu_barcode&dossier-$pnIdDossierDeFab&$link";
            $this->cURLexec($url);
//            $this->getWrLog("CodeBarre Dossier", "$url", __FUNCTION__, __FILE__);

            //__CREATE QRcode
            $path= $_SESSION['QR']['PATH'];
            $link= $_SESSION['QR']['IMG']."/dossier";
            $ref = $_SESSION['QR']['DOSSIER']."?action=getDataDossierDeFabForFiche&IDDossierDeFab=$pnIdDossierDeFab";
            $url = "$path?dossier-$pnIdDossierDeFab&$link&$ref";
            $this->cURLexec($url);
//            $this->getWrLog("QRcode Dossier", "$url", __FUNCTION__, __FILE__);

            //__ up tbl_dossier_defab
            $up_dossier = "UPDATE
    TBL_DOSSIER_DE_FAB AS T1
SET
    T1.Dossier = '$psDossier',
    T1.Ref = '$psRef',
    T1.Commentaire = '$psCommentaire',
    T1.EstPliable = '$pbPliage',
    T1.EstAmalgame = '$pbAmalgame',
    T1.LargeurOuvert = '$pnLargeurOuvert',
    T1.HauteurOuvert = '$pnHauteurOuvert',
    T1.LargeurFerme = '$pnLargeurFerme',
    T1.HauteurFerme = '$pnHauteurFerme',
    T1.Quantite = '$pnQuantite',
    T1.DateExpedition = '$pdDateExpedition',
    T1.IDMembreMaj = '$pnIdUser',
    T1.NbPose = '$pnNbPose',
    T1.DateMaj = NOW()
WHERE
    T1.IDDossierDeFab = '$pnIdDossierDeFab' ";

            //__ up tbl_dossier_de_fab_tl_element
            if ($pnNbElement>0) {
                for ($i = 0; $i < $pnNbElement; $i++) {
                    if ( isset($args["Element_".$i]) && $args["Element_".$i] != '' )        $pn_elementElement = $args["Element_".$i];          else $pn_elementElement = '0';
                    if ( isset($args["Quantite_".$i]) && $args["Quantite_".$i] != '' )      $pn_elementQuantite = $args["Quantite_".$i];        else $pn_elementQuantite = '0';
                    if ( isset($args["Support_".$i]) && $args["Support_".$i] != '' )        $pn_elementSupport = $args["Support_".$i];          else $pn_elementSupport = '0';
                    if ( isset($args["Format_".$i]) && $args["Format_".$i] != '' )          $pn_elementFormat = $args["Format_".$i];            else $pn_elementFormat = '0';
                    if ( isset($args["Impression_".$i]) && $args["Impression_".$i] != '' )  $pn_elementImpression = $args["Impression_".$i];    else $pn_elementImpression = '0';
                    if ( isset($args["Commentaire_".$i]) && $args["Commentaire_".$i] != '' )$ps_elementCommentaire = $args["Commentaire_".$i];  else $ps_elementCommentaire = '';
                    $pnIdDossierDeFab_tl_element = $args['IDDossierDeFab_tl_element_' . $i];

                    $array_up_dossierTlElement[] = "UPDATE
    TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T1
SET
    T1.DateMaj = NOW(),
    T1.IDElement = '$pn_elementElement',
    T1.Quantite = '$pn_elementQuantite',
    T1.IDSupport = '$pn_elementSupport',
    T1.IDFormat = '$pn_elementFormat',
    T1.IDImpression = '$pn_elementImpression',
    T1.Commentaire = '$ps_elementCommentaire',
    T1.IDMembreMaj = '$pnIdUser'
WHERE
    T1.EstProtected = '0'
    AND T1.IDDossierDeFab_tl_element = '$pnIdDossierDeFab_tl_element'";

                    //__CREATE CODE BARRE
                    $path = ($_SESSION['BARCODE']['PATH']);
                    $link = ($_SESSION['BARCODE']['IMG'])."/dossier";
//                    $contenu_barcode = "()".$pn_elementElement."()";
                    $contenu_barcode = "(($pnIdDossierDeFab(($pn_elementElement";
                    $url = "$path?$contenu_barcode&dossiertlement-$pnIdDossierDeFab_tl_element&$link";
                    $this->cURLexec($url);

                    //__ up tbl_dossier_de_fab_tl_machine
                    if ( isset($args["Element".($i+1)."NbMachine"]) && $args["Element".($i+1)."NbMachine"] != '' )$pn_NbMachine = $args["Element".($i+1)."NbMachine"];  else $pn_NbMachine = '';
                    if ($pn_NbMachine > 0) {
                        for ($k = 0; $k < $pn_NbMachine; $k++) {
                            if (isset ($args["Element" . ($i+1) . "Machine" . ($k+1)]) && $args["Element" . ($i+1) . "Machine" . ($k+1)] > 0) {
                                $pnElementTlMachine = $args["Element" . ($i+1) . "Machine" . ($k+1)];
                            } else $pnElementTlMachine = '0';
                            if (isset ($args["Element" . ($i+1) . "MachineImpression" . ($k+1)]) && $args["Element" . ($i+1) . "MachineImpression" . ($k+1)] > 0) {
                                $pnElementTlMachineImpression = $args["Element" . ($i+1) . "MachineImpression" . ($k+1)];
                            } else $pnElementTlMachineImpression = '0';
                            $pn_IDDossierDeFab_tl_element_tl_machine = $args["IDElement" . ($i+1) . "Machine" . ($k+1)];
                            $array_up_dossierTlElementTlMachine[] = "UPDATE
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_MACHINE AS T1
SET
    T1.IDMachine = '$pnElementTlMachine'
    , T1.IDImpression = '$pnElementTlMachineImpression'
WHERE
    T1.IDDossierDeFab_tl_element_tl_machine = '$pn_IDDossierDeFab_tl_element_tl_machine'";
                        }
                        $up_dossierTlElementTlMachine = implode(';', $array_up_dossierTlElementTlMachine);
                    }
                }
                //__ convert array on chaine
                $up_dossierTlElement = implode(';', $array_up_dossierTlElement);
            }

            //__ up tbl_dossier_de_fab_tl_option
            if ($pnNbOption>0) {
                for ($i = 0; $i < $pnNbOption; $i++) {
                    if ( isset($args["selectOptionModal_".$i]) && $args["selectOptionModal_".$i] != '' )  $pnIdOption = $args["selectOptionModal_".$i];    else $pnIdOption = '0';
                    $pnIdDossierDeFab_tl_option = $args['IDDossierDeFab_tl_option_' . $i];
                    $array_up_dossierTlOption[] = "UPDATE
    TBL_DOSSIER_DE_FAB_TL_OPTION AS T1
SET
    T1.DateMaj = NOW(),
    T1.IDOption = '$pnIdOption',
    T1.IDMembreMaj = '$pnIdUser'
WHERE
    T1.EstProtected = '0'
    AND T1.IDDossierDeFab_tl_option = '$pnIdDossierDeFab_tl_option'";

                    //__ up tbl_dossier_de_fab_tl_element_tl_option
                    for ($j = 0; $j < $pnNbElement; $j++){
                        $pnIdDossierDeFab_tl_element = $args['IDDossierDeFab_tl_element_' . $j];
                        if ( isset($args['Option'.($j+1).'Element'.($i+1)]) && $args['Option'.($j+1).'Element'.($i+1)] != '' )  $pnIdOption = $args['Option'.($j+1).'Element'.($i+1)];    else $pnIdOption = '0';

                        if ( isset ($args['IDDossierDeFab_tl_element_'.$j.'_tl_option_'.$i]) && $args['IDDossierDeFab_tl_element_'.$j.'_tl_option_'.$i] != '' ){
                            $pnIdDossierDeFab_tl_element_tl_option = $args['IDDossierDeFab_tl_element_'.$j.'_tl_option_'.$i];
                            $array_up_dossierTlElementTlOption[] = "UPDATE
    TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION AS T1
SET
    T1.DateMaj = NOW(),
    T1.IDMembreMaj = '$pnIdUser',
    T1.IDOption = '$pnIdOption'
WHERE
    T1.IDDossierDeFab_tl_element_tl_option = '$pnIdDossierDeFab_tl_element_tl_option'";
                        } else {
                            if ( $pnIdOption > 0 && $pnIdDossierDeFab_tl_element > 0 ){
                                $array_up_dossierTlElementTlOption[] = "INSERT INTO
TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
(IDDossierDeFab_tl_element, IDOption, IDMembreAdd, DateAdd)
VALUES
($pnIdDossierDeFab_tl_element,'$pnIdOption','$pnIdUser',NOW())";
                            }
                        }
                    }
                    $up_dossierTlElementTlOption = implode(';', $array_up_dossierTlElementTlOption);
                }
                //__ convert array on chaine
                $up_dossierTlOption = implode(';', $array_up_dossierTlOption);
            }

            $q = $up_dossier . ";" . $up_dossierTlElement . ";" . $up_dossierTlOption . ";" . $up_dossierTlElementTlOption . ";" . $up_dossierTlElementTlMachine;

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, "up dossier de fab", __FUNCTION__, __FILE__);

//            $this->printr($data);
        }

//        $this->printr($args);

        $this->_data = array("OUT"=>$args);

        $this->getDataDossierDeFab($args);
    }
}