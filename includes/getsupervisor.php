<?php
require_once '../db_config.php';

header("Content-Type: application/json");

if (isset($_GET['section'])) {
    $section = $_GET['section'];

    try {
        $stmt = $conn->prepare("SELECT last_name FROM Employees WHERE section = ? AND position = ?");
        $stmt->execute([$section, 'Supervisor']);
        $supervisors = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo json_encode($supervisors);
    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>
