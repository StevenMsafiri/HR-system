<?php
require_once './db_config.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD']=='GET'){

// if (isset($_GET['department'])) {
//     $department = $_GET['department'];

    try {

        $stmt = $conn->prepare("SELECT id FROM departments WHERE name = ?");
        $stmt->execute(['Production']);
        $id = $stmt->fetch(PDO::FETCH_COLUMN);
        // echo $id;
        // echo json_encode($id);

        $stmt = $conn->prepare("SELECT name FROM sections WHERE department_id = ?");
        $stmt->execute([$id]);
        $sections = $stmt->fetchAll(PDO::FETCH_COLUMN);
        // print_r($sections);
        echo json_encode($sections);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>