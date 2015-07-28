<?php
/**
 *
 * Created by blond.
 * File: GestionReglage.php
 * Date: 24/03/15 - 22:38
 *
 */

namespace fbx\Fab;


class GestionReglage extends Select
{
    const ClassPage = 'GestionReglage';

    public $_template = "Gestion/GestionReglage.twig";

    //__define path to up perso img & txt
    private function path($args) {
        return "img/$args";
    }

    //__ up img user
    public function getUpImg($args){

        $pnIdFbxUser = $_SESSION['FBX_USER_ID'];
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIdSocieteUser = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIdSocieteUser = $args['IDSociete']; else $pnIdSocieteUser = '0'; }
//        $this->printr($_SESSION);

        $psNameOfFile = $args['nameOfFile']."-".$pnIdSocieteUser;

        $chemin_destination = $this->path("logos")."/";

        if(isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='') {
//            $this->printr($_FILES);
            move_uploaded_file($_FILES['image']['tmp_name'], $this->path("tmp/")."{$pnIdFbxUser}-{$psNameOfFile}.png");

            if(file_exists("{$chemin_destination}{$psNameOfFile}.png")==1) {
                $date = date('YmdHis');
                rename("{$chemin_destination}{$psNameOfFile}.png", $this->path("tmp/").$date."-{$psNameOfFile}.png");
            }
            if(file_exists($this->path("tmp/")."{$pnIdFbxUser}-{$psNameOfFile}.png")==1) {
                if(!copy ( $this->path("tmp/")."{$pnIdFbxUser}-{$psNameOfFile}.png" , "{$chemin_destination}{$psNameOfFile}.png")) {
                    $this->getWrLog("copy img to /tmp","ERR",__FUNCTION__,__FILE__);
                    echo $alert = '<script type="text/javascript">$(function(){getModalAlert("Fail: ' . $_FILES . '");})</script>';
                }
            }
        }

        if(file_exists($this->path("tmp/")."{$pnIdFbxUser}-{$psNameOfFile}.png")==1) {
            unlink($this->path("tmp/")."{$pnIdFbxUser}-{$psNameOfFile}.png");
        }

