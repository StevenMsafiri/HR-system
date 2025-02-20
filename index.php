<?php
require_once './db_config.php';

// header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD']=='GET'){

    // require_once '../db_config.php';

    // header("Content-Type: application/json");
    
    // if (isset($_GET['section'])) {
    //     $section = $_GET['section'];
    
        try {
            $stmt = $conn->prepare("SELECT last_name FROM Employees WHERE section = ? AND position = ?");
            $stmt->execute(['IT', 'Supervisor']);
            $supervisors = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo $supervisors;
            print_r($supervisors);

            echo $supervisors[0];
        } catch (PDOException $e) {
            echo $e;
        }
    }
// }
?>