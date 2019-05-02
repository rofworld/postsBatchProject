<?php

$servername = "localhost";
$username = "root";
$password = "pollo0123";
$dbname = "videoOfToday";

echo "Starting createTop100.php...\n";
echo date(DATE_RFC822)."\n";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


echo "Moving to best_videos...\n";


$resultado = mysqli_query($conn,"SELECT * FROM videoOfToday.videos where TIMESTAMPDIFF(DAY,uploadDate,NOW()) > 0");


//Coge el primer elemento de la fila
while ($fila=mysqli_fetch_array($resultado, 2)){
    
    
    $url_escaped=mysqli_real_escape_string($conn, $fila[1]);
    $path_escaped = mysqli_real_escape_string($conn,$fila[2]);
    
    
    
    $sql = "INSERT INTO videoOfToday.best_videos (url,path,video_type,total_rate,uploadDate,title,user)
    VALUES ('$url_escaped','$path_escaped','$fila[3]','$fila[4]','$fila[5]','$fila[6]','$fila[7]')";
    
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
    
}

echo "End moving to best_videos\n";


$result=mysqli_query($conn,"SELECT @rownum:=@rownum+1 AS rownum, bv.* FROM (SELECT @rownum:=0) r, videoOfToday.best_videos bv ORDER BY total_rate DESC");

echo "Deleting files...\n";
while ($fila = mysqli_fetch_array($result, 2)) {
    
    if ($fila[0]>100){
        
        //Delete video
        unlink($fila[3]);
        
        //Delete from the database
        
        $sql="DELETE FROM videoOfToday.best_videos WHERE id='$fila[1]'";
        
        if ($conn->query($sql) === TRUE) {
            echo "Video  deleted from best_videos list\n";
            // Commit transaction
            mysqli_commit($conn);
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
echo "End Deleting Files.\n";




$conn->close();



?>
