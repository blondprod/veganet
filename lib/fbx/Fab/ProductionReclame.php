<?php
/**
 *
 * Created by blond.
 * File: ProductionReclame.php
 * Date: 28/03/15 - 15:48
 *
 */

namespace fbx\Fab;


class ProductionReclame extends Select
{
    const ClassPage = 'ProductionReclame';

    public $_template = "Production/ProductionReclame.twig";

    //__FUNCTION (no JS) table reclame
    public function getDataTableProductionReclame($args)
    {
//        $this->printr($args);

        $where = $data_reclame = null;
        $pdDateCreaBegin = $pdDateCreaEnd = null;

        $pnIdLangue = $_SESSION['IDLANGUE'];

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= " AND T1.IDSociete = '$pnIdSociete'";
        }
        if (isset($args['Dossier']) && $args['Dossier']!='') {
            $psDossier = ($args['Dossier']);
            $where .= " AND T1.Dossier LIKE '%$psDossier%'";
        }
        if (isset($args['Ref']) && $args['Ref']!='') {
            $psRef = ($args['Ref']);
            $where .= " AND T1.Ref LIKE '%$psRef%'";
        }
        if (isset($args['SelectReclameEtat']) && $args['SelectReclameEtat']>0) {
            $pnIdReclameEtat = ($args['SelectReclameEtat']);
            $where .= " AND T1.IDReclameEtat = '$pnIdReclameEtat'";
        }

        if (isset($args['searchDateDossierCreaBegin']) && $args['searchDateDossierCreaBegin'])  $pdDateCreaBegin = $this->getConvertDate($args['searchDateDossierCreaBegin']);
        if (isset($args['searchDateDossierCreaEnd']) && $args['searchDateDossierCreaEnd'])      $pdDateCreaEnd = $this->getConvertDate($args['searchDateDossierCreaEnd']);
        if ($pdDateCreaBegin != '' && $pdDateCreaEnd != '')                                     $where .= " AND T1.DateAdd BETWEEN '$pdDateCreaBegin' AND '$pdDateCreaEnd 23:59:59'";
        elseif ($pdDateCreaBegin != '' && $pdDateCreaEnd == '')                                 $where .= " AND T1.DateAdd >= '$pdDateCreaBegin'";
        elseif ($pdDateCreaBegin == '' && $pdDateCreaEnd != '')                                 $where .= " AND T1.DateAdd <= '$pdDateCreaEnd 23:59:59'";

        echo '<script type="text/javascript">$(function(){$("#divJumbotron").prop("hidden",true);})</script>';

        $q_reclame = "SELECT
    T1.IDReclame
    , T1.Dossier
    , T1.Ref
    , T1.Quantite
    , T1.DateExpedition
    , T1.DateAdd
    , T1.DateMaj
    , T1.DateReponse
    , T1.Demande
    , T1.Reponse
    , (SELECT CONCAT(TT1.Prenom,' ', TT1.Nom) FROM TBL_MEMBRE AS TT1 WHERE TT1.IDMembre = T1.IDMembreAdd) AS MembreAdd
    , (SELECT CONCAT(TT2.Prenom,' ', TT2.Nom) FROM TBL_MEMBRE AS TT2 WHERE TT2.IDMembre = T1.IDMembreMaj) AS MembreMaj
    , (SELECT CONCAT(TT3.Prenom,' ', TT3.Nom) FROM TBL_MEMBRE AS TT3 WHERE TT3.IDMembre = T1.IDMembreReponse) AS MembreReponse
    , T1.IDReclameEtat
    , T2.Nom AS NomReclameEtat
FROM
    TBL_RECLAME AS T1
    LEFT OUTER JOIN TBL_RECLAME_ETAT_TRAD AS T2 ON T1.IDReclameEtat = T2.IDReclameEtat AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    $where
ORDER BY
    T1.IDReclame DESC";
        $data_reclame = \fbx\DBmysql::getInstance()->getSelectData($q_reclame);

