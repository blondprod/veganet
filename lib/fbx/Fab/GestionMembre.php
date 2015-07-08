<?php
/**
 *
 * Created by blond.
 * File: GestionMembre.php
 * Date: 28/03/15 - 15:48
 *
 */

namespace fbx\Fab;

class GestionMembre extends Select
{
    const ClassPage = 'GestionMembre';

    public $_template = "Gestion/GestionMembre.twig";

    //__table
    public function getDataTableGestionMembre($args)
    {
        $where = null;

        if ($_SESSION['FBX_USER_SU'] != '1' ) $where .= "AND TM.EstSu != '1'";

        if ($_SESSION['FBX_USER_SU'] == '1' ) {
            if(isset($args['IDSociete']) && $args['IDSociete'] > '0' ) $where .= "AND TM.IDSociete = '{$args['IDSociete']}'";
        }
        else {
            $where .= "AND TM.IDSociete = '{$_SESSION['FBX_USER_SOCIETE_ID']}'";
        }

        $this->_template = "table/tableGestionMembre.twig";

        if ( $args['Prenom'] != "-+null+-" )                                                        $where .= "AND TM.Prenom LIKE '%{$args['Prenom']}%'";
        if ( $args['Nom']    != "-+null+-" )                                                        $where .= "AND TM.Nom LIKE '%{$args['Nom']}%'";
        if ( $args['Login']  != "-+null+-" )                                                        $where .= "AND TM.Login LIKE '%{$args['Login']}%'";
        if ( $args['Email']  != "-+null+-" )                                                        $where .= "AND TM.Mail LIKE '%{$args['Email']}%'";
        if ( $args['Telephone'] != "-+null+-")                                                      $where .= "AND TM.Telephone LIKE '%{$args['Telephone']}%'";
        if ( $args['Langue'] != "-+null+-" )                                                        $where .= "AND TM.IDLangue = '{$args['Langue']}'";
        if ( $args['estActif'] != "-+null+-" )                                                      $where .= "AND TM.EstActif = '{$args['estActif']}'";
        if (isset($args['Groupe']) && is_array($args['Groupe']) && $args['Groupe'][0] != 0 )        $where .= "AND TGTF.IDGroupe IN (".implode(',',$args['Groupe']).")";
        if (isset($args['Fonction']) && is_array($args['Fonction']) && $args['Fonction'][0] != 0 )  $where .= "AND TGTF.IDFonction IN (".implode(',',$args['Fonction']).")";

        $q = "SELECT
    TM.IDMembre,
    TM.Nom,
    TM.Prenom,
    TM.Login,
    TM.Pwd,
    TM.Mail,
    TM.Telephone,
    TM.EstActif,
    TM.IDFonction,
    TM.IDSociete,
    CASE WHEN ISNULL(TFT.Nom) THEN '-' ELSE TFT.Nom END AS NomFonction,
    TL.IDLangue,
    TL.Nom AS NomLangue,
    TS.Nom AS NomSociete
FROM
    TBL_MEMBRE AS TM
    LEFT OUTER JOIN TBL_LANGUE AS TL ON TL.IDLangue = TM.IDLangue AND TL.EstSupp = '0' AND TL.EstActif = '1'
    LEFT OUTER JOIN TBL_SOCIETE AS TS ON TS.IDSociete = TM.IDSociete AND TS.EstSupp = '0' AND TS.EstActif = '1'
    LEFT OUTER JOIN TBL_FONCTION AS TF ON TF.IDFonction = TM.IDFonction AND TF.EstSupp = '0' AND TF.EstActif = '1'
    LEFT OUTER JOIN TBL_GROUPE_TL_FONCTION AS TGTF ON TGTF.IDFonction = TM.IDFonction AND TGTF.EstSupp = '0'
    LEFT OUTER JOIN TBL_FONCTION_TRAD AS TFT ON TFT.IDFonction = TM.IDFonction AND TFT.IDLangue = {$_SESSION['IDLANGUE']}
WHERE
    TM.EstSupp = '0'
    $where
ORDER BY
    TS.Nom,
    TM.Nom,
    TM.Prenom";

        $data_membre = \fbx\DBmysql::getInstance()->getSelectData($q);

        $this->_data = array(
            "data_membre"=>$data_membre
            , "OUT"=>$args
            , "Q"=>$q
        );
    }

