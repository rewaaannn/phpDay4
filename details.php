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

if(! $result ) {
   die('Could not get data: ' . mysqli_connect_error($result));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $mail_status = isset($_POST['mail_status']) ? 'yes' : 'no';

    $_SESSION['users'][] = [
        'name' => $name,
        'email' => $email,
        'gender' => $gender,
        'mail_status' => $mail_status,
    ];
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
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($_SESSION['users'])): ?>
                    <?php foreach ($_SESSION['users'] as $index => $user): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['gender']) ?></td>
                            <td><?= htmlspecialchars($user['mail_status']) ?></td>
                            <td>
                                <button class="btn  btn-sm"><i class="fa-solid fa-eye"></i></button>
                                <button class="btn  btn-sm"><i class="fa-solid fa-pen"></i></button>
                                <button class="btn  btn-sm"><i class="fa-solid fa-trash"></i></button>
                                
                            </td> 
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No users added yet.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
