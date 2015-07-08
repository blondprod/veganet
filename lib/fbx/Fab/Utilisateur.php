<?php
/**
 *
 * Created by blond.
 * File: Utilisateur.php
 * Date: 24/03/15 - 11:53
 *
 */


namespace fbx\Fab;

class Utilisateur
{
    protected static $_instance;
    private $_nIdUtilisateur;
    private $_nIdNomUtilisateur;
    private $_nIdPrenomUtilisateur;
    private $_nIdUtilisateurGroupe;
    private $_nIdUtilisateurFonction;
    private $_bUtilisateurSu;
    private $_nIdSociete;

    public static function getInstance()
    {
        if (!isset(self::$_instance))  throw new \Exception('L\'utilisateur n\' a pas été initialisée. Appeler Utilisateur::init()');

        return self::$_instance;
    }

    public static function init()
    {
        try {
            self::$_instance = new self();
            if(isset($_SESSION['FBX_USER'])){
                self::$_instance->getData($_SESSION['FBX_USER']);
                if (isset($_SESSION['languages'])) self::$_instance->getLangue($_SESSION['languages']);
                else self::$_instance->getLangue($_GET["languages"]);
                self::$_instance->getPrefsAffichage();
            }
            elseif(isset($_SESSION['loginUsr'])){
                self::$_instance->getData($_SESSION['loginUsr']);
                if (isset($_SESSION['languages'])) self::$_instance->getLangue($_SESSION['languages']);
                else self::$_instance->getLangue($_GET["languages"]);
                self::$_instance->getPrefsAffichage();

                //-- recuperation du text pour le welcome message
                if(isset($_SESSION['FBX_USER_ID'])) $chemin_destination = "img/carousel/{$_SESSION['FBX_USER_ID']}/";
                else $chemin_destination = null;
                for($i = 1; $i <= 4; $i++) {
                    $fichier = "{$chemin_destination}text{$i}.txt";
                    if(file_exists($fichier)==1) {
                        $txtfile = fopen($fichier,'r');
                        $_SESSION["TXT"][$i] = fgets($txtfile);
                        fclose($txtfile);
                    }

                    $image = "{$chemin_destination}image{$i}.png";
                    if(file_exists($image)==1) {
                        $_SESSION["IMG"][$i] = $image;
                    } else {
                        $_SESSION["IMG"][$i] = "img/carousel/0/image{$i}.png";
                    }
                }
            }
        } catch (Exception $exc) {
            throw new \Exception("Impossible d'initialiser Utilisateur");
        }
    }

    public static function getLangue($codeBCP){
//        $q = "SELECT langues.IDLangue FROM langues WHERE langues.CodeBCP = '$codeBCP'";
        $q = "SELECT
L.IDLangue AS IDLangue
FROM
  TBL_LANGUE AS L
WHERE
  L.EstSupp = '0'
  AND L.CodeBCP = '$codeBCP'";
        $data = \fbx\DBmysql::getInstance()->getSelectData($q);
        if(isset($data[0])) $_SESSION['IDLANGUE'] = $data[0]->IDLangue;
    }

