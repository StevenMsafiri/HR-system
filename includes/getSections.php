<?php
require_once '../db_config.php';

$data = [];
header("Content-Type: application/json");

if (isset($_GET['department'])) {
    $department = $_GET['department'];

    try {
        $stmt = $conn->prepare("SELECT section_name, sect_id FROM Sections WHERE department_id = ?");
        $stmt->execute([intval($department)]);
        $sections = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($sections as $section) {

            $data[] = $section;
        }

        echo json_encode($data);

    } catch (PDOException $e) {
        echo json_encode([]);
    }
}
?>
