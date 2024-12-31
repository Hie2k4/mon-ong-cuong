<?php
class News {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getAllNews() {
        $stmt = $this->conn->query("SELECT * FROM news ORDER BY id DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getNewsOne($id){
        $stmt = $this->conn->prepare("SELECT * FROM news WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>