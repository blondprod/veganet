<?php
/**
 *
 * Created by blond.
 * File: Select.php
 * Date: 25/03/15 - 09:53
 *
 */

namespace fbx\Fab;

class Select extends Base
{
    private function getListeLangue()
    {
        $q = "SELECT L.IDLangue AS ID, L.Nom AS Nom FROM TBL_LANGUE AS L WHERE L.EstSupp = '0' AND L.EstActif = '1'";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeGroupe()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDGroupe AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_GROUPE AS T1
    LEFT OUTER JOIN TBL_GROUPE_TRAD AS T2
    ON T1.IDGroupe = T2.IDGroupe AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeGroupeTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDGroupe AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_GROUPE AS T1
    LEFT OUTER JOIN TBL_GROUPE_TRAD AS T2
    ON T1.IDGroupe = T2.IDGroupe AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }
    
    private function getListeImpressionTrad()
    {
        $where = null;
        $pnIdLangue = $_SESSION['IDLANGUE'];

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDImpression AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_IMPRESSION AS T1
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T2
    ON T1.IDImpression = T2.IDImpression AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeElementTrad()
    {
        $where = null;
        $pnIdLangue = $_SESSION['IDLANGUE'];

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDElement AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_ELEMENT AS T1
    LEFT OUTER JOIN TBL_ELEMENT_TRAD AS T2
    ON T1.IDElement = T2.IDElement AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
//        $this->getWrLog($q, "select element trad", __FUNCTION__, __FILE__);
        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeMenu()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDMenu AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_MENU AS T1
    LEFT OUTER JOIN TBL_MENU_TRAD AS T2
    ON T1.IDMenu = T2.IDMenu AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeReclameEtatTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDReclameEtat AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_RECLAME_ETAT AS T1
    LEFT OUTER JOIN TBL_RECLAME_ETAT_TRAD AS T2
    ON T1.IDReclameEtat = T2.IDReclameEtat AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeTypeFournisseurTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDFournisseurType AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_FOURNISSEUR_TYPE AS T1
    LEFT OUTER JOIN TBL_FOURNISSEUR_TYPE_TRAD AS T2
    ON T1.IDFournisseurType = T2.IDFournisseurType AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeSecteurTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDSecteur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_SECTEUR AS T1
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T2
    ON T1.IDSecteur = T2.IDSecteur AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeSecteur()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDSecteur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_SECTEUR AS T1
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T2
    ON T1.IDSecteur = T2.IDSecteur AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListePage()
    {
        $q = "SELECT
    T1.IDPage AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_PAGE AS T1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T2
    ON T1.IDPage = T2.IDPage AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeSupport()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDSupport AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_SUPPORT AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2
    ON T1.IDSupport = T2.IDSupport AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeSupportTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDSupport AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_SUPPORT AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2
    ON T1.IDSupport = T2.IDSupport AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeOptionTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDOption AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2
    ON T1.IDOption = T2.IDOption AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeFormatTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDFormat AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_FORMAT AS T1
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T2
    ON T1.IDFormat = T2.IDFormat AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeFonction()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDFonction AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_FONCTION AS T1
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS T2
    ON T1.IDFonction = T2.IDFonction AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeMachine()
    {
        $q = "SELECT
    T1.IDMachine AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_MACHINE AS T1
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T2
    ON T1.IDMachine = T2.IDMachine AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeSocieteTrad()
    {
        $q = "SELECT
    T1.IDSociete AS ID,
    CASE WHEN ISNULL(T1.Nom) THEN '-' ELSE T1.Nom END AS Nom
FROM
    TBL_SOCIETE AS T1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
ORDER BY
    T1.Nom";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeFonctionTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDFonction AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_FONCTION AS T1
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS T2
    ON T1.IDFonction = T2.IDFonction AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
//        $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeCodeErreur()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDCodeErreur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2
    ON T1.IDCodeErreur = T2.IDCodeErreur AND T2.IDLangue = 1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeCodeErreurTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDCodeErreur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2
    ON T1.IDCodeErreur = T2.IDCodeErreur AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeMembre()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= " AND T1.EstSu != '1'";
            $where .= " AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT CONCAT(T1.Prenom,' ', T1.Nom) AS Nom , T1.IDMembre AS ID FROM TBL_MEMBRE AS T1 WHERE T1.EstSupp = '0' AND T1.EstActif = '1' $where";
        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    private function getListeMachineTrad()
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND T1.IDSociete = '$pnIDSociete'";
            }
        }

        $q = "SELECT
    T1.IDMachine AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_MACHINE AS T1
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T2
    ON T1.IDMachine = T2.IDMachine AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListe($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        $data_Liste = $this->$args['class']();

        $data_ID = explode('.:.',$args['id']);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );
    }

    public function getListeGroupeTLFonction($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND TF.IDSociete = '$pnIDSociete'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND TF.IDSociete = '$pnIDSociete'";
            }
        }

        if (is_array($args['id'])) $plIDGroupe = implode(',',$args['id']);
        else $plIDGroupe = $args['id'];

        if ($plIDGroupe != '0') {
            $q = "SELECT
    TGTF.IDFonction AS ID,
    CASE WHEN ISNULL(TFT.Nom) THEN '-' ELSE TFT.Nom END AS Nom
FROM
    TBL_GROUPE_TL_FONCTION AS TGTF
    LEFT OUTER JOIN TBL_FONCTION AS TF ON TF.IDFonction = TGTF.IDFonction
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS TFT ON TF.IDFonction = TFT.IDFonction  AND TFT.IDLangue = '{$_SESSION['IDLANGUE']}'
WHERE
    TF.EstActif = '1'
    AND TF.EstSupp = '0'
    AND TGTF.EstSupp = '0'
    AND TGTF.IDGroupe IN ($plIDGroupe)
    $where
ORDER BY
    TF.Ordre";

            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeFonctionTrad();
//        var_dump($data_Liste);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );
    }

    public function getListeGroupeTLMembre($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND M.IDSociete = '$pnIDSociete'";
            $where .= " AND M.EstSu != '1'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND M.IDSociete = '$pnIDSociete'";
            }
        }

