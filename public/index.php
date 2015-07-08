<?php
/**
 *
 * Created by blond.
 * File: Config.php
 * Date: 24/03/15 - 10:53
 *
 */

//-- load "autoload"
require '../vendor/autoload.php';

//-- calcul time elapsed
$time_start = microtime(true);

define("APPLICATION_ROOT", realpath("../"));

session_start();

$_SESSION['IP_SERVER'] = $_SERVER['HTTP_HOST'];
if (isset($_GET['IDUser']) && $_GET['IDUser'] > '0') {

    $data = null;

    $pnidUser = $_GET['IDUser'];

    $config = simplexml_load_file("../lib/config.ini");
    $host = $config->dev->host;
    $user = $config->dev->username;
    $pwd = $config->dev->password;
    $port = $config->dev->port;
    $dbname = $config->dev->dbname;

    $ip = $config->dev->ip;
    $public = $config->path->public;

    $q = "SELECT Login,Pwd FROM TBL_MEMBRE WHERE IDMembre = '$pnidUser' AND EstActif = '1' AND EstSupp = 0";

    try {
        $pdo = new \PDO('mysql:host=' . $host . ';port=' . $port . ';dbname=' . $dbname, $user, $pwd);
        $query = $pdo->prepare($q);
        $query->execute();
    } catch (\PDOException $e) {
        var_dump(\fbx\Config::getInstance());
        var_dump($e->getMessage());
        echo "l'erreur " . $e->getMessage() . "<br />";
        echo "le numero de l'erreur est " . $e->getCode() . "<br />";
        echo "l'erreur est à la ligne " . $e->getLine() . "<br />";
        echo "l'erreur est à la ligne " . $e->getTrace() . "<br />";
        die;
    }

    $ind = 0;

    while ($row = $query->fetchObject()) {
        $data[$ind] = $row;
        $ind++;
    }
    unset($pdo);
    unset($query);
//    $_SESSION['conn'] =  "http://$ip/$public"."index.php?login=$login&password=$pwd&languages=fr_FR";
//    echo "http://$ip/$public"."index.php?login=$login&password=$pwd&languages=fr_FR";
    $_POST["login"] = $data[0]->Login;
    $_POST["password"] = $data[0]->Pwd;
    $_POST["languages"] = "fr_FR";
}

date_default_timezone_set('Europe/Paris');

//-- definition du serveur
$config = simplexml_load_file("../lib/config.ini");
$_SESSION['IP'] = "{$config->dev->ip}";
$_SESSION['PUBLIC_PATH'] = "{$config->path->public}";

//-- définition de la langue
if(isset($_POST["languages"]) && !isset($_GET["languages"]))        $language = $_SESSION["languages"] = $_POST["languages"];
elseif(isset($_GET["languages"]) && !isset($_POST["languages"]))    $language = $_SESSION["languages"] = $_GET["languages"];
elseif(isset($_SESSION["languages"]))                               $language = $_SESSION["languages"];
else                                                                $language = $_SESSION["languages"] = "fr_FR";

//--Load Config
\fbx\Config::init();

//--Load DBmysql
\fbx\DBmysql::init();

//-- définition du user

if(isset($_POST["login"]) && !isset($_GET["login"]))        $_SESSION["loginUsr"] = $_POST["login"];
elseif(isset($_GET["login"]) && !isset($_POST["login"]))    $_SESSION["loginUsr"] = $_GET["login"];
\fbx\Fab\Utilisateur::init();

putenv("LC_MESSAGES=" . $language);
setlocale(LC_MESSAGES, $language.".utf8");

if (function_exists('bindtextdomain') && function_exists('textdomain')) {
    bindtextdomain("messages", APPLICATION_ROOT . "/locale");
    textdomain("messages");
    bind_textdomain_codeset("messages", "UTF-8");
}


$app = new \Slim\Slim(array(
    'view'           => new \Slim\Views\Twig(),
    'templates.path' => '../templates'
));

$twig = $app->view();

$twig->parserOptions = array(
    'debug' => true
);

$twig->parserExtensions = array(
    new Twig_Extensions_Extension_I18n() ,
    new Twig_Extension_Debug()
);


if(!isset($_GET["async"])) $app->render("head.twig");

$app->get('/', function () use ($app) {
    $controller = new \fbx\Fab\Controller("");
    if($controller->getNavBar()!="") $app->render($controller->getNavBar());
    $app->render($controller->getTemplate());
    $app->render("foot.twig");
});

$app->get('/:name', function ($name) use ($app) {
    $controller = new \fbx\Fab\Controller($name,$_GET);
    if(!isset($_GET["async"])) { if($controller->getNavBar()!="") $app->render($controller->getNavBar()); }

    if(!isset($_GET["async"])) $app->render($controller->getTemplate(),$controller->getData());
    else{
        header('Content-Type: application/json');
        if(isset($_GET['async_data'])) echo json_encode($controller->getData());
        else{
            $app->view->setTemplatesDirectory(APPLICATION_ROOT.'/templates');
            $app->view->appendData($controller->getData());
            $output = $app->view->fetch($controller->getTemplate());
            echo json_encode(array("SentData"=>$output));
        }
    }
    //-- si foot.twig appelé plus bas le html ne se construit pas correctement
    if(!isset($_GET["async"])) $app->render("foot.twig");
});

$app->post('/:name', function ($name) use ($app) {
    $controller = new \fbx\Fab\Controller($name,$_POST);
    if($controller->getNavBar()!="") $app->render($controller->getNavBar());
    $app->render($controller->getTemplate(),$controller->getData());
    $app->render("foot.twig");
});

$app->run();

$time_end = microtime(true);
if(!isset($_GET["async"])){
    echo '<div class="container-fluid paddingCount"><a id="chrono" href="#top">'.round($time_end-$time_start,4)." s</a></div>";
}

//echo "<pre>";
//var_dump($_SESSION);
//var_dump($_SERVER);
//phpinfo();
//echo "</pre>";

