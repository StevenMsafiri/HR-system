
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
    <h2>Department Sections</h2>
    <a href="./create.php" class="create-btn">Add Section</a>    
        <table class="table">
            <thead>
                <tr>
                    <th>Section ID</th>
                    <th>Name</th>
                    <th>Department ID</th>
                    <th>Supervisor ID</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>
                <?php

                try {
                    require_once "../db_config.php";

                    $query = "SELECT * FROM sections";
                    $data = $conn->query($query, PDO::FETCH_ASSOC);

                    if (!$data) {
                        die("No sections");
                    } else {

                        while ($row = $data->fetch()) {
                            echo "
                            <tr class='horizontal'>
                            <td> $row[id]</td>
                            <td> $row[name]</td>
                            <td>$row[department_id]</td>
                            <td> $row[supervisor_id]</td>
                            <td> <a href='./edit.php?id=$row[id]' class='update-btn'>Edit</a>
                                 <a href='./delete.php?id=$row[id]' class='clear-btn'>Delete</a>
                            </td>
                            </tr>
                            </tbody>";
                        }
                    }
                } catch (PDOException $e) {
                    $error = $e->getMessage();
                    die("<p> Query failed: .$error </p>");
                }

                ?>

        </table>
    </div>

</body>

</html>