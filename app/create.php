<?php

// checks if the post request is correct and receives user data
if($_SERVER["REQUEST_METHOD"]== "POST"){

    $firstName = $_POST["Firstname"];
    $secondName = $_POST["Second-name"];
    $lastName = $_POST["Lastname"];
    $qualification = $_POST["Qualification"];
    $birthdate =$_POST["Birthdate"];
    $position = $_POST["Position"];
    $supervisor = $_POST["Supervisor"];
    $employedDate =$_POST["Employed-date"];
    $department = $_POST["Department"];
    $section = $_POST["Section"];

    try{
        require_once '../db_config.php';

        $query = "INSERT INTO Employees (first_name, second_name, last_name, birth_date, qualification, position, department, employedDate, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $res = $stmt->execute([$firstName, $secondName, $lastName, $birthdate ,$qualification, $position, $department, $employedDate, $section]);

        $conn = null;
        $stmt = null;

        header("Location: ../staffs.php");
        
        die();

        } catch(PDOException $e){
            die("Query failed: ".$e->getMessage());
            
        }

}else{
    // echo "errors";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Registration Form</title>
</head>
<body>
<div class="container-reg">
    <form method="POST">
        <div class="title">Register an employee</div>
        <br>
        <div class="employee-info">
        <div class="input-box">
            <label for="Firstname:">First name:</label>
            <input type="text" name="Firstname" id="" placeholder="First name" required>
        </div>
        <div class="input-box">
            <label for="Second-name:">Second name:</label>
            <input type="text" name="Second-name" id="" placeholder="Second name" required>
        </div>

        <div class="input-box">
            <label for="Lastname:"> Last name:</label>
            <input type="text" name="Lastname" id="" placeholder="Last name" required>
        </div>

        <div class="input-box">
        <label for="Qualification:">Qualification:</label>
            <select type="text" name="Qualification" style="width: 54%;">
                <option value="certificate" class="value">Certificate</option>
                <option value="diploma" class="value">Diploma</option>
                <option value="bachelor" class="value">Bachelor</option>
                <option value="masters" class="value">Masters</option>
                <option value="PhD" class="value">PhD</option>
                <option value="other" class="value">Other</option>
            </select>
        </div>

        <div class="input-box">
            <label for="Birthdate:">Birthdate:</label>
            <input type="date" name="Birthdate" id="" placeholder="birthdate" required>
        </div>


        <div class="input-box">
            <label for="Position:"> Position:</label>
            <input type="text" name="Position" id="" placeholder="position" required>
        </div>

        <div class="input-box">
            <label for="Department:">Department:</label>
            <input type="text" name="Department" id="" placeholder="department" required>
        </div>

        <div class="input-box">
            <label for="Section:">Section:</label>
            <input type="text" name="Section" id="" placeholder="section" required>
        </div>

        <div class="input-box">
            <label for="Supervisor:">Supervisor:</label>
            <input type="text" name="Supervisor" id="" placeholder="supervisor" required>
        </div>

        <div class="input-box">
            <label for="Employed-date:">Employed-date:</label>
            <input type="date" name="Employed-date" id="" placeholder="employed-date" required>
        </div>

        </div>

        <div class="input-box" id="btn">
            <button type="submit" id="reg-btn">Register</button>
        </div>
    </form>
</div>
</body>
</html>