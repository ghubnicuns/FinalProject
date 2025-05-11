<?php
    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";
    echo "<br><br>";

    $fname = $_POST['fname'];
    $uname = $_POST['uname'];
    $pword = $_POST['pword'];
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
    $sql = "INSERT INTO user (id, fname, uname, pword)
    VALUES (NULL, '$fname', '$uname', '$pword')";
    
    if ($conn->query($sql) === TRUE) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>