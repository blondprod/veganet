<?php
/**
 *
 * Created by blond.
 * File: GestionFournisseur.php
 * Date: 11/07/15 - 15:48
 *
 */

namespace fbx\Fab;


class GestionFournisseur extends Select
{
    const ClassPage = 'GestionFournisseur';

    public $_template = "Gestion/GestionFournisseur.twig";

    public function getDataFournisseur($args)
    {
        $where = null;
        $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];

        echo '<script type="text/javascript">
    $(function(){
//        $(".collapse").collapse("toggle");
        $("#divJumbotron").prop("hidden",true);
    })
</script>';

        if ( isset($args['Entreprise']) && $args['Entreprise'] != '' ) $where .= " AND T1.Nom LIKE '%{$args['Entreprise']}%'";
        if ( isset($args['CodeClient']) && $args['CodeClient'] != '' ) $where .= " AND T1.CodeClient LIKE '%{$args['CodeClient']}%'";

        $q = "
SELECT
    T1.IDFournisseur,
    T1.DateAdd,
    T1.DateMaj,
    T1.Nom,
    T1.Adresse1,
    T1.Adresse2,
    T1.CodePostal,
    T1.Ville,
    T1.Telephone,
    T1.Fax,
    T1.Mail,
    T1.Certification,
    T1.Activite,
    T1.CodeClient,
    T1.IDFournisseurType,
    T1.EstFournisseur,
    T1.EstSousTraitant,
    T1.EstPrestataire,
    T1.ContactNom,
    T1.ContactPrenom,
    T1.ContactFonction,
    T1.ContactTelephone,
    T1.ContactMail,
    T1.IDSociete,
    T2.Nom AS NomFournisseurType,
    T1.IDFournisseurType,
    (SELECT CONCAT(TT1.Prenom,' ', TT1.Nom) FROM TBL_MEMBRE AS TT1 WHERE TT1.IDMembre = T1.IDMembreAdd) AS MembreAdd,
    (SELECT CONCAT(TT2.Prenom,' ', TT2.Nom) FROM TBL_MEMBRE AS TT2 WHERE TT2.IDMembre = T1.IDMembreMaj) AS MembreMaj
FROM
    TBL_FOURNISSEUR AS T1
    LEFT OUTER JOIN TBL_FOURNISSEUR_TYPE_TRAD AS T2 ON T1.IDFournisseurType = T2.IDFournisseurType
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    AND T1.IDSociete = '$pnIdSociete'
    $where
ORDER BY
    T1.Nom";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "OUT" => $args,
            "DATA_FOURNISSEUR" => $data
        );
    }

    public function getInsertFournisseur($args)
    {
//        $this->printr($args);
        $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if (isset($args['EntrepriseModal']) && $args['EntrepriseModal'] != '')              $EntrepriseModal = "'".strtoupper($args['EntrepriseModal'])."'";    else $EntrepriseModal = 'null';
        if (isset($args['Adresse1Modal']) && $args['Adresse1Modal'] != '')                  $Adresse1Modal = "'".$args['Adresse1Modal']."'";                    else $Adresse1Modal = 'null';
        if (isset($args['Adresse2Modal']) && $args['Adresse2Modal'] != '')                  $Adresse2Modal = "'".$args['Adresse2Modal']."'";                    else $Adresse2Modal = 'null';
        if (isset($args['CodeModal']) && $args['CodeModal'] != '')                          $CodeModal = "'".$args['CodeModal']."'";                            else $CodeModal = 'null';
        if (isset($args['VilleModal']) && $args['VilleModal'] != '')                        $VilleModal = "'".strtoupper($args['VilleModal'])."'";              else $VilleModal = 'null';
        if (isset($args['TelephoneModal']) && $args['TelephoneModal'] != '')                $TelephoneModal = "'".$args['TelephoneModal']."'";                  else $TelephoneModal = 'null';
        if (isset($args['FaxModal']) && $args['FaxModal'] != '')                            $FaxModal = "'".$args['FaxModal']."'";                              else $FaxModal = 'null';
        if (isset($args['MailModal']) && $args['MailModal'] != '')                          $MailModal = "'".$args['MailModal']."'";                            else $MailModal = 'null';
        if (isset($args['CertificationModal']) && $args['CertificationModal'] != '')        $CertificationModal = "'".$args['CertificationModal']."'";          else $CertificationModal = 'null';
        if (isset($args['ActiviteModal']) && $args['ActiviteModal'] != '')                  $ActiviteModal = "'".$args['ActiviteModal']."'";                    else $ActiviteModal = 'null';
        if (isset($args['CodeClientModal']) && $args['CodeClientModal'] != '')              $CodeClientModal = "'".$args['CodeClientModal']."'";                else $CodeClientModal = 'null';
        if (isset($args['IDTypeFournisseurModal']) && $args['IDTypeFournisseurModal'] > '0')$IDTypeFournisseurModal = "'".$args['IDTypeFournisseurModal']."'";  else $IDTypeFournisseurModal = 'null';

        if (isset($args['CategorieFournisseur1'])) $CategorieFournisseur1 = "1";            else $CategorieFournisseur1 = '0';
        if (isset($args['CategorieFournisseur2'])) $CategorieFournisseur2 = "1";            else $CategorieFournisseur2 = '0';
        if (isset($args['CategorieFournisseur3'])) $CategorieFournisseur3 = "1";            else $CategorieFournisseur3 = '0';

        if (isset($args['NomContactModal']) && $args['NomContactModal'] != '')              $NomContactModal = "'".strtoupper($args['NomContactModal'])."'";        else $NomContactModal = 'null';
        if (isset($args['PrenomContactModal']) && $args['PrenomContactModal'] != '')        $PrenomContactModal = "'".ucfirst($args['PrenomContactModal'])."'";     else $PrenomContactModal = 'null';
        if (isset($args['FonctionContactModal']) && $args['FonctionContactModal'] != '')    $FonctionContactModal = "'".ucfirst($args['FonctionContactModal'])."'"; else $FonctionContactModal = 'null';
        if (isset($args['TelephoneContactModal']) && $args['TelephoneContactModal'] != '')  $TelephoneContactModal = "'".$args['TelephoneContactModal']."'";        else $TelephoneContactModal = 'null';
        if (isset($args['MailContactModal']) && $args['MailContactModal'] != '')            $MailContactModal = "'".$args['MailContactModal']."'";                  else $MailContactModal = 'null';

        $q_insertFournisseur = "
INSERT INTO TBL_FOURNISSEUR
( IDMembreAdd, DateAdd, Nom, Adresse1, Adresse2, CodePostal, Ville, Telephone, Fax, Mail, Certification, Activite, CodeClient, IDFournisseurType, EstFournisseur, EstSousTraitant, EstPrestataire,
  ContactNom, ContactPrenom, ContactFonction, ContactTelephone, ContactMail, IDSociete
)
VALUES
( $pnIdUser,
  NOW(),
  $EntrepriseModal,
  $Adresse1Modal,
  $Adresse2Modal,
  $CodeModal,
  $VilleModal,
  $TelephoneModal,
  $FaxModal,
  $MailModal,
  $CertificationModal,
  $ActiviteModal,
  $CodeClientModal,
  $IDTypeFournisseurModal,
  $CategorieFournisseur1,
  $CategorieFournisseur2,
  $CategorieFournisseur3,
  $NomContactModal,
  $PrenomContactModal,
  $FonctionContactModal,
  $TelephoneContactModal,
  $MailContactModal,
  $pnIdSociete
)";
        $data = \fbx\DBmysql::getInstance()->getInsertData($q_insertFournisseur);
        $this->getWrLog($q_insertFournisseur,"$data",__FUNCTION__,__FILE__);
        $this->getDataFournisseur($args);
    }

    public function getUpdateFournisseur($args)
    {
        if ( isset($args['IDFournisseur']) && $args['IDFournisseur'] > '0' ) {

            $pnIDFournisseur = $args['IDFournisseur'];
            $pnIdUser = $_SESSION['FBX_USER_ID'];

            if (isset($args['Entreprise']) && $args['Entreprise'] != '') $Entreprise = "'" . strtoupper($args['Entreprise']) . "'"; else $Entreprise = 'null';
            if (isset($args['Adresse1']) && $args['Adresse1'] != '') $Adresse1 = "'" . $args['Adresse1'] . "'"; else $Adresse1 = 'null';
            if (isset($args['Adresse2']) && $args['Adresse2'] != '') $Adresse2 = "'" . $args['Adresse2'] . "'"; else $Adresse2 = 'null';
            if (isset($args['Code']) && $args['Code'] != '') $Code = "'" . $args['Code'] . "'"; else $Code = 'null';
            if (isset($args['Ville']) && $args['Ville'] != '') $Ville = "'" . strtoupper($args['Ville']) . "'"; else $Ville = 'null';
            if (isset($args['Telephone']) && $args['Telephone'] != '') $Telephone = "'" . $args['Telephone'] . "'"; else $Telephone = 'null';
            if (isset($args['Fax']) && $args['Fax'] != '') $Fax = "'" . $args['Fax'] . "'"; else $Fax = 'null';
            if (isset($args['Mail']) && $args['Mail'] != '') $Mail = "'" . $args['Mail'] . "'"; else $Mail = 'null';
            if (isset($args['Certification']) && $args['Certification'] != '') $Certification = "'" . $args['Certification'] . "'"; else $Certification = 'null';
            if (isset($args['Activite']) && $args['Activite'] != '') $Activite = "'" . $args['Activite'] . "'"; else $Activite = 'null';
            if (isset($args['CodeClient']) && $args['CodeClient'] != '') $CodeClient = "'" . $args['CodeClient'] . "'"; else $CodeClient = 'null';
            if (isset($args['IDTypeFournisseur']) && $args['IDTypeFournisseur'] > '0') $IDTypeFournisseur = "'" . $args['IDTypeFournisseur'] . "'"; else $IDTypeFournisseur = 'null';

            if (isset($args['CategorieFournisseur1'])) $CategorieFournisseur1 = $args['CategorieFournisseur1'];
            if (isset($args['CategorieFournisseur2'])) $CategorieFournisseur2 = $args['CategorieFournisseur2'];
            if (isset($args['CategorieFournisseur3'])) $CategorieFournisseur3 = $args['CategorieFournisseur3'];

            if (isset($args['NomContact']) && $args['NomContact'] != '') $NomContact = "'" . strtoupper($args['NomContact']) . "'"; else $NomContact = 'null';
            if (isset($args['PrenomContact']) && $args['PrenomContact'] != '') $PrenomContact = "'" . ucfirst($args['PrenomContact']) . "'"; else $PrenomContact = 'null';
            if (isset($args['FonctionContact']) && $args['FonctionContact'] != '') $FonctionContact = "'" . ucfirst($args['FonctionContact']) . "'"; else $FonctionContact = 'null';
            if (isset($args['TelephoneContact']) && $args['TelephoneContact'] != '') $TelephoneContact = "'" . $args['TelephoneContact'] . "'"; else $TelephoneContact = 'null';
            if (isset($args['MailContact']) && $args['MailContact'] != '') $MailContact = "'" . $args['MailContact'] . "'"; else $MailContact = 'null';

            $up = "
UPDATE 
      TBL_FOURNISSEUR
SET
      DateMaj = NOW(),
      IDMembreMaj = $pnIdUser,
      Nom = $Entreprise,
      Adresse1 = $Adresse1,
      Adresse2 = $Adresse2,
      CodePostal = $Code,
      Ville = $Ville,
      Telephone = $Telephone,
      Fax = $Fax,
      Mail = $Mail,
      Certification = $Certification,
      Activite = $Activite,
      CodeClient = $CodeClient,
      IDFournisseurType = $IDTypeFournisseur,
      EstFournisseur = $CategorieFournisseur1,
      EstSousTraitant = $CategorieFournisseur2,
      EstPrestataire = $CategorieFournisseur3,
      ContactNom = $NomContact,
      ContactPrenom = $PrenomContact,
      ContactFonction = $FonctionContact,
      ContactTelephone = $TelephoneContact,
      ContactMail = $MailContact
WHERE 
      IDFournisseur = $pnIDFournisseur";

            \fbx\DBmysql::getInstance()->getUpdateData($up);
            $this->getWrLog($up, "update fournisseur $pnIDFournisseur", __FUNCTION__, __FILE__);
            $this->_data = "update ok";
        }

    }

    public function getDeleteFournisseur($args)
    {
        if (isset($args['IDFournisseurDelete']) && $args['IDFournisseurDelete']!='') {

            $pnIdUser = $_SESSION['FBX_USER_ID'];

            $pnIDFournisseurDelete = ($args['IDFournisseurDelete']);

            $up = "
UPDATE TBL_FOURNISSEUR
SET EstSupp = '1' , DateSupp = NOW() , IDMembreSupp = '$pnIdUser'
WHERE IDFournisseur = $pnIDFournisseurDelete";

            \fbx\DBmysql::getInstance()->getUpdateData($up);
            $this->getWrLog($up, "delete fournisseur $pnIDFournisseurDelete", __FUNCTION__, __FILE__);

            $this->getDataFournisseur($args);

        } else { echo "<script type='text/javascript'>$(function(){getModalAlert('Pas de fournisseur trouvé');})</script>"; }
    }
}