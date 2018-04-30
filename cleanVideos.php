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
//Delete Files

$result=mysqli_query($conn,"select path from videoOfToday.videos");

echo "Deleting files...\n";
while ($fila = mysqli_fetch_array($result, 2)) {
    
    unlink($fila[0]);
}
echo "End Deleting Files.\n";



//Delete table videos
echo "In table videos...\n";

$sql = "delete from videoOfToday.videos";

if ($conn->query($sql) === TRUE) {
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$conn->close();



?>
