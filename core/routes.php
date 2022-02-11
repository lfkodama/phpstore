<?php

// Routes Collection

$routes = [
    'inicio' => 'main@index',
    'loja' => 'main@loja',

    // Cliente
    'novo_cliente' => 'main@novo_cliente',
    'criar_cliente' => 'main@criar_cliente',
    'confirmar_email' => 'main@confirmar_email',

    // Login
    'login' => 'main@login',
    'login_submit' => 'main@login_submit',
    'logout' => 'main@logout',

    // Carrinho
    'adicionar_carrinho' => 'carrinho@adicionar_carrinho',
    'remover_produto_carrinho' => 'carrinho@remover_produto_carrinho',
    'limpar_carrinho' => 'carrinho@limpar_carrinho',
    'finalizar_encomenda' => 'carrinho@finalizar_encomenda',
    'finalizar_encomenda_resumo' => 'carrinho@finalizar_encomenda_resumo',
    'carrinho' => 'carrinho@carrinho',
    'definir_endereco_alternativo' => 'carrinho@definir_endereco_alternativo',
    'confirmar_pedido' => 'carrinho@confirmar_pedido'
];

// Define a ação default
$acao = 'inicio';

// Verifica se a ação existe na query string
if(isset($_GET['a'])){

    // Verifica se a ação existe nas rotas
    if(!key_exists($_GET['a'], $routes)){
        $acao = 'inicio';
    } else {
        $acao = $_GET['a'];
    }
}

// Trata a definição da rota
$parts = explode('@', $routes[$acao]);  //Chave[0] -> Controller, Chave[1] -> Método

//$controller = ucfirst($parts[0]);
$controller = 'core\\controllers\\'.ucfirst($parts[0]);
$method = $parts[1];


$ctr = new $controller();
$ctr->$method();

