<?php
// Arquivo: app/views/gerenciar_vagas.php

require_once __DIR__ . '/../utils/init.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}

$vagaModel = new Vaga();
$vagas = $vagaModel->findByEmpresaId($_SESSION['usuario_id']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Vagas</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="painel-container">
        <h2>Gerenciar Vagas</h2>

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

        <div class="painel-options">
            <a href="criar_vaga.php" class="painel-option">Criar Nova Vaga</a>
            <a href="painel_empresa.php" class="painel-option">Voltar ao Painel</a>
        </div>

        <h3>Minhas Vagas</h3>
        <div class="job-listing">
            <?php if (empty($vagas)): ?>
                <p>Você ainda não publicou nenhuma vaga.</p>
            <?php else: ?>
                <?php foreach ($vagas as $vaga): ?>
                    <div class="job-card">
                        <h4><?php echo htmlspecialchars($vaga['titulo']); ?></h4>
                        <p><strong>Publicada em:</strong> <?php echo date('d/m/Y', strtotime($vaga['data_criacao'])); ?></p>
                        <div class="actions">
                            <a href="ver_candidatura.php?vaga_id=<?php echo htmlspecialchars($vaga['id']); ?>" class="edit">Ver Candidatos</a>
                            <a href="editar_vaga.php?id=<?php echo htmlspecialchars($vaga['id']); ?>" class="edit">Editar</a>
                            <form action="../controllers/VagaController.php" method="POST" style="display: inline;">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($vaga['id']); ?>">
                                <button type="submit" class="delete" onclick="return confirm('Tem certeza que deseja excluir esta vaga?');">Excluir</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>