        $this->_data = $args;
        $this->getWrLog("copy img","EXE",__FUNCTION__,__FILE__);
        echo '<script type="text/javascript">$(function(){collapse("'.$args['div'].'");})</script>';
    }

    //__up slogan in navbar
    public function getUpBrand($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSocieteSlogan']) && $args['IDSocieteSlogan'] != '')  $pnIDSociete = $args['IDSocieteSlogan']; else $pnIDSociete = ''; }

        if (isset($args['brand']) && $args['brand'] != '') $psBrand = $args['brand']; else $psBrand = 'null';

        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_SLOGAN AS SLOGAN
SET
    SLOGAN.DateMaj = NOW(),
    SLOGAN.IDMembreMaj = '$pnIdUser',
    SLOGAN.Slogan = '$psBrand'
WHERE
    SLOGAN.IDSociete = '$pnIDSociete'";

        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);

        $this->getWrLog("$q","",__FUNCTION__,__FILE__);

        $_SESSION['Slogan'] = $args['brand'];

        $this->_data = $args;

        echo '<script type="text/javascript">$(function(){collapse("collapseSlogan");})</script>';
    }

    //__table Gestion Reglage
    public function getDataTableGestionLangue()
    {
        $this->_template = "table/tableGestionLangue.twig";

        $q = "SELECT
    L.Nom AS NomLangue,
    L.CodeBCP AS CodeBCP,
    L.IDLangue AS IDLangue,
    L.EstActif AS EstActif
FROM
    TBL_LANGUE AS L
WHERE
    L.EstSupp = '0'";
        $data_langue = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_langue"=>$data_langue
        );
    }

    public function getDataTableGestionMenu($args)
    {
        $this->_template = "table/tableGestionMenu.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDMenu AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS Langue,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_MENU AS T1
    LEFT OUTER JOIN TBL_MENU_TRAD AS T2 ON T2.IDMenu = T1.IDMenu AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_menu = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = array("data_menu"=>$data_menu);
    }

    public function getDataTableGestionPage($args)
    {
        $this->_template = "table/tableGestionPage.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT #tableGestionPage
    T1.IDPage AS ID,
    T1.Classe AS ClassPage,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS Langue,
    T1.IDPage AS ConstantePage,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_PAGE AS T1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T2 ON T2.IDPage = T1.IDPage AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    #AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
        $data_page = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q,"yep",__FUNCTION__,__FILE__);

        $this->_data = array(
            "data_page"=>$data_page
        );
    }

    public function getDataTableGestionSecteur($args)
    {
        $this->_template = "table/tableGestionSecteur.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDSecteur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.Code,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS NomLangue,
    T1.IDSociete AS IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_SECTEUR AS T1
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T2 ON T2.IDSecteur = T1.IDSecteur AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";
        $data_secteur = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_secteur"=>$data_secteur
        );
    }

    public function getDataTableGestionMachine($args)
    {
        $this->_template = "table/tableGestionMachine.twig";

        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND TM.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND TM.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "
SELECT
    TM.IDMachine AS IDMachine,
    CASE WHEN ISNULL(TMT.Nom) THEN '-' ELSE TMT.Nom END AS Nom,
    TM.Ordre AS Ordre,
    TM.EstActif AS EstActif,
    TM.IDSecteur AS IDSecteur,
    TMT.IDLangue AS IDLangue,
    TM.CalageMin AS CalageMin,
    TM.CalageFeuilles AS CalageFeuilles,
    TM.GachePour1000Feuilles AS GachePour1000Feuilles,
    TM.CadenceTourMin AS CadenceTourMin,
    TM.2passages AS passages,
    L.Nom AS NomLangue,
    TST.Nom AS NomSecteur,
    TM.IDSociete AS IDSociete,
    TS.Nom AS NomSociete
FROM
    TBL_MACHINE AS TM
    JOIN TBL_MACHINE_TRAD AS TMT ON TM.IDMachine = TMT.IDMachine AND TMT.IDLangue = '1'
    JOIN TBL_LANGUE AS L ON TMT.IDLangue = L.IDLangue
    JOIN TBL_SECTEUR_TRAD AS TST ON TM.IDSecteur = TST.IDSecteur AND TST.IDLangue = '1'
    JOIN TBL_SOCIETE AS TS ON TS.IDSociete = TM.IDSociete
WHERE
    TM.EstSupp = '0'
    $where
ORDER BY
    TM.Ordre";

        $data_machine = \fbx\DBmysql::getInstance()->getSelectData($q);
        #$this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = array(
            "data_machine"=>$data_machine
        );
    }

    public function getDataTableGestionSociete()
    {
        $this->_template = "table/tableGestionSociete.twig";

        $q = " SELECT
    TS.IDSociete AS ID,
    TS.Nom,
    TS.Adresse1,
    TS.Adresse2,
    TS.CodePostal,
    TS.Ville,
    TS.Pays,
    TS.Mail,
    TS.Telephone,
    TS.IDMembreContact,
    TS.IDLangue,
    TS.EstActif,
    CONCAT(TM.Prenom,' ', TM.Nom) AS PrenomNomMembre,
    TL.Nom AS NomLangue
FROM
    TBL_SOCIETE AS TS
    LEFT OUTER JOIN TBL_MEMBRE AS TM ON TM.IDMembre = TS.IDMembreContact
    LEFT OUTER JOIN TBL_LANGUE AS TL ON TL.IDLangue = TS.IDLangue
WHERE
    TS.EstSupp = '0'
ORDER BY
    TS.Nom";

        $data_societe = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_societe"=>$data_societe,
            "Q"=>$q
        );
    }

    public function getDataTableGestionCodeErreur($args)
    {
        $this->_template = "table/tableGestionCodeErreur.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDCodeErreur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS NomLangue,
    T1.IDSociete AS IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2 ON T2.IDCodeErreur = T1.IDCodeErreur AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_CodeErreur = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_CodeErreur"=>$data_CodeErreur
        );
    }

    public function getDataTableGestionSupport($args)
    {
        $this->_template = "table/tableGestionSupport.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDSupport AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS Langue,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_SUPPORT AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2 ON T2.IDSupport = T1.IDSupport AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_support = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_support"=>$data_support);
    }

    public function getDataTableGestionElement($args)
    {
        $this->_template = "table/tableGestionElement.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDElement AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS Langue,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_ELEMENT AS T1
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T2 ON T2.IDElement = T1.IDElement AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_element = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_element"=>$data_element);
    }

    public function getDataTableGestionFormat($args)
    {
        $this->_template = "table/tableGestionFormat.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDFormat AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS Langue,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_FORMAT AS T1
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T2 ON T2.IDFormat = T1.IDFormat AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_format = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_format"=>$data_format);
    }

    public function getDataTableGestionImpression($args)
    {
        $this->_template = "table/tableGestionImpression.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDImpression AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS Langue,
    T1.IDSociete,
    T4.Nom AS NomSociete,
    T1.NbCalage,
    T1.NbTour
FROM
    TBL_IMPRESSION AS T1
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T2 ON T2.IDImpression = T1.IDImpression AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_impression = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_impression"=>$data_impression);
    }

    public function getDataTableGestionOption($args)
    {
        $this->_template = "table/tableGestionOption.twig";
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= " AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') ) { $where .= " AND T1.IDSociete = '{$args['IDSociete']}'"; } }

        $q = "SELECT
    T1.IDOption AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom,
    T1.Ordre AS Ordre,
    T1.EstActif AS EstActif,
    T2.IDLangue AS IDLangue,
    T3.Nom AS NomLangue,
    T1.IDSociete,
    T4.Nom AS NomSociete
FROM
    TBL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2 ON T2.IDOption = T1.IDOption AND T2.IDLangue = '1'
    LEFT OUTER JOIN TBL_LANGUE AS T3 ON T3.IDLangue = T2.IDLangue
    LEFT OUTER JOIN TBL_SOCIETE AS T4 ON T1.IDSociete = T4.IDSociete
WHERE
    T1.EstSupp = '0'
    $where
    #AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        $data_option = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array("data_option"=>$data_option);
    }


    //__insert
    public function getInsertLangue($args)
    {
        if (isset($args['NomLangue']) && $args['NomLangue'] != '')  $psNomLangue = $args['NomLangue'];  else $psNomLangue = 'null';
        if (isset($args['CodeBCP']) && $args['CodeBCP'] != '')      $psCodeBCP = $args['CodeBCP'];      else $psCodeBCP = 'null';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_LANGUE ( Nom, CodeBCP, EstActif, IDMembreAdd, DateAdd ) VALUES ( '$psNomLangue','$psCodeBCP','$pbEstActif','$pnIdUser',NOW() )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertMenu($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomMenu']) && $args['NomMenu'] != '')      $psNom = $args['NomMenu'];          else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_MENU ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete' );
INSERT INTO TBL_MENU_TRAD ( IDMenu,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertPage($args)
    {
        if (isset($args['NomPage']) && $args['NomPage'] != '')              $psNom = $args['NomPage'];                      else $psNom = 'null';
        if (isset($args['ClassPage']) && $args['ClassPage'] != '')          $psClassPage = $args['ClassPage'];              else $psClassPage = 'null';
        if (isset($args['ConstantePage']) && $args['ConstantePage'] != '')  $pnConstantePage = $args['ConstantePage'];      else $pnConstantePage = '1';
        if (isset($args['IDLangue']) && $args['IDLangue'] != '')            $pnIDLangue = $args['IDLangue'];                else $pnIDLangue = '1';
        if (isset($args['Ordre']) && $args['Ordre'] != '')                  $pnOrdre = $args['Ordre'];                      else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')            $pbEstActif = $args['EstActif'];                else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_PAGE_TRAD
    ( DateAdd, IDMembreAdd, IDPage, Nom, Classe , IDLangue, EstActif, Ordre )
VALUES
    ( NOW(),'$pnIdUser','$pnConstantePage','$psNom','$psClassPage','$pnIDLangue','$pbEstActif','$pnOrdre' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertSecteur($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomSecteur']) && $args['NomSecteur'] != '')    $psNom = $args['NomSecteur'];       else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')              $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['Code']) && $args['Code'] != '')        $pnCode = $args['Code'];    else $pnCode = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_SECTEUR ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete, Code ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete', '$pnCode' );
INSERT INTO TBL_SECTEUR_TRAD ( IDSecteur,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertMachine($args)
    {
        if (isset($args['NomMachine']) && $args['NomMachine'] != '')                        $psNom = $args['NomMachine'];                               else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')                                  $pnOrdre = $args['Ordre'];                                  else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')                            $pbEstActif = $args['EstActif'];                            else $pbEstActif = '0';
        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '')                          $pnIDSecteur = $args['IDSecteur'];                          else $pnIDSecteur = '1';
        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
        }else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '0') $pnIDSociete = $args['IDSociete']; else $pnIDSociete = 'null';
        }
        if (isset($args['CalageMin']) && $args['CalageMin'] != '')                          $pnCalageMin = $args['CalageMin'];                          else $pnCalageMin = '0';
        if (isset($args['CalageFeuilles']) && $args['CalageFeuilles'] != '')                $pnCalageFeuilles = $args['CalageFeuilles'];                else $pnCalageFeuilles = '0';
        if (isset($args['GachePour1000Feuilles']) && $args['GachePour1000Feuilles'] != '')  $pnGachePour1000Feuilles = $args['GachePour1000Feuilles'];  else $pnGachePour1000Feuilles = '0';
        if (isset($args['CadenceTourMin']) && $args['CadenceTourMin'] != '')                $pnCadenceTourMin = $args['CadenceTourMin'];                else $pnCadenceTourMin = '0';
        if (isset($args['passages']) && $args['passages'] != '')                            $pb2passages = $args['passages'];                           else $pb2passages = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_MACHINE ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSecteur,CalageMin,CalageFeuilles,GachePour1000Feuilles,CadenceTourMin,2passages,IDSociete )
VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSecteur','$pnCalageMin','$pnCalageFeuilles','$pnGachePour1000Feuilles','$pnCadenceTourMin','$pb2passages','$pnIDSociete');";
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"$data",__FUNCTION__,__FILE__);

        $q_trad = "INSERT INTO TBL_MACHINE_TRAD ( IDMachine, Nom,IDLangue ) VALUES ( '$data','$psNom','1' )";
        $data_trad = \fbx\DBmysql::getInstance()->getInsertData($q_trad);
        $this->getWrLog($q_trad,"$data_trad",__FUNCTION__,__FILE__);

        //__CREATE QRcode
        $path= $_SESSION['QR']['PATH'];
        $link= $_SESSION['QR']['IMG']."/machine";
        $ref = $_SESSION['QR']['MACHINE']."?action=getInsertDataFicheDeProd&IDSecteur=$pnIDSecteur&IDMachine=$data"; //
        $url = "$path?machine-$data&$link&$ref";
        $this->cURLexec($url);
//        $this->getWrLog("add QRcode machine", "$url", __FUNCTION__, __FILE__);

        //__CREATE CODE BARRE
        $path = ($_SESSION['BARCODE']['PATH']);
        $link = ($_SESSION['BARCODE']['IMG'])."/machine";
        $filename = "barcodeMachine-$data";
        $contenu_barcode = "$$$pnIDSecteur$$$data";
        $url = "$path?$contenu_barcode&$filename&$link";
        $this->cURLexec($url);
