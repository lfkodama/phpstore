<?php

namespace core\classes;

use Exception;
use PDO;
use PDOException;

class Database {

    private $connection;
    

    //============================================================
    private function dbconnect(){
        $this->connection = new PDO(
            'pgsql:'. 
            'host='.PGSQL_HOST.';'.
            'port='.PGSQL_PORT.';'.
            'dbname='.PGSQL_DATABASE.';'.
            'user='.PGSQL_USER.';'.
            'password='.PGSQL_PASS
            //array(PDO::ATTR_PERSISTENT => true)
        );

        // Debug da Conexão com o Banco de Dados
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    }

    //============================================================
    private function disconnect(){
        // Desconecta a ligação com o Banco de Dados
        $this->connection = null;
    }

    //============================================================
    public function select($sql, $parameters = null){
        
        $sql = trim($sql);
        
        // Verifica se é uma função SELECT
        if(!preg_match("/^SELECT/i", $sql)){
            throw new Exception('Base de dados - Não é uma instrução SELECT.');
        }

        // Executa instruções de SELECT no Banco de Dados
        
        // Conecta no Banco de Dados
        $this->dbconnect();

        $db_result = null;
       

        try {
            // Comunicação com o Banco de Dados
            if(!empty($parameters)) {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parameters);
                // Retorna os resultados no formato de classe de objetos
                $db_result = $execute->fetchAll(PDO::FETCH_CLASS);
            } else { // Caso não houver parâmetros de conexão
                $execute = $this->connection->prepare($sql);
                $execute->execute();
                $db_result = $execute->fetchAll(PDO::FETCH_CLASS);
            }

        } catch (PDOException $e) {
            // Executa caso exista erro na conexão com o Banco de Dados
            return false;
        }

        // Desconecta do Banco de Dados
        $this->disconnect();

        // Retornar os resultados obtidos
        return $db_result;
    }

    //============================================================
    public function insert($sql, $parameters = null) {
        
        $sql = trim($sql);
        
        // Verifica se é uma função INSERT.
        if(!preg_match("/^INSERT/i", $sql)) {
            throw new Exception('Base de dados - Não é uma instrução INSERT.');
        }

        // Conecta no Banco de Dados
        $this->dbconnect();

        // Comunica com o Banco de Dados e executa a instrução
        try {
            if(!empty($parameters)) {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parameters);
            } else {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch(PDOException $e) {
            // Caso exista algum erro
            return false;
        }

        // Desconecta do Banco de Dados
        $this->disconnect();
       
    }

    //============================================================
    public function update($sql, $parameters = null) {
        
        $sql = trim($sql);
        
        // Verifica se é uma função UPDATE.
        if(!preg_match("/^UPDATE/i", $sql)) {
            throw new Exception('Base de dados - Não é uma instrução UPDATE.');
        }

        // Conecta no Banco de Dados
        $this->dbconnect();

        // Comunica com o Banco de Dados e executa a instrução
        try {
            if(!empty($parameters)) {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parameters);
            } else {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch(PDOException $e) {
            // Caso exista algum erro
            return false;
        }

        // Desconecta do Banco de Dados
        $this->disconnect();
    }
    
    //============================================================
    public function delete($sql, $parameters = null) {
        
        $sql = trim($sql);
        
        // Verifica se é uma função DELETE.
        if(!preg_match("/^DELETE/i", $sql)) {
            throw new Exception('Base de dados - Não é uma instrução DELETE.');
        }

        // Conecta no Banco de Dados
        $this->dbconnect();

        // Comunica com o Banco de Dados e executa a instrução
        try {
            if(!empty($parameters)) {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parameters);
            } else {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch(PDOException $e) {
            // Caso exista algum erro
            return false;
        }

        // Desconecta do Banco de Dados
        $this->disconnect();
    }
    
    //============================================================================
    // INSTRUÇÃO GENÉRICA (Se tentar passar qualquer outra instrução...)
    //============================================================================
    public function statement($sql, $parameters = null) {
        
        $sql = trim($sql);
        
        // Verifica se é uma função INSERT.
        if(!preg_match("/^(SELECT|INSERT|UPDATE|DELETE/i", $sql)) {
            throw new Exception('Base de dados - Instrução Inválida.');
        }

        // Conecta no Banco de Dados
        $this->dbconnect();

        // Comunica com o Banco de Dados e executa a instrução
        try {
            if(!empty($parameters)) {
                $execute = $this->connection->prepare($sql);
                $execute->execute($parameters);
            } else {
                $execute = $this->connection->prepare($sql);
                $execute->execute();
            }
        } catch(PDOException $e) {
            // Caso exista algum erro
            return false;
        }

        // Desconecta do Banco de Dados
        $this->disconnect();

    }    
}