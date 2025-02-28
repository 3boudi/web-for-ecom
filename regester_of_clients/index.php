<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>CLINENT INFOMATION</title>
</head>
<body>
    <div class="container my-5"></div>
    <br>
    <h2>LIST OF CLINENT</h2>
    <a class="btn btn-primary" href="creat.php">ADD NEW CLINENT</a>
    <br>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>NAME</th>
                <th>EMAIL</th>
                <th>PHONE</th>
                <th>ADDRESS</th>
                <th>ACTION</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include 'database.php';
                $conn = new mysqli($servername, $username, $password, $dbname);
                if($conn->connect_error){
                    die("Connection failed: ".$conn->connect_error);
                }

                $sql = "SELECT * FROM clients";
                $result = $conn->query($sql);
                if($result->num_rows > 0){
                    while($row = $result->fetch_assoc()){
                        echo "<tr>
                            <td>".$row['id']."</td>
                            <td>".$row['name']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['phone']."</td>
                            <td>".$row['address']."</td>
                            <td>
                                <a class='btn btn-primary' href='edit.php?id=".$row['id']."'>EDIT</a>
                                <a class='btn btn-danger' href='delete.php?id=".$row['id']."'>DELETE</a>
                            </td>
                        </tr>";
                    }
                }
            ?>
        </tbody>
    </table>
   
</body>
</html>