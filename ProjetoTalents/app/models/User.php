<?php
// Arquivo: app/models/User.php

class User {
    private $conn;

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function findByEmail($email) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário por email: " . $e->getMessage());
            return false;
        }
    }

    public function findById($id) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Erro ao buscar usuário por ID: " . $e->getMessage());
            return false;
        }
    }

    public function update($id, $nome, $email, $senha = null) {
        try {
            if ($senha) {
                $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([$nome, $email, $senha, $id]);
            } else {
                $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
                $stmt = $this->conn->prepare($sql);
                return $stmt->execute([$nome, $email, $id]);
            }
        } catch (PDOException $e) {
            error_log("Erro ao atualizar perfil: " . $e->getMessage());
            return false;
        }
    }
}
?>