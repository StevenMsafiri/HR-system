<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/staffs.css">
    <title>Staffs</title>
</head>

<body>
    <div class="container-staff">
    <h2>List of Employees</h2>
    <a href="./create.php" class="create-btn">Add Employee</a>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Second Name</th>
                    <th>Last Name</th>
                    <th>Birth Date</th>
                    <th>Qualification</th>
                    <th>Department</th>
                    <th>Section</th>
                    <th>Position</th>
                    <th>Date of Employment</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php

                try {
                    require_once "../db_config.php";

                    $query = "SELECT * FROM Employees";
                    $data = $conn->query($query, PDO::FETCH_ASSOC);

                    if (!$data) {
                        die("No staff found");
                    } else {

                        while ($row = $data->fetch()) {
                            echo "
                            <tr class='horizontal'>
                            <td> $row[id]</td>
                            <td> $row[first_name]</td>
                            <td>$row[second_name]</td>
                            <td> $row[last_name]</td>
                            <td> $row[birth_date]</td>
                            <td> $row[qualification]</td>
                            <td> $row[department]</td>
                            <td> $row[section]</td>
                            <td> $row[position]</td>
                            <td> $row[employedDate]</td>
                            <td> <a href='./edit.php?id=$row[id]' class='update-btn'>Edit</a>
                                 <a href='./delete.php?id=$row[id]' class='clear-btn'>Delete</a>
                            </td>
                            </tr>
                            </tbody>";
                        }
                    }
                } catch (PDOException $e) {
                    die("Query failed: " . $e->getMessage());
                }

                ?>

        </table>
    </div>

</body>

</html>