//        $this->getWrLog("add barcode machine", "$url", __FUNCTION__, __FILE__);

        $this->_data = $data;
    }

    public function getInsertSociete($args)
    {
        if (isset($args['NomSociete']) && $args['NomSociete'] != '')    $psNom = $args['NomSociete'];           else $psNom = '';
        if (isset($args['Mail']) && $args['Mail'] != '')                $psMail = $args['Mail'];                else $psMail = '';
        if (isset($args['Telephone']) && $args['Telephone'] != '')      $psTelephone = $args['Telephone'];      else $psTelephone = '';
        if (isset($args['IDMembre']) && $args['IDMembre'] != '')        $pnIDMembre = $args['IDMembre'];        else $pnIDMembre = '';
        if (isset($args['IDLangue']) && $args['IDLangue'] != '')        $pnIDLangue = $args['IDLangue'];        else $pnIDLangue = '1';
        if (isset($args['Adresse1']) && $args['Adresse1'] != '')        $psAdresse1 = $args['Adresse1'];        else $psAdresse1 = '';
        if (isset($args['Adresse2']) && $args['Adresse2'] != '')        $psAdresse2 = $args['Adresse2'];        else $psAdresse2 = '';
        if (isset($args['CodePostal']) && $args['CodePostal'] != '')    $pnCodePostal = $args['CodePostal'];    else $pnCodePostal = '';
        if (isset($args['Ville']) && $args['Ville'] != '')              $psVille = $args['Ville'];              else $psVille = '';
        if (isset($args['Pays']) && $args['Pays'] != '')                $psPays = $args['Pays'];                else $psPays = '';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif'];        else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_SOCIETE ( DateAdd,Nom,Adresse1,Adresse2,CodePostal,Ville,Pays,Mail,Telephone,IDMembreContact,IDLangue,EstActif,IDMembreAdd )
VALUES ( NOW(),'$psNom','$psAdresse1','$psAdresse2','$pnCodePostal','$psVille','$psPays','$psMail','$psTelephone','$pnIDMembre','$pnIDLangue','$pbEstActif','$pnIdUser');
INSERT INTO TBL_SLOGAN ( DateAdd,Slogan,IDSociete,IDMembreAdd ) VALUES ( NOW(),'$psNom',LAST_INSERT_ID(),'$pnIdUser');";
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "SELECT IDSociete FROM TBL_SOCIETE WHERE Nom = '$psNom' AND IDMembreAdd = '$pnIdUser'";
        $data_societe = \fbx\DBmysql::getInstance()->getSelectData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        #$this->printr($data_societe);

        $pnIdSociete = $data_societe[0]->IDSociete;
        #$this->printr($pnIdSociete);
        $q = "INSERT INTO TBL_PAGE ( IDSociete,IDMembreAdd,DateAdd,Classe,Ordre ) VALUES ( '$pnIdSociete','$pnIdUser',NOW(),'GestionReglage','1' );
INSERT INTO TBL_PAGE_TRAD ( IDPage,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'-Reglages','1' );";
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);

        $q = "INSERT INTO TBL_PAGE ( IDSociete,IDMembreAdd,DateAdd,Classe,Ordre ) VALUES ( '$pnIdSociete','$pnIdUser',NOW(),'GestionMembre','2' );
