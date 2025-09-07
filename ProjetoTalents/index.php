<?php
// Arquivo: app/index.php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projeto Talents - Conectando talentos e oportunidades</title>
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <a href="index.php">
                <h1>Projeto Talents</h1>
            </a>
        </div>
        <div class="auth-links">
            <?php if (isset($_SESSION['usuario_id'])): ?>
                <?php if ($_SESSION['usuario_tipo'] === 'candidato'): ?>
                    <a href="views/painel_candidato.php">Painel do Candidato</a>
                <?php elseif ($_SESSION['usuario_tipo'] === 'empresa'): ?>
                    <a href="views/painel_empresa.php">Painel da Empresa</a>
                <?php endif; ?>
                <a href="controllers/LogoutController.php">Sair</a>
            <?php else: ?>
                <a href="views/auth.php">Login / Cadastro</a>
            <?php endif; ?>
        </div>
    </div>

    <div class="hero-section">
        <div class="hero-content">
            <h2>Encontre a vaga dos seus sonhos ou o talento ideal para sua empresa.</h2>
            <p>Conectamos profissionais qualificados a grandes empresas de forma simples e eficaz.</p>
            <a href="views/vagas.php" class="cta-button">Ver Vagas Disponíveis</a>
        </div>
    </div>

    <div class="features-section">
        <div class="feature-card">
            <h3>Para Candidatos</h3>
            <p>Encontre vagas que combinam com seu perfil, candidate-se com um clique e acompanhe o processo.</p>
            <a href="views/vagas.php" class="feature-link">Buscar Vagas</a>
        </div>
        <div class="feature-card">
            <h3>Para Empresas</h3>
            <p>Publique vagas, gerencie candidaturas e encontre os melhores profissionais do mercado.</p>
            <a href="views/auth.php" class="feature-link">Cadastrar Empresa</a>
        </div>
    </div>
</body>
</html>