    //__insert
    public function getInsertMembre($args)
    {
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if ($_SESSION['FBX_USER_SU'] != '1' ) { $pnIDSociete = $_SESSION['FBX_USER_SOCIETE_ID'];}
        else { if (isset($args['IDSociete']) && $args['IDSociete'] != '')  $pnIDSociete = $args['IDSociete']; else $pnIDSociete = 'null'; }

        if (isset($args['Nom']) && $args['Nom'] != '')                  $psNom = $args['Nom']; else $psNom = 'null';
        if (isset($args['Prenom']) && $args['Prenom'] != '')            $psPrenom = $args['Prenom']; else $psPrenom = 'null';
        if (isset($args['IDFonction']) && $args['IDFonction'] != '')    $pnIDFonction = $args['IDFonction']; else $pnIDFonction = '0';
        if (isset($args['Login']) && $args['Login'] != '')              $psLogin = $args['Login']; else $psLogin = 'null';
        if (isset($args['Pwd']) && $args['Pwd'] != '')                  $psPwd = $args['Pwd']; else $psPwd = 'null';
        if (isset($args['IDLangue']) && $args['IDLangue'] != '')        $pnIDLangue = $args['IDLangue']; else $pnIDLangue = '0';
        if (isset($args['Telephone']) && $args['Telephone'] != '')      $psTelephone = $args['Telephone']; else $psTelephone = 'null';
        if (isset($args['Mail']) && $args['Mail'] != '')                $psMail = $args['Mail']; else $psMail = 'null';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbEstActif = $args['EstActif']; else $pbEstActif = '0';

        if (isset($args['Prenom']) && $args['Prenom'] != ''){
            $q = "INSERT INTO TBL_MEMBRE
    ( DateAdd,IDMembreAdd,Nom,Prenom,IDFonction,Login,Pwd,IDLangue,Telephone,Mail,EstActif,IDSociete )
VALUES
    ( NOW(),'$pnIdUser','$psNom','$psPrenom','$pnIDFonction','$psLogin','$psPwd','$pnIDLangue','$psTelephone','$psMail','$pbEstActif',$pnIDSociete )";

            $data = \fbx\DBmysql::getInstance()->getInsertData($q);
            $this->getWrLog($q, "$data", __FUNCTION__, __FILE__);

            //__CREATE QRcode
            if (isset($data)&&$data>0){
                $filename = "membre-$data";
                $path= $_SESSION['QR']['PATH'];
                $link= $_SESSION['QR']['IMG']."/membre";
                $ref = $_SESSION['QR']['MEMBRE']."?login=$psLogin&password=$psPwd&languages=fr_FR";
                $url = "$path?$filename&$link&$ref";
                $this->cURLexec($url);
//                $this->getWrLog($url, "QRcode membre", __FUNCTION__, __FILE__);

                //__CREATE CODE BARRE
                $path = ($_SESSION['BARCODE']['PATH']);
                $link = ($_SESSION['BARCODE']['IMG'])."/membre";
                $filename = "barcodeMembre-$data";
//                $contenu_barcode = "'$psLogin'$psPwd";
                $contenu_barcode = "()$data()";
                $url = "$path?$contenu_barcode&$filename&$link";
                $this->cURLexec($url);
            }

            $this->_data = $data;
        }
    }

    //__update
    public function getUpdateMembre($args)
    {
        if (isset($args['Nom']) && $args['Nom'] != '')                  $psNom = $args['Nom'];                  else $psNom = 'null';
        if (isset($args['Prenom']) && $args['Prenom'] != '')            $psPrenom = $args['Prenom'];            else $psPrenom = 'null';
        if (isset($args['IDFonction']) && $args['IDFonction'] != '')    $pnIDFonction = $args['IDFonction'];    else $pnIDFonction = '0';
        if (isset($args['Login']) && $args['Login'] != '')              $psLogin = $args['Login'];              else $psLogin = 'null';
        if (isset($args['Pwd']) && $args['Pwd'] != '')                  $psPwd = $args['Pwd'];                  else $psPwd = 'null';
        if (isset($args['IDLangue']) && $args['IDLangue'] != '')        $pnIDLangue = $args['IDLangue'];        else $pnIDLangue = '0';
        if (isset($args['Telephone']) && $args['Telephone'] != '')      $psTelephone = $args['Telephone'];      else $psTelephone = 'null';
        if (isset($args['Mail']) && $args['Mail'] != '')                $psMail = $args['Mail'];                else $psMail = 'null';
        if (isset($args['EstActif']) && $args['EstActif'] != '')        $pbActif = $args['EstActif'];           else $pbActif = '0';
        if (isset($args['IDMembre']) && $args['IDMembre'] != '')        $pnIDMembre = $args['IDMembre'];        else $pnIDMembre = '0';
        if (isset($args['IDSociete']) && $args['IDSociete'] != '')      $pnIDSociete = $args['IDSociete'];      else $pnIDSociete = 'null';
        $pnIdUser = $_SESSION['FBX_USER_ID'];

        if ($pnIDMembre > '0') {
            $q = "UPDATE
    TBL_MEMBRE AS MEMBRE
SET
    MEMBRE.DateMaj = NOW(),
    MEMBRE.IDMembreMaj = '$pnIdUser',
    MEMBRE.Nom = '$psNom',
    MEMBRE.Prenom = '$psPrenom',
    MEMBRE.IDFonction = '$pnIDFonction',
    MEMBRE.Login = '$psLogin',
    MEMBRE.Pwd = '$psPwd',
    MEMBRE.IDLangue = '$pnIDLangue',
    MEMBRE.Telephone = '$psTelephone',
    MEMBRE.Mail = '$psMail',
    MEMBRE.EstActif = '$pbActif',
    MEMBRE.IDSociete = '$pnIDSociete'
WHERE
    MEMBRE.IDMembre = '$pnIDMembre'";

            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
            $this->getWrLog($q, "", __FUNCTION__, __FILE__);

            //__CREATE QRcode
            if (isset($pnIDMembre)&&$pnIDMembre>0){
                $filename = "membre-$pnIDMembre";
                $path= $_SESSION['QR']['PATH'];
                $link= $_SESSION['QR']['IMG']."/membre";
                $ref = $_SESSION['QR']['MEMBRE']."?login=$psLogin&password=$psPwd&languages=fr_FR";
                $url = "$path?$filename&$link&$ref";
                $this->cURLexec($url);
//                $this->getWrLog($url, "UP QRcode membre", __FUNCTION__, __FILE__);
            }

            //__CREATE CODE BARRE
            $path = ($_SESSION['BARCODE']['PATH']);
            $link = ($_SESSION['BARCODE']['IMG'])."/membre";
            $filename = "barcodeMembre-$pnIDMembre";
//            $contenu_barcode = "'$psLogin'$psPwd";
            $contenu_barcode = "()$pnIDMembre()";
            $url = "$path?$contenu_barcode&$filename&$link";
            $this->cURLexec($url);
//            $this->getWrLog("UP CodeBarre membre", "$url", __FUNCTION__, __FILE__);

            $this->_data = $data;
        }
    }

    //__ update txt accueil
    public function getUpAccueilTxt($args)
    {
        if(isset($args['IDMembre']))
        {
            foreach($args["IDMembre"] AS $key => $value)
            {
                $chemin_destination = $this->path($value);
                if(file_exists($chemin_destination)==0) mkdir($chemin_destination, 0777);
                for($i = 1; $i <= 4; $i++)
                {
                    if(isset($args["text".$i]) && $args["text".$i] != "")
                    {
                        $fichier = "{$chemin_destination}text{$i}.txt";

                        if(file_exists($fichier)==1)
                        {
                            $oldPath = date('YmdHis');
                            rename($fichier , $chemin_destination.$oldPath."-text{$i}.txt");
                        }
                        // ouverture du fichier text
                        $txtfile = fopen($fichier,'a+');
                        // ecriture du fichier text
                        fputs($txtfile , $args["text".$i]);
                        // fermeture du fichier text
                        fclose($txtfile);
                    }
                }
            }
        }
        $this->_data = array("OUT"=>$args);
        $this->getWrLog("up txt welcome","EXE",__FUNCTION__,__FILE__);
        echo '<script type="text/javascript">$(function(){collapse("'.$args['div'].'");})</script>';
    }

    //__ update img accueil
    public function getUpAccueilImg($args){

//        $this->printr($_FILES);
//        $this->printr($args);
        $idUser = $_SESSION['FBX_USER_ID'];

        if(isset($args['IDMembre2']))
        {
            foreach($args["IDMembre2"] AS $key => $value)
            {
                $chemin_destination = $this->path($value);

                if(file_exists($chemin_destination)==0) mkdir($chemin_destination, 0777);

                for($i = 1; $i <= 4; $i++)
                {
                    if(isset($_FILES['image'.$i]['tmp_name']) && $_FILES['image'.$i]['tmp_name']!='')
                    {
                        move_uploaded_file($_FILES['image'.$i]['tmp_name'], $this->path("tmp")."{$idUser}-image{$i}.png");

                        if(file_exists("{$chemin_destination}image{$i}.png")==1)
                        {
                            $oldPath = date('YmdHis');
                            rename("{$chemin_destination}image{$i}.png", $chemin_destination.$oldPath."-image{$i}.png");
                        }

                        if(file_exists($this->path("tmp")."{$idUser}-image{$i}.png")==1)
                        {
                            if(!copy ( $this->path("tmp")."{$idUser}-image{$i}.png" , "{$chemin_destination}image{$i}.png"))
                            {
                                $this->getWrLog("up img welcome","ERR",__FUNCTION__,__FILE__);
                                echo $alert = '<script type="text/javascript">
                                    $(function(){
                                        getModalAlert("echecDuTransfert","'.$_FILES.'");
                                    })
                               </script>';
                            }
                        }
                    }
                }
            }

            for($i = 1; $i <= 4; $i++)
            {
                if(file_exists($this->path("tmp")."{$idUser}-image{$i}.png")==1)
                {
                    unlink($this->path("tmp")."{$idUser}-image{$i}.png");
                }
            }
        }
        $this->_data = $_SESSION;
        $this->getWrLog("up img welcome","EXE",__FUNCTION__,__FILE__);
        echo '<script type="text/javascript">$(function(){collapse("'.$args['div'].'");})</script>';
    }

    //__ define path
    private function path($id) {
        return "img/carousel/{$id}/";
    }
}