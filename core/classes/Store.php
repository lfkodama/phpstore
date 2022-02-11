<?php

namespace core\classes;

use Exception;

class Store {

    /* Funções do Sistema */

    //=============================================================================
    public static function Layout($structures, $dados = null) {
        // Função para apresentar as views da aplicação

        // Verifica se structure é um array
        if(!is_array($structures)) {
            throw new Exception("Coleção de estruturas inválida!");
        }

        // Variáveis
        if(!empty($dados) && is_array($dados)) {
            extract($dados);
        }


        // Apresentar as Views da aplicação
        foreach($structures as $structure) {
            include("../core/views/$structure.php");
        }


    }


    //=============================================================================
    public static function clienteLogado() {

        // Verifica se existe um cliente com Sessão
        return isset($_SESSION['cliente']);

    }


    //=============================================================================
    public static function criarHash($num_caracteres = 12) {
        // Criar Hashes
        $chars = '01234567890123456789abcdefghijklmnopqrstuvwyxzABCDEFGHIJKLMNOPQRSTUVWYXZ';
        return substr(str_shuffle($chars), 0, $num_caracteres);
    }


     //=============================================================================
     public static function redirect($route = '') {
        // Faz o redirecionamento para a url desejada
        header("Location: " . BASE_URL . "?a=$route");
     }


    //================================================================================
    public static function gerarCodigoEncomenda() {

        $codigo = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codigo.=substr(str_shuffle($chars),0,2);
        $codigo.=rand(100000,999999);
        return $codigo;

    }

     //================================================================================
    public static function printData($data) {
        if(is_array($data) || is_object($data)) {
            echo '<pre>';
            print_r($data);
        } else {
            echo '<pre>';
            echo $data;
        }

        die('Terminado');
    }
}