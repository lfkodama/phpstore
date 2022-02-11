<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;

class Carrinho {

    //================================================================================
    public function adicionar_carrinho() {

        // Busca o id_produto à Query String
        if(!isset($_GET['id_produto'])) {
            
            // Verifica se existe sessão criada, caso exista, devolve a quantidade de produtos, senão, devolve zero
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }
        
        // Define o ID do Produto
        $id_produto = $_GET['id_produto'];

        $produtos = new Produtos();
        $results = $produtos->verificar_stock_produto($id_produto);
        
        if(!$results) {
            echo isset($_SESSION['carrinho']) ? count($_SESSION['carrinho']) : '';
            return;
        }

        // Adiciona / gerencia a variável de sessão do carrinho
        $carrinho = [];

        if(isset($_SESSION['carrinho'])) {

            $carrinho = $_SESSION['carrinho'];

        }   

        // Adiciona produtos ao carrinho
        if(key_exists($id_produto, $carrinho)) {

            // Se for um produto já existente no array, incrementa quantidade
            $carrinho[$id_produto]++;

        } else {

            // Adiciona novo item no array
            $carrinho[$id_produto] = 1;

        }

        // atualiza os dados do carrinho na sessão
        $_SESSION['carrinho'] = $carrinho;

        // devolve a resposta (número de produtos do carrinho)
        $total_produtos = 0;

        foreach($carrinho as $quantidade) {
            $total_produtos += $quantidade; 
        }

        echo $total_produtos;

    }

    //================================================================================
    public function remover_produto_carrinho() {

        // Busca o id_produto na query string
        $id_produto = $_GET['id_produto'];

        // Busca o carrinho na Session
        $carrinho = $_SESSION['carrinho'];

        // Remove o produto do carrinho
        unset($carrinho[$id_produto]);

        // Atualiza o carrinho na Session
        $_SESSION['carrinho'] = $carrinho;

        // Apresenta o carrinho atualizado
        $this->carrinho();

    }

    //================================================================================
    public function limpar_carrinho() {

        // Limpa o carrinho de todos os produtos
        unset($_SESSION['carrinho']);
        
        $this->carrinho();

    }

