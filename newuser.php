<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER["REQUEST_METHOD"]=="POST"){
if(empty($_POST["username"])){
    die("Fill in your Username.");
}

if(empty($_POST["firstname"])){
    die("Fill in your firstname.");
}

if(empty($_POST["lastname"])){
    die("Fill in your lastname.");
}

if(empty($_POST["email"])){
    die("Fill in your email.");
}

if(empty($_POST["password"])){
    die("Fill in your password.");
}

if(empty($_POST["password-check"])){
    die("Confirm password.");
}

if($_POST["password"]!=$_POST["password-check"]){
    die("Passwords must match");
}

$connection=require("db-connect.php");

$pass_hash=md5($_POST["password"]);

$sql="SELECT * FROM users WHERE username=? ;";
$stmt=$connection->prepare($sql);
$stmt->bind_param("s",$_POST["username"]);
$stmt->execute();
$result = $stmt->get_result();
    if(mysqli_num_rows($result)>0){
        echo "User already exists with this name and/or email";
        echo "<a href='lab9-1.html'>Return to user entry</a>";
    } else{
         $sql="INSERT INTO users(username, firstName, lastName, email, password) VALUES (?, ?,?,?,?)";
         $stmt=$connection->prepare($sql);
        $stmt->bind_param('sssss',$_POST["username"],$_POST["firstname"],$_POST["lastname"],$_POST["email"],$pass_hash);


        if( $stmt->execute()){
            echo "account for the user ".$_POST["username"]." has been created";
        } else{
            echo "Problem with creating your account";
        }

    }



    mysqli_close($connection);

} else{
    die("INVALID METHOD!");
}

?>