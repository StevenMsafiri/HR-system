<?php
require_once '../db_config.php';
$departments = [];

// checks if the post request is correct and receives user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST["Firstname"];
    $secondName = $_POST["Second-name"];
    $lastName = $_POST["Lastname"];
    $qualification = $_POST["Qualification"];
    $birthdate = $_POST["Birthdate"];
    $position = $_POST["Position"];
    $supervisor = $_POST["Supervisor"];
    $employedDate = $_POST["Employed-date"];
    $department = $_POST["Department"];
    $section = $_POST["Section"];

    try {

        $query = "INSERT INTO Employees (first_name, second_name, last_name, birth_date, qualification, position, department, employedDate, section) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($query);
        $res = $stmt->execute([$firstName, $secondName, $lastName, $birthdate, $qualification, $position, $department, $employedDate, $section]);

        if($position == 'Manager' || $position == 'Supervisor'){

            $query = " SELECT id FROM Employees WHERE position = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$position]);
            $id = $stmt->fetch(PDO::FETCH_COLUMN);
            echo $id;

            switch($position){
                case "Manager":
                    $query = "UPDATE departments SET manager_id = ? WHERE name = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$id, $department]);
                    break;

                case "Supervisor":
                    $query = "UPDATE sections SET supervisor_id = ? WHERE name = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$id, $section]);
                    break;

            }
        }

        $conn = null;
        $stmt = null;
        header("Location: ../staffs.php");

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    try {
        $stmt = $conn->prepare("SELECT name FROM departments");
        $stmt->execute();
        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            $departments[] = $row['name']; // Store department names in the array
        }
    } catch (PDOException $e) {
        echo "Error fetching departments: " . $e->getMessage();
    }
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
                    <select type="text" name="Qualification">
                        <option value="" selected>Select qualification</option>
                        <option value="Certificate" class="value">Certificate</option>
                        <option value="Diploma" class="value">Diploma</option>
                        <option value="Bachelor" class="value">Bachelor</option>
                        <option value="Masters" class="value">Masters</option>
                        <option value="PhD" class="value">PhD</option>
                        <option value="Other" class="value">Other</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="Birthdate:">Birthdate:</label>
                    <input type="date" name="Birthdate" id="" placeholder="birthdate" required>
                </div>

                <div class="input-box">
                    <label for="Department">Department:</label>
                    <?php
                    if (!empty($departments)) {
                        echo '<select name="Department" id="dept" required>';
                        foreach ($departments as $dept) {
                            echo '<option value="' . htmlspecialchars($dept) . '">' . htmlspecialchars($dept) . '</option>';
                        }
                        echo '</select>';
                    } else {
                        echo '<input type="text" name="Department" placeholder="Department" required>';
                    }
                    ?>
                </div>

                <div class="input-box">
                    <label for="Section">Section:</label>
                    <select name="Section" id="section" required>
                        <option value="">Select a section</option>
                    </select>
                </div>

                <div class="input-box">
                    <label for="Position:"> Position:</label>
                    <select type="text" name="Position" id="pos">
                        <option value="" selected>Select a position</option>
                        <option value="Manager" class="value">Manager</option>
                        <option value="Supervisor" class="value">Supervisor</option>
                        <option value="Other" >Other</option>
                    </select>
                </div>

                <div class="input-box" id="super">
                    <label for="Supervisor:">Supervisor:</label>
                    <input type="text" name="Supervisor" id="leader" placeholder="supervisor">
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

<script src="../js/jquery-3.7.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dept').on('change', function() {
            var department = $(this).val()
    
            if (department) {
                $.getJSON('../includes/getsections.php', {
                    department: department
                }, function(data) {
                    $('#section').empty(); // Clear existing options
                    $('#section').append('<option value="">Select a section</option>'); // Default option

                    $.each(data, function(key, value) {
                        $('#section').append('<option value="' + value + '">' + value + '</option>');
                    });
                });
            } else {
                $('#section').empty();
                $('#section').append('<input type="text" name="Section">');
            }

        });


        $('#pos').on('change', function(){
            var position = $(this).val()
            var section = $('#section').val()
            if(position == "Manager"|| position == "Supervisor"){
                $('#super').hide()

            }else{
                $('#super').show()
                $.getJSON('../includes/getsupervisor.php',{
                   section:section
                },
            function(data){
            
            if (data.length > 0) {
                $('#leader').val(data[0]); 
                // alert(data)
            } else {
                $('#leader').val(''); 
            }
            }
            
            )
            }
        });





    });
</script>