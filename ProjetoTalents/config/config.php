<?php
// Arquivo: app/config/config.php

$servidor = "localhost";
$usuario = "root";
$senha = ""; // Use uma senha forte e considere variáveis de ambiente em produção
$banco = "site_rh";

// As variáveis são agora um array associativo para facilitar o uso
$dbConfig = [
    'host' => $servidor,
    'user' => $usuario,
    'pass' => $senha,
    'dbname' => $banco
];

?>