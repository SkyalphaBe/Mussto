<?php
require_once (PATH_MODELS."Database.php");
abstract class DAO
{

    private $_erreur;
    private $_debug;

    public function __construct($debug)
    {
        $this->_debug = $debug;
    }

    public function getErreur()
    {
        return $this->_erreur;
    }

    private function _requete($sql, $args = null)
    {
        if ($args == null)
        {
            $pdos = Database::getInstance()->getBdd()->query($sql);// exécution directe
        }
        else
        {
            $pdos = Database::getInstance()->getBdd()->prepare($sql);// requête préparée
            $pdos->execute($args);
        }
        return $pdos;
    }

    public function beginTransaction(){
        return Database::getInstance()->getBdd()->beginTransaction();
    }

    public function commitTransaction(){
        return Database::getInstance()->getBdd()->commit();
    }

    public function rollbackTransaction(){
        return Database::getInstance()->getBdd()->rollBack();
    }

    public function queryRow($sql, $args = null)
    {
        try
        {
            $pdos = $this->_requete($sql, $args);
            $res = $pdos->fetch(PDO::FETCH_ASSOC);
            $pdos->closeCursor();
        }
        catch(PDOException $e)
        {
            error_log($e->getMessage());
            if($this->_debug)
                die($e->getMessage());
            $this->_erreur = 'query';
            $res = false;
        }
        return $res;
    }

    public function queryAll($sql, $args = null)
    {
        try
        {
            $pdos = $this->_requete($sql, $args);
            $res = $pdos->fetchAll(PDO::FETCH_ASSOC);
            $pdos->closeCursor();
        }
        catch(PDOException $e)
        {
            error_log($e->getMessage());
            if($this->_debug)
                die($e->getMessage());
            $this->_erreur = 'query';
            $res = false;
        }
        return $res;
    }

    public function execQuery($sql,$args){
        try
        {
            $pdos = $this->_requete($sql,$args);
            $res = $pdos->rowCount();
        
        }
        catch(PDOException $e)
        {
            error_log($e->getMessage());
            if($this->_debug)
                die($e->getMessage());
            $this->_erreur = 'exec';
            $res = false;
        }
        return $res;
    }

    public function insertRow($sql, $args){
        try{
            $pdos = $this->_requete($sql,$args);
            $res = Database::getInstance()->getBdd()->lastInsertId();
        }
        catch(PDOException $e)
        {
            error_log($e->getMessage());
            if($this->_debug)
                die($e->getMessage());
            $this->_erreur = 'exec';
            $res = false;
        }
        return $res;
    }

    public function updateRow($sql,$args){
        try
        {
            $res = $this->_requete($sql,$args);

        }
        catch(PDOException $e)
        {
            if($this->_debug)
                die($e->getMessage());
            $this->_erreur = 'insert';
            $res = false;
        }
        return $res;
    }

    public function deleteRow($sql,$args){
        try
        {
            $res = $this->_requete($sql,$args);

        }
        catch(PDOException $e)
        {
            if($this->_debug)
                die($e->getMessage());
            $this->_erreur = 'insert';
            $res = false;
        }
        return $res;
    }
}