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


echo "In table post_of_the_day...\n";


$sql = "delete from postOfToday.post_of_the_day";

if ($conn->query($sql) === TRUE) {
    echo "Deleting table ...\n";
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$sql = "ALTER TABLE postOfToday.post_of_the_day AUTO_INCREMENT = 1";

if ($conn->query($sql) === TRUE) {
    echo "Restarting autoincrement to 1...\n";
    // Commit transaction
    mysqli_commit($conn);
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}




$resultado = mysqli_query($conn,"SELECT posts,total_rate FROM postOfToday.posts ORDER BY total_rate DESC");


//Coge el primer elemento de la fila
if ($fila=mysqli_fetch_array($resultado, 2)){

    $post_of_the_day = mysqli_real_escape_string($conn, strval($fila[0]));
    
    $sql = "INSERT INTO postOfToday.post_of_the_day (post_of_the_day,total_rate)
    VALUES ('$post_of_the_day','$fila[1]')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Post of the day created successfully\n";
        // Commit transaction
        mysqli_commit($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $sql = "INSERT INTO postOfToday.best_posts (posts,total_rate)
    VALUES ('$post_of_the_day','$fila[1]')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Insert into best_posts successfully\n";
        // Commit transaction
        mysqli_commit($conn);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
}else{
    echo "There are no posts. Cannot insert in the post_of_the_day and best_posts...\n";
}





$conn->close();


?>