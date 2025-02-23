<?php
require_once "../db_config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){

        $dId = $_POST["id"];
        $name = $_POST["name"];
        $manager_id = $_POST["department"];

            do{
                if( empty($dId) || empty($name)){
                
                    echo "All fields are required";
                    break;
                }

                try{
                    
                    $sql = "INSERT INTO departments(name, manager_id) VALUES (?, ?)";
           
                    $stmt = $conn->prepare($sql);
                    $result = $stmt->execute([$name,  $manager_id]);
                      header("Location: ./read_sections.php");
                      die();

                     } catch(PDOException $error){

                        echo "Error: ".$error->getMessage();
                        break;
                     }


            }while (true);

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Upadate Department</title>
</head>
<body>
<div class="container-reg">
    <form method="POST">
        <div class="form-info">
        <div class="input-box">
            <label for="name:">name:</label>
            <input type="text" name="name">
        </div>
        <div class="input-box">
            <label for="department:">Department</label>
            <input type="number" name="department">
        </div>

        <div class="input-box">
            <label for="manager:"> Manager_id:</label>
            <input type="number" name="manager">
        </div>


        <div class="input-box" id="btn">
            <button type="submit" id="save-btn" class="btn">Create</button>
        </div>

        </div>


    </form>
</div>
</body>
</html>