INSERT INTO TBL_PAGE_TRAD ( IDPage,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'-Membres','1' );";
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);

        $q = "INSERT INTO TBL_PAGE ( IDSociete,IDMembreAdd,DateAdd,Classe,Ordre ) VALUES ( '$pnIdSociete','$pnIdUser',NOW(),'ProductionFicheDeProd','3' );
INSERT INTO TBL_PAGE_TRAD ( IDPage,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'-OuvertureFiches','1' );";
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);

        $q = "INSERT INTO TBL_PAGE ( IDSociete,IDMembreAdd,DateAdd,Classe,Ordre ) VALUES ( '$pnIdSociete','$pnIdUser',NOW(),'ProductionDossierDeFab','4' );
INSERT INTO TBL_PAGE_TRAD ( IDPage,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'-OuvertureDossier','1' );";
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);

        $q = "INSERT INTO TBL_PAGE ( IDSociete,IDMembreAdd,DateAdd,Classe,Ordre ) VALUES ( '$pnIdSociete','$pnIdUser',NOW(),'SuiviDossierDeFab','5' );
INSERT INTO TBL_PAGE_TRAD ( IDPage,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'-SuiviDossier','1' );";
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);

        $q = "INSERT INTO TBL_PAGE ( IDSociete,IDMembreAdd,DateAdd,Classe,Ordre ) VALUES ( '$pnIdSociete','$pnIdUser',NOW(),'SuiviFicheDeProd','6' );
