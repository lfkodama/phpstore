<?php

define('APP_NAME',         'PHPSTORE');
define('APP_VERSION',      '1.0.0');

define('BASE_URL',    'http://localhost:3000/public/index.php');

//Conexão com o PostgreSQL
define('PGSQL_HOST',  'localhost');
define('PGSQL_DATABASE', 'php_store');
define('PGSQL_PORT', '5432');
define('PGSQL_USER', 'postgres');
define('PGSQL_PASS', '');


// E-Mail
define('EMAIL_HOST',         'smtp.gmail.com');
define('EMAIL_FROM',         'sempreviva.americana@gmail.com');
define('EMAIL_PASS',         '');
define('EMAIL_PORT',         587);


/* OBSERVAÇÕES:
- Alterei o arquivo postgresql.conf, parâmetro password encryption para MD5;
- Alterei o arquivo pg_hba.conf, e mudei todos os parâmetros de encryption type para MD5;
- Não usa o SCRAM do postgres para autenticação.
*/