<?php

$servername = "localhost";
$username = "root";
$password = "pollo0123";
$dbname = "postOfToday";

echo "Starting cleanTables.php...\n";
echo date(DATE_RFC822)."\n";


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

$sql = "delete from postOfToday.posts";

if ($conn->query($sql) === TRUE) {
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();



?>