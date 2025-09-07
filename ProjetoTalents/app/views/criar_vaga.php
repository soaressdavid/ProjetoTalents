<?php
// Arquivo: app/views/criar_vaga.php

require_once __DIR__ . '/../utils/init.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nova Vaga</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="painel-container">
        <h2>Criar Nova Vaga</h2>

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

        <form action="../controllers/VagaController.php" method="POST">
            <input type="hidden" name="action" value="create">
            
            <label for="titulo">Título da Vaga:</label>
            <input type="text" id="titulo" name="titulo" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="5" required></textarea>

            <label for="requisitos">Requisitos:</label>
            <textarea id="requisitos" name="requisitos" rows="5" required></textarea>
            
            <label for="localizacao">Localização:</label>
            <input type="text" id="localizacao" name="localizacao" required>
            
            <input type="submit" value="Publicar Vaga">
        </form>
    </div>
    <a href="painel_empresa.php" class="back-link">Voltar para o Painel</a>
</body>
</html>