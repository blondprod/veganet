<?php
/**
 *
 * Created by blond.
 * File: Config.php
 * Date: 24/03/15 - 10:03
 *
 */

namespace fbx;

class Config {

    private $_host;
    private $_user;
    private $_pwd;
    private $_port;
    private $_dbname;
    protected static $_instance;

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            throw new \Exception('Config n\' a pas été initialisée. Appeler Config::init()');
        }
        return self::$_instance;
    }

    public static function init()
    {
        try {
            self::$_instance = new self();
        } catch (Exception $exc){

            throw new \Exception("Impossible d'initialiser Config");
        }
    }

    public function __construct(){
        $config = simplexml_load_file("../lib/config.ini");
        $this->_host = $config->dev->host;
        $this->_user = $config->dev->username;
        $this->_pwd = $config->dev->password;
        $this->_port = $config->dev->port;
        $this->_dbname = $config->dev->dbname;
    }

    public function getHost(){
        return (string)$this->_host;
    }

    public function getPort(){
        return (string)$this->_port;
    }

    public function getPwd(){
        return (string)$this->_pwd;
    }

    public function getUser(){
        return (string)$this->_user;
    }

    public  function getDbName(){
        return (string)$this->_dbname;
    }
}