INSERT INTO TBL_PAGE_TRAD ( IDPage,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'-SuiviFiches','1' );";
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $data = \fbx\DBmysql::getInstance()->getInsertData($q);

        $this->_data = $data;
    }

    public function getInsertCodeErreur($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) {                             $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )   $pnIDSociete = $args['IDSociete'];  else $pnIDSociete = ''; }

        if (isset($args['NomCodeErreur']) && $args['NomCodeErreur'] != '')  $psNom = $args['NomCodeErreur'];    else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')                  $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')            $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_CODE_ERREUR ( DateAdd, IDMembreAdd, EstActif, Ordre,IDSociete ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete' );
INSERT INTO TBL_CODE_ERREUR_TRAD ( IDCodeErreur, Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertSupport($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomSupport']) && $args['NomSupport'] != '')$psNom = $args['NomSupport'];       else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_SUPPORT ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete' );
INSERT INTO TBL_SUPPORT_TRAD ( IDSupport,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertElement($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomElement']) && $args['NomElement'] != '')  $psNom = $args['NomElement'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_ELEMENT ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete' );
INSERT INTO TBL_ELEMENT_TRAD ( IDElement,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertFormat($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomFormat']) && $args['NomFormat'] != '')  $psNom = $args['NomFormat'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_FORMAT ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete' );
INSERT INTO TBL_FORMAT_TRAD ( IDFormat,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertImpression($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomImpression']) && $args['NomImpression'] != '')  $psNom = $args['NomImpression'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['NbTour']) && $args['NbTour'] != '')        $pnNbTour = $args['NbTour'];        else $pnNbTour = '1';
        if (isset($args['NbCalage']) && $args['NbCalage'] != '')    $pnNbCalage = $args['NbCalage'];    else $pnNbCalage = '1';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_IMPRESSION ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete,NbCalage,NbTour  ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete','$pnNbCalage','$pnNbTour' );
INSERT INTO TBL_IMPRESSION_TRAD ( IDImpression,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getInsertOption($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomOption']) && $args['NomOption'] != '')  $psNom = $args['NomOption'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "INSERT INTO TBL_OPTION ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'$pnIdUser','$pbEstActif','$pnOrdre','$pnIDSociete' );
INSERT INTO TBL_OPTION_TRAD ( IDOption,Nom,IDLangue ) VALUES ( LAST_INSERT_ID(),'$psNom','1' )";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }


    //__update
    public function getUpdateLangue($args)
    {
        if (isset($args['NomLangue']) && $args['NomLangue'] != '')  $psNomLangue = $args['NomLangue'];  else $psNomLangue = 'null';
        if (isset($args['CodeBCP']) && $args['CodeBCP'] != '')      $psCodeBCP = $args['CodeBCP'];      else $psCodeBCP = 'null';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDLangue']) && $args['IDLangue'] != '')    $pnIDLangue = $args['IDLangue'];    else $pnIDLangue = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_LANGUE AS TBL
SET
    TBL.DateMaj=NOW(),
    TBL.IDMembreMaj='$pnIdUser',
    TBL.EstActif='$pbEstActif',
    TBL.CodeBCP='$psCodeBCP',
    TBL.Nom='$psNomLangue'
WHERE
    TBL.IDLangue = '$pnIDLangue'";

        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);
        $this->_data = $data;
    }

    public function getUpdateMenu($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomMenu']) && $args['NomMenu'] != '')      $psNom = $args['NomMenu'];          else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDMenu']) && $args['IDMenu'] != '')        $pnIDMenu = $args['IDMenu'];        else $pnIDMenu = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_MENU AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete'
WHERE
    TBL.IDMenu = '$pnIDMenu'";
        \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_MENU_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDMenu = '$pnIDMenu'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdatePage($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomPage']) && $args['NomPage'] != '')      $psNom = $args['NomPage'];          else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDPage']) && $args['IDPage'] != '')        $pnIdPage = $args['IDPage'];        else $pnIdPage = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_PAGE AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete',
    TBL.EstActif = '$pbEstActif'
WHERE
    TBL.IDPage = '$pnIdPage'";
        \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_PAGE_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDPage = '$pnIdPage'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateSecteur($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomSecteur']) && $args['NomSecteur'] != '')    $psNom = $args['NomSecteur'];       else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')              $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDSecteur']) && $args['IDSecteur'] != '')      $pnIDSecteur = $args['IDSecteur'];  else $pnIDSecteur = 'null';
        if (isset($args['Code']) && $args['Code'] != '')        $pnCode = $args['Code'];    else $pnCode = '0';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_SECTEUR AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.Ordre = '$pnOrdre',
    TBL.EstActif = '$pbEstActif',
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.IDSociete = '$pnIDSociete',
    TBL.CODE = '$pnCode'
WHERE
    TBL.IDSecteur = '$pnIDSecteur'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_SECTEUR_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDSecteur = '$pnIDSecteur'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateMachine($args)
    {
        if (isset($args['NomMachine']) && $args['NomMachine'] != '')                        $psNom = $args['NomMachine'];                               else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')                                  $pnOrdre = $args['Ordre'];                                  else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')                            $pbEstActif = $args['EstActif'];                            else $pbEstActif = '0';
        if (isset($args['IDsecteur']) && $args['IDsecteur'] != '')                          $pnIDSecteur = $args['IDsecteur'];                          else $pnIDSecteur = '1';
        if (isset($args['IDSociete']) && $args['IDSociete'] != '0')                         $pnIDSociete = $args['IDSociete'];                          else $pnIDSociete = 'null';
        if (isset($args['CalageMin']) && $args['CalageMin'] != '')                          $pnCalageMin = $args['CalageMin'];                          else $pnCalageMin = '0';
        if (isset($args['CalageFeuilles']) && $args['CalageFeuilles'] != '')                $pnCalageFeuilles = $args['CalageFeuilles'];                else $pnCalageFeuilles = '0';
        if (isset($args['GachePour1000Feuilles']) && $args['GachePour1000Feuilles'] != '')  $pnGachePour1000Feuilles = $args['GachePour1000Feuilles'];  else $pnGachePour1000Feuilles = '0';
        if (isset($args['CadenceTourMin']) && $args['CadenceTourMin'] != '')                $pnCadenceTourMin = $args['CadenceTourMin'];                else $pnCadenceTourMin = '0';
        if (isset($args['passages']) && $args['passages'] != '')                            $pb2passages = $args['passages'];                           else $pb2passages = '0';
        if (isset($args['IDMachine']) && $args['IDMachine'] != '')                          $pnIDMachine = $args['IDMachine'];                          else $pnIDMachine = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_MACHINE AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.2passages = '$pb2passages',
    TBL.CalageMin = '$pnCalageMin',
    TBL.CalageFeuilles = '$pnCalageFeuilles',
    TBL.GachePour1000Feuilles = '$pnGachePour1000Feuilles',
    TBL.CadenceTourMin = '$pnCadenceTourMin',
    TBL.IDSecteur = '$pnIDSecteur',
    TBL.Ordre = '$pnOrdre',
    TBL.EstActif = '$pbEstActif',
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.IDSociete = '$pnIDSociete'
WHERE
    TBL.IDMachine = '$pnIDMachine'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_MACHINE_TRAD AS TMT
SET
    TMT.Nom = '$psNom'
WHERE
    TMT.IDMachine = '$pnIDMachine'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        //__CREATE QRcode
        $path= $_SESSION['QR']['PATH'];
        $link= $_SESSION['QR']['IMG']."/machine";
        $ref = $_SESSION['QR']['MACHINE']."?action=getInsertDataFicheDeProd&IDSecteur=$pnIDSecteur&IDMachine=$pnIDMachine"; //
        $url = "$path?machine-$pnIDMachine&$link&$ref";
        $this->cURLexec($url);
//        $this->getWrLog("up QRcode machine", "$url", __FUNCTION__, __FILE__);

        //__CREATE CODE BARRE
        $path = ($_SESSION['BARCODE']['PATH']);
        $link = ($_SESSION['BARCODE']['IMG'])."/machine";
        $filename = "barcodeMachine-$pnIDMachine";
        $contenu_barcode = "$$$pnIDSecteur$$$pnIDMachine";
        $url = "$path?$contenu_barcode&$filename&$link";
        $this->cURLexec($url);

        $this->_data = $data;
    }

    public function getUpdateSociete($args)
    {
        if (isset($args['NomSociete']) && $args['NomSociete'] != '')    $psNom = $args['NomSociete'];                   else $psNom = 'null';
        if (isset($args['Mail']) && $args['Mail'] != '')                $psMail = $args['Mail'];                        else $psMail = '99';
        if (isset($args['Telephone']) && $args['Telephone'] != '')      $psTelephone = $args['Telephone'];              else $psTelephone = '1';
        if (isset($args['IDMembre']) && $args['IDMembre'] != '')        $pnIDMembreContact = $args['IDMembre'];  else $pnIDMembreContact = '0';
        if (isset($args['IDLangue']) && $args['IDLangue'] != '')        $pnIDLangue = $args['IDLangue'];                else $pnIDLangue = '0';
        if (isset($args['Adresse1']) && $args['Adresse1'] != '')        $psAdresse1 = $args['Adresse1'];                else $psAdresse1 = '0';
        if (isset($args['Adresse2']) && $args['Adresse2'] != '')        $psAdresse2 = $args['Adresse2'];                else $psAdresse2 = '0';
        if (isset($args['CodePostal']) && $args['CodePostal'] != '')    $pnCodePostal = $args['CodePostal'];            else $pnCodePostal = '0';
        if (isset($args['Ville']) && $args['Ville'] != '')              $psVille = $args['Ville'];                      else $psVille = '0';
        if (isset($args['Pays']) && $args['Pays'] != '')                $psPays = $args['Pays'];                        else $psPays = '0';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif'];                else $pbEstActif = '0';
        if (isset($args['IDSociete']) && $args['IDSociete'] != '0')      $pnIDSociete = $args['IDSociete'];              else $pnIDSociete = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
TBL_SOCIETE SET
    DateMaj = NOW(),
    Nom = '$psNom',
    Adresse1 = '$psAdresse1',
    Adresse2 = '$psAdresse2',
    CodePostal = '$pnCodePostal',
    Ville = '$psVille',
    Pays = '$psPays',
    Mail = '$psMail',
    Telephone = '$psTelephone',
    IDMembreContact = '$pnIDMembreContact',
    IDLangue = '$pnIDLangue',
    EstActif = '$pbEstActif',
    IDMembreMaj = '$pnIdUser'
WHERE
    IDSociete = $pnIDSociete";

        $data = \fbx\DBmysql::getInstance()->getInsertData($q);

        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateCodeErreur($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) {                             $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )   $pnIDSociete = $args['IDSociete'];          else $pnIDSociete = ''; }

        if (isset($args['NomCodeErreur']) && $args['NomCodeErreur'] != '')  $psNom = $args['NomCodeErreur'];            else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')                  $pnOrdre = $args['Ordre'];                  else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')            $pbEstActif = $args['EstActif'];            else $pbEstActif = '0';
        if (isset($args['IDCodeErreur']) && $args['IDCodeErreur'] != '')    $pnIDCodeErreur = $args['IDCodeErreur'];    else $pnIDCodeErreur = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_CODE_ERREUR AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete'
WHERE
    TBL.IDCodeErreur = '$pnIDCodeErreur'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_CODE_ERREUR_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDCodeErreur = '$pnIDCodeErreur'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateSupport($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomSupport']) && $args['NomSupport'] != '')    $psNom = $args['NomSupport'];         else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')              $pnOrdre = $args['Ordre'];            else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif'];      else $pbEstActif = '0';
        if (isset($args['IDSupport']) && $args['IDSupport'] != '')      $pnIDSupport = $args['IDSupport'];    else $pnIDSupport = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_SUPPORT AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete'
WHERE
    TBL.IDSupport = '$pnIDSupport'";
        \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_SUPPORT_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDSupport = '$pnIDSupport'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateElement($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomElement']) && $args['NomElement'] != '')  $psNom = $args['NomElement'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDElement']) && $args['IDElement'] != '')    $pnIDElement = $args['IDElement'];    else $pnIDElement = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_ELEMENT AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete'
