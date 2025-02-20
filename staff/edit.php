<?php
$uId = 0;
$first = "";
$second ="";
$last = "";
$bdate = "";
$qualif = "";
$position = "";
$depart = "";
$sect = "";
$e_date = "";

require "../db_config.php";

if($_SERVER['REQUEST_METHOD'] == 'GET'){


    //checks if the id is passed in the get request
    if(!isset($_GET["id"])){
        header("location: ./read_staff.php");
        exit();}

        $id = $_GET["id"];
        try {

            $stmt = $conn->prepare("SELECT * FROM Employees WHERE id = :id");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as an associative array
            
            if ($row) {
                // print_r($row);

                $uId = $row["id"];
                $first = $row["first_name"];
                $second = $row["second_name"];
                $last = $row["last_name"];
                $bdate = $row["birth_date"];
                $qualif = $row["qualification"];
                $position = $row["position"];
                $depart = $row["department"];
                $sect = $row["section"];
                $e_date = $row["employedDate"];


            }else {
                echo "No employee found.";
                header("Location: ./read_staff.php");
                exit();}

             } catch (PDOException $e) { 
            die("Query failed: " . $e->getMessage());
        }
    }else{

        $uId = $_POST["id"];
        $first = $_POST["Firstname"];
        $second = $_POST["Second-name"];
        $last = $_POST["Lastname"];
        $bdate = $_POST["Birthdate"];
        $qualif = $_POST["Qualification"];
        $position = $_POST["Position"];
        $depart = $_POST["Department"];
        $sect = $_POST["Section"];
        $e_date = $_POST["Employed-date"];
        
            do{
                if( empty($uId) || empty($first) || empty($second) || empty($last)
                || empty($bdate) || empty($qualif) || empty($position) || empty($depart) || empty($sect) || empty($e_date) ){
                
                    echo "All fields are required";
                    break;
                }

                try{
                    
                      $sql = "UPDATE Employees SET first_name='$first', second_name='$second', last_name='$last', birth_date='$bdate', qualification='$qualif',
                      position='$position', department='$depart', section='$sect', employedDate='$e_date' WHERE id = $uId";
               
                      $result = $conn->query($sql);
                      header("Location: ./read_staff.php");
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
        <div class="title">Update employee <span><input type="hidden" name="id" value="<?php echo $uId?>"></span></div>
        <br>
        <div class="employee-info">
        <div class="input-box">
            <label for="Firstname:">First name:</label>
            <input type="text" name="Firstname" value="<?php echo $first?>" >
        </div>
        <div class="input-box">
            <label for="Second-name:">Second name:</label>
            <input type="text" name="Second-name" value="<?php echo $second?>">
        </div>

        <div class="input-box">
            <label for="Lastname:"> Last name:</label>
            <input type="text" name="Lastname" value="<?php echo $last?>">
        </div>

        <div class="input-box">
        <label for="Qualification:">Qualification:</label>
        <input type="text" name="Qualification" value="<?php echo $qualif?>">
        </div>


        <div class="input-box">
            <label for="Birthdate:">Birthdate:</label>
            <input type="text" name="Birthdate" value="<?php echo $bdate?>" >
        </div>

        <div class="input-box">
            <label for="Position:"> Position:</label>
            <input type="text" name="Position" value="<?php echo $position?>">
        </div>

        <div class="input-box">
            <label for="Department:">Department:</label>
            <input type="text" name="Department" value="<?php echo $depart?>">
        </div>

        <div class="input-box">
            <label for="Section:">Section:</label>
            <input type="text" name="Section" value="<?php echo $sect?>">
        </div>

        <div class="input-box">
            <label for="Supervisor:">Supervisor:</label>
            <input type="text" name="Supervisor" value="<?php echo "echo"?>">
        </div>

        <div class="input-box">
            <label for="Employed-date:">Employed-date:</label>
            <input type="text" name="Employed-date" value="<?php echo $e_date?>">
        </div>

        <div class="input-box" id="btn">
            <button type="submit" id="save-btn" class="btn">Save</button>
            <a href="./read_staff.php" id="cancel-btn" class="btn"> Cancel </a>
        </div>

        </div>


    </form>
</div>
</body>
</html>


