<?php
/**
 *
 * Created by blond.
 * File: Auth.php
 * Date: 24/03/15 - 10:53
 *
 */

namespace fbx\Fab;

class Auth
{
    private $_template = "login.twig";

    public function login($username, $password)
    {
        $q = "SELECT
  M.IDMembre AS IDMembre
FROM
  TBL_MEMBRE AS M
WHERE
  M.EstSupp = '0'
  AND M.EstActif = '1'
  AND M.Login LIKE '%$username%'
  AND M.Pwd = '$password'";

        $data = \fbx\DBmysql::getInstance()->getSelectData($q);

        if(isset($data[0]->IDMembre) && $data[0]->IDMembre>0) {
            $_SESSION['FBX_USER'] = $username;
            $out = 'True';
        }
        else {
            $out = "False";
            #echo '<script type="text/javascript">$(function(){getModalAlert("Identifiant ou mot de passe erroné");})</script>';
        }

        return $out;
    }

    public function logout()
    {
        setcookie("FBX_SESSID","",time()+1);
        unset($_SESSION['FBX_USER']);
        unset($_SESSION['FBX_USER_PRENOM']);
        unset($_SESSION['FBX_USER_NOM']);
        unset($_SESSION['FBX_USER_ID']);
        unset($_SESSION['FBX_USER_GROUPE_ID']);
        unset($_SESSION['FBX_USER_FONCTION_ID']);
        unset($_SESSION['FBX_USER_SOCIETE_ID']);
        unset($_SESSION['FBX_USER_TYPE_NAT']);
        unset($_SESSION['FBX_USER_SU']);
        unset($_SESSION['FBX_SERVER_TYPE']);
        unset($_SESSION['IDLANGUE']);
        unset($_SESSION['QR']);
        unset($_SESSION['BARCODE']);
//        unset($_SESSION['IP']);
//        unset($_SESSION['PUBLIC_PATH']);
        session_destroy();
    }

    public function isUserLoggedIn()
    {
        return isset($_SESSION['FBX_USER']);
    }

    public function getUsername()
    {
        if ($this->isUserLoggedIn()) {
            return $_SESSION['FBX_USER'];
        }
        return null;
    }

    public function getTemplate(){

        return (string)$this->_template;
    }

    public function SendForgottenPassword($args){
//        \fbx\WS::init(\fbx\Config::getInstance()->getWSDL(),\fbx\ExaConfig::getInstance()->getToken());
//        $result = \fbx\WS::getInstance()->WS_bMotDePasseOublie(array(
//            "sLogin" => $args['login']
//        ));
//
//        //return ($result->WS_bMotDePasseOublie == 1);
//        return ($result->WS_bMotDePasseOublieResult == 1);
        return 1;
    }
}
