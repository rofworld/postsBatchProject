<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "postOfToday";

echo "Starting cleanTables.php...\n";
echo date(DATE_RFC822)."\n";
writeLog("Starting cleanTables.php...");
writeLog(date(DATE_RFC822));

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    writeLog("Connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}



$sql = "SET SQL_SAFE_UPDATES = 0";

if ($conn->query($sql) === TRUE) {
    writeLog("Setting SQL_SAFE_UPDATES TO 0...");
    echo "Setting SQL_SAFE_UPDATES TO 0...\n";
    mysqli_commit($conn);
} else {
    writeLog("Error: " . $sql . "<br>" . $conn->error);
    echo "Error: " . $sql . "<br>" . $conn->error;
}

echo "In table posts...\n";

$sql = "delete from posts";

if ($conn->query($sql) === TRUE) {
    writeLog("Deleting table ...");
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    writeLog("Error: " . $sql . "<br>" . $conn->error);
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "ALTER TABLE posts AUTO_INCREMENT = 1";

if ($conn->query($sql) === TRUE) {
    writeLog("Restarting autoincrement to 1...");
    echo "Restarting autoincrement to 1...\n";
    mysqli_commit($conn);
} else {
    writeLog("Error: " . $sql . "<br>" . $conn->error);
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();


function writeLog($str){
    error_log($str."\n", 3, "logs/cleanTables.log");
}


?>