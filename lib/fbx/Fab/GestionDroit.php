<?php
/**
 *
 * Created by blond.
 * File: GestionDroit.php
 * Date: 24/03/15 - 22:38
 *
 */

namespace fbx\Fab;


class GestionDroit extends Select
{
    const ClassPage = 'GestionDroit';

    public $_template = "Gestion/GestionDroit.twig";

    //__table Gestion Droit
    public function getDataTableGestionGroupe($args)
    {
        $this->_template = "table/tableGestionGroupe.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDGroupe AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS NomLangue,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_GROUPE AS T1
    LEFT OUTER JOIN TBL_GROUPE_TRAD AS T2 ON T2.IDGroupe = T1.IDGroupe AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_groupe = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_groupe"=>$data_groupe
        );
    }

    public function getDataTableGestionFonction($args)
    {
        $this->_template = "table/tableGestionFonction.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDFonction AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS NomLangue,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_FONCTION AS T1
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS T2 ON T2.IDFonction = T1.IDFonction AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_fonction = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_fonction"=>$data_fonction
        );
    }

    public function getDataTableGestionGroupeTlFonction()
    {
        $this->_template = "table/tableGestionGroupeTlFonction.twig";

        $q = "SELECT
    T1.IDGroupe_tl_fonction AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomGroupe,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomFonction,
    T4.IDGroupe AS IDGroupe,
    T5.IDFonction AS IDFonction
FROM
    TBL_GROUPE_TL_FONCTION AS T1
    LEFT OUTER JOIN TBL_GROUPE AS T2 ON T2.IDGroupe = T1.IDGroupe AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_FONCTION AS T3 ON T3.IDFonction = T1.IDFonction AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_GROUPE_TRAD AS T4 ON T4.IDGroupe = T1.IDGroupe AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS T5 ON T5.IDFonction = T1.IDFonction AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_groupeTlFonction = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_groupeTlFonction"=>$data_groupeTlFonction
        );
    }

    public function getDataTableGestionGroupeTlMenu()
    {
        $this->_template = "table/tableGestionGroupeTlMenu.twig";

        $q = "SELECT
    T1.IDGroupe_tl_menu AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomGroupe,
    T4.IDGroupe AS IDGroupe,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomMenu,
    T5.IDMenu AS IDMenu
FROM
    TBL_GROUPE_TL_MENU AS T1
    LEFT OUTER JOIN TBL_GROUPE AS T2 ON T2.IDGroupe = T1.IDGroupe AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_MENU AS T3 ON T3.IDMenu = T1.IDMenu AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_GROUPE_TRAD AS T4 ON T4.IDGroupe = T1.IDGroupe AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_MENU_TRAD AS T5 ON T5.IDMenu = T1.IDMenu AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_groupePtMenu = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_groupePtMenu"=>$data_groupePtMenu
        );
    }

    public function getDataTableGestionFonctionTlPage()
    {
        $this->_template = "table/tableGestionFonctionTlPage.twig";

        $q = "SELECT
    T1.IDFonction_tl_page AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomFonction,
    T4.IDFonction AS IDFonction,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomPage,
    T5.IDPage AS IDPage
FROM
    TBL_FONCTION_TL_PAGE AS T1
    LEFT OUTER JOIN TBL_FONCTION AS T2 ON T2.IDFonction = T1.IDFonction AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_PAGE AS T3 ON T3.IDPage = T1.IDPage AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS T4 ON T4.IDFonction = T1.IDFonction AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T5 ON T5.IDPage = T1.IDPage AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_fonctionPtPage = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_fonctionPtPage"=>$data_fonctionPtPage
        );
    }

    public function getDataTableGestionMenuTlPage()
    {
        $this->_template = "table/tableGestionMenuTlPage.twig";

        $q = "SELECT
    T1.IDMenu_tl_page AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomMenu,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomPage,
    T4.IDMenu AS IDMenu,
    T5.IDPage AS IDPage
FROM
    TBL_MENU_TL_PAGE AS T1
    LEFT OUTER JOIN TBL_MENU AS T2 ON T2.IDMenu = T1.IDMenu AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_PAGE AS T3 ON T3.IDPage = T1.IDPage AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_MENU_TRAD AS T4 ON T4.IDMenu = T1.IDMenu AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T5 ON T5.IDPage = T1.IDPage AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_menu_tl_page = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_menu_tl_page"=>$data_menu_tl_page
        );
    }

    public function getDataTableGestionSecteurTlCodeErreur()
    {
        $this->_template = "table/tableGestionSecteurTlCodeErreur.twig";

        $q = "SELECT
    T1.IDSecteur_tl_code_erreur AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomSecteur,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomCodeErreur,
    T4.IDSecteur AS IDSecteur,
    T5.IDCodeErreur AS IDCodeErreur
FROM
    TBL_SECTEUR_TL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_SECTEUR AS T2 ON T2.IDSecteur = T1.IDSecteur AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_CODE_ERREUR AS T3 ON T3.IDCodeErreur = T1.IDCodeErreur AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T4 ON T4.IDSecteur = T1.IDSecteur AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T5 ON T5.IDCodeErreur = T1.IDCodeErreur AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_secteur_tl_code_erreur = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_secteur_tl_code_erreur"=>$data_secteur_tl_code_erreur
        );
    }

    public function getDataTableGestionSupportTlFormat()
    {
        $this->_template = "table/tableGestionSupportTlFormat.twig";

        $q = "SELECT
    T1.IDSupport_tl_format AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomSupport,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomFormat,
    T4.IDSupport AS IDSupport,
    T5.IDFormat AS IDFormat
FROM
    TBL_SUPPORT_TL_FORMAT AS T1
    LEFT OUTER JOIN TBL_SUPPORT AS T2 ON T2.IDSupport = T1.IDSupport AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_FORMAT AS T3 ON T3.IDFormat = T1.IDFormat AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T4 ON T4.IDSupport = T1.IDSupport AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T5 ON T5.IDFormat = T1.IDFormat AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_support_tl_format = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_support_tl_format"=>$data_support_tl_format
        );
    }

    public function getDataTableGestionSecteurTlOption()
    {
        $this->_template = "table/tableGestionSecteurTlOption.twig";

        $q = "SELECT
    T1.IDSecteur_tl_option AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomSecteur,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomOption,
    T4.IDSecteur AS IDSecteur,
    T5.IDOption AS IDOption
FROM
    TBL_SECTEUR_TL_OPTION AS T1
    LEFT OUTER JOIN TBL_SECTEUR AS T2 ON T2.IDSecteur = T1.IDSecteur AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_OPTION AS T3 ON T3.IDOption = T1.IDOption AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T4 ON T4.IDSecteur = T1.IDSecteur AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T5 ON T5.IDOption = T1.IDOption AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_secteur_tl_option = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_secteur_tl_code_erreur"=>$data_secteur_tl_option
        );
    }

    public function getDataTableGestionSecteurTlImpression()
    {
        $this->_template = "table/tableGestionSecteurTlImpression.twig";

        $q = "SELECT
    T1.IDSecteur_tl_impression AS ID,
    CASE WHEN ISNULL(T4.Nom) THEN '-' ELSE T4.Nom END AS NomSecteur,
    CASE WHEN ISNULL(T5.Nom) THEN '-' ELSE T5.Nom END AS NomImpression,
    T4.IDSecteur AS IDSecteur,
    T5.IDImpression AS IDImpression
FROM
    TBL_SECTEUR_TL_IMPRESSION AS T1
    LEFT OUTER JOIN TBL_SECTEUR AS T2 ON T2.IDSecteur = T1.IDSecteur AND T2.EstActif = '1' AND T2.EstSupp = '0'
    LEFT OUTER JOIN TBL_IMPRESSION AS T3 ON T3.IDImpression = T1.IDImpression AND T3.EstActif = '1' AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T4 ON T4.IDSecteur = T1.IDSecteur AND T4.IDLangue = 1
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T5 ON T5.IDImpression = T1.IDImpression AND T5.IDLangue = 1
WHERE
    T1.EstSupp = '0'
ORDER BY
    T2.Ordre,
    T3.Ordre";

        $data_secteur_tl_impression = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_secteur_tl_code_erreur"=>$data_secteur_tl_impression
        );
    }


    //__insert
    public function getInsertGroupe($args)
    {
        if (isset($args['NomGroupe']) && $args['NomGroupe'] != '')  $psNom = $args['NomGroupe'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIdSociete = $args['IDSociete']; else $pnIdSociete = ''; }

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_GROUPE (DateAdd,IDMembreAdd,EstActif,Ordre,IDSociete) VALUES (NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIdSociete');
INSERT INTO TBL_GROUPE_TRAD (Nom,IDGroupe, IDLangue) VALUES ('$psNom',LAST_INSERT_ID(),'1')";
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertFonction($args)
    {
        if (isset($args['NomFonction']) && $args['NomFonction'] != '')  $psNom = $args['NomFonction'];      else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')              $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIdSociete = $args['IDSociete']; else $pnIdSociete = ''; }

        $q = "INSERT INTO TBL_FONCTION (DateAdd, IDMembreAdd, EstActif, Ordre,IDSociete ) VALUES (NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIdSociete');
INSERT INTO TBL_FONCTION_TRAD (Nom, IDFonction, IDLangue) VALUES ('$psNom',LAST_INSERT_ID(),'1')";
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }


    //__update
    public function getUpdateGroupe($args)
    {
        if (isset($args['NomGroupe']) && $args['NomGroupe'] != '')  $psNom = $args['NomGroupe'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDGroupe']) && $args['IDGroupe'] != '')    $pnIDGroupe = $args['IDGroupe'];    else $pnIDGroupe = '0';

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIdSociete = $args['IDSociete']; else $pnIdSociete = ''; }

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_GROUPE AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.Ordre = '$pnOrdre',
    TBL.EstActif = '$pbEstActif',
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.IDSociete = '$pnIdSociete'
WHERE
    TBL.IDGroupe = '$pnIDGroupe'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_GROUPE_TRAD AS GROUPE
SET
    GROUPE.Nom = '$psNom'
WHERE
    GROUPE.IDGroupe = '$pnIDGroupe'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateFonction($args)
    {
        if (isset($args['NomFonction']) && $args['NomFonction'] != '')  $psNom = $args['NomFonction'];          else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')              $pnOrdre = $args['Ordre'];              else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif'];        else $pbEstActif = '0';
        if (isset($args['IDFonction']) && $args['IDFonction'] != '')    $pnIDFonction = $args['IDFonction'];    else $pnIDFonction = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIdSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIdSociete = $args['IDSociete']; else $pnIdSociete = ''; }

        $q = "UPDATE
    TBL_FONCTION AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDMembreMaj ='$pnIdUser',
    TBL.IDSociete = '$pnIdSociete'
WHERE
    TBL.IDFonction = '$pnIDFonction'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_FONCTION_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDFonction = '$pnIDFonction'";

        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }


    //__tables liaison
    public function getDataGestionMenuTlPage($args){
        $this->_template = "elements/tableLiaisonMenuTlPage.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDMenu']) && $args['IDMenu'] != '') { $whereClause .= " AND T3.IDMenu = '{$args['IDMenu']}'";}

        $q = "SELECT
    T1.IDPage AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDMenu) THEN '-' ELSE T3.IDMenu END AS IDMenu
FROM
    TBL_PAGE AS T1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T2 ON T1.IDPage = T2.IDPage AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_MENU_TL_PAGE AS T3 ON T1.IDPage = T3.IDPage AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }

    public function getDataGestionFonctionTlPage($args){
        $this->_template = "elements/tableLiaisonFonctionTlPage.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDFonction']) && $args['IDFonction'] != '') { $whereClause .= " AND T3.IDFonction = '{$args['IDFonction']}'";}

        $q = "SELECT
    T1.IDPage AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDFonction) THEN '-' ELSE T3.IDFonction END AS IDFonction
