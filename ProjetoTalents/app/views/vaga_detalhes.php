<?php
require_once __DIR__ . '/../utils/init.php';

// Verifica se o ID da vaga foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    // Redireciona para a página de vagas se o ID for inválido
    header('Location: vagas.php');
    exit();
}

$vagaModel = new Vaga();
$vaga = $vagaModel->findById($_GET['id']);

// Verifica se a vaga foi encontrada
if (!$vaga) {
    // Exibe uma mensagem de erro se a vaga não existir
    echo "<!DOCTYPE html><html lang='pt-br'><head><meta charset='UTF-8'><title>Vaga não encontrada</title><link rel='stylesheet' href='../../public/css/style.css'></head><body><main class='container'><h2 class='main-title' style='text-align:center;'>Vaga não encontrada</h2><p style='text-align:center;'>A vaga que você está procurando não existe ou foi removida.</p><p style='text-align:center;'><a href='vagas.php' class='button button-secondary'>Voltar para as vagas</a></p></main></body></html>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($vaga['titulo']); ?> - JobFind</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body>

    <header class="header">
        <div class="container">
            <h1 class="logo">JobFind</h1>
            <nav class="nav">
                <a href="vagas.php">Vagas</a>
                <a href="#">Empresas</a>
                <a href="#">Candidatos</a>
                <a href="#">Login</a>
            </nav>
        </div>
    </header>

    <main class="container job-detail-container">
        <div class="job-detail-card">
            <h2 class="job-detail-title"><?php echo htmlspecialchars($vaga['titulo']); ?></h2>
            <div class="job-meta">
                <span class="job-company"><?php echo htmlspecialchars($vaga['nome_empresa']); ?></span>
                <span class="job-location"><?php echo htmlspecialchars($vaga['localizacao']); ?></span>
            </div>

            <div class="job-section">
                <h3>Descrição da Vaga</h3>
                <p><?php echo nl2br(htmlspecialchars($vaga['descricao'])); ?></p>
            </div>

            <div class="job-section">
                <h3>Requisitos</h3>
                <p><?php echo nl2br(htmlspecialchars($vaga['requisitos'])); ?></p>
            </div>

            <div class="job-actions">
                <a href="candidatar.php?vaga_id=<?php echo $vaga['id']; ?>" class="button button-primary">Candidatar-se</a>
                <a href="vagas.php" class="button button-secondary">Voltar para as Vagas</a>
            </div>
        </div>
    </main>

</body>
</html>