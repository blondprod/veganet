<?php
/**
 *
 * Created by blond.
 * File: Base.php
 * Date: 24/03/15 - 22:30
 *
 */

namespace fbx\Fab;

class Base
{
    public $_template;
    public $_data;

    public function printr($arr)
    {
        echo "<div style='margin-top: 60px;' class='container-fluid'>";
        echo "<pre>";
        var_dump($arr);
        echo "</pre>";
        echo "</div>";
    }

    public function getTemplate()
    {
        return (string)$this->_template;
    }

    public function getData()
    {
        return $this->_data;
    }

    public function getMenu()
    {
        $this->_template = "elements/elementsMenu.twig";

        $where = $wherePage = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) {
            $where .= " AND TM.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'";
            $wherePage .= " AND TP.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'";
        }

        $q = "SELECT
    TM.IDMenu AS IDMenu,
    CASE WHEN ISNULL(TMT.Nom) THEN '-' ELSE TMT.Nom END AS NomMenu
FROM
    TBL_MENU AS TM
    LEFT OUTER JOIN TBL_MENU_TRAD AS TMT ON TM.IDMenu = TMT.IDMenu AND TMT.IDLangue = '{$_SESSION['IDLANGUE']}'
WHERE
    TM.EstSupp = '0'
    AND TM.EstActif = '1'
    $where
ORDER BY
    TM.Ordre";

        $data_menu = \fbx\DBmysql::getInstance()->getSelectData($q);

        foreach($data_menu AS $key => $value) {

            $q = "SELECT
    TP.IDPage AS IDPage,
    CASE WHEN ISNULL(TPT.Nom) THEN '-' ELSE TPT.Nom END AS NomPage,
    TMTP.IDPage AS ID,
    TP.Classe AS ClassPage
FROM
    TBL_PAGE AS TP
    LEFT OUTER JOIN TBL_MENU_TL_PAGE AS TMTP ON TP.IDPage = TMTP.IDPage AND TMTP.EstSupp = '0'
    LEFT OUTER JOIN TBL_PAGE_TRAD AS TPT ON TP.IDPage = TPT.IDPage AND TPT.IDLangue = '{$_SESSION['IDLANGUE']}'
WHERE
    TP.EstSupp = '0'
    AND TP.EstActif = '1'
    AND TMTP.IDMenu = '{$value->IDMenu}'
    $wherePage
ORDER BY
    TP.Ordre";

            $data = \fbx\DBmysql::getInstance()->getSelectData($q);

            $data_page[$value->IDMenu] = $data;
        }