        $this->_data = array(
            "OUT"=>$args,
            "DATA_RECLAME"=>$data_reclame,
            "Q"=>$q_reclame
        );
    }

    public function getClotureReclame($args)
    {
//        $this->printr($args);

        if (isset($args['IDReclameModalCloture']) && $args['IDReclameModalCloture']!='') {
            $pnIdUser = $_SESSION['FBX_USER_ID'];
            $pnIdReclame = ($args['IDReclameModalCloture']);

        $up = "
UPDATE TBL_RECLAME
SET IDReclameEtat = '3' , DateMaj = NOW() , IDMembreMaj = '$pnIdUser'
WHERE IDReclame IN ($pnIdReclame)";

            \fbx\DBmysql::getInstance()->getUpdateData($up);
            $this->getWrLog($up, "cloture reclame $pnIdReclame", __FUNCTION__, __FILE__);

            $this->getDataTableProductionReclame($args);

        } else { echo "<script type='text/javascript'>$(function(){getModalAlert('Pas de dossier séléctionnés');})</script>"; }
    }

    public function getDeleteReclame($args)
    {
//        $this->printr($args);

        if (isset($args['IDReclameModalDelete']) && $args['IDReclameModalDelete']!='') {
            $pnIdUser = $_SESSION['FBX_USER_ID'];
            $pnIdReclame = ($args['IDReclameModalDelete']);

        $up = "
UPDATE TBL_RECLAME
SET EstSupp = '1' , DateSupp = NOW() , IDMembreSupp = '$pnIdUser'
WHERE IDReclame IN ($pnIdReclame)";

            \fbx\DBmysql::getInstance()->getUpdateData($up);
            $this->getWrLog($up, "supp reclame $pnIdReclame", __FUNCTION__, __FILE__);

            $this->getDataTableProductionReclame($args);

        } else { echo "<script type='text/javascript'>$(function(){getModalAlert('Pas de dossier séléctionnés');})</script>"; }
    }

    public function getAddReponse($args)
    {
//        $this->printr($args);

        if (isset($args['IDReclame']) && $args['IDReclame']!='') {
            $pnIdUser = $_SESSION['FBX_USER_ID'];
            $pnIdReclame = ($args['IDReclame']);
            if (isset($args['ReponseModal']) && $args['ReponseModal']!='')  { $psReponse = ($args['ReponseModal']); }   else $psReponse = '';

        $up = "
UPDATE TBL_RECLAME
SET Reponse = '$psReponse' , DateReponse = NOW() , IDMembreReponse = '$pnIdUser' , IDReclameEtat = '2'
WHERE IDReclame IN ($pnIdReclame)";

            \fbx\DBmysql::getInstance()->getUpdateData($up);
            $this->getWrLog($up, "up reclame $pnIdReclame", __FUNCTION__, __FILE__);

            $this->getDataTableProductionReclame($args);

        } else { echo "<script type='text/javascript'>$(function(){getModalAlert('Pas de dossier séléctionnés');})</script>"; }
    }

    public function getInsertProductionReclame($args)
    {
//        $this->printr($args);

        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];

        if (isset($args['DossierModal']) && $args['DossierModal']!='') {

            $psDossier = $args['DossierModal'];

            if (isset($args['RefModal']) && $args['RefModal']!='')                  $psRef = $args['RefModal'];                     else $psRef = '';
            if (isset($args['QuantiteModal']) && $args['QuantiteModal']>'0')        $pnQuantite = intval($args['QuantiteModal']);   else $pnQuantite = 'null';
            if (isset($args['DemandeModal']) && $args['DemandeModal']>'0')          $psDemande = $args['DemandeModal'];             else $psDemande = '';

            if (isset($args['DateExpeditionModal'])) {
                $date = \DateTime::createFromFormat('d/m/Y', $args['DateExpeditionModal']);
                if (is_object($date)) $pdDateExpedition = "'".$date->format('Ymd')."'"; else $pdDateExpedition = 'null';
            } else $pdDateExpedition = 'null';

            $q_insertReclame = "
INSERT INTO TBL_RECLAME
    (IDMembreAdd, DateAdd, Dossier, Ref, Quantite, DateExpedition, Demande, IDSociete)
VALUES
    ('$pnIdUser',NOW(),'$psDossier','$psRef',$pnQuantite,$pdDateExpedition,'$psDemande','$pnIdSociete')";

            $data_Reclame = \fbx\DBmysql::getInstance()->getInsertData($q_insertReclame);

            $this->getWrLog($q_insertReclame, "$data_Reclame", __FUNCTION__, __FILE__);
        }

        $this->getDataTableProductionReclame($args);
    }

    public function getUpdateProductionReclame($args)
    {

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if (isset($args['IDReclameModalUp']) && $args['IDReclameModalUp']>'0') {

//            $this->printr($args);

            $pnIdReclame = $args['IDReclameModalUp'];

            if (isset($args['DossierModalUp']) && $args['DossierModalUp']!='')         $psDossier = $args['DossierModalUp'];             else $psDossier = '';
            if (isset($args['RefModalUp']) && $args['RefModalUp']!='')                  $psRef = $args['RefModalUp'];                     else $psRef = '';
            if (isset($args['QuantiteModalUp']) && $args['QuantiteModalUp']>'0')        $pnQuantite = intval($args['QuantiteModalUp']);   else $pnQuantite = 'null';
            if (isset($args['DemandeModalUp']) && $args['DemandeModalUp']>'0')          $psDemande = $args['DemandeModalUp'];             else $psDemande = '';

            if (isset($args['DateExpeditionModalUp'])) {
                $date = \DateTime::createFromFormat('d/m/Y', $args['DateExpeditionModalUp']);
                if (is_object($date)) $pdDateExpedition = "'".$date->format('Ymd')."'"; else $pdDateExpedition = 'null';
            } else $pdDateExpedition = 'null';

            $up = "
UPDATE
    TBL_RECLAME
SET
    IDMembreMaj = '$pnIdUser',
    DateMaj = NOW(),
    Dossier = '$psDossier',
    Ref = '$psRef',
    Demande = '$psDemande',
    Quantite = '$pnQuantite',
    DateExpedition = $pdDateExpedition
WHERE
    IDReclame = '$pnIdReclame'";

            \fbx\DBmysql::getInstance()->getUpdateData($up);

            $this->getWrLog($up, "up IDReclame : $pnIdReclame", __FUNCTION__, __FILE__);
        }

        $this->getDataTableProductionReclame($args);
    }

    //__ FUNCTION FOR JS
    public function getDataReclameToFillModalEdit($args)
    {
        if (isset($args['IDReclame']) && $args['IDReclame'] > 0) {
            $pnIdReclame = $args['IDReclame'];

            $q = "
SELECT
    IDReclame
    , Dossier
    , Ref
    , Demande
    , Quantite
    , DATE_FORMAT(DateExpedition,'%d/%m/%Y') AS DateExpedition
FROM
    TBL_RECLAME
WHERE
    EstSupp = '0'
    AND IDReclame = '$pnIdReclame'";

            $data_reclame= \fbx\DBmysql::getInstance()->getSelectData($q);
            $this->_data = array("DATA_RECLAME"=>$data_reclame);
        }
    }
}