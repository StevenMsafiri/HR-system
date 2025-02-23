<?php
$sId = 0;
$name = "";
$department_id = 0;
$supervisor_id= 0;

require "../db_config.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){


    //checks if the id is passed in the get request
    if(!isset($_GET["id"])){
        header("location: ./read_staff.php");
        exit();}

        $id = $_GET["id"];
        try {

            $stmt = $conn->prepare("SELECT * FROM sections WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
            
            if ($row) {
                $sId = $row["id"];
                $name = $row["name"];
                $department_id = $row["department_id"];
                $supervisor_id= $row["supervisor_id"];

            }else {
                echo "No employee found.";
                header("Location: ./read_sections.php");
                exit();}

             } catch (PDOException $e) { 
            die("Query failed: " . $e->getMessage());
        }
    }else{

        $sId = $_POST["id"];
        $name = $_POST["name"];
        $department_id = $_POST["department"];
        $supervisor_id= $_POST["Supervisor"];

            do{
                if( empty($sId) || empty($name) || empty($department_id) || empty($supervisor_id)){
                
                    echo "All fields are required";
                    break;
                }

                try{
                    
                      $sql = "UPDATE Employees SET name ='$name', deparment_id = '$department_id', supervisor_id = $supervisor_id WHERE id = $sId";
               
                      $result = $conn->query($sql);
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
    <title>Upadate Staffs</title>
</head>
<body>
<div class="container-reg">
    <form method="POST">
        <div class="title">Update employee <span><input type="hidden" name="id" value="<?php echo $sId?>"></span></div>
        <br>
        <div class="form-info">
        <div class="input-box">
            <label for="name:">name:</label>
            <input type="text" name="name" value="<?php echo $name?>" >
        </div>
        <div class="input-box">
            <label for="department:">Department_id:</label>
            <input type="number" name="department" value="<?php echo $department_id?>">
        </div>

        <div class="input-box">
            <label for="supervisor:"> Supervisor_id:</label>
            <input type="number" name="supervisor" value="<?php echo $supervisor_id?>">
        </div>


        <div class="input-box" id="btn">
            <button type="submit" id="save-btn" class="btn">Save</button>
            <a href="./read_sections.php" id="cancel-btn" class="btn"> Cancel </a>
        </div>

        </div>


    </form>
</div>
</body>
</html>


