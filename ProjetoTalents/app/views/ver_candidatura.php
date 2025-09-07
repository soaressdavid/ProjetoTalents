<?php
// Arquivo: app/views/ver_candidatura.php

require_once __DIR__ . '/../utils/init.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'empresa') {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}

if (!isset($_GET['vaga_id']) || empty($_GET['vaga_id']) || !is_numeric($_GET['vaga_id'])) {
    header("Location: " . BASE_DIR . "/app/views/gerenciar_vagas.php");
    exit();
}

$vaga_id = $_GET['vaga_id'];

$vagaModel = new Vaga();
$vaga = $vagaModel->findById($vaga_id);

if (!$vaga || $vaga['empresa_id'] !== $_SESSION['usuario_id']) {
    $_SESSION['vaga_erro'] = "Acesso negado: Vaga não encontrada ou não pertence a você.";
    header("Location: " . BASE_DIR . "/app/views/gerenciar_vagas.php");
    exit();
}

$candidaturaModel = new Candidatura();
$candidaturas = $candidaturaModel->findByVagaId($vaga_id);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Candidatos para a Vaga</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>
    <div class="header">
        <h1>Gerenciar Candidaturas</h1>
        <div class="auth-links">
            <a href="painel_empresa.php">Voltar ao Painel</a>
        </div>
    </div>
    
    <div class="painel-container">
        <h2>Candidatos para a Vaga: <br>"<?php echo htmlspecialchars($vaga['titulo']); ?>"</h2>
        
        <?php if (empty($candidaturas)): ?>
            <p>Nenhum candidato se inscreveu para esta vaga ainda.</p>
        <?php else: ?>
            <div class="job-listing">
                <?php foreach ($candidaturas as $candidatura): ?>
                    <div class="job-card">
                        <h4><?php echo htmlspecialchars($candidatura['nome']); ?></h4>
                        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($candidatura['email']); ?></p>
                        <p><strong>Candidatou-se em:</strong> <?php echo date('d/m/Y H:i:s', strtotime($candidatura['data_candidatura'])); ?></p>
                        <a href="perfil_candidato.php?candidato_id=<?php echo htmlspecialchars($candidatura['candidato_id']); ?>" class="edit">Ver Perfil</a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <a href="gerenciar_vagas.php" class="back-link">Voltar para Gerenciar Vagas</a>
    </div>

</body>
</html>