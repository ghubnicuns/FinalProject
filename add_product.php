<?php
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
    echo "<br><br>";

    $product_id = $_POST['product_id'];
    $pname = $_POST['pname'];
    $ptag = $_POST['ptag'];
    $pdescript = $_POST['pdescript'];
    $pquantity = $_POST['pquantity'];
?>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ims";

    $conn = new mysqli($servername, $username, $password, $database);


    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully";
?>

<?php
    $sql = "INSERT INTO products (product_id, pname, ptag, pdescript,pquantity)
    VALUES (NULL,'product_id',$pname', '$ptag', '$pdescript','$pquantity',)";
    
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>