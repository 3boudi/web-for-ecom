<?php

if(isset($_GET['id'])){
    $id = $_GET['id'];
    include 'database.php';
    $conn = new mysqli($servername, $username, $password, $dbname);
    if($conn->connect_error){
        die("Connection failed: ".$conn->connect_error);
    }
    $sql = "DELETE FROM clients WHERE id = $id";
    if($conn->query($sql) === TRUE){
        header('Location: index.php');
        exit;
    }else{
        echo "Error: ".$conn->error;
    }
    $conn->close();
}

?>