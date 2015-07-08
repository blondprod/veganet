<?php
/**
 *
 * Created by blond.
 * File: DBmysql.php
 * Date: 24/03/15 - 10:53
 *
 */

namespace fbx;

class DBmysql
{
    protected static $_instance;

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            throw new \Exception('La BDD n\' a pas été initialisée. Appeler Utilisateur::init()');
        }
        return self::$_instance;
    }

    public static function init()
    {
        self::$_instance = new self();
    }

    public function getSelectData($sql_select)
    {
        $data = array();

        try {
            $pdo = new \PDO('mysql:host=' . \fbx\Config::getInstance()->getHost() . ';port=' . \fbx\Config::getInstance()->getPort() . ';dbname=' . \fbx\Config::getInstance()->getDbName(), \fbx\Config::getInstance()->getUser(), \fbx\Config::getInstance()->getPwd());
            $query = $pdo->prepare($sql_select);
            $query->execute();
        }
        catch ( \PDOException $e ) {
            var_dump(\fbx\Config::getInstance());
            var_dump($e->getMessage());
            echo "l'erreur " . $e->getMessage() . "<br />";
            echo "le numero de l'erreur est " . $e->getCode() . "<br />";
            echo "l'erreur est à la ligne " . $e->getLine() . "<br />";
            echo "l'erreur est à la ligne " . $e->getTrace() . "<br />";
            die;
        }

        $ind=0;

        while ( $row = $query->fetchObject() ) {
            $data[$ind] = $row;
            $ind++;
        }

        unset($pdo);

        unset($query);

        return $data;
    }

    public function getInsertData($sql)
    {
        $resu = null;
        try
        {
            $pdo = new \PDO('mysql:host=' . \fbx\Config::getInstance()->getHost() . ';port=' . \fbx\Config::getInstance()->getPort() . ';dbname=' . \fbx\Config::getInstance()->getDbName(), \fbx\Config::getInstance()->getUser(), \fbx\Config::getInstance()->getPwd());
            $pdo->exec($sql);
            $resu = $pdo->lastInsertId();
        }
        catch ( PDOException $e )
        {
            echo $e->getMessage();
        }
        unset($pdo);
        return $resu;
    }

    public function getUpdateData($sql)
    {
        $resu = null;
        try
        {
            $pdo = new \PDO('mysql:host=' . \fbx\Config::getInstance()->getHost() . ';port=' . \fbx\Config::getInstance()->getPort() . ';dbname=' . \fbx\Config::getInstance()->getDbName(), \fbx\Config::getInstance()->getUser(), \fbx\Config::getInstance()->getPwd());
            $resu = $pdo->exec($sql);
        }
        catch ( PDOException $e )
        {
            echo $e->getMessage();
        }
        unset($pdo);
        return $resu;
    }
}
