<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "postOfToday";

echo "Starting writeDayPost.php...\n";
echo date(DATE_RFC822)."\n";
writeLog("Starting writeDayPost.php...");
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


echo "In table post_of_the_day...\n";
writeLog("In table post_of_the_day...");

$sql = "delete from post_of_the_day";

if ($conn->query($sql) === TRUE) {
    writeLog("Deleting table ...");
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    writeLog("Error: " . $sql . "<br>" . $conn->error);
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "ALTER TABLE post_of_the_day AUTO_INCREMENT = 1";

if ($conn->query($sql) === TRUE) {
    writeLog("Restarting autoincrement to 1...");
    echo "Restarting autoincrement to 1...\n";
    // Commit transaction
    mysqli_commit($conn);
} else {
    writeLog("Error: " . $sql . "<br>" . $conn->error);
    echo "Error: " . $sql . "<br>" . $conn->error;
}




$resultado = mysqli_query($conn,"SELECT posts,total_rate FROM posts ORDER BY total_rate DESC");


//Coge el primer elemento de la fila
$fila=mysqli_fetch_array($resultado, 2);

$post_of_the_day = ""."'".$fila[0]."'";

$sql = "INSERT INTO post_of_the_day (post_of_the_day,total_rate)
VALUES ($post_of_the_day,$fila[1])";

if ($conn->query($sql) === TRUE) {
    writeLog("Post of the day created successfully");
    echo "Post of the day created successfully\n";
    // Commit transaction
    mysqli_commit($conn);
} else {
    writeLog("Error: " . $sql . "<br>" . $conn->error);
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

function writeLog($str){
    error_log($str."\n", 3, "logs/writeDayPost.log");
}

?>