WHERE
    TBL.IDElement = '$pnIDElement'";
        \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_ELEMENT_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDElement = '$pnIDElement'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateFormat($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomFormat']) && $args['NomFormat'] != '')  $psNom = $args['NomFormat'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDFormat']) && $args['IDFormat'] != '')    $pnIDFormat = $args['IDFormat'];    else $pnIDFormat = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_FORMAT AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete'
WHERE
    TBL.IDFormat = '$pnIDFormat'";
        \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_FORMAT_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDFormat = '$pnIDFormat'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateImpression($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomImpression']) && $args['NomImpression'] != '')  $psNom = $args['NomImpression'];            else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')                  $pnOrdre = $args['Ordre'];                  else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')            $pbEstActif = $args['EstActif'];            else $pbEstActif = '0';
        if (isset($args['IDImpression']) && $args['IDImpression'] != '')    $pnIDImpression = $args['IDImpression'];    else $pnIDImpression = 'null';
        if (isset($args['NbTour']) && $args['NbTour'] != '')                $pnNbTour = $args['NbTour'];                else $pnNbTour = '1';
        if (isset($args['NbCalage']) && $args['NbCalage'] != '')            $pnNbCalage = $args['NbCalage'];            else $pnNbCalage = '1';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_IMPRESSION AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete',
    TBL.NbCalage = '$pnNbCalage',
    TBL.NbTour = '$pnNbTour'
