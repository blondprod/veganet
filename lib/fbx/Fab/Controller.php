<?php
/**
 *
 * Created by blond.
 * File: Controller.php
 * Date: 24/03/15 - 10:53
 *
 */

namespace fbx\Fab;

class Controller
{

    private $_controller;
    private $_template;
    private $_navbar;
    private $_action;
    private $_args;
    private $_data;
    private $_class;

    private $_key = "bcb04b7e103a0cd8b54763051cef08bc55abe029fdebae5e1d417e2ffb2a00a3";
    private $_cipher = MCRYPT_RIJNDAEL_128;
    private $_mode = MCRYPT_MODE_CBC;


    private function path($id) {
        return "img/carousel/{$id}/";
    }

    private function ivSize(){
        return mcrypt_get_iv_size($this->_cipher, $this->_mode);
    }

    private function packkey(){
        return pack('H*', $this->_key);
    }

    private function hashPassword($string){

        $key = $this->packkey();

        $iv_size = $this->ivSize();

        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);

        $ciphertext = mcrypt_encrypt($this->_cipher, $key, $string, $this->_mode, $iv);

        $ciphertext = $iv . $ciphertext;

        return base64_encode($ciphertext);
    }

    private function dehashPassword($string){

        $key = $this->packkey();

        $iv_size = $this->ivSize();

        $ciphertext_dec = base64_decode($string);

        $iv_dec = substr($ciphertext_dec, 0, $iv_size);

        $ciphertext_dec = substr($ciphertext_dec, $iv_size);

        return mcrypt_decrypt($this->_cipher, $key, $ciphertext_dec, $this->_mode, $iv_dec);
    }

    public function __construct($class_controller,$args_array = null){

        $this->_class = $class_controller;
        $this->_template = "welcome.twig";

        \fbx\Config::init();

        $auth = new Auth();
        $usr = $pwd = $lng = $loginText = $loginPwd = $loginLng = null;

        if (isset($_POST["login"]))            $loginTxt = $_POST["login"];
        else {if (isset($_GET["login"]))       $loginTxt = $_GET["login"];}

        if (isset($_POST["password"]))        $loginPwd = $_POST["password"];
        else {if (isset($_GET["password"]))   $loginPwd = $_GET["password"];}

        if (isset($_POST["languages"]))             $loginLng = $_POST["languages"];
        else {if (isset($_GET["languages"]))        $loginLng = $_GET["languages"];}

        //--- si cookie existe alors on recup value cookie et on le dehash sinon on recup value post
        if(isset($_COOKIE['FBX_SESSID'])){
            $FBX_SESSID = explode("-+-+-", $_COOKIE['FBX_SESSID']);
            $usr = $FBX_SESSID[0];
            $pwd = $FBX_SESSID[1];
            $pwd = $this->dehashPassword($pwd);
            $lng = $_SESSION['languages'] = $loginLng = $FBX_SESSID[2];
            $_SESSION['IDLANGUE'] = $FBX_SESSID[3];
        } elseif(isset($loginTxt)){
            $usr = $loginTxt;
            $pwd = $loginPwd;
            $lng = $loginLng;
        }

        if(isset($usr) && $usr!=""){
            $auth->login($usr,$pwd);
        }

        if($auth->isUserLoggedIn()){

            \fbx\DBmysql::init();

            //-- identification de l'utilisateur
            if(!Utilisateur::isIdentified()) Utilisateur::init();

            //-- si la coche est "on" alors on instruit cookie valable 5j = 5*24*3600 et on hash le mdp
            $pwd = $this->hashPassword($pwd);
            if(isset($_POST['remember'])) setcookie("FBX_SESSID","{$usr}-+-+-{$pwd}-+-+-{$lng}-+-+-{$_SESSION['IDLANGUE']}",time()+5*24*60*60*1);

            //-- recuperation du text pour le welcome message
            $chemin_destination = $this->path($_SESSION['FBX_USER_ID']);
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

            $this->_data = array("session"=>$_SESSION,"OUT"=>$_SESSION);

            $class_controller = __NAMESPACE__."\\".$class_controller;

            if(class_exists($class_controller)){
                $this->_controller = new $class_controller();
                $this->setAction();
                $methodVariable = array($this->_controller, $this->_action);

                if(is_callable($methodVariable,false,$callback_name)){

                    $this->_controller->{$this->_action}(array_merge($args_array,$_SESSION));
                    $this->_template = $this->_controller->getTemplate();

                    $methodVariable = array($this->_controller, "getData");
                    if(is_callable($methodVariable,false,$callback_name)){
                        $this->_data = $this->_controller->getData();
                    }

                }
            }

            if($auth->isUserLoggedIn()) $this->_navbar = "navbar.twig";
        }
        else{
            $this->_template = "login.twig";

            //-- Envoi du mot de passe si le mot de passe n'a pas déjà été envoyé dans les 5mn précédentes
            if(!isset($_SESSION["MdpEnvoye"])) $send_pwd = 1;
            else{
                if($_SESSION["MdpEnvoye"]<time()-300) $send_pwd = 1;
                else $send_pwd = 0;
            }

            if(isset($_POST['login'])){
                if($send_pwd==1){
                    $this->_data = array("MdpOublie"=>$auth->SendForgottenPassword($args_array));
                    if($this->_data["MdpOublie"]=="1") $_SESSION["MdpEnvoye"] = time();
                }
                else $this->_data = array("MdpOublie"=>"1");
            }
            elseif($send_pwd==0) $this->_data = array("MdpOublie"=>"1");

        }
    }

    public function getController(){

    }

    public function getTemplate(){
        return (string)$this->_template;
    }

    public function getNavBar(){
        return (string)$this->_navbar;
    }

    public function getData(){
        return (isset($this->_data))?$this->_data:array();
    }

    private function setAction(){
        if(isset($_POST["action"])) $this->_action = $_POST["action"];
        else
            $this->_action = (isset($_GET["action"]))?$_GET["action"]:"getTemplate";
    }
}
