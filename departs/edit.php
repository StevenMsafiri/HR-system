<?php
$dId = 0;
$name = "";
$manager_id = 0;

require "../db_config.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){


    //checks if the id is passed in the get request
    if(!isset($_GET["id"])){
        header("location: ./read_departs.php");
        exit();}

        $id = $_GET["id"];
        try {

            $stmt = $conn->prepare("SELECT * FROM departments WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
            
            if ($row) {
                $dId = $row["id"];
                $name = $row["name"];
                $manager_id = $row["manager_id"];

            }else {
                echo "No department found.";
                header("Location: ./read_departs.php");
                exit();}

             } catch (PDOException $e) { 
            die("Query failed: " . $e->getMessage());
        }
    }else{

        $dId = $_POST["id"];
        $name = $_POST["name"];
        $manager_id = $_POST["department"];

            do{
                if( empty($dId) || empty($name) || empty($manager_id)){
                
                    echo "All fields are required";
                    break;
                }

                try{
                    
                      $sql = "UPDATE Employees SET name ='$name', deparment_id = '$manager_id' WHERE id = $dId";
               
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
    <title>Upadate Department</title>
</head>
<body>
<div class="container-reg">
    <form method="POST">
        <div class="title">Update Department <span><input type="hidden" name="id" value="<?php echo $dId?>"></span></div>
        <br>
        <div class="form-info">
        <div class="input-box">
            <label for="name:">name:</label>
            <input type="text" name="name" value="<?php echo $name?>" >
        </div>
        
        <div class="input-box">
            <label for="manager:"> Manager_id:</label>
            <input type="number" name="manager" value="<?php echo $manager_id?>">
        </div>


        <div class="input-box" id="btn">
            <button type="submit" id="save-btn" class="btn">Save</button>
            <a href="./read_departs.php" id="cancel-btn" class="btn"> Cancel </a>
        </div>

        </div>


    </form>
</div>
</body>
</html>


