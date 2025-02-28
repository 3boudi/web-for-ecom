<?php 

$id = "";
$name = "";
$email = "";
$phone = "";
$address = "";
$error = "";
$success = "";

include 'database.php';

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        header('Location: index.php');
        exit;
    }

    $id = intval($_GET['id']);
    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) {
        header('Location: index.php');
        exit;
    }
    
    $name = $row['name'];
    $email = $row['email'];
    $phone = $row['phone'];
    $address = $row['address'];
} else {
    $id = intval($_POST['id']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    if (empty($id) || empty($name) || empty($email) || empty($phone) || empty($address)) {
        $error = "All fields are required";
    } else {
        $sql = "UPDATE clients SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $email, $phone, $address, $id);
        
        if ($stmt->execute()) {
            $success = "Client updated successfully";
            header('Location: index.php');
            exit;
        } else {
            $error = "Failed to update client";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Edit Client</title>
</head>
<body>
    <div class="container my-5">
        <h2>Edit Client: <?php echo htmlspecialchars($name); ?></h2>

        <?php if (!empty($error)): ?>
            <div class='alert alert-danger'><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if (!empty($success)): ?>
            <div class='alert alert-success'><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        
        <form method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
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
            <button type="submit" class="btn btn-primary">Update Client</button>
            <a class="btn btn-secondary" href="index.php">Cancel</a>
        </form>
    </div>
</body>
</html>
<?php   #my code but i dont kno why it is not working

/*
 edit.php<?php 
$id="";
$name = "";
$email = "";
$phone = "";
$address = "";


include 'database.php';

$conn = new mysqli($servername, $username, $password, $dbname); 

$error = "";
$success = "";

    if($_SERVER['REQUEST_METHOD']=='GET'){ # to get the data form the database

        if(isset($_GET['id'])){
            header('Location: index.php');
            exit;
        }
        $id = $_GET['id'];
        $sql = "SELECT * FROM clients WHERE id =$id";
        $result = $conn->query $sql; # use to do the operation
        $row= $result->fetch_assoc; # use to fetch the data
        
        if(!$row){
            header('Location: index.php');
            exit;
        }
        $name = $row['name'];
        $email = $row['email'];
        $phone = $row['phone'];
        $address = $row['address'];

    }
    else{

        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $address = $_POST['address'];

        do{

            if(empty($_POST['id']||$_POST['name']||$_POST['email']||$_POST['phone']||$_POST['address'])){
                $error = "All fields are required";
                break;
            }
            $sql ="UPDATE clients".
                "SET name = $name, email =$email phone =$phone, address =$address".
                "WHERE id = $id";
            $result = $conn->query($sql); # use to do the operation
            if(!$result){
                $error = "Failed to update client";
                break;
            }
            $success = "Client updated successfully";

            header('Location: index.php');#use to save the data
            exit;

        }while(false);
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>ADD CLIENT</title>
    <link rel="stylesheet" href="creat.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>


    <div class="container my-5">
        <h2>CLIENT <?php echo htmlspecialchars($name); ?></h2>

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
            <input type="hidden" name="id" value="<?php echo $id; ?>" > 
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
*/
?>
