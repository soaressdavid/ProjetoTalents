<?php
// Arquivo: app/controllers/CadastroController.php

require_once __DIR__ . '/../utils/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = getDbConnection();

    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'] ?? '';

    if (empty($nome) || empty($email) || empty($senha) || empty($tipo_usuario)) {
        $_SESSION['cadastro_erro'] = "Preencha todos os campos.";
        header("Location: " . BASE_DIR . "/app/views/auth.php");
        exit();
    }

    $senhaCriptografada = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $conn->beginTransaction();

        $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, tipo_usuario) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nome, $email, $senhaCriptografada, $tipo_usuario]);
        $usuario_id = $conn->lastInsertId();
        
        if ($tipo_usuario === 'candidato') {
            $stmt = $conn->prepare("INSERT INTO candidatos (usuario_id) VALUES (?)");
            $stmt->execute([$usuario_id]);
        } elseif ($tipo_usuario === 'empresa') {
            $stmt = $conn->prepare("INSERT INTO empresas (usuario_id) VALUES (?)");
            $stmt->execute([$usuario_id]);
        }
        
        $conn->commit();
        $_SESSION['cadastro_sucesso'] = "Cadastro de " . $tipo_usuario . " realizado com sucesso!";
        header("Location: " . BASE_DIR . "/app/views/auth.php");
        exit();
    } catch (PDOException $e) {
        $conn->rollBack();
        $_SESSION['cadastro_erro'] = "Erro ao cadastrar. Tente novamente ou entre em contato com o suporte.";
        error_log("Erro no cadastro: " . $e->getMessage());
        header("Location: " . BASE_DIR . "/app/views/auth.php");
        exit();
    }
} else {
    header("Location: " . BASE_DIR . "/app/views/auth.php");
    exit();
}
?>