        $this->_data = array(
            "data_menu"=>$data_menu,
            "data_page"=>$data_page
        );
    }

    public function getWrLog($q,$data,$function,$file)
    {
        $args = basename($file) . " | " . $function . " | IDuser: " . $_SESSION['FBX_USER_ID'] . " | " . $_SESSION['FBX_USER_NOM'] . " " . $_SESSION['FBX_USER_PRENOM'] . "\n$q \nresu: $data";

        if (isset($args) && $args!="") $message = "| " . $args;
        else $message = "| ";

        if (!is_dir("log")) mkdir("/log", 0777);

        if (is_dir("log")) {
            // ouverture
            $fichier = "log/".date('Y-m-d').".log";
            $txtfile = fopen($fichier,'a'); //a+ ou c+ ou r+ ou w+

            // ecriture
            $date = explode(" ",microtime());
            $microSec = $date[0];
            $strMessage = "\n".date('Y-m-d H:i:s') . $microSec . " $message\n";
            fputs($txtfile , $strMessage);

            // fermeture
            fclose($txtfile);
            chmod($fichier,0777);
        }
    }

    public function getDelete($args)
    {
        $table = $args['Table'];            // ex: TBL_MENU_TRAD
        $colonne = $args['Colonne'];        // ex: IDMenu
        $plID = implode(',',$args['ID']);

        $q = "UPDATE $table SET $table.IDMembreSupp='{$_SESSION['FBX_USER_ID']}',$table.DateSupp=NOW(), $table.EstSupp = '1' WHERE $table.EstProtected = '0' AND $table.$colonne IN ($plID)";
        $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
        $this->getWrLog($q,$data,__FUNCTION__,__FILE__);

        if($table == "TBL_SOCIETE"){
            $q_page = "UPDATE TBL_PAGE AS T1 SET T1.EstSupp = '1', T1.DateSupp = NOW(), T1.IDMembreSupp = '{$_SESSION['FBX_USER_ID']}' WHERE T1.IDSociete IN ($plID) AND T1.EstProtected = '0'";
            $data = \fbx\DBmysql::getInstance()->getUpdateData($q_page);
            $this->getWrLog($q_page,$data,__FUNCTION__,__FILE__);
        }
        elseif($table == "TBL_DOSSIER_DE_FAB"){
            $q_dossier = "UPDATE TBL_DOSSIER_DE_FAB_TL_ELEMENT AS T1 SET T1.EstSupp = '1', T1.DateSupp = NOW(), T1.IDMembreSupp = '{$_SESSION['FBX_USER_ID']}' WHERE T1.IDDossierDeFab IN ($plID) AND T1.EstProtected = '0';
UPDATE TBL_DOSSIER_DE_FAB_TL_OPTION AS T1 SET T1.EstSupp = '1', T1.DateSupp = NOW(), T1.IDMembreSupp = '{$_SESSION['FBX_USER_ID']}' WHERE T1.IDDossierDeFab IN ($plID) AND T1.EstProtected = '0'";
            $data = \fbx\DBmysql::getInstance()->getUpdateData($q_dossier);
            $this->getWrLog($q_dossier,$data,__FUNCTION__,__FILE__);
        }

        $this->_data = $data;

        echo "<script type='text/javascript'>$(function(){getTableGestionReglageAll();getTableGestionDroitAll();})</script>";
    }

    public function getParams($args)
    {

        $config = simplexml_load_file("../lib/config.ini");

        // PARAMS STAGE
        if($_SESSION['EXAFAB_SERVER_TYPE']=="DEV") {
            $envScript = "scriptsStage";
            $envPrinergy = "prinergyStage";
            $envTwist = "twistStage";
            $envFPdata = "FPdataStage";
            $envStockage = "stockageStage";
            $envFtp = "ftpStage";
            $envFPexa = "FPexaStage";
        }

        // PARAMS PROD
        else {
            $envScript = "scriptsProd";
            $envPrinergy = "prinergyProd";
            $envTwist = "twistProd";
            $envFPdata = "FPdataProd";
            $envStockage = "stockageProd";
            $envFtp = "ftpProd";
            $envFPexa = "FPexaProd";
        }

        //PARAMS SCRIPTS
        $ipXml =  $config->$envScript->xml->ip;
        $pathXml =  $config->$envScript->xml->path;
        $paramsXml = $config->$envScript->xml;

        // PARAMS Prinergy
        $loginPrinergy = $config->$envPrinergy->login;
        $pwdPrinergy = $config->$envPrinergy->pwd;
        $ipPrinergy = $config->$envPrinergy->ip;
        $sharePrinergy = $config->$envPrinergy->share;
        $paramsPrinergy = $config->$envPrinergy;

        // PARAMS Twists
        $loginTwists = $config->$envTwist->login;
        $pwdTwists = $config->$envTwist->pwd;
        $ipTwists = $config->$envTwist->ip;
        $shareTwists = $config->$envTwist->share;
        $paramsTwists = $config->$envTwist;

        // PARAMS FPdata (tete et chef de fab VM)
        $loginFPdata = $config->$envFPdata->login;
        $pwdFPdata = $config->$envFPdata->pwd;
        $ipFPdata = $config->$envFPdata->ip;
        $shareTete = $config->$envFPdata->shareTete;
        $shareMontage = $config->$envFPdata->shareMontage; # Chef_de_fab_v2/
        $pathMontage = $config->$envFPdata->urlMontage; # /Chef_de_fab_v2/MONTAGE
        $paramsFPdata = $config->$envFPdata;

        // PARAMS Stockage
        $loginStockage = $config->$envStockage->login;
        $pwdStockage = $config->$envStockage->pwd;
        $ipStockage = $config->$envStockage->ip;
        $shareStockage = $config->$envStockage->share;
        $shareStockageCmd = $config->$envStockage->linkCmd;
        $shareStockagePlanches = $config->$envStockage->linkPlanches;
        $paramsStockage = $config->$envStockage;

        // PARAMS FTP
        $loginftp = $config->$envFtp->login;
        $pwdftp = $config->$envFtp->pwd;
        $ipftp = $config->$envFtp->ip;
        $shareftpEntree = $config->$envFtp->urlEntreeFTP;
        $shareftpAtelier = $config->$envFtp->urlFTP;
        $paramsFTP = $config->$envFtp;

        // PARAMS FPexa
        $loginFPexa = $config->$envFPexa->login;
        $pwdFPexa = $config->$envFPexa->pwd;
        $ipFPexa = $config->$envFPexa->ip;
        $shareNasFPexa = $config->$envFPexa->share;
        $paramsFPexa = $config->$envFPexa;

        // URL SMB OR AFP
        $path_Prinergy = "smb://$loginPrinergy:$pwdPrinergy@$ipPrinergy/$sharePrinergy/";
        $path_Twist = "smb://$loginTwists:$pwdTwists@$ipTwists/$shareTwists/";
        $path_Tetes_v2 = "afp://$loginFPdata:$pwdFPdata@$ipFPdata/$shareTete/";
        $path_Chef_de_fab_v2 = "afp://$loginFPdata:$pwdFPdata@$ipFPdata/$shareMontage/";
        $path_montage = "afp://$loginFPdata:$pwdFPdata@$ipFPdata/$pathMontage";
        $path_Stockage = "afp://$loginStockage:$pwdStockage@$ipStockage/$shareStockage/";
        $path_StockageCmd = "afp://$loginStockage:$pwdStockage@$ipStockage/$shareStockageCmd";
        $path_StockagePlanches = "afp://$loginStockage:$pwdStockage@$ipStockage/$shareStockagePlanches";
        $path_FtpEntree = "afp://$loginftp:$pwdftp@$ipftp/$shareftpEntree/";
        $path_FtpAtelier = "afp://$loginftp:$pwdftp@$ipftp/$shareftpAtelier/";
        $path_FtpClient = "afp://$loginStockage:$pwdStockage@$ipStockage/Stockage/Prod/FTP/DeposeFichierCommande/";
        $path_NasFPexa = "smb://$loginFPexa:$pwdFPexa@$ipFPexa/$shareNasFPexa/";

        $out['linkTo'] = [
            'prinergy'          => $path_Prinergy,
            'twist'             => $path_Twist,
            'tete_v2'           => $path_Tetes_v2,
            'chef_de_fab_v2'    => $path_Chef_de_fab_v2,
            'montage'           => $path_montage,
            'stockage'          => $path_Stockage,
            'stockageCmd'       => $path_StockageCmd,
            'stockagePlanches'  => $path_StockagePlanches,
            'ftpEntree'         => $path_FtpEntree,
            'ftpAtelier'        => $path_FtpAtelier,
            'ftpClient'         => $path_FtpClient,
            'nasFPexa'          => $path_NasFPexa
        ];

        $out['params'] = [
            'scriptXML' => $paramsXml,
            'prinergy'  => $paramsPrinergy,
            'twist'     => $paramsTwists,
            'fpdata'    => $paramsFPdata,
            'stockage'  => $paramsStockage,
            'ftp'       => $paramsFTP,
            'fpexa'     => $paramsFPexa
        ];

//        echo "<pre>";
//        print_r($out);
//        echo "</pre>";
        return $out;

        /*
         *  // FICHIERS commandes
            $pnNumber = $pnIdCommande;
            $pnNumeroCourt = (ceil($pnNumber / 1000)) * 1000;
            $btnStockage = "<a href='smb://$loginStockage:$pwdStockage@$ipStockage/Stockage/$env/Commandes/$pnNumeroCourt/$pnNumber/'><button class='btn btn-primary' type='button'><span class='glyphicon glyphicon-cloud-download'></span>&nbsp;Stockage</button></a>";
            $btnArchive = "<a href='smb://monteur:exa@192.168.1.215/NasFPexa/archives_controleurs/'><button class='btn btn-primary'><span class='glyphicon glyphicon-folder-open'></span>&nbsp; Archive Controle</button></a>";

            // FICHIERS planches
            $psCodeTeteMonteur = $data_detailsPlanches[0]->CodeTeteMonteur;
            $psCodeAtelierPrincipale = $data_detailsPlanches[0]->CodeAtelierPrincipale;
            $pdDateCrea = date('Y-m-d',strtotime($data_detailsPlanches[0]->DateCrea));
            $pnIdPlanche = $args["dossier"];
            $pnNumeroCourt = (ceil($pnIdPlanche / 1000)) * 1000;
            $filename = "$pathMontage/$psCodeTeteMonteur/$pdDateCrea/$pnIdPlanche/";
            $btnEntreeFTP = "<a href='afp://$loginFTP:$pwdFTP@$ipFTP/$urlEntreeFTP/'><button class='btn btn-primary'><span class='glyphicon glyphicon-transfer'></span>&nbsp;Entrée FTP</button></a>&nbsp;";
            $btnChefDeFab = "<a href='afp://$loginFPdata:$pwdFPdata@$ipFPdata/$urlMontage/$psCodeTeteMonteur/$pdDateCrea/$pnIdPlanche/'><button class='btn btn-primary'><span class='glyphicon glyphicon-home'></span>&nbsp;Montage</button></a>&nbsp;";
            $btnStockage = "<a href='afp://$loginStockage:$pwdStockage@$ipStockage/Stockage/$envStockage/Planches/$pnNumeroCourt/'><button class='btn btn-primary'><span class='glyphicon glyphicon-cloud-download'></span>&nbsp;Stockage</button></a>&nbsp;";
            $btnFTP = "<a href='afp://$loginFTP:$pwdFTP@$ipFTP/$urlFTP/$psCodeAtelierPrincipale/'><button class='btn btn-primary'><span class='glyphicon glyphicon-hdd'></span>&nbsp;FTP Ateliers</button></a>&nbsp;";
         */
    }

    public function getConvertDate($args)
    {
        $pdDate = null;

        if (isset($args)) {
            $date = \DateTime::createFromFormat('d/m/Y', $args);
            if (is_object($date)) $pdDate = $date->format('Y-m-d'); else $pdDate = '';
        }

        return $pdDate;
    }

    private function curlopt($string)
    {
        //-- define option for cURL
        $options = array(
            CURLOPT_URL             => $string,        // url cible
            CURLOPT_RETURNTRANSFER  => true,           // Retourner le contenu téléchargé dans une chaine
            CURLOPT_HEADER          => false,          // Ne pas inclure l'entête de réponse du serveur dans la chaine retournée
            CURLOPT_FAILONERROR     => true,           // Gestion des codes d'erreur HTTP supérieurs ou égaux à 400
            CURLOPT_FOLLOWLOCATION  => true            // Suivre les redirections
        );
        return $options;
    }

    public function cURLexec($url)
    {
        $data = $suite = null;

        //-- options cURL
        $options = $this->curlopt($url);
        $ch = curl_init();
        curl_setopt_array($ch, $options);

        //-- exec cURL to url
        $content = curl_exec($ch);
        if (curl_error($ch)) {
            //-- LOG ERROR & MAIL
            $data .= curl_error($ch) . " " . $content;
        }
        curl_close($ch);

        return $data;
    }

    public function getDossierWithIDDossierDeFab($args)
    {
        $pnIdDossierDeFab = $args['IDDossierDeFab'];
        $data = \fbx\DBmysql::getInstance()->getSelectData("SELECT Dossier FROM TBL_DOSSIER_DE_FAB WHERE IDDossierDeFab = '$pnIdDossierDeFab' AND EstSupp = 0");
        $this->_data = $data[0]->Dossier;
    }
}