FROM
    TBL_PAGE AS T1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T2 ON T1.IDPage = T2.IDPage AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_FONCTION_TL_PAGE AS T3 ON T1.IDPage = T3.IDPage AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }

    public function getDataGestionGroupeTlFonction($args){
        $this->_template = "elements/tableLiaisonGroupeTlFonction.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDGroupe']) && $args['IDGroupe'] != '') { $whereClause .= " AND T3.IDGroupe = '{$args['IDGroupe']}'";}

        $q = "SELECT
    T1.IDFonction AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDGroupe) THEN '-' ELSE T3.IDGroupe END AS IDGroupe
FROM
    TBL_FONCTION AS T1
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS T2 ON T1.IDFonction = T2.IDFonction AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_GROUPE_TL_FONCTION AS T3 ON T1.IDFonction = T3.IDFonction AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }

    public function getDataGestionGroupeTlMenu($args){
        $this->_template = "elements/tableLiaisonGroupeTlMenu.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDGroupe']) && $args['IDGroupe'] != '') { $whereClause .= " AND T3.IDGroupe = '{$args['IDGroupe']}'";}

        $q = "SELECT
    T1.IDMenu AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDGroupe) THEN '-' ELSE T3.IDGroupe END AS IDGroupe
FROM
    TBL_MENU AS T1
    LEFT OUTER JOIN TBL_MENU_TRAD AS T2 ON T1.IDMenu = T2.IDMenu AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_GROUPE_TL_MENU AS T3 ON T1.IDMenu = T3.IDMenu AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }

    public function getDataGestionSecteurTlCodeErreur($args){
        $this->_template = "elements/tableLiaisonSecteurTlCodeErreur.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '') { $whereClause .= " AND T3.IDSecteur = '{$args['IDSecteur']}'";}

        $q = "SELECT
    T1.IDCodeErreur AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDSecteur) THEN '-' ELSE T3.IDSecteur END AS IDSecteur