    private function getData($login){

        $q = "SELECT
  M.IDMembre AS id_membres,
  M.Prenom AS prenom,
  M.Nom AS nom,
  M.IDFonction AS id_fonction_membres,
  M.EstSu AS su,
  M.IDSociete AS IDSociete,
  GTF.IDGroupe AS IDGroupe
FROM
  TBL_MEMBRE AS M
  LEFT OUTER JOIN TBL_GROUPE_TL_FONCTION AS GTF
  ON GTF.IDFonction = M.IDFonction
WHERE
  M.EstActif = '1'
  AND M.EstSupp = '0'
  AND M.Login = '$login'";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        if(isset($data[0])){
            $this->_nIdUtilisateur = $data[0]->id_membres;
            $this->_nIdNomUtilisateur = $data[0]->nom;
            $this->_nIdPrenomUtilisateur = $data[0]->prenom;
            $this->_nIdUtilisateurGroupe = $data[0]->IDGroupe;
            $this->_nIdUtilisateurFonction = $data[0]->id_fonction_membres;
            $this->_bUtilisateurSu = $data[0]->su;
            $this->_nIdSociete = $data[0]->IDSociete;

            $_SESSION['FBX_USER_ID'] = $this->_nIdUtilisateur;
            $_SESSION['FBX_USER_NOM'] = $this->_nIdNomUtilisateur;
            $_SESSION['FBX_USER_PRENOM'] = $this->_nIdPrenomUtilisateur;
            $_SESSION['FBX_USER_GROUPE_ID'] = $this->_nIdUtilisateurGroupe;
            $_SESSION['FBX_USER_FONCTION_ID'] = $this->_nIdUtilisateurFonction;
            $_SESSION['FBX_USER_SOCIETE_ID'] = $this->_nIdSociete;
            $_SESSION['FBX_USER_SU'] = $this->_bUtilisateurSu;

            if(preg_match("/192.168/",$_SERVER['REMOTE_ADDR'])) $_SESSION['FBX_USER_TYPE_NAT'] = "LAN";
            else $_SESSION['FBX_USER_TYPE_NAT'] = "WAN";

            if( preg_match('/127.0.0.1/',$_SERVER['SERVER_ADDR']) ) $_SESSION['FBX_SERVER_TYPE'] = "DEV";
            else $_SESSION['FBX_SERVER_TYPE'] = "PROD";

            $config = simplexml_load_file("../lib/config.ini");
//            $_SESSION['IP'] = "{$config->dev->ip}";
//            $_SESSION['PUBLIC_PATH'] = "{$config->path->public}";

            $_SESSION['QR'] = array(
                "PATH"=>"{$config->path->qrcode}",
                "IMG"=>"{$config->img->qrcode}",
                "DOSSIER"=>"{$config->qr->dossier}",
                "MACHINE"=>"{$config->qr->machine}",
                "MEMBRE"=>"{$config->qr->membre}"
            );

            $_SESSION['BARCODE'] = array(
                "PATH"=>"{$config->path->barcode}",
                "IMG"=>"{$config->img->barcode}"
            );
        }
    }

    private function getPrefsAffichage()
    {
        $where=null;
        if ($_SESSION['FBX_USER_SU'] != '1' ) { $where .= "AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'"; }

        //-- Préférences de pagination
        $sql = "SELECT
  MRP.IDpage AS IDpage ,
  MRP.NbRow AS NbRow
FROM
  TBL_MEMBRE_ROW_PAGE AS MRP
WHERE
  MRP.IDmembre = '{$this->_nIdUtilisateur}'";
        $data = \fbx\DBmysql::getInstance()->getSelectData($sql);
        foreach($data as $key=>$value){ $_SESSION['PrefsNbPages'][$value->IDpage] = $value->NbRow; }

        //-- droit des pages
        $qPage = "SELECT
    T1.IDPage AS IDpage
    , CASE WHEN ISNULL(T3.IDFonction) THEN '0' ELSE '1' END AS permitPage
    ,T1.Classe
FROM
    TBL_PAGE AS T1
    LEFT OUTER JOIN TBL_PAGE_TRAD AS T2 ON T1.IDPage = T2.IDPage AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_FONCTION_TL_PAGE AS T3 ON T1.IDPage = T3.IDPage AND T3.EstSupp = '0' AND T3.IDFonction = '{$_SESSION['FBX_USER_FONCTION_ID']}'
WHERE
    T1.EstSupp = '0'
    #$where
    AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'
ORDER BY
    T1.Ordre";
        $data_permitPage = \fbx\DBmysql::getInstance()->getSelectData($qPage);
        foreach($data_permitPage as $key=>$value){
            $_SESSION['PrefsPagesPermit'][$value->IDpage] = $value->permitPage;
            $_SESSION['Classe'][$value->Classe] = $value->permitPage;
        }

        //-- droit des menus
        $qMenu = "SELECT
    T1.IDMenu AS IDmenu
    , CASE WHEN ISNULL(T3.IDGroupe) THEN '0' ELSE '1' END AS permitMenu
FROM
    TBL_MENU AS T1
    LEFT OUTER JOIN TBL_MENU_TRAD AS T2 ON T1.IDMenu = T2.IDMenu AND T2.IDLangue = 1
    LEFT OUTER JOIN TBL_GROUPE_TL_MENU AS T3 ON T1.IDMenu = T3.IDMenu AND T3.EstSupp = '0' AND T3.IDGroupe = '{$_SESSION['FBX_USER_GROUPE_ID']}'
WHERE
    T1.EstSupp = '0'
    #$where
    AND T1.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'
ORDER BY
    T1.Ordre";
        $data_permitMenu = \fbx\DBmysql::getInstance()->getSelectData($qMenu);
        foreach($data_permitMenu as $key=>$value){
            $_SESSION['PrefsMenusPermit'][$value->IDmenu] = $value->permitMenu;
        }

//        if (isset($data[0]->IDSociete)) $pnIDSociete = $data[0]->IDSociete; else $pnIDSociete = '0';
        $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];
        $q = "SELECT * FROM TBL_SLOGAN WHERE EstSupp = '0' AND IDSociete = '$pnIDSociete'";

        $data_slogan = \fbx\DBmysql::getInstance()->getSelectData($q);

        if (isset($data_slogan[0]->Slogan)) $_SESSION['Slogan'] = $data_slogan[0]->Slogan;
        else $_SESSION['Slogan'] = "FBX";
    }

    public static function isIdentified(){
        
        return (
            isset($_SESSION['FBX_USER_ID'])
            &&isset($_SESSION['FBX_USER_PRENOM'])
            &&isset($_SESSION['FBX_USER_NOM'])
            &&isset($_SESSION['FBX_USER_GROUPE_ID'])
            &&isset($_SESSION['FBX_USER_FONCTION_ID'])
            &&isset($_SESSION['FBX_USER_SOCIETE_ID'])
            &&isset($_SESSION['FBX_USER_SU'])
            &&isset($_SESSION['FBX_USER_TYPE_NAT'])
            &&isset($_SESSION['FBX_SERVER_TYPE'])
            &&isset($_SESSION['IDLANGUE'])
            &&isset($_SESSION['QR'])
            &&isset($_SESSION['BARCODE'])
//            &&isset($_SESSION['PUBLIC_PATH'])
//            &&isset($_SESSION['IP'])
        );
    }

}