WHERE
    TBL.IDImpression = '$pnIDImpression'";
        \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_IMPRESSION_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDImpression = '$pnIDImpression'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }

    public function getUpdateOption($args)
    {
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && ($args['IDSociete'] != '0' && $args['IDSociete'] != '') )  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = ''; }

        if (isset($args['NomOption']) && $args['NomOption'] != '')  $psNom = $args['NomOption'];        else $psNom = 'null';
        if (isset($args['Ordre']) && $args['Ordre'] != '')          $pnOrdre = $args['Ordre'];          else $pnOrdre = '99';
        if (isset($args['EstActif']) && $args['EstActif'] != '')    $pbEstActif = $args['EstActif'];    else $pbEstActif = '0';
        if (isset($args['IDOption']) && $args['IDOption'] != '')    $pnIDOption = $args['IDOption'];    else $pnIDOption = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        $q = "UPDATE
    TBL_OPTION AS TBL
SET
    TBL.DateMaj = NOW(),
    TBL.IDMembreMaj = '$pnIdUser',
    TBL.EstActif = '$pbEstActif',
    TBL.Ordre = '$pnOrdre',
    TBL.IDSociete = '$pnIDSociete'
WHERE
    TBL.IDOption = '$pnIDOption'";
        \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $q = "UPDATE
    TBL_OPTION_TRAD AS TBL
SET
    TBL.Nom = '$psNom'
WHERE
    TBL.IDOption = '$pnIDOption'";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,"",__FUNCTION__,__FILE__);

        $this->_data = $data;
    }
}