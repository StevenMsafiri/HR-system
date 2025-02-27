<?php
require_once '../db_config.php';

header("Content-Type: application/json");

if (isset($_GET['zone'])) {
       $zone = $_GET['zone'];
        try {
        
            $stmt = $conn->prepare("SELECT department_name, dept_id FROM Departments WHERE zone = ?");
            $stmt->execute([strval($zone)]);
            $departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($departments);
        } catch (PDOException $e) {
            echo json_encode([]);


        }
    }
?>
