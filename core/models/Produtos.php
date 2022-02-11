<?php

namespace core\models;

use core\classes\Database;
use core\classes\Store;

class Produtos {

    //================================================================================
    public function lista_produtos_disponiveis($categoria) {

        // Retorna todos os produtos da base de dados
        $db = new Database();

        // Busca a lista de categorias da loja
        $categorias = $this->lista_categorias();
        
        $sql = "SELECT * FROM produtos ";
        $sql.= "WHERE visivel = 'true' ";

        if(in_array($categoria, $categorias)) {
            $sql .= "AND categoria = '$categoria'";
        }

        $produtos = $db->select($sql);
        return $produtos;

    }

    //================================================================================
    public function lista_categorias() {
        // Devolve a lista de categorias existentes na base de dados
        $db = new Database();
        $result = $db->select("SELECT DISTINCT categoria FROM produtos");
        $categorias = [];
        foreach($result as $resultado) {
            array_push($categorias, $resultado->categoria);
        }
        
        return $categorias;
    }


    //================================================================================
    public function verificar_stock_produto($id_produto) {

        $db = new Database();
        $parameters = [
            'id_produto' => $id_produto
        ];
        $result = $db->select("
                               SELECT * FROM produtos
                                WHERE id_produto = :id_produto
                                  AND visivel = true
                                  AND stock > 0 
        ", $parameters);

        return count($result) != 0 ? true : false;

    }


    //================================================================================
    public function buscar_produtos_por_ids($ids) {

        $db = new Database();
      
        return $db->select("
            SELECT * FROM produtos WHERE id_produto IN ($ids)
        ");

    }

}