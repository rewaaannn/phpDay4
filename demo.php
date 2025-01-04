<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "user_registration";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if(! $conn ) {
   die('Could not connect: ' . mysqli_connect_error($conn));
}

echo 'Connected successfully<br>';
$name = $email = $gender = $receive_emails = "";
$id = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $receive_emails = isset($_POST['receive_emails']) ? 'Subscribed' : 'Unsubscribed';

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        
        $id = $_POST['id'];
        $sql = "UPDATE users SET name = '$name', email = '$email', gender = '$gender', receive_emails = '$receive_emails' WHERE id = $id";
    } else {
      
        $sql = "INSERT INTO users (name, email, gender, receive_emails) VALUES ('$name', '$email', '$gender', '$receive_emails')";
    }

    $retval = mysqli_query($conn, $sql);

    if (!$retval) {
        die('Could not perform the operation: ' . mysqli_error($conn));
    }

    echo "<br>Operation performed successfully\n";
    header("Location: details.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $user = mysqli_fetch_assoc($result);
        $name = $user['name'];
        $email = $user['email'];
        $gender = $user['gender'] == 'Subscribed' ? 'checked' : '';
        $receive_emails = $user['receive_emails'] ? 'Subscribed' : 'Unsubscribed';
    }
}



    mysqli_close($conn);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header text-center ">
                        <h4>User Registration Form</h4>
                    </div>
                    <div class="card-body">
                        <form action="details.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo $name; ?>"  placeholder="Enter your name" required>
                            </div>
                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>"   placeholder="Enter your email" required>
                            </div>
                            <!-- Gender Field -->
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="female"  value="Female" <?php echo ($gender == 'Female' ? 'checked' : ''); ?>   required>
                                        <label class="form-check-label" for="female" >Female</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="gender" id="male"  value="male" <?php echo ($gender == 'male' ? 'checked' : ''); ?>  required>
                                        <label class="form-check-label" for="male" >Male</label>
                                    </div>
                                </div>
                            </div>
                            <!-- Receive Emails Field -->
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="receive_emails" name="receive_emails" <?php echo $receive_emails; ?>>      
                                <label class="form-check-label" for="receive_emails" >Receive E-Mails from us</label>
                            </div>
                            <!-- Buttons -->
                            <div class="">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="reset" class="btn btn-secondary">Cancel</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>