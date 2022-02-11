<?php

namespace core\controllers;

use core\classes\Database;
use core\classes\EnviarEmail;
use core\classes\Store;
use core\models\Clientes;
use core\models\Produtos;
use DateTime;

class Main {
    
    //================================================================================
    public function index() {
        
        //$email = new EnviarEmail();
        //$email->enviar_email_confirmacao();
        //die('OK');

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'home',
            'layouts/footer',
            'layouts/html_footer'
        ]);


    }

    //================================================================================
    public function loja() {
        // Apresenta a página da Loja
        
        // Buscar a lista de produtos disponíveis

        $produtos = new Produtos();

        // Analisa qual categoria é para mostrar
        $c = 'todos';
        if(isset($_GET['c'])) {
            $c = $_GET['c'];
        }

        // Busca as informações na base de dados
        $lista_produtos = $produtos->lista_produtos_disponiveis($c);
        $lista_categorias = $produtos->lista_categorias();
        
        $dados = [
            'produtos' => $lista_produtos,
            'categorias' => $lista_categorias
        ];

        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'loja',
            'layouts/footer',
            'layouts/html_footer'
        ], $dados);

    }

    //================================================================================
    public function novo_cliente() {
        // Verifica se já existe Sessão de Usuário
        if(Store::clienteLogado()) {
            $this->index();
            return;
        }

        // Apresenta a página do cadastro de novo cliente
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'signup',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }
    

    //================================================================================
    public function criar_cliente() {

       // Verifica se já existe Sessão de Usuário
        if(Store::clienteLogado()) {
            $this->index();
            return;
        }

        // Verifica se houve submissão de um formulário
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            $this->index();
            return;
        }

        // Verifica se a senha e a confirmação da senha são idênticas
        if($_POST['text_senha_1'] !== $_POST['text_senha_2']) {
            // As senhas são diferentes
            $_SESSION['erro'] = 'As senhas não estão iguais.';
            $this->novo_cliente();
            return;
        }

        // Verifica na base de dados se existe cliente com mesmo e-mail
        $cliente = New Clientes();

        if($cliente->verifica_email_existe($_POST['text_email'])) {
            $_SESSION['erro'] = 'Já existe um cliente com o mesmo E-mail.';
            $this->novo_cliente();
            return;
        }
        
        
        // Cliente pronto para ser inserido na base de dados e devolver o purl
        $email_cliente = strtolower(trim($_POST['text_email']));

        $purl = $cliente->registrar_cliente();

        // Criar o link purl para enviar por e-mail
        $email = new EnviarEmail();
        $result = $email->enviar_email_confirmacao($email_cliente, $purl);

        if($result = true) {
            // Apresenta a página de mensagem de cliente validado com sucesso
            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'signup_success',
                'layouts/footer',
                'layouts/html_footer'
            ]);
        } else {
            echo 'Aconteceu um Erro';
        }

        

    }

    //================================================================================
    public function confirmar_email() {

        // Verifica se já existe uma sessão
        if(Store::clienteLogado()) {
            $this->index();
            return;
        }

        // Verificar se existe na query string um purl
        if(!isset($_GET['purl'])) {
            $this->index();
            return;
        }

        // Verifica se a string do purl é válida
        $purl = $_GET['purl'];
        if(strlen($purl) != 12) {
            $this->index();
            return;
        }

        $cliente = new Clientes();
        $result = $cliente->validar_email($purl);

        if($result) {
            // Apresenta a página de mensagem de cliente validado com sucesso
            Store::Layout([
                'layouts/html_header',
                'layouts/header',
                'validation_success',
                'layouts/footer',
                'layouts/html_footer'
            ]);
        } else {
            // Redirecionar para a página inicial
            Store::redirect('home');
        }
    }

     //================================================================================
    public function login() {
        
        // Verifica se o usuário já está logado
        if(Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        // Direciona o usuário para a tela de login
        Store::Layout([
            'layouts/html_header',
            'layouts/header',
            'login',
            'layouts/footer',
            'layouts/html_footer'
        ]);
    }

    //================================================================================
    public function login_submit() {

        // Verifica se o usuário já está logado
        if(Store::clienteLogado()) {
            Store::redirect();
            return;
        }

        
        // Verifica se foi efetuado POST do formulário de login
        if($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::redirect();
            return;
        }
        
                
        // Verifica se o login é válido
        if(!isset($_POST['text_usuario']) || 
           !isset($_POST['text_password']) ||
           !filter_var(trim($_POST['text_usuario']), FILTER_VALIDATE_EMAIL)) {
            
            // Em caso de erro de preenchimento do formulário de login
            $_SESSION['erro'] = 'Login Inválido';
            Store::redirect('login');
            return;
        }
        
        // prepara os dados para o Model
        $usuario = trim(strtolower($_POST['text_usuario']));
        $senha = trim($_POST['text_password']);
        
        // carrega o Model e verifica se o login é válido
        $cliente =  new Clientes();

        $result = $cliente->validar_login($usuario, $senha);
        
        
        // Analisa o resultado
        if(is_bool($result)) {
            $_SESSION['erro'] = 'Login inválido';
            Store::redirect('login');
            //return;

        } else {
            // Login válido
            $_SESSION['cliente'] = $result->id_cliente;
            $_SESSION['usuario'] = $result->email;
            $_SESSION['nome_cliente'] = $result->full_name;

            // Redirecionar para o local correto
            if(isset($_SESSION['tmp_carrinho'])) {
                // Remove a variável temporária da sessão
                unset($_SESSION['tmp_carrinho']);
                // Redireciona para o resumo da encomenda
                Store::redirect('finalizar_encomenda_resumo');
            } else {
                // Redireciona para a loja
                Store::redirect();
            }
            
            
        }

    }


    //================================================================================
    public function logout() {
        // Remove as variáveis da sessão
        unset($_SESSION['cliente']);
        unset($_SESSION['usuario']);
        unset($_SESSION['nome_cliente']);


        // Redireciona para o incício da loja
        Store::redirect();
    }

    



}