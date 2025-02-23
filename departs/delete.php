<?php

require "../db_config.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(!isset($_GET["id"])){
        header("location: ./read_departs.php");
        exit();}

        $id = $_GET["id"];
        try {

            $stmt = $conn->prepare("DELETE FROM departments WHERE id = :id");
            $stmt->execute(['id' => $id]);
            header("location: ./read_departments.php");
            exit();
             
        } catch (PDOException $e) { 
            die("Query failed: " . $e->getMessage());
        }
}
?>