        if (is_array($args['id'])) $plIDGroupe = implode(',',$args['id']);
        else $plIDGroupe = $args['id'];

        if ($plIDGroupe != '0') {
            $q = "SELECT
    CONCAT(M.Prenom,' ', M.Nom) AS Nom,
    M.IDMembre AS ID
FROM
    TBL_MEMBRE AS M
    INNER JOIN TBL_FONCTION AS F ON F.IDFonction = M.IDFonction
    INNER JOIN TBL_GROUPE_TL_FONCTION AS GTF ON F.IDFonction = GTF.IDFonction
WHERE
    M.EstSupp = '0'
    AND M.EstActif = '1'
    AND GTF.EstSupp = '0'
    AND GTF.IDGroupe IN ($plIDGroupe)
    $where";

            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeMembre();
//        var_dump($data_Liste);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );
    }

    public function getListeFonctionTLMembre($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND M.IDSociete = '$pnIDSociete'";
            $where .= " AND M.EstSu != '1'";
        }
        else {
            if (isset($args['IDSociete']) && $args['IDSociete'] != '')  {
                $pnIDSociete = $args['IDSociete'];
                $where .= "AND M.IDSociete = '$pnIDSociete'";
            }
        }

        if (is_array($args['id'])) $plIDMembre = implode(',',$args['id']);
        else $plIDMembre = $args['id'];

