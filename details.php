<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";

session_start();
$conn = mysqli_connect($servername, $username, $password, $dbname);
if(! $conn ) {
    die('Could not connect: ' . mysqli_connect_error($conn));
 }
 
 echo 'Connected successfully<br>';

$sql = 'SELECT id, name, email, gender, receive_emails FROM users';
mysqli_select_db($conn,$dbname);
$result = mysqli_query($conn,$sql );

//delete row
if (isset($_GET['delete'])) {
    $id_to_delete = intval($_GET['delete']); 

    $delete_sql = "DELETE FROM users WHERE id = $id_to_delete";
    if (mysqli_query($conn, $delete_sql)) {
        echo '<div class="alert alert-success">User deleted successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error deleting user: ' . mysqli_error($conn) . '</div>';
    }
}

// echo 'Connected successfully<br>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $receive_emails = isset($_POST['receive_emails']) ? 'Subscribed' : 'Unsubscribed';


$sql = "INSERT INTO users (name, email, gender, receive_emails) 
        VALUES ('$name', '$email', '$gender', '$receive_emails')";

    $retval = mysqli_query( $conn,$sql );
    

    if(! $retval ) {
       die('Could not insert to table: ' . mysqli_connect_error($retval));
    }
     
    echo "<br>Data inserted to table successfully\n";
}


mysqli_close($conn);



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Users Details</h1>
            <a href="demo.php" class="btn btn-success" >Add New User</a>
        </div>
        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Mail Status</th>
                    <th colspan="3">Action</th>
           

            </thead>
            <tbody>
                <?php   if (mysqli_num_rows($result) > 0) {
                   
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['gender']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['receive_emails']) . '</td>';
                        echo '<td><a href="view.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm"><i class="fa-solid fa-eye"></i></a></td>';
                        echo '<td><a href="demo.php?id=' . htmlspecialchars($row['id']) . '" class="btn btn-sm "><i class="fa-solid fa-pen"></i> </a></td>';
                        echo '<td><a href="details.php?delete='.  $row['id'] .'" class="btn btn-sm "><i class="fa-solid fa-trash"></i></a></td>';

                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6" class="text-center">No users found</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
