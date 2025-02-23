<?php
require_once "../db_config.php";

if($_SERVER['REQUEST_METHOD']=="POST"){

    $sId = $_POST["id"];
    $name = $_POST["name"];
    $department_id = $_POST["department"];
    $supervisor_id= $_POST["Supervisor"];

        do{
            if(empty($name) || empty($department_id)){
            
                echo "All fields are required";
                break;
            }

            try{
                
                  $sql = "INSERT INTO sections(name, department_id, supervisor_id) VALUES (?, ?, ?)";
           
                  $stmt = $conn->prepare($sql);
                  $result = $stmt->execute([$name, $department_id, $supervisor_id]);

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
    <title>Create Section</title>
</head>
<body>
<div class="container-reg">
    <form method="POST">
        <div class="form-info">
        <div class="input-box">
            <label for="name:">name:</label>
            <input type="text" name="name" >
        </div>
        <div class="input-box">
            <label for="department:">Department_id:</label>
            <input type="number" name="department">
        </div>

        <div class="input-box">
            <label for="supervisor:"> Supervisor_id:</label>
            <input type="number" name="supervisor">
        </div>


        <div class="input-box" id="btn">
            <button type="submit" id="save-btn" class="btn">Create</button>
        </div>

        </div>


    </form>
</div>
</body>
</html>