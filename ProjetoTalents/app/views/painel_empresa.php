<?php
// Arquivo: app/views/painel_empresa.php

require_once __DIR__ . '/../utils/init.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <title>Painel da Empresa</title>
</head>
<body>
    <div class="painel-container">
        <?php
        if (isset($_SESSION['vaga_sucesso'])) {
            echo '<p class="sucesso">' . htmlspecialchars($_SESSION['vaga_sucesso']) . '</p>';
            unset($_SESSION['vaga_sucesso']);
        }
        if (isset($_SESSION['vaga_erro'])) {
            echo '<p class="erro">' . htmlspecialchars($_SESSION['vaga_erro']) . '</p>';
            unset($_SESSION['vaga_erro']);
        }
        ?>
        <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?>!</h2>
        <p>Este é o seu painel de empresa. Selecione uma opção abaixo:</p>
        
        <div class="painel-options">
            <a href="criar_vaga.php" class="painel-option">Criar Vaga</a>
            <a href="gerenciar_vagas.php" class="painel-option">Gerenciar Vagas</a>
            <a href="editar_perfil_empresa.php" class="painel-option">Editar Perfil</a>
            <a href="../controllers/LogoutController.php" class="painel-option">Sair</a>
        </div>
    </div>
</body>
</html>