        if ($plIDMembre != '0') {
            $q = "SELECT
    CONCAT(M.Prenom,' ', M.Nom) AS Nom,
    M.IDMembre AS ID
FROM
    TBL_MEMBRE AS M
WHERE
    M.EstSupp = '0'
    AND M.EstActif = '1'
    AND M.IDFonction IN ($plIDMembre)
    $where";

            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeMembre();
//        var_dump($data_Liste);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );
    }

    public function getListeSecteurTlMachine($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSecteur = implode(',',$args['id']);
        else $plIDSecteur = $args['id'];

        if ($plIDSecteur != '0') {
            $q = "SELECT
    T1.IDMachine AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_MACHINE AS T1
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T2
    ON T1.IDMachine = T2.IDMachine AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    AND T1.IDSecteur IN ($plIDSecteur)
ORDER BY
    T1.Ordre";

            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeMachineTrad();

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );
    }

    public function getListeCodeErreurTlSecteur($args)
    {
        $where = null;
        $this->_template = "elements/elementsSelect.twig";

        $pnIdLangue = $_SESSION['IDLANGUE'];

        if (is_array($args['IDSociete'])) $plIDSociete = implode(',',$args['IDSociete']);
        else $plIDSociete = $args['IDSociete'];
        if (isset($plIDSociete) && $plIDSociete != '0') { $where .= "AND T1.IDSociete IN ($plIDSociete)"; }   else { $where = null; }

        if (is_array($args['IDSecteur'])) $plIDSecteur = implode(',',$args['IDSecteur']);
        else $plIDSecteur = $args['IDSecteur'];
        if (isset($plIDSecteur) && $plIDSecteur != '0') { $where .= "AND T3.IDSecteur IN ($plIDSecteur)"; }   else { $where = null; }

        if ($plIDSecteur != '0') {
            $q = "SELECT
    T2.Nom,
    T1.IDCodeErreur AS ID
FROM
    TBL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2
    ON T1.IDCodeErreur = T2.IDCodeErreur  AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR_TL_CODE_ERREUR AS T3
    ON T1.IDCodeErreur = T3.IDCodeErreur AND T3.EstSupp = '0'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
//            $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeCodeErreurTrad();
        $data_ID = explode('.:.',$args['IDCode']);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );
    }

