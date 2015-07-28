<?php
/**
 *
 * Created by blond.
 * File: class.csv.php
 * Date: 27/07/15 - 20:41
 * Proj: veganet
 *
 */

class csv {

    private $_pnIdUser = '17';
    private $_nbMachine = '2';

    public function getVerifDossierExist($psDossier)
    {
        $data = null;

        $pdo = $this->getPDO();

        try {
            $query = $pdo->prepare("SELECT IDDossierDeFab FROM TBL_DOSSIER_DE_FAB WHERE Dossier = $psDossier AND EstSupp = '0'");
            $query->execute();
        }

        catch (\PDOException $e) {
            var_dump($e->getMessage());
            echo "l'erreur " . $e->getMessage() . "<br />";
            echo "le numero de l'erreur est " . $e->getCode() . "<br />";
            echo "l'erreur est à la ligne " . $e->getLine() . "<br />";
            echo "l'erreur est à la ligne " . $e->getTrace() . "<br />";
            die;
        }
        $i = 0;
        while ($row = $query->fetchObject()) {
            $data[$i] = $row;
            $i++;
        }
        unset($query);
        unset($pdo);
        return $data;
    }

    public function getVerifOptionExist($data_csv,$pnIDSociete)
    {
        $resu = null;

        $pdo = $this->getPDO();

        for($i=1; $i <= $data_csv[0]; $i++){

            $psOption = $data_csv[$i];
            if ($psOption != "null"){
                $query = $pdo->prepare("
    SELECT
        T2.IDOption AS IDOption
    FROM
        TBL_OPTION_TRAD AS T1
        LEFT OUTER JOIN TBL_OPTION AS T2 ON T1.IDOption = T2.IDOption
    WHERE
        T1.Nom = '$psOption'
        AND T2.IDSociete = '$pnIDSociete'
        AND T2.EstSupp = 0");

                $query->execute();

                $out = $query->fetchObject();

                if(!isset($out->IDOption)) {

                    $q = "INSERT INTO TBL_OPTION ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'".$this->_pnIdUser."','1','99','$pnIDSociete' )";
                    try {
                        $pdo->exec($q);
                        $pnIdOption = $pdo->lastInsertId();
                        $resu[] = $pnIdOption;
                        $this->getWrtLogFile($q,$pnIdOption,__FUNCTION__,__FILE__);
                    }
                    catch (\PDOException $e) { echo $e->getMessage(); }
                    unset($q);

                    if (isset($pnIdOption) && $pnIdOption > '0'){
                        $q = "INSERT INTO TBL_OPTION_TRAD ( IDOption,Nom,IDLangue ) VALUES ( $pnIdOption,'$psOption','1' )";
                        try {
                            $pdo->exec($q);
                            $pnIdOptionTrad = $pdo->lastInsertId();
                            $this->getWrtLogFile($q,$pnIdOptionTrad,__FUNCTION__,__FILE__);
                            echo "<pre style='color: #000FFF;'><h1>Option $psOption ajoutée</h1></pre>";
                        }
                        catch (\PDOException $e) { echo $e->getMessage(); }
                        unset($q);
                    }
                }
                else {
                    $resu[] = $out->IDOption;
                }
                unset($query);
            }
        }
        unset($pdo);

        return $resu;
    }

    public function getVerifElementExist($data_csv,$pnIDSociete)
    {
        $resu = null;

        $pdo = $this->getPDO();

//        for($i=1; $i <= $data_csv[0]; $i++){

            $psElement = $data_csv[0];
            if ($psElement != "null"){
                $query = $pdo->prepare("
    SELECT
        T2.IDElement AS IDElement
    FROM
        TBL_ELEMENT_TRAD AS T1
        LEFT OUTER JOIN TBL_ELEMENT AS T2 ON T1.IDElement = T2.IDElement
    WHERE
        T1.Nom = '$psElement'
        AND T2.IDSociete = '$pnIDSociete'
        AND T2.EstSupp = 0");

                $query->execute();

                $out = $query->fetchObject();

                if(!isset($out->IDElement)) {

                    $q = "INSERT INTO TBL_ELEMENT ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'".$this->_pnIdUser."','1','99','$pnIDSociete' )";
                    try {
                        $pdo->exec($q);
                        $pnIdElement = $pdo->lastInsertId();
                        $resu = $pnIdElement;
                        $this->getWrtLogFile($q,$pnIdElement,__FUNCTION__,__FILE__);
                    }
                    catch (\PDOException $e) { echo $e->getMessage(); }
                    unset($q);

                    if (isset($pnIdElement) && $pnIdElement > '0'){
                        $q = "INSERT INTO TBL_ELEMENT_TRAD ( IDElement,Nom,IDLangue ) VALUES ( $pnIdElement,'$psElement','1' )";
                        try {
                            $pdo->exec($q);
                            $pnIdElementTrad = $pdo->lastInsertId();
                            $this->getWrtLogFile($q,$pnIdElementTrad,__FUNCTION__,__FILE__);
                            echo "<pre style='color: #000FFF;'><h1>Element $psElement ajoutée</h1></pre>";
                        }
                        catch (\PDOException $e) { echo $e->getMessage(); }
                        unset($q);
                    }
                }
                else {
                    $resu = $out->IDElement;
                }
                unset($query);
            }
//        }
        unset($pdo);

        return $resu;
    }

    public function getVerifPapierExist($data_csv,$pnIDSociete)
    {
        $resu = null;

        $pdo = $this->getPDO();

//        for($i=1; $i <= $data_csv[2]; $i++){

            $psPapier = $data_csv[2];
            if ($psPapier != "null"){
                $query = $pdo->prepare("
    SELECT
        T1.IDSupport AS IDPapier
    FROM
        TBL_SUPPORT_TRAD AS T1
        LEFT OUTER JOIN TBL_SUPPORT AS T2 ON T1.IDSupport = T2.IDSupport
    WHERE
        T1.Nom = '$psPapier'
        AND T2.IDSociete = '$pnIDSociete'
        AND T2.EstSupp = 0");

                $query->execute();

                $out = $query->fetchObject();

                if(!isset($out->IDPapier)) {

                    $q = "INSERT INTO TBL_SUPPORT ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'".$this->_pnIdUser."','1','99','$pnIDSociete' )";
                    try {
                        $pdo->exec($q);
                        $pnIdPapier = $pdo->lastInsertId();
                        $resu = $pnIdPapier;
                        $this->getWrtLogFile($q,$pnIdPapier,__FUNCTION__,__FILE__);
                    }
                    catch (\PDOException $e) { echo $e->getMessage(); }
                    unset($q);

                    if (isset($pnIdPapier) && $pnIdPapier > '0'){
                        $q = "INSERT INTO TBL_SUPPORT_TRAD ( IDSupport,Nom,IDLangue ) VALUES ( $pnIdPapier,'$psPapier','1' )";
                        try {
                            $pdo->exec($q);
                            $pnIdPapierTrad = $pdo->lastInsertId();
                            $this->getWrtLogFile($q,$pnIdPapierTrad,__FUNCTION__,__FILE__);
                            echo "<pre style='color: #000FFF;'><h1>Papier $psPapier ajoutée</h1></pre>";
                        }
                        catch (\PDOException $e) { echo $e->getMessage(); }
                        unset($q);
                    }
                }
                else {
                    $resu = $out->IDPapier;
                }
                unset($query);
            }
//        }
        unset($pdo);

        return $resu;
    }

    public function getVerifFormatExist($data_csv,$pnIDSociete)
    {
        $resu = null;

        $pdo = $this->getPDO();

//        for($i=1; $i <= $data_csv[3]; $i++){

            $psFormat = $data_csv[3];
            if ($psFormat != "null"){
                $query = $pdo->prepare("
    SELECT
        T1.IDFormat AS IDFormat
    FROM
        TBL_FORMAT_TRAD AS T1
        LEFT OUTER JOIN TBL_FORMAT AS T2 ON T1.IDFormat = T2.IDFormat
    WHERE
        T1.Nom = '$psFormat'
        AND T2.IDSociete = '$pnIDSociete'
        AND T2.EstSupp = 0");

                $query->execute();

                $out = $query->fetchObject();

                if(!isset($out->IDFormat)) {

                    $q = "INSERT INTO TBL_FORMAT ( DateAdd, IDMembreAdd, EstActif, Ordre, IDSociete  ) VALUES ( NOW(),'".$this->_pnIdUser."','1','99','$pnIDSociete' )";
                    try {
                        $pdo->exec($q);
                        $pnIdFormat = $pdo->lastInsertId();
                        $resu = $pnIdFormat;
                        $this->getWrtLogFile($q,$pnIdFormat,__FUNCTION__,__FILE__);
                    }
                    catch (\PDOException $e) { echo $e->getMessage(); }
                    unset($q);

                    if (isset($pnIdFormat) && $pnIdFormat > '0'){
                        $q = "INSERT INTO TBL_FORMAT_TRAD ( IDFormat,Nom,IDLangue ) VALUES ( $pnIdFormat,'$psFormat','1' )";
                        try {
                            $pdo->exec($q);
                            $pnIdFormatTrad = $pdo->lastInsertId();
                            $this->getWrtLogFile($q,$pnIdFormatTrad,__FUNCTION__,__FILE__);
                            echo "<pre style='color: #000FFF;'><h1>Format $psFormat ajoutée</h1></pre>";
                        }
                        catch (\PDOException $e) { echo $e->getMessage(); }
                        unset($q);
                    }
                }
                else {
                    $resu = $out->IDFormat;
                }
                unset($query);
            }
//        }
        unset($pdo);

        return $resu;
    }

    public function getInsertDossier($data_csv)
    {
        $pnIdDossierDeFab = $pnIdDossierDeFabTlElement = $insert_option = null;

        if ( isset($data_csv[1][0]) && $data_csv[1][0] != '' ) $psDossier = "'".$data_csv[1][0]."'";            else $psDossier = 'null';
        if ( isset($data_csv[1][1]) && $data_csv[1][1] != '' ) $psRef = "'".$data_csv[1][1]."'";                else $psRef = 'null';
        if ( isset($data_csv[1][2]) && $data_csv[1][2] != '' ) $psCommentaire = "'".$data_csv[1][2]."'";        else $psCommentaire = 'null';
        if ( isset($data_csv[1][3]) && $data_csv[1][3] != '' ) $pnQuantite = "'".$data_csv[1][3]."'";           else $pnQuantite = 'null';
        if ( isset($data_csv[1][4]) && $data_csv[1][4] != '' ) $pnNbElement = "'".$data_csv[1][4]."'";          else $pnNbElement = 'null';
        if ( isset($data_csv[1][5]) && $data_csv[1][5] != '' ) $pdDateExpedition = "'".$data_csv[1][5]."'";     else $pdDateExpedition = 'null';
        if ( isset($data_csv[1][6]) && $data_csv[1][6] != '' ) $pbEstPliable = "'".$data_csv[1][6]."'";         else $pbEstPliable = '0';
        if ( isset($data_csv[1][7]) && $data_csv[1][7] != '' ) $pbEstAmalgame = "'".$data_csv[1][7]."'";        else $pbEstAmalgame = '0';
        if ( isset($data_csv[1][8]) && $data_csv[1][8] != '' ) $pnLargeurOuvert = "'".$data_csv[1][8]."'";      else $pnLargeurOuvert = 'null';
        if ( isset($data_csv[1][9]) && $data_csv[1][9] != '' ) $pnLargeurFerme = "'".$data_csv[1][9]."'";       else $pnLargeurFerme = 'null';
        if ( isset($data_csv[1][10]) && $data_csv[1][10]!= '') $pnHauteurOuvert = "'".$data_csv[1][10]."'";     else $pnHauteurOuvert = 'null';
        if ( isset($data_csv[1][11]) && $data_csv[1][11]!= '') $pnHauteurFerme = "'".$data_csv[1][11]."'";      else $pnHauteurFerme = 'null';
        if ( isset($data_csv[1][12]) && $data_csv[1][12]!= '') $pnNbPose = "'".$data_csv[1][12]."'";            else $pnNbPose = 'null';
        if ( isset($data_csv[2][0]) && $data_csv[2][0]!= '')   $pnNbOption = "'".$data_csv[2][0]."'";           else $pnNbOption = '0';

        $pdo = $this->getPDO();

        //__ INSERT DOSSIER DE FAB
        $ins_dossier = "INSERT INTO TBL_DOSSIER_DE_FAB
    (IDMembreAdd, DateAdd, Dossier, Ref, Commentaire, Quantite, NbElement, DateExpedition, EstPliable, EstAmalgame, LargeurOuvert, LargeurFerme, HauteurOuvert, HauteurFerme, NbPose, NbOption, NbMachine)
VALUES
('".$this->_pnIdUser."',NOW(),$psDossier,$psRef,$psCommentaire,$pnQuantite,$pnNbElement,$pdDateExpedition,$pbEstPliable,$pbEstAmalgame,$pnLargeurOuvert,$pnLargeurFerme,$pnHauteurOuvert,$pnHauteurFerme,$pnNbPose,$pnNbOption,'".$this->_nbMachine."')";

        try {
            $pdo->exec($ins_dossier);
            $pnIdDossierDeFab = $pdo->lastInsertId();
            $this->getWrtLogFile($ins_dossier,$pnIdDossierDeFab,__FUNCTION__,__FILE__);
        }

        catch (\PDOException $e) { echo $e->getMessage(); }

        unset($ins_dossier);

        unset($pdo);

        return $pnIdDossierDeFab;
    }

    public function getInsertDossierTlOption($pnIdDossierDeFab,$array_IDOption)
    {
        $pnIdDossierDeFabTlOption = $insert_option = null;

        $pdo = $this->getPDO();

        for ($i = 0; $i <= count($array_IDOption); $i++) {
            if (isset($array_IDOption[$i]) && $array_IDOption[$i] > '0') {
                $insert_option[] = "('$pnIdDossierDeFab','" . intval($array_IDOption[$i]) . "','".$this->_pnIdUser."',NOW())";
            }
        }

        if (count($insert_option) >= 1) {
            $ins_dossierTlOption = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_OPTION
    (IDDossierDeFab, IDOption, IDMembreAdd, DateAdd)
VALUES
    " . implode(',', $insert_option) . "";

            try {
                $pdo->exec($ins_dossierTlOption);
                $pnIdDossierDeFabTlOption = $pdo->lastInsertId();
                $this->getWrtLogFile($ins_dossierTlOption,$pnIdDossierDeFabTlOption,__FUNCTION__,__FILE__);
            }

            catch (\PDOException $e) { echo $e->getMessage(); }

            unset($ins_dossierTlOption);
        }
        return $pnIdDossierDeFabTlOption;
    }

    public function getInsertDossierTlElement($data_csv,$pnIdDossierDeFab)
    {
        //__ INSERT DOSSIER DE FAB TL ELEMENT
        $pnIdDossierDeFabTlElement = $pnIDElement = $pnIDSupport = $pnIDFormat = null;

        if (isset($data_csv[3]) && $data_csv[3][0] > '0' ) {
            $pnIDElement = $this->getVerifElementExist($data_csv[3],$data_csv[0][0]);
            $pnIDSupport = $this->getVerifPapierExist($data_csv[3],$data_csv[0][0]);
            $pnIDFormat = $this->getVerifFormatExist($data_csv[3],$data_csv[0][0]);
        }

        if (isset($pnIdDossierDeFab) && $pnIdDossierDeFab > '0'){

            $pdo = $this->getPDO();

            if ( isset($data_csv[3][1]) && $data_csv[3][1] != '' ) $pnQuantite = "'".$data_csv[3][1]."'"; else $pnQuantite = 'null';
            if ( isset($data_csv[3][4]) && $data_csv[3][4] != '' ) $psCommentaire = "'".$data_csv[3][4]."'"; else $psCommentaire = 'null';

            $ins_dossierTlElement = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT
    (IDMembreAdd, DateAdd, IDDossierDeFab, Quantite, IDElement, IDSupport, IDFormat, Commentaire)
VALUES
    ('".$this->_pnIdUser."',NOW(),'$pnIdDossierDeFab',$pnQuantite,$pnIDElement,$pnIDSupport,$pnIDFormat,$psCommentaire);";

            try {
                $pdo->exec($ins_dossierTlElement);
                $pnIdDossierDeFabTlElement = $pdo->lastInsertId();
                $this->getWrtLogFile($ins_dossierTlElement,$pnIdDossierDeFabTlElement,__FUNCTION__,__FILE__);
            }

            catch (\PDOException $e) { echo $e->getMessage(); }

            unset($ins_dossierTlElement);
        }

        unset($pdo);

        return $pnIdDossierDeFabTlElement;
    }

    public function getInsertDossierTlElementTlOption($pnIdDossierDeFabTlElement,$array_IDOption)
    {
        $pnIdDossierDeFabTlElementTlOption = $jnsert_element_TL_option = null;

        $pdo = $this->getPDO();

        //__ QUERY ELEMENT_TL_OPTION
        for ($i = 0; $i <= count($array_IDOption); $i++) {
            if (isset($pnIdDossierDeFabTlElement) && $pnIdDossierDeFabTlElement > '0') {
                if (isset($array_IDOption[$i]) && $array_IDOption[$i] > '0') {
                    $jnsert_element_TL_option[] = "('".$this->_pnIdUser."',NOW(),'$pnIdDossierDeFabTlElement','".$array_IDOption[$i]."')";
                }
            }
        }

        //__ INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
        if (count($jnsert_element_TL_option) >= 1) {
            $ins_dossierTlElementTlOption = "INSERT INTO TBL_DOSSIER_DE_FAB_TL_ELEMENT_TL_OPTION
    (IDMembreAdd, DateAdd, IDDossierDeFab_tl_element, IDOption)
VALUES
    " . implode(',', $jnsert_element_TL_option) . "";

            try {
                $pdo->exec($ins_dossierTlElementTlOption);

                $pnIdDossierDeFabTlElementTlOption = $pdo->lastInsertId();

                $this->getWrtLogFile($ins_dossierTlElementTlOption,$pnIdDossierDeFabTlElementTlOption,__FUNCTION__,__FILE__);
            }

            catch (\PDOException $e) { echo $e->getMessage(); }

            unset($ins_dossierTlOption);
        }
        return $pnIdDossierDeFabTlElementTlOption;
    }

    public function getPath()
    {
        return dirname(__FILE__)."/file";
    }

    public function getPrint($obj)
    {
        echo "<pre>";
        print_r($obj);
        echo "</pre>";
    }

    public function getDataFromCSV($fichier)
    {
        $data_csv = null;

        $path = $this->getPath();

//        chown("$path/$fichier","_www");
//        chmod("$path/$fichier",0777);
        $contentFile = fopen($path."/".$fichier, "r");

        $inn = 0;

        while($cell = fgetcsv($contentFile,1024,';')) {
            $nbChamps = count($cell);
            for ($i = 0; $i < $nbChamps; $i++) { $data_csv[$inn][] = $cell[$i]; }
            $inn++;
        }

        return $data_csv;
    }

    public function getFileForRead()
    {
        $path = $this->getPath();

        $dir = opendir($path);

        while ($files = readdir($dir)) { $element[] = $files; }

        closedir($dir);

        sort($element);

        return $element;
    }

    public function getQRandBarCodeDossierDeFab($pnIdDossierDeFab,$psDossier)
    {
        $config = $this->getConfig();

        //__CREATE QRcode
        $path = $config->path->qrcode;
        $link = $config->img->qrcode . "/dossier";
        $ref = $config->qr->dossier . "?action=getDataDossierDeFabForFiche&IDDossierDeFab=$pnIdDossierDeFab";
        $url = "$path?dossier-$pnIdDossierDeFab&$link&$ref";
        $this->cURLexec($url);
        $this->getWrtLogFile("QRcode Dossier", "$url", __FUNCTION__, __FILE__);

        //__CREATE CODE BARRE
        $path = ($config->path->barcode);
        $link = ($config->img->barcode) . "/dossier";
        $contenu_barcode = "%%" . $psDossier;
        $url = "$path?$contenu_barcode&dossier-$pnIdDossierDeFab&$link";
        $this->cURLexec($url);
        $this->getWrtLogFile("CodeBarre Dossier", "$url", __FUNCTION__, __FILE__);
    }

    public function getBarCodeDossierDeFabTlElement($pnIdDossierDeFab,$pnIdDossierDeFabTlElement)
    {
        $config = $this->getConfig();
        $path = ($config->path->barcode);
        $link = ($config->img->barcode)."/dossier";
        $contenu_barcode = "(($pnIdDossierDeFab(($pnIdDossierDeFabTlElement";
        $url = "$path?$contenu_barcode&dossiertlement-$pnIdDossierDeFabTlElement&$link";
        $this->cURLexec($url);
    }

    public function getDeleteFile($fichier)
    {
        $path = $this->getPath();
        unlink($path."/".$fichier);
    }

    private function getPDO()
    {
        $config = $this->getConfig();
        $pdo = new \PDO('mysql:host=' . $config->dev->host . ';port=' . $config->dev->port . ';dbname=' . $config->dev->dbname . '', '' . $config->dev->username . '', '' . $config->dev->password . '');
        return $pdo;
    }

    private function getConfig()
    {
        return simplexml_load_file("../../../lib/config.ini");
    }

    private function getWrtLogFile($q,$data,$function,$file)
    {
        date_default_timezone_set('Europe/Paris');

        $args = basename($file) . " | " . $function . "\n$q \n$data";

        if (isset($args) && $args != "") $message = "| " . $args;
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

    private function cURLexec($url)
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
}