    //================================================================================
    public function carrinho() {
        // Apresenta a página do Carrinho
        //$dados = [];
        if(!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) == 0 ) {
            $dados = [
                'carrinho' => null
            ];
        } else {
            
            $ids = [];
            
            foreach($_SESSION['carrinho'] as $id_produto => $quantidade){
                array_push($ids, $id_produto);
            }
            $ids = implode(",", $ids);
            
            $produtos = new Produtos();
            $results = $produtos->buscar_produtos_por_ids($ids);
            
            /* 
            fazer um ciclo por cada produto no carrinho
                - identificar o id e usar os dados da bd para criar
                  uma coleção de dados para a página do carrinho

                imagem | titulo | quantidade | preço | xxx
            */

            $dados_tmp = [];
            foreach($_SESSION['carrinho'] as $id_produto=>$quantidade_carrinho) {
                
                // Imagem do produto
                foreach($results as $produto) {
                    if($produto->id_produto == $id_produto) {
                        $id_produto = $produto->id_produto;
                        $imagem = $produto->imagem;
                        $titulo = $produto->nome_produto;
                        $quantidade = $quantidade_carrinho;
                        $preco = $produto->preco * $quantidade;
                    

                        // Coloca os dados no array
                        array_push($dados_tmp, [
                            'id_produto' => $id_produto,
                            'imagem' => $imagem,
                            'titulo' => $titulo,
                            'quantidade' => $quantidade,
                            'preco' => $preco
                        ]);
                        
                        break;
                    }
                }

            }
            
        

            // calcular o total
            $total_da_encomenda = 0;
            foreach($dados_tmp as $item){
                $total_da_encomenda += $item['preco'];
            }
            array_push($dados_tmp, $total_da_encomenda);

        // Store::printData($dados_tmp);
        // die();

            $dados = [
                'carrinho' => $dados_tmp
            ];
        }
        // Apresenta a página do carrinho
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'carrinho',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);

    }

    //================================================================================
    public function finalizar_encomenda() {

        // Verifica se existe cliente logado
        if(!isset($_SESSION['cliente'])) {

            // Coloca na sessão um referer temporário (de onde eu venho)
            $_SESSION['tmp_carrinho'] = true; 

            // Redireciona para o login
            Store::redirect('login');

        } else {

            Store::redirect('finalizar_encomenda_resumo');

        }

    }   
    
    //================================================================================
    public function finalizar_encomenda_resumo() {

        // Verifica se existe usuário logado
        if(!isset($_SESSION['cliente'])) {

            Store::redirect('inicio');

        }
        
        //------------------------------------------------------------------------
        // Informações do Carrinho
        $ids = [];
            
        foreach($_SESSION['carrinho'] as $id_produto => $quantidade){
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        
        $produtos = new Produtos();
        $results = $produtos->buscar_produtos_por_ids($ids);
        
        $dados_tmp = [];
        foreach($_SESSION['carrinho'] as $id_produto=>$quantidade_carrinho) {
            
            // Imagem do produto
            foreach($results as $produto) {
                if($produto->id_produto == $id_produto) {
                    $id_produto = $produto->id_produto;
                    $imagem = $produto->imagem;
                    $titulo = $produto->nome_produto;
                    $quantidade = $quantidade_carrinho;
                    $preco = $produto->preco * $quantidade;
                

                    // Coloca os dados no array
                    array_push($dados_tmp, [
                        'id_produto' => $id_produto,
                        'imagem' => $imagem,
                        'titulo' => $titulo,
                        'quantidade' => $quantidade,
                        'preco' => $preco
                    ]);
                    
                    break;
                }
            }

        }
        
    

        // calcular o total
        $total_da_encomenda = 0;
        foreach($dados_tmp as $item){
            $total_da_encomenda += $item['preco'];
        }
        array_push($dados_tmp, $total_da_encomenda);

        // Colocar o preço total na sessão
        $_SESSION['total_encomenda'] = $total_da_encomenda;

        // Prepara os dados da view
        $dados = [];
        $dados['carrinho'] = $dados_tmp;
        

        // Buscar as informações do cliente
        $cliente = new Clientes();
        $dados_cliente = $cliente->buscar_dados_cliente($_SESSION['cliente']);
        $dados['cliente'] = $dados_cliente;

        // Gerar o código da encomenda
        if(!isset($_SESSION['codigo_encomenda'])) {
            $codigo_encomenda = Store::gerarCodigoEncomenda();
            $_SESSION['codigo_encomenda'] = $codigo_encomenda;
        }

        
        


        // Apresenta a página do carrinho
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_resumo',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);

    }



    //================================================================================
    public function definir_endereco_alternativo() {

        // Recebe os dados de endereço alternativo via AJAX
        $post = json_decode(file_get_contents('php://input'), true);

        $_SESSION['dados_alternativos'] = [
            'nome' => $post['text_nome'],
            'endereco' => $post['text_endereco'],
            'cidade' => $post['text_cidade'],
            'telefone' => $post['text_telefone'],
        ];

    }

    //================================================================================
    public function confirmar_pedido() {

        /*
            - Apresentar mensagem sobre encomenda confirmada;
            - enviar e-mail para o cliente;
            - gravar os dados da encomenda na base de dados;
        */
        $codigo_encomenda = $_SESSION['codigo_encomenda'];
        $total_encomenda = $_SESSION['total_encomenda'];

        // Enviar o e-mail de confirmação da encomenda para o cliente
        $dados_encomenda = [];
        
        $ids = [];
        foreach($_SESSION['carrinho'] as $id_produto => $quantidade) {
            array_push($ids, $id_produto);
        }
        $ids = implode(",", $ids);
        $produtos = new Produtos();
        $results = $produtos->buscar_produtos_por_ids($ids);


        // Estrutura dos dados dos produtos
        $string_produtos = [];

        foreach($results as $result) {

            // Buscar a quantidade
            $quantidade = $_SESSION['carrinho'][$result->id_produto];
            $string_produtos[] = "$quantidade x $result->nome_produto - " . "R$ " . number_format($result->preco, 2, ',', '.') . ' / Unid.';

        }

        // Dados dos produtos para o e-mail
        $dados_encomenda['lista_produtos'] = $string_produtos;

        // Preço total da encomenda para o e-mail
        $dados_encomenda['total'] = "R$ " . number_format($_SESSION['total_encomenda'],2,',','.');

        // Dados do pagamento para o e-mail
        $dados_encomenda['dados_pagamento'] = [
            'numero_conta' => '123456699',
            'codigo_encomentda' => $_SESSION['codigo_encomenda'],
            'total' => "R$ " . number_format($_SESSION['total_encomenda'],2,',','.')
        ];

        Store::printData($dados_encomenda);



            

            /*
                - Lista de produtos + quantidade + preço unitário;
                    2 x [nome do produto] - preço unitário
                    1 x [nome ..]

                    total da encomenda: valor R$

                    dados de pagamento
                    numero da conta para pagamento
                    código da encomenda
                    total

            */
        
        // Limpa todos os dados que estão no carrinho (reset)




        // Apresenta a página de agradecimento pela encomenda
        $dados = [
            'codigo_encomenda' => $codigo_encomenda,
            'total_encomenda' => $total_encomenda
        ];

        
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'encomenda_confirmada',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);

    }

}