    public function getListeSocieteTlMenu($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSociete = implode(',',$args['id']);
        else $plIDSociete = $args['id'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

            $q = "SELECT
    T1.IDMenu AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_MENU AS T1
    LEFT OUTER JOIN TBL_MENU_TRAD AS T2
    ON T1.IDMenu = T2.IDMenu AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlSecteur($args)
    {
        $data_ID = null;
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSociete = implode(',',$args['id']);
        else $plIDSociete = $args['id'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

        if ( isset($args['IDSecteur'])) $data_ID = array($args['IDSecteur']);

            $q = "SELECT
    T1.IDSecteur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_SECTEUR AS T1
    LEFT OUTER JOIN TBL_SECTEUR_TRAD AS T2
    ON T1.IDSecteur = T2.IDSecteur AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlCodeErreur($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSociete = implode(',',$args['id']);
        else $plIDSociete = $args['id'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

            $q = "SELECT
    T1.IDCodeErreur AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_CODE_ERREUR AS T1
    LEFT OUTER JOIN TBL_CODE_ERREUR_TRAD AS T2
    ON T1.IDCodeErreur = T2.IDCodeErreur AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlPage($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSociete = implode(',',$args['id']);
        else $plIDSociete = $args['id'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

            $q = "SELECT
    T1.IDPage AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_PAGE AS T1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T2
    ON T1.IDPage = T2.IDPage AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlGroupe($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSociete = implode(',',$args['id']);
        else $plIDSociete = $args['id'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

            $q = "SELECT
    T1.IDGroupe AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_GROUPE AS T1
    LEFT OUTER JOIN TBL_GROUPE_TRAD AS T2
    ON T1.IDGroupe = T2.IDGroupe AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args,
            "Q"=>$q
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlMembre($args)
    {
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSociete = implode(',',$args['id']);
        else $plIDSociete = $args['id'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

            $q = "SELECT
    T1.IDMembre AS ID,
    CONCAT(T1.Prenom,' ', T1.Nom) AS Nom
FROM
    TBL_MEMBRE AS T1
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Prenom,T1.Nom";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q, "", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args,
            "Q"=>$q
        );

//        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlFonction($args)
    {
        $data_ID = null;
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['id'])) $plIDSociete = implode(',',$args['id']);
        else $plIDSociete = $args['id'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

        if ( isset($args['IDFonction'])) $data_ID = array($args['IDFonction']);

            $q = "SELECT
    T1.IDFonction AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_FONCTION AS T1
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS T2
    ON T1.IDFonction = T2.IDFonction AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        #$this->getWrLog($q, "ici", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

//        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlOption($args)
    {
        $data_ID = null;
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['IDSociete'])) $plIDSociete = implode(',',$args['IDSociete']);
        else $plIDSociete = $args['IDSociete'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

        if ( isset($args['IDOption'])) $data_ID = array($args['IDOption']);

            $q = "SELECT
    T1.IDOption AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2
    ON T1.IDOption = T2.IDOption AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        #$this->getWrLog($q, "ici", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeSocieteTlSupport($args)
    {
        $data_ID = null;
        $plIDSociete = '0';
        $this->_template = "elements/elementsSelect.twig";

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $plIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
        } else {
            if (isset($args['id'])) {
                if (is_array($args['id'])) $plIDSociete = implode(',', $args['id']);
                else $plIDSociete = $args['id'];
            }
        }

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

        if ( isset($args['IDSupport'])) $data_ID = array($args['IDSupport']);

            $q = "SELECT
    T1.IDSupport AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_SUPPORT AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2
    ON T1.IDSupport = T2.IDSupport AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        #$this->getWrLog($q, "ici", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getSelectMachineTlSociete($args)
    {
        $data_ID = null;
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['IDSociete'])) $plIDSociete = implode(',',$args['IDSociete']);
        else $plIDSociete = $args['IDSociete'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

        $q = "SELECT
    T1.IDMachine AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_MACHINE AS T1
    LEFT OUTER JOIN TBL_MACHINE_TRAD AS T2
    ON T1.IDMachine = T2.IDMachine AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getSelectFormatTlSociete($args)
    {
        $data_ID = null;
        $this->_template = "elements/elementsSelect.twig";

        if (is_array($args['IDSociete'])) $plIDSociete = implode(',',$args['IDSociete']);
        else $plIDSociete = $args['IDSociete'];

        if ($plIDSociete != '0') { $where = "AND T1.IDSociete IN ($plIDSociete)"; } else { $where = null; }

        $q = "SELECT
    T1.IDFormat AS ID,
    CASE WHEN ISNULL(T2.Nom) THEN '-' ELSE T2.Nom END AS Nom
FROM
    TBL_FORMAT AS T1
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T2
    ON T1.IDFormat = T2.IDFormat AND T2.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getSelectSupportTlFormat($args)
    {
        $data_ID = $where = null;
        $this->_template = "elements/elementsSelect.twig";

        $pnIdLangue = $_SESSION['IDLANGUE'];

        if (is_array($args['IDSociete'])) $plIDSociete = implode(',',$args['IDSociete']);
        else $plIDSociete = $args['IDSociete'];

        if (isset($plIDSociete) && $plIDSociete != '0') { $where .= "AND T1.IDSociete IN ($plIDSociete)"; }   else { $where = null; }
        if (isset($args['ID']) && $args['ID'] != '0')   { $where .= "AND T3.IDFormat = '{$args['ID']}'"; }    else { $where = null; }

        $q = "SELECT
    T1.IDSupport AS ID,
    T2.Nom AS Nom
FROM
    TBL_SUPPORT AS T1
    LEFT OUTER JOIN TBL_SUPPORT_TRAD AS T2
    ON T1.IDSupport = T2.IDSupport AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SUPPORT_TL_FORMAT AS T3
    ON T1.IDSupport = T3.IDSupport  AND T3.EstSupp = '0'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";

        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
//        $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getSelectFormatTlSupport($args)
    {
        $data_ID = $where = null;
        $plIDSociete = '0';
        $this->_template = "elements/elementsSelect.twig";

        $pnIdLangue = $_SESSION['IDLANGUE'];

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete IN ($pnIDSociete)";}
        else {
            if (isset($args['IDSociete'])) {
                if (is_array($args['IDSociete'])) $plIDSociete = implode(',', $args['IDSociete']);
                else $plIDSociete = $args['IDSociete'];
            }
            if (isset($plIDSociete) && $plIDSociete != '0') { $where .= "AND T1.IDSociete IN ($plIDSociete)"; }   else { $where = null; }
        }

        if (isset($args['idformat']) && $args['idformat'] != '0') { $data_ID = explode('.:.',$args['idformat']); }

        if (isset($args['ID']) && $args['ID'] != '0')   {
            $where .= "AND T3.IDSupport = '{$args['ID']}'";

        $q = "SELECT
    T1.IDFormat AS ID,
    T2.Nom AS Nom
FROM
    TBL_FORMAT AS T1
    LEFT OUTER JOIN TBL_FORMAT_TRAD AS T2
    ON T1.IDFormat = T2.IDFormat AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SUPPORT_TL_FORMAT AS T3
    ON T1.IDFormat = T3.IDFormat  AND T3.EstSupp = '0'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);

//        $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
        }
        else {
            if (isset($plIDSociete) && $plIDSociete != '0') {
                $data_Liste = $this->getSelectFormatTlSociete($args);
            }
            else {
                $data_Liste = $this->getListeFormatTrad();
            }
        }

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getSelectImpressionTlMachine($args)
    {
        $data_ID = $where = null;
        $plIDSociete = '0';
        $this->_template = "elements/elementsSelect.twig";

        $pnIdLangue = $_SESSION['IDLANGUE'];

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
            $where .= "AND T1.IDSociete IN ($pnIDSociete)";}
        else {
            if (isset($args['IDSociete'])) {
                if (is_array($args['IDSociete'])) $plIDSociete = implode(',', $args['IDSociete']);
                else $plIDSociete = $args['IDSociete'];
            }
            if (isset($plIDSociete) && $plIDSociete != '0') { $where .= "AND T1.IDSociete IN ($plIDSociete)"; }   else { $where = null; }
        }

        if (isset($args['idformat']) && $args['idformat'] != '0') { $data_ID = explode('.:.',$args['idformat']); }

        if (isset($args['ID']) && $args['ID'] != '0')   {
            $where .= " AND T4.IDMachine = '{$args['ID']}'";

        $q = "SELECT
    T1.IDImpression AS ID,
    T2.Nom AS Nom
FROM
    TBL_IMPRESSION AS T1
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T2 ON T1.IDImpression = T2.IDImpression AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR_TL_IMPRESSION AS T3 ON T1.IDImpression = T3.IDImpression  AND T3.EstSupp = '0'
    LEFT OUTER JOIN TBL_MACHINE AS T4 ON T3.IDSecteur = T4.IDSecteur AND T4.EstSupp = '0'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
        $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);

//        $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
        }
        else {
            $data_Liste = $this->getListeImpressionTrad();
        }

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );

        #return \fbx\DBmysql::getInstance()->getSelectData($q);
    }

    public function getListeOptionTlSecteur($args)
    {
        $where = null;
        $this->_template = "elements/elementsSelect.twig";

        $pnIdLangue = $_SESSION['IDLANGUE'];

        if (is_array($args['IDSociete'])) $plIDSociete = implode(',',$args['IDSociete']);
        else $plIDSociete = $args['IDSociete'];
        if (isset($plIDSociete) && $plIDSociete != '0') { $where .= "AND T1.IDSociete IN ($plIDSociete)"; }   else { $where = null; }

        if (is_array($args['IDSecteur'])) $plIDSecteur = implode(',',$args['IDSecteur']);
        else $plIDSecteur = $args['IDSecteur'];
        if (isset($plIDSecteur) && $plIDSecteur != '0') { $where .= "AND T3.IDSecteur IN ($plIDSecteur)"; }   else { $where = null; }

        if ($plIDSecteur != '0') {
            $q = "SELECT
    T2.Nom,
    T1.IDOption AS ID
FROM
    TBL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2
    ON T1.IDOption = T2.IDOption  AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR_TL_OPTION AS T3
    ON T1.IDOption = T3.IDOption AND T3.EstSupp = '0'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
//            $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeOptionTrad();

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );
    }

    public function getListeImpressionTlSecteur($args)
    {
        $where = null;
        $this->_template = "elements/elementsSelect.twig";

        $pnIdLangue = $_SESSION['IDLANGUE'];

        if (is_array($args['IDSociete'])) $plIDSociete = implode(',',$args['IDSociete']);
        else $plIDSociete = $args['IDSociete'];
        if (isset($plIDSociete) && $plIDSociete != '0') { $where .= "AND T1.IDSociete IN ($plIDSociete)"; }   else { $where = null; }

        if (is_array($args['IDSecteur'])) $plIDSecteur = implode(',',$args['IDSecteur']);
        else $plIDSecteur = $args['IDSecteur'];
        if (isset($plIDSecteur) && $plIDSecteur != '0') { $where .= "AND T3.IDSecteur IN ($plIDSecteur)"; }   else { $where = null; }

        if ($plIDSecteur != '0') {
            $q = "SELECT
    T2.Nom,
    T1.IDImpression AS ID
FROM
    TBL_IMPRESSION AS T1
    LEFT OUTER JOIN TBL_IMPRESSION_TRAD AS T2
    ON T1.IDImpression = T2.IDImpression  AND T2.IDLangue = '$pnIdLangue'
    LEFT OUTER JOIN TBL_SECTEUR_TL_IMPRESSION AS T3
    ON T1.IDImpression = T3.IDImpression AND T3.EstSupp = '0'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    $where
ORDER BY
    T1.Ordre";
//            $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeImpressionTrad();

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "OUT"=>$args
        );
    }

    public function getListeOptionTlOption($args)
    {
        $plIDoption = '0'; $data_ID = null;

        $pnIdLangue = $_SESSION['IDLANGUE'];
        $this->_template = "elements/elementsSelect.twig";

        if (isset($args['listeIdOption']) && $args['listeIdOption'] != '') $plIDoption = $args['listeIdOption'];
        if (isset($args['idoption']) && $args['idoption'] != '0') { $data_ID = explode('.:.',$args['idoption']); }

        if ($plIDoption != '0') {
            $q = "SELECT
    T2.Nom,
    T1.IDOption AS ID
FROM
    TBL_OPTION AS T1
    LEFT OUTER JOIN TBL_OPTION_TRAD AS T2
    ON T1.IDOption = T2.IDOption  AND T2.IDLangue = '$pnIdLangue'
WHERE
    T1.EstSupp = '0'
    AND T1.EstActif = '1'
    AND T1.IDOption IN ($plIDoption)
ORDER BY
    T1.Ordre";
//            $this->getWrLog($q, "---ICI---", __FUNCTION__, __FILE__);
            $data_Liste = \fbx\DBmysql::getInstance()->getSelectData($q);
        }
        else $data_Liste = $this->getListeOptionTrad();

        $this->_data = array(
            "data_Liste"=>$data_Liste,
            "data_ID"=>$data_ID,
            "OUT"=>$args
        );
    }
}