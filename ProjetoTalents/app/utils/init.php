<?php
// Arquivo: app/utils/init.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// **CORREÇÃO:** Use o caminho relativo para o servidor, não o caminho do sistema de arquivos.
define('BASE_DIR', '/ProjetoTalents');

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Vaga.php';
require_once __DIR__ . '/../models/Candidatura.php';
require_once __DIR__ . '/../models/PerfilCandidato.php';

// A conexão não é mais global, os modelos a obtêm através de `getDbConnection()`
$conn = getDbConnection();
?>