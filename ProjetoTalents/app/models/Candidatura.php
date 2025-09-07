<?php
// Arquivo: app/models/Candidatura.php

class Candidatura {
    private $conn;

    public function __construct() {
        $this->conn = getDbConnection();
    }

    public function create($vaga_id, $candidato_id) {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM candidaturas WHERE vaga_id = ? AND candidato_id = ?");
            $stmt->execute([$vaga_id, $candidato_id]);
            if ($stmt->fetchColumn() > 0) {
                return false; // Candidatura já existe
            }
            
            $stmt = $this->conn->prepare("INSERT INTO candidaturas (vaga_id, candidato_id) VALUES (?, ?)");
            return $stmt->execute([$vaga_id, $candidato_id]);
        } catch(PDOException $e) {
            error_log("Erro ao criar candidatura: " . $e->getMessage());
            return false;
        }
    }

    public function findByCandidatoId($candidato_id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.id, c.data_candidatura, v.titulo, v.localizacao
                FROM candidaturas c
                JOIN vagas v ON c.vaga_id = v.id
                WHERE c.candidato_id = ?
                ORDER BY c.data_candidatura DESC
            ");
            $stmt->execute([$candidato_id]);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Erro ao buscar candidaturas por candidato: " . $e->getMessage());
            return [];
        }
    }

    public function findByVagaId($vaga_id) {
        try {
            $stmt = $this->conn->prepare("
                SELECT c.id, c.data_candidatura, u.nome, u.email
                FROM candidaturas c
                JOIN usuarios u ON c.candidato_id = u.id
                WHERE c.vaga_id = ?
                ORDER BY c.data_candidatura DESC
            ");
            $stmt->execute([$vaga_id]);
            return $stmt->fetchAll();
        } catch(PDOException $e) {
            error_log("Erro ao buscar candidaturas por vaga: " . $e->getMessage());
            return [];
        }
    }
}
?>