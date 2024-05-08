<?php

class Tarefas {
    private $conn;
    private $table_name = 'tarefas';

    public $id;
    public $id_usuario;
    public $titulo;
    public $descricao;

    public function __construct($db){
        $this->conn = $db;
    }

    // Criar tarefas
    public function create() {
        $query = 'INSERT INTO ' . $this->table_name . ' SET titulo = :titulo, descricao = :descricao, id_usuario = :id_usuario';
        $stmt = $this ->conn->prepare($query);

        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));
        
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // Ler tarefas
    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obter tarefas pelo ID
    public function getTaskById($id){
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->titulo = $row['titulo'];
            $this->descricao = $row['descricao'];
            $this->id_usuario = $row['id_usuario'];
            return $row;
        }
        return []; 
    }

    // Obter tarefas de um usuario
    public function getTaskUserById($id_usuario) {
        $query = 'SELECT * FROM ' . $this->table_name . ' WHERE id_usuario = :id_usuario';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $this->titulo = $row['titulo'];
            $this->descricao = $row['descricao'];
            $this->id_usuario = $row['id_usuario'];
            return $row;
        }
        return [];
    }

    //atualizar tarefas
    public function update(){
        $query = 'UPDATE ' . $this->table_name . ' SET titulo = :titulo, descricao = :descricao, id_usuario = :id_usuario WHERE id = :id';
        $stmt= $this->conn->prepare($query);

        $this->id  = htmlspecialchars(strip_tags($this->id));
        $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
        $this->titulo = htmlspecialchars(strip_tags($this->titulo));
        $this->descricao = htmlspecialchars(strip_tags($this->descricao));

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':id_usuario', $this->id_usuario);
        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':descricao', $this->descricao);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // deletar tarefas
    public function remove(){
        $query = 'DELETE FROM ' . $this->table_name . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}