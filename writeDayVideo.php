<?php
$servername = "localhost";
$username = "root";
$password = "pollo0123";
$dbname = "postOfToday";

echo "Starting writeDayPost.php...\n";
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


echo "In table videoOfToday.video_of_the_day...\n";


$sql = "delete from videoOfToday.video_of_the_day";

if ($conn->query($sql) === TRUE) {
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "ALTER TABLE videoOfToday.video_of_the_day AUTO_INCREMENT = 1";

if ($conn->query($sql) === TRUE) {
    echo "Restarting autoincrement to 1...\n";
    // Commit transaction
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}




$resultado = mysqli_query($conn,"SELECT * FROM videoOfToday.videos ORDER BY total_rate DESC");


//Coge el primer elemento de la fila
if ($fila=mysqli_fetch_array($resultado, 2)){
    
    $url_escaped=mysqli_real_escape_string($conn, $fila[1]);
    $path_escaped = mysqli_real_escape_string($conn,$fila[2]);
    
    $sql = "INSERT INTO videoOfToday.video_of_the_day (url,path,video_type,total_rate)
    VALUES ('$url_escaped','$path_escaped','$fila[3]','$fila[4]')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Video of the day created successfully\n";
        // Commit transaction
        mysqli_commit($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
    
    $sql = "INSERT INTO videoOfToday.best_videos (url,path,video_type,total_rate)
    VALUES ('$url_escaped','$path_escaped','$fila[3]','$fila[4]')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Insert into best_videos successfully\n";
        // Commit transaction
        mysqli_commit($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    
    $sql="DELETE FROM videoOfToday.videos WHERE id='$fila[0]'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Video of the day deleted from video list\n";
        // Commit transaction
        mysqli_commit($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}else{
    echo "There are no videos. Cannot insert in the video_of_the_day and best_videos...\n";
}





$conn->close();


?>