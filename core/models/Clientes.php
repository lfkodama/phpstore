<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Clientes {

    public function verifica_email_existe($email) {

        // Verifica na base de dados se existe cliente com mesmo e-mail
        $db = new Database();
        $parameters = [
            ':email' => strtolower(trim($email))
        ];
        $result = $db->select("SELECT email FROM clientes WHERE email = :email", $parameters);

        if(count($result) != 0) {
            return true;
        } else {
            return false;
        }

    }


    public function registrar_cliente() {
        // Registra o novo cliente na base de dados
        $db = new Database();

        // Cira um hase para o cliente
        $purl = Store::criarHash();

        // Parâmetros do Banco de Dados
        $params = [
            ':email' => strtolower(trim($_POST['text_email'])),
            ':senha' => password_hash($_POST['text_senha_1'], PASSWORD_DEFAULT),
            ':nome' => trim($_POST['text_nome_completo']),
            ':endereco' => trim($_POST['text_endereco']),
            ':cidade' => trim($_POST['text_cidade']),
            ':telefone' => trim($_POST['text_telefone']),
            ':purl' => $purl,
            ':ativo' => 'I'

        ];

        $db->insert("
            INSERT INTO clientes (email, password, full_name, address, city, 
                                  phone, purl, status)  
                          VALUES (
                :email,
                :senha,
                :nome,
                :endereco,
                :cidade,
                :telefone,
                :purl,
                :ativo)
        ", $params);

        // Retorna o purl criado
        return $purl;
    }

    //================================================================================
    public function validar_email($purl) {


        // Validar o email do novo cliente
        $db = new Database();
        
        $parameters = [
            ':purl' => $purl
        ];

        $result = $db->select("SELECT id_cliente FROM clientes WHERE purl = :purl", $parameters);
        
        // Verifica se foi encontrado o cliente no banco de dados
        if(count($result) != 1) {
            return false;
        }

        // Foi encontrado o cliente com o purl indicado
        $id_cliente = strval($result[0]->id_cliente);
    
        // Atualizar os dados do Cliente no banco de dados
        $parameters = [
            ':id_cliente' => $id_cliente
        ];

        $db->update("UPDATE clientes 
                        SET purl = NULL, 
                            status = 'A', 
                            updated_at = NOW()
                      WHERE id_cliente = :id_cliente",
                    $parameters);
        return true;
    
        

    }

    
    //================================================================================
    public function validar_login($usuario, $senha) {
        
        // Verificar se o login é válido
        $parameters = [
            ':usuario' => $usuario
        ];

        $db = new Database();
        $result = $db->select("SELECT * 
                                 FROM clientes 
                                WHERE email = :usuario 
                                  AND status = 'A' 
                                  AND deleted_at IS NULL", $parameters);
        
        if(count($result) != 1) {
            return false;
        } else {
            // O usuário existe
            $usuario = $result[0];
            
            // Verifica se o password está correto
            if(!password_verify($senha, $usuario->password)) {
                // Password inválido
                return false;
            } else {
                // Login válido
                return $usuario;
            }

        }

    }

    //================================================================================
    public function buscar_dados_cliente($id_cliente) {

        $params = [
            'id_cliente' => $id_cliente
        ];

        $db = new Database();
        $results = $db->select("SELECT email, full_name, address, city, phone
                                  FROM clientes 
                                 WHERE id_cliente = :id_cliente"
                                 , $params);
        return $results[0];

    }

}