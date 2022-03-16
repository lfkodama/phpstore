<?php

// abrir a sessão

use core\classes\Database;
session_start();

// carregar todas as classes do projeto
require_once('../vendor/autoload.php');

// Carregar o sistema de rotas
require_once('../core/routes.php');




/*
- Carregar o config
- Carregar classes
- Carregar o sistema de rotas
    - mostrar loja
    - mostrar carrinho
    - mostrar backoffice, etc.
*/