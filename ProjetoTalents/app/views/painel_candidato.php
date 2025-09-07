<?php
// Arquivo: app/views/painel_candidato.php

require_once __DIR__ . '/../utils/init.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'candidato') {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}

$candidaturaModel = new Candidatura();
$candidaturas = $candidaturaModel->findByCandidatoId($_SESSION['usuario_id']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <title>Painel do Candidato</title>
</head>
<body>

    <div class="painel-container">
        <h2>Bem-vindo, <?php echo htmlspecialchars($_SESSION['usuario_nome']); ?></h2>
        <p>Este é o seu painel de candidato. Aqui você pode gerenciar suas candidaturas.</p>

        <div class="painel-options">
            <a href="vagas.php" class="painel-option">Ver Vagas Disponíveis</a>
            <a href="../controllers/LogoutController.php" class="painel-option">Sair</a>
        </div>
        <a href="editar_perfil_candidato.php" class="painel-option">Editar Perfil</a>
        <hr>

        <h3>Minhas Candidaturas</h3>
        <div class="job-listing">
            <?php if (empty($candidaturas)): ?>
                <p>Você ainda não se candidatou a nenhuma vaga.</p>
            <?php else: ?>
                <?php foreach ($candidaturas as $candidatura): ?>
                    <div class="job-card">
                        <h4><?php echo htmlspecialchars($candidatura['titulo']); ?></h4>
                        <p><strong>Candidatou-se em:</strong> <?php echo date('d/m/Y H:i:s', strtotime($candidatura['data_candidatura'])); ?></p>
                        <p><strong>Localização:</strong> <?php echo htmlspecialchars($candidatura['localizacao']); ?></p>
                        <div class="actions">
                            <a href="vagas_detalhes.php?id=<?php echo htmlspecialchars($candidatura['id']); ?>" class="edit">Ver Vaga</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>