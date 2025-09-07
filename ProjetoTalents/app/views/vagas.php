<?php
require_once __DIR__ . '/../utils/init.php';

$vagaModel = new Vaga();

$termo_busca = $_GET['termo_busca'] ?? '';
$filtro_localizacao = $_GET['filtro_localizacao'] ?? '';

$vagas = $vagaModel->searchAndFilter($termo_busca, $filtro_localizacao);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vagas Disponíveis - JobFind</title>
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
                <a href="#">Vagas</a>
                <a href="#">Empresas</a>
                <a href="#">Candidatos</a>
                <a href="#">Login</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h2 class="main-title">Encontre o Emprego Perfeito para Você</h2>
        
        <form action="vagas.php" method="GET" class="search-form">
            <input type="text" name="termo_busca" placeholder="Pesquisar por título ou descrição..." value="<?php echo htmlspecialchars($termo_busca); ?>">
            <select name="filtro_localizacao">
                <option value="">Todas as Localizações</option>
                <option value="Remoto" <?php echo ($filtro_localizacao == 'Remoto') ? 'selected' : ''; ?>>Remoto</option>
                <option value="São Paulo" <?php echo ($filtro_localizacao == 'São Paulo') ? 'selected' : ''; ?>>São Paulo</option>
                <option value="Rio de Janeiro" <?php echo ($filtro_localizacao == 'Rio de Janeiro') ? 'selected' : ''; ?>>Rio de Janeiro</option>
            </select>
            <button type="submit" class="button button-primary">Pesquisar</button>
        </form>

        <div class="job-list">
            <?php if (empty($vagas)): ?>
                <p class="no-results">Nenhuma vaga encontrada para sua busca.</p>
            <?php else: ?>
                <?php foreach ($vagas as $vaga): ?>
                    <div class="job-card">
                        <div class="job-header">
                            <h3 class="job-title"><?php echo htmlspecialchars($vaga['titulo']); ?></h3>
                            <span class="job-type">
                                <?php echo htmlspecialchars($vaga['localizacao']); ?>
                            </span>
                        </div>
                        <div class="job-meta">
                            <span class="job-company"><?php echo htmlspecialchars($vaga['nome_empresa']); ?></span>
                        </div>
                        <div class="job-description">
                            <p><?php echo nl2br(htmlspecialchars($vaga['descricao'])); ?></p>
                        </div>
                        <div class="job-footer">
                            <a href="vaga_detalhes.php?id=<?php echo $vaga['id']; ?>" class="button button-secondary">Ver Detalhes</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </main>

</body>
</html>