FROM
    TBL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2 ON T1.IDCodeErreur = T2.IDCodeErreur AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_SECTEUR_TL_CODE_ERREUR AS T3 ON T1.IDCodeErreur = T3.IDCodeErreur AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }

    public function getDataGestionSupportTlFormat($args){
        $this->_template = "elements/tableLiaisonSupportTlFormat.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDSupport']) && $args['IDSupport'] != '') { $whereClause .= " AND T3.IDSupport = '{$args['IDSupport']}'";}

        $q = "SELECT
    T1.IDFormat AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDSupport) THEN '-' ELSE T3.IDSupport END AS IDSupport
FROM
    TBL_FORMAT AS T1
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T2 ON T1.IDFormat = T2.IDFormat AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_SUPPORT_TL_FORMAT AS T3 ON T1.IDFormat = T3.IDFormat AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }

    public function getDataGestionSecteurTlOption($args){
        $this->_template = "elements/tableLiaisonSecteurTlOption.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '') { $whereClause .= " AND T3.IDSecteur = '{$args['IDSecteur']}'";}

        $q = "SELECT
    T1.IDOption AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDSecteur) THEN '-' ELSE T3.IDSecteur END AS IDSecteur
FROM
    TBL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T1.IDOption = T2.IDOption AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_SECTEUR_TL_OPTION AS T3 ON T1.IDOption = T3.IDOption AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }

    public function getDataGestionSecteurTlImpression($args){
        $this->_template = "elements/tableLiaisonSecteurTlImpression.twig";
        $where = $whereClause = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '') { $whereClause .= " AND T3.IDSecteur = '{$args['IDSecteur']}'";}

        $q = "SELECT
    T1.IDImpression AS ID
    , CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
    , CASE WHEN ISNULL(T3.IDSecteur) THEN '-' ELSE T3.IDSecteur END AS IDSecteur
