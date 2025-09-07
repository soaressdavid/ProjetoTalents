<?php
// Arquivo: app/controllers/VagaController.php

require_once __DIR__ . '/../utils/init.php';

// Redireciona se a requisição não for POST ou se o usuário não for uma empresa
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $_SESSION['usuario_tipo'] !== 'empresa') {
    // Redireciona para a página anterior, se existir.
    header('Location: ' . $_SERVER['HTTP_REFERER'] ?? BASE_DIR);
    exit();
}

$action = $_POST['action'] ?? '';

// Lógica para criar uma nova vaga
if ($action === 'create') {
    // Garante que o ID do usuário é válido e é do tipo correto
    $empresa_id = filter_var($_SESSION['usuario_id'], FILTER_VALIDATE_INT);
    if ($empresa_id === false) {
        $_SESSION['vaga_erro'] = "ID da empresa inválido na sessão.";
        header('Location: ' . BASE_DIR . '/app/views/criar_vaga.php');
        exit();
    }

    $vagaModel = new Vaga();
    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $requisitos = $_POST['requisitos'] ?? '';
    $localizacao = $_POST['localizacao'] ?? '';

    if (empty($titulo) || empty($descricao) || empty($localizacao) || empty($requisitos)) {
        $_SESSION['vaga_erro'] = "Por favor, preencha todos os campos obrigatórios.";
        header('Location: ' . BASE_DIR . '/app/views/criar_vaga.php');
        exit();
    }

    if ($vagaModel->create($titulo, $descricao, $requisitos, $localizacao, $empresa_id)) {
        $_SESSION['vaga_sucesso'] = "Vaga publicada com sucesso!";
        header('Location: ' . BASE_DIR . '/app/views/gerenciar_vagas.php');
        exit();
    } else {
        $_SESSION['vaga_erro'] = "Ocorreu um erro ao publicar a vaga.";
        header('Location: ' . BASE_DIR . '/app/views/criar_vaga.php');
        exit();
    }
}

// Lógica para deletar uma vaga
if ($action === 'delete') {
    $vagaModel = new Vaga();
    $vaga_id = $_POST['id'] ?? null;
    $empresa_id = $_SESSION['usuario_id'];

    // Verifique se a vaga pertence à empresa logada
    $vaga = $vagaModel->findById($vaga_id);
    if (!$vaga || $vaga['empresa_id'] != $empresa_id) {
        $_SESSION['vaga_erro'] = "Você não tem permissão para deletar esta vaga.";
        header('Location: ' . BASE_DIR . '/app/views/gerenciar_vagas.php');
        exit();
    }

    if ($vagaModel->delete($vaga_id)) {
        $_SESSION['vaga_sucesso'] = "Vaga deletada com sucesso!";
        header('Location: ' . BASE_DIR . '/app/views/gerenciar_vagas.php');
        exit();
    } else {
        $_SESSION['vaga_erro'] = "Ocorreu um erro ao deletar a vaga.";
        header('Location: ' . BASE_DIR . '/app/views/gerenciar_vagas.php');
        exit();
    }
}
?>
