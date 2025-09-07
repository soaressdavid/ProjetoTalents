<?php
// Arquivo: app/views/editar_vaga.php

require_once __DIR__ . '/../utils/init.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: " . BASE_DIR . "/app/views/gerenciar_vagas.php");
    exit();
}

$vagaModel = new Vaga();
$vaga_id = $_GET['id'];
$vaga = $vagaModel->findById($vaga_id);

if (!$vaga || $vaga['empresa_id'] !== $_SESSION['usuario_id']) {
    $_SESSION['vaga_erro'] = "Vaga não encontrada ou você não tem permissão para editá-la.";
    header("Location: " . BASE_DIR . "/app/views/gerenciar_vagas.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Vaga</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="painel-container">
        <h2>Editar Vaga</h2>

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
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($vaga['id']); ?>">
            
            <label for="titulo">Título da Vaga:</label>
            <input type="text" id="titulo" name="titulo" value="<?php echo htmlspecialchars($vaga['titulo']); ?>" required>

            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" rows="5" required><?php echo htmlspecialchars($vaga['descricao']); ?></textarea>

            <label for="requisitos">Requisitos:</label>
            <textarea id="requisitos" name="requisitos" rows="5" required><?php echo htmlspecialchars($vaga['requisitos']); ?></textarea>
            
            <label for="localizacao">Localização:</label>
            <input type="text" id="localizacao" name="localizacao" value="<?php echo htmlspecialchars($vaga['localizacao']); ?>" required>
            
            <input type="submit" value="Salvar Alterações">
        </form>
    </div>
    
    <a href="gerenciar_vagas.php" class="back-link">Voltar para Gerenciar Vagas</a>
</body>
</html>