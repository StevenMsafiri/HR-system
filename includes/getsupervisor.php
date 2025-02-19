<?php
require_once '../db_config.php';

header("Content-Type: application/json");

if (isset($_GET['section'])) {
    $section = $_GET['section'];

    try {
        $stmt = $conn->prepare("SELECT supervisor_name FROM employees WHERE section = ?");
        $stmt->execute([$section]);
        $supervisors = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode($supervisors);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>
