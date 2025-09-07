<?php
require_once __DIR__ . '/../utils/init.php';

// Redireciona se a requisição não for POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

$action = $_POST['action'] ?? '';

if ($action === 'apply') {
    $vaga_id = $_POST['vaga_id'] ?? null;
    $candidato_id = $_SESSION['usuario_id'] ?? null;

    if (!$vaga_id || !$candidato_id) {
        $_SESSION['candidatura_erro'] = "Dados de candidatura incompletos.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $candidaturaModel = new Candidatura();

    // Verifica se o candidato já se candidatou a essa vaga
    if ($candidaturaModel->checkIfAlreadyApplied($candidato_id, $vaga_id)) {
        $_SESSION['candidatura_erro'] = "Você já se candidatou para esta vaga.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    // Lida com o upload do currículo
    $curriculo_path = null;
    if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../../public/uploads/curriculos/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $curriculo_name = uniqid('cv_') . '_' . basename($_FILES['curriculo']['name']);
        $curriculo_path = $upload_dir . $curriculo_name;
        
        if (!move_uploaded_file($_FILES['curriculo']['tmp_name'], $curriculo_path)) {
            $_SESSION['candidatura_erro'] = "Erro ao fazer upload do currículo.";
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } else {
        $_SESSION['candidatura_erro'] = "Por favor, selecione um currículo válido.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $mensagem = $_POST['mensagem'] ?? '';

    // Salva a candidatura no banco de dados
    if ($candidaturaModel->create($vaga_id, $candidato_id, $curriculo_name, $mensagem)) {
        $_SESSION['candidatura_sucesso'] = "Candidatura enviada com sucesso!";
        header('Location: ../views/vaga_detalhes.php?id=' . $vaga_id);
        exit();
    } else {
        $_SESSION['candidatura_erro'] = "Ocorreu um erro ao enviar a candidatura.";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}