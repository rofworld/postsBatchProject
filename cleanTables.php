<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "new_schema";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$sql = "SET SQL_SAFE_UPDATES = 0";

if ($conn->query($sql) === TRUE) {
    echo "Setting SQL_SAFE_UPDATES TO 0...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "In table posts...\n";

$sql = "delete from posts";

if ($conn->query($sql) === TRUE) {
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "ALTER TABLE posts AUTO_INCREMENT = 1";

if ($conn->query($sql) === TRUE) {
    echo "Restarting autoincrement to 1...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "In table post_of_the_day...\n";

$sql = "delete from post_of_the_day";

if ($conn->query($sql) === TRUE) {
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "ALTER TABLE post_of_the_day AUTO_INCREMENT = 1";

if ($conn->query($sql) === TRUE) {
    echo "Restarting autoincrement to 1...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Commit transaction
mysqli_commit($conn);
$conn->close();



?>