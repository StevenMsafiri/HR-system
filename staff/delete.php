<?php

require "../db_config.php";
// echo $_SERVER['REQUEST_METHOD'];

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    // echo $_SERVER['REQUEST_METHOD'];
    // echo $_GET['id'];

    if(!isset($_GET["id"])){
        header("location: ../read_staff.php");
        exit();}

        $id = $_GET["id"];
        try {

            $stmt = $conn->prepare("DELETE FROM Employees WHERE id = :id");
            $stmt->execute(['id' => $id]);
            header("location: ./read_staff.php");
            exit();
             
        } catch (PDOException $e) { 
            die("Query failed: " . $e->getMessage());
        }

}
?>