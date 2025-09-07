<?php
// Arquivo: app/views/editar_perfil_candidato.php

require_once __DIR__ . '/../utils/init.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] !== 'candidato') {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}

$usuarioModel = new User();
$usuario = $usuarioModel->findById($_SESSION['usuario_id']);

if (!$usuario) {
    echo "<h1>Erro: Usuário não encontrado.</h1>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link rel="stylesheet" href="../../public/css/style.css">
</head>
<body>

    <div class="form-container">
        <h2>Editar Perfil</h2>

        <?php
        if (isset($_SESSION['perfil_sucesso'])) {
            echo '<p class="sucesso">' . htmlspecialchars($_SESSION['perfil_sucesso']) . '</p>';
            unset($_SESSION['perfil_sucesso']);
        }
        if (isset($_SESSION['perfil_erro'])) {
            echo '<p class="erro">' . htmlspecialchars($_SESSION['perfil_erro']) . '</p>';
            unset($_SESSION['perfil_erro']);
        }
        ?>

        <form action="../controllers/PerfilController.php" method="POST">
            <input type="hidden" name="action" value="update_perfil">

            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>
            
            <p style="font-size: 0.9em; color: #666; margin-bottom: 15px;">Deixe a senha em branco se não quiser alterá-la.</p>
            <label for="senha">Nova Senha:</label>
            <input type="password" id="senha" name="senha">
            
            <input type="submit" value="Salvar Alterações">
        </form>
    </div>

</body>
</html>