FROM
    TBL_IMPRESSION AS T1
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T2 ON T1.IDImpression = T2.IDImpression AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_SECTEUR_TL_IMPRESSION AS T3 ON T1.IDImpression = T3.IDImpression AND T3.EstSupp = '0' $whereClause
WHERE
    T1.EstSupp = '0' AND T1.EstActif = 1
    $where
ORDER BY
    T1.Ordre";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_table"=>$data,"Q"=>$q);
    }


    //__up liaison
    public function getLiaisonMenuTlPage($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Menu_tl_page = $data = $q = null;

        if (isset($args['IDMenu']) && $args['IDMenu'] != '')    $pnIdMenu = $args['IDMenu'];    else $pnIdMenu = '0';
        if (isset($args['IDPage']) && $args['IDPage'] != '')    $pnIdPage = $args['IDPage'];    else $pnIdPage = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDMenu_tl_page AS ID FROM TBL_MENU_TL_PAGE AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDPage = $pnIdPage AND TBL.IDMenu = $pnIdMenu";

            $data_Menu_tl_page = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIDMenu_tl_page = $data_Menu_tl_page[0]->ID;

            $q = "UPDATE
    TBL_MENU_TL_PAGE AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDMenu_tl_page = $pnIDMenu_tl_page";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_MENU_TL_PAGE ( DateAdd, IDMembreAdd, IDMenu, IDPage ) VALUES ( NOW(),'$pnIdUser','$pnIdMenu','$pnIdPage' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Menu_tl_page"=>$data,"Q"=>$q);
    }

    public function getLiaisonFonctionTlPage($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Fonction_tl_page = $data = $q = null;

        if (isset($args['IDFonction']) && $args['IDFonction'] != '')    $pnIdFonction = $args['IDFonction'];    else $pnIdFonction = '0';
        if (isset($args['IDPage']) && $args['IDPage'] != '')    $pnIdPage = $args['IDPage'];    else $pnIdPage = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDFonction_tl_page AS ID FROM TBL_FONCTION_TL_PAGE AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDPage = $pnIdPage AND TBL.IDFonction = $pnIdFonction";

            $data_Fonction_tl_page = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIDFonction_tl_page = $data_Fonction_tl_page[0]->ID;

            $q = "UPDATE
    TBL_FONCTION_TL_PAGE AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDFonction_tl_page = $pnIDFonction_tl_page";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_FONCTION_TL_PAGE ( DateAdd, IDMembreAdd, IDFonction, IDPage ) VALUES ( NOW(),'$pnIdUser','$pnIdFonction','$pnIdPage' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Fonction_tl_page"=>$data,"Q"=>$q);
    }

    public function getLiaisonGroupeTlFonction($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Groupe_tl_fonction = $data = $q = null;

        if (isset($args['IDFonction']) && $args['IDFonction'] != '')    $pnIdFonction = $args['IDFonction'];    else $pnIdFonction = '0';
        if (isset($args['IDGroupe']) && $args['IDGroupe'] != '')        $pnIdGroupe = $args['IDGroupe'];        else $pnIdGroupe = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDGroupe_tl_fonction AS ID FROM TBL_GROUPE_TL_FONCTION AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDGroupe = $pnIdGroupe AND TBL.IDFonction = $pnIdFonction";

            $data_Groupe_tl_fonction = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIdGroupe_tl_fonction = $data_Groupe_tl_fonction[0]->ID;

            $q = "UPDATE
    TBL_GROUPE_TL_FONCTION AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDGroupe_tl_fonction = $pnIdGroupe_tl_fonction";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_GROUPE_TL_FONCTION ( DateAdd, IDMembeAdd, IDFonction, IDGroupe ) VALUES ( NOW(),'$pnIdUser','$pnIdFonction','$pnIdGroupe' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Fonction_tl_page"=>$data,"Q"=>$q);
    }

    public function getLiaisonSupportTlFormat($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Support_tl_format = $data = $q = null;

        if (isset($args['IDFormat']) && $args['IDFormat'] != '')        $pnIdFormat = $args['IDFormat'];        else $pnIdFormat = '0';
        if (isset($args['IDSupport']) && $args['IDSupport'] != '')    $pnIdSupport = $args['IDSupport'];    else $pnIdSupport = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDSupport_tl_format AS ID FROM TBL_SUPPORT_TL_FORMAT AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDSupport = $pnIdSupport AND TBL.IDFormat = $pnIdFormat";

            $data_Support_tl_format = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIdSupport_tl_format = $data_Support_tl_format[0]->ID;

            $q = "UPDATE
    TBL_SUPPORT_TL_FORMAT AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDSupport_tl_format = $pnIdSupport_tl_format";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_SUPPORT_TL_FORMAT ( DateAdd, IDMembreAdd, IDFormat, IDSupport ) VALUES ( NOW(),'$pnIdUser','$pnIdFormat','$pnIdSupport' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Format_tl_page"=>$data,"Q"=>$q);
    }

    public function getLiaisonGroupeTlMenu($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Groupe_tl_menu = $data = $q = null;

        if (isset($args['IDMenu']) && $args['IDMenu'] != '')        $pnIdMenu = $args['IDMenu'];        else $pnIdMenu = '0';
        if (isset($args['IDGroupe']) && $args['IDGroupe'] != '')    $pnIdGroupe = $args['IDGroupe'];    else $pnIdGroupe = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDGroupe_tl_menu AS ID FROM TBL_GROUPE_TL_MENU AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDGroupe = $pnIdGroupe AND TBL.IDMenu = $pnIdMenu";

            $data_Groupe_tl_menu = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIdGroupe_tl_menu = $data_Groupe_tl_menu[0]->ID;

            $q = "UPDATE
    TBL_GROUPE_TL_MENU AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDGroupe_tl_menu = $pnIdGroupe_tl_menu";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_GROUPE_TL_MENU ( DateAdd, IDMembreAdd, IDMenu, IDGroupe ) VALUES ( NOW(),'$pnIdUser','$pnIdMenu','$pnIdGroupe' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Menu_tl_page"=>$data,"Q"=>$q);
    }

    public function getLiaisonSecteurTlCodeErreur($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Secteur_tl_code_erreur = $data = $q = null;

        if (isset($args['IDCodeErreur']) && $args['IDCodeErreur'] != '')    $pnIdCodeErreur = $args['IDCodeErreur'];    else $pnIdCodeErreur = '0';
        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '')          $pnIdSecteur = $args['IDSecteur'];          else $pnIdSecteur = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDSecteur_tl_code_erreur AS ID FROM TBL_SECTEUR_TL_CODE_ERREUR AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDSecteur = $pnIdSecteur AND TBL.IDCodeErreur = $pnIdCodeErreur";

            $data_Secteur_tl_code_erreur = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIdSecteur_tl_code_erreur = $data_Secteur_tl_code_erreur[0]->ID;

            $q = "UPDATE
    TBL_SECTEUR_TL_CODE_ERREUR AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDSecteur_tl_code_erreur = $pnIdSecteur_tl_code_erreur";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_SECTEUR_TL_CODE_ERREUR ( DateAdd, IDMembreAdd, IDCodeErreur, IDSecteur ) VALUES ( NOW(),'$pnIdUser','$pnIdCodeErreur','$pnIdSecteur' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Secteur_tl_code_erreur"=>$data,"Q"=>$q);
    }

    public function getLiaisonSecteurTlOption($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Secteur_tl_option = $data = $q = null;

        if (isset($args['IDOption']) && $args['IDOption'] != '')    $pnIdOption = $args['IDOption'];    else $pnIdOption = '0';
        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '')          $pnIdSecteur = $args['IDSecteur'];          else $pnIdSecteur = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDSecteur_tl_option AS ID FROM TBL_SECTEUR_TL_OPTION AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDSecteur = $pnIdSecteur AND TBL.IDOption = $pnIdOption";

            $data_Secteur_tl_option = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIdSecteur_tl_option = $data_Secteur_tl_option[0]->ID;

            $q = "UPDATE
    TBL_SECTEUR_TL_OPTION AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDSecteur_tl_option = $pnIdSecteur_tl_option";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_SECTEUR_TL_OPTION ( DateAdd, IDMembreAdd, IDOption, IDSecteur ) VALUES ( NOW(),'$pnIdUser','$pnIdOption','$pnIdSecteur' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Secteur_tl_option"=>$data,"Q"=>$q);
    }

    public function getLiaisonSecteurTlImpression($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];
        $data_Secteur_tl_impression = $data = $q = null;

        if (isset($args['IDImpression']) && $args['IDImpression'] != '')    $pnIdImpression = $args['IDImpression'];    else $pnIdImpression = '0';
        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '')          $pnIdSecteur = $args['IDSecteur'];          else $pnIdSecteur = '0';

        if ($args['Actif']=='0') {
            $q = "SELECT TBL.IDSecteur_tl_impression AS ID FROM TBL_SECTEUR_TL_IMPRESSION AS TBL WHERE TBL.EstSupp = '0' AND TBL.IDSecteur = $pnIdSecteur AND TBL.IDImpression = $pnIdImpression";

            $data_Secteur_tl_impression = \fbx\DBmysql::getInstance()->getSelectData($q);

            $pnIdSecteur_tl_impression = $data_Secteur_tl_impression[0]->ID;

            $q = "UPDATE
    TBL_SECTEUR_TL_IMPRESSION AS TBL
SET
    TBL.IDMembreSupp='$pnIdUser',
    TBL.DateSupp=NOW(),
    TBL.EstSupp = '1'
WHERE
    TBL.IDSecteur_tl_impression = $pnIdSecteur_tl_impression";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

            $this->getWrLog($q, $data, __FUNCTION__, __FILE__);
        }
        else if ($args['Actif']=='1') {
            $q = "INSERT INTO TBL_SECTEUR_TL_IMPRESSION ( DateAdd, IDMembreAdd, IDImpression, IDSecteur ) VALUES ( NOW(),'$pnIdUser','$pnIdImpression','$pnIdSecteur' )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);

            $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        }

        $this->_data = array("data_Secteur_tl_impression"=>$data,"Q"=>$q);
    }
}