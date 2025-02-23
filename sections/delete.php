<?php

require "../db_config.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(!isset($_GET["id"])){
        header("location: ./read_staff.php");
        exit();}

        $id = $_GET["id"];
        try {

            $stmt = $conn->prepare("DELETE FROM sections WHERE id = :id");
            $stmt->execute(['id' => $id]);
            header("location: ./read_staff.php");
            exit();
             
        } catch (PDOException $e) { 
            die("Query failed: " . $e->getMessage());
        }
}
?>