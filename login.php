<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if($_SERVER["REQUEST_METHOD"]=="POST"){
if(empty($_POST["username"])){
    die("Fill in your Username.");
}

if(empty($_POST["password"])){
    die("Fill in your password.");
}

$connection=require("db_connect.php");
  
   
$pass_hash=md5($_POST["password"]);
$query = 
"SELECT username, password 
FROM users WHERE username=?;";
$stmt=$connection->prepare($query);
$stmt->bind_param('s',$_POST["username"]);
$stmt->execute();
$result = $stmt->get_result();

// if($result){
//  echo "user has valid account.";
// } else if ( $row["password"]==$pass_hash){
//     echo "username and/or password are invalid";
// }



while($row=$result->fetch_assoc()){

    if( $row["password"]==$pass_hash){
  
        echo "user has a valid account";
    } else{
        echo "username and/or password are invalid";
    }
}

}
?>
