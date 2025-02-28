<?php
// Database connection (update with your credentials)
$servername = "localhost";
$username = "root"; // Change if necessary
$password = ""; // Change if necessary
$dbname = "myshop"; // Change to your database name
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = "";
$email = "";
$phone = "";
$address = "";
$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (empty($name) || empty($email) || empty($phone) || empty($address)) {
        $error = "All fields are required";
    } else {
        // Check if email already exists
        $check_email_stmt = $conn->prepare("SELECT id FROM clients WHERE email = ?");
        $check_email_stmt->bind_param("s", $email);
        $check_email_stmt->execute();
        $check_email_stmt->store_result();

        if ($check_email_stmt->num_rows > 0) {
            $error = "This email is already registered";
        } else {
            // Proceed with inserting new client
            $stmt = $conn->prepare("INSERT INTO clients (name, email, phone, address) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $address);
            
            if ($stmt->execute()) {
                $success = "New client added successfully";
                $name = "";
                $email = "";
                $phone = "";
                $address = "";
            } else {
                $error = "Failed to add client";
            }
            $stmt->close();
        }
        $check_email_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>ADD CLIENT</title>
    <link rel="stylesheet" href="creat.css">

    </head>
<body>    
    <div class="container my-5">
        <h2>NEW CLIENT</h2>
        
        <?php if (!empty($error)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?= $error ?></strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class='alert alert-success alert-dismissible fade show' role='alert' id='successMessage'>
                <strong><?= $success ?></strong>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
                    <span aria-hidden='true'>&times;</span>
                </button>
            </div>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($phone) ?>">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($address) ?>">
            </div>
            <button type="submit" class="btn btn-primary">ADD CLIENT</button>
            <a class="btn btn-outline-primary" href="index.php" id="cancel">CANCEL ADD</a>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hide success message after 2 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $("#successMessage").fadeOut("slow");
            }, 2000);
        });
    </script>
</body>
</html>
