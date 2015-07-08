<?php
/**
 *
 * Created by blond.
 * File: GestionDroit.php
 * Date: 24/03/15 - 22:38
 *
 */

namespace fbx\Fab;


class Profil extends Select
{
    const ClassPage = 'Profil';

    public $_template = "Profil.twig";

    public function getUpdatePwd($args)
    {
        $setClause = null;

        if(isset($args['Prenom']) && $args['Prenom'] != "") {
            $psPrenom = ($args['Prenom']);
            $setClause .= "MEMBRE.Prenom = '$psPrenom',";
        }
        if(isset($args['Nom']) && $args['Nom'] != "") {
            $psNom = ($args['Nom']);
            $setClause .= "MEMBRE.Nom = '$psNom',";
        }
        if(isset($args['Telephone']) && $args['Telephone'] != "") {
            $psTelephone = ($args['Telephone']);
            $setClause .= "MEMBRE.Telephone = '$psTelephone',";
        }
        if(isset($args['Email']) && $args['Email'] != "") {
            $psEmail = ($args['Email']);
            $setClause .= "MEMBRE.Mail = '$psEmail',";
        }
        if(isset($args['Login']) && $args['Login'] != "") {
            $psLogin = ($args['Login']);
            $setClause .= "MEMBRE.Login = '$psLogin',";
        }
        if(isset($args['Pwd']) && $args['Pwd'] != "") {
            $psPwd = ($args['Pwd']);
            $setClause .= "MEMBRE.Pwd = '$psPwd',";
        }
        if($setClause != "") {
            $q = "UPDATE
    TBL_MEMBRE AS MEMBRE
SET
    MEMBRE.DateMaj = NOW(),
    $setClause
    MEMBRE.IDMembreMaj = '{$_SESSION['FBX_USER_ID']}'
WHERE
    MEMBRE.IDMembre = '{$_SESSION['FBX_USER_ID']}'";
            $data = \fbx\DBmysql::getInstance()->getUpdateData($q);
            $this->getWrLog("$q","",__FUNCTION__,__FILE__);
            if($data>'0') $this->_data = array("save"=>"ok");
        }

        if(isset($args['IDLangue']) && $args['IDLangue'] > 0){
            $pnIdLangue = intval($args['IDLangue']);
            $q = "SELECT L.CodeBCP AS CodeBCP , L.IDLangue FROM TBL_LANGUE AS L WHERE L.EstSupp = '0' AND L.IDLangue = '$pnIdLangue'";
            $data = \fbx\DBmysql::getInstance()->getSelectData($q);
            $this->getWrLog("$q","",__FUNCTION__,__FILE__);
            if(isset($data[0])) {
                unset($_SESSION['IDLANGUE']);
                $_SESSION['IDLANGUE'] = $data[0]->IDLangue;
                unset($_SESSION['languages']);
                $_SESSION['languages'] = $data[0]->CodeBCP;
                $this->_data = array("IdLangue"=>$data[0]->IDLangue);
//                $this->printr($_SESSION);
            }
        }
    }
}