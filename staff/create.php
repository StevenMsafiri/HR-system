<?php
require_once '../db_config.php';
$zones = [];

// checks if the post request is correct and receives user data
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $firstName = $_POST["Firstname"];
    $secondName = $_POST["Second-name"];
    $lastName = $_POST["Lastname"];
    $qualification = $_POST["Qualification"];
    $birthdate = $_POST["Birthdate"];
    $zone = $_POST["Zone"];
    $position = $_POST["Position"];
    $supervisor = $_POST["Supervisor"];
    $employedDate = $_POST["Employed-date"];
    $department = $_POST["Department"];
    $section = $_POST["Section"];

    try {

        $query = "INSERT INTO Employees (f_name, s_name, l_name, birth_date, qualification, zone_code, department_id, section_id, position,employed_date, reporting_to) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";

        $stmt = $conn->prepare($query);
        $res = $stmt->execute([$firstName, $secondName, $lastName, $birthdate, $qualification, $zone, $department, $section, $position, $employedDate, $supervisor ]);


        $conn = null;
        $stmt = null;
        header("Location: ./read_staff.php");

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
} else {
    try {
        $stmt = $conn->prepare("SELECT zone_name, zone_code FROM Zones");
        $stmt->execute();
        $result = $stmt->fetchAll();

        // print_r($result);

        foreach ($result as $row) {
      
                $zones[] = $row;
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
        <a href="./read_staff.php"  class="go-back">X</a>
        <form method="POST">
          <div class="form-content">
              <div class="title">Register Employee</div>
              <div class=" two">
                  <div class="input-box">
                      <label for="Firstname:">First Name:</label>
                      <input type="text" name="Firstname" id="" placeholder="First name" required>
                  </div>
                  <div class="input-box">
                      <label for="Second-name:">Second Name:</label>
                      <input type="text" name="Second-name" id="" placeholder="Second name" required>
                  </div>

                  <div class="input-box">
                      <label for="Lastname:"> Last Name:</label>
                      <input type="text" name="Lastname" id="" placeholder="Last name" required>
                  </div>

              </div>

              <div class="two">

                  <div class="input-box">
                      <label for="Qualification:">Qualification:</label>
                      <select type="text" name="Qualification" id="qualify">
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
                      <label for="Birthdate:">Birth Date:</label>
                      <input type="date" name="Birthdate" id="" placeholder="birthdate" required>
                  </div>

              </div>



              <div class="two">
                  <div class="input-box">
                      <label for="Zone">Zone:</label>
                      <?php
                      if (!empty($zones)) {
                          echo '<select name="Zone" id="zone">';
                          echo '<option selected> Select a Zone </option>';
                          foreach ($zones as $zone) {
                              echo '<option value="' . htmlspecialchars($zone['zone_code']) . '">' . htmlspecialchars($zone['zone_name']) . '</option>';
                          }
                          echo '</select>';
                      } else {
                          echo '<input type="text" name="Zone" placeholder="Zone" required>';
                      }
                      ?>
                  </div>

                  <div class="input-box">
                      <label for="Department">Department:</label>
                      <select name="Department" id="dept" required>
                          <option value="">Select a Department</option>
                      </select>
                  </div>

                  <div class="input-box">
                      <label for="Section">Section:</label>
                      <select name="Section" id="section" required>
                          <option value="">Select a section</option>
                      </select>
                  </div>

              </div>


              <div class="two">
        

              </div>

              <div class="two">

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
                      <label for="Supervisor:">Reporting to:</label>
                      <input type="text" name="Supervisor" id="leader" placeholder="Reporting to">
                  </div>

                  <div class="input-box">
                      <label for="Employed-date:">Employed-date:</label>
                      <input type="date" name="Employed-date" id="" placeholder="employed-date" required>
                  </div>

              </div>

              <div class="form-actions">
                  <button type="reset">Clear</button>
                  <button type="submit" id="create-btn">Create</button>
              </div>
          </div>
        </form>
    </div>
</body>

</html>

<script src="../js/jquery-3.7.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#zone').on('change', function() {
            var zone = $(this).val()
            if (zone) {
                $.getJSON('../includes/getDepartments.php', {
                    zone:zone
                    
                }, function(data) {
                    $('#dept').empty(); // Clear existing options
                    $('#dept').append('<option value="">Select a Department</option>'); // Default option

                    $.each(data, function(key, value) {
                        $('#dept').append('<option value="' + value['dept_id'] + '">' + value['department_name'] + '</option>');
                    });
                });
            } else {
                $('#dept').empty();
                $('#dept').append('<input type="text" name="Department">');
            }

        });


        $('#dept').on('change', function(){
            var department = $(this).val()
            if(department){
                $.getJSON('../includes/getSections.php',{
                   department:department
                },
            function(data){
                $.each(data, function(key, value) {
                    alert(value)
                        $('#section').append('<option value="' + value['sect_id'] + '">' + value['section_name'] + '</option>');
                    });
                })
            }else {
                $('#section').empty();
                $('#section').append('<input type="text" name="Department">');
            }
        });
    });

</script>