<?php

// This gets the sections of a department selected by the hr while registering an employee
require_once '../db_config.php';

header("Content-Type: application/json");

if (isset($_GET['department'])) {
        $department = $_GET['department'];
    
        try {
    
            $stmt = $conn->prepare("SELECT id FROM departments WHERE name = ?");
            $stmt->execute([$department]);
            $id = $stmt->fetch(PDO::FETCH_COLUMN);
    
            $stmt = $conn->prepare("SELECT name FROM sections WHERE department_id = ?");
            $stmt->execute([$id]);
            $sections = $stmt->fetchAll(PDO::FETCH_COLUMN);

            echo json_encode($sections);
        } catch (PDOException $e) {
            echo json_encode([]);
        }
    }
?>