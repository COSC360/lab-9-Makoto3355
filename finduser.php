<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1 );
error_reporting(E_ALL);

if($_SERVER["REQUEST_METHOD"]==POST){
    if(empty($_POST["username"])){
        die("Fill in your Username.")
    }
    $connection = require("db_connect.php");
    $sql = "SELECT * FROM users WHERE username =?;"
    $stmt=$connection->prepare($sql);
    $stmt->bind_param('s', $_POST["username"]);
    $stmt->execute();
    $result = $stmt->get_result();


    $row= $resul->fetch_assoc();
    if($result){
        echo "<form method='post' action = 'finduser.php'"
        echo"<fieldset>";
        echo"<legend>";
        echo "User: ".$row['username']."<br>";
        echo"</legend>";
        echo "<p>";
        echo "<label>First Name: ".$row['firstName']."</label>";
        echo "</p>";
        echo "<p>";
        echo "<label>Last Name: ".$row['lastName']."</label>";
        echo "</p>";
        echo "<p>";
        echo "<label>Email: ".$row['email']."</label>";
        echo "</p>";
        echo"</fieldset>";
        echo "</form>"
    }
}
$connection->close();
?>