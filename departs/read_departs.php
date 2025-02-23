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
    <h2>Departments</h2>
    <a href="./create.php" class="create-btn">Add Department</a>    
        <table class="table">
            <thead>
                <tr>
                    <th>Department ID</th>
                    <th>Name</th>
                    <th>Manager's ID</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php

                try {
                    require_once "../db_config.php";

                    $query = "SELECT * FROM departments";
                    $data = $conn->query($query, PDO::FETCH_ASSOC);

                    if (!$data) {
                        die("No departments found");
                    } else {

                        while ($row = $data->fetch()) {
                            echo "
                            <tr class='horizontal'>
                            <td> $row[id]</td>
                            <td> $row[name]</td>
                            <td>$row[manager_id]</td>
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