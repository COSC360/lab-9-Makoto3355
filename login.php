<?php

if (
    isset($_POST['username']) && strlen($_POST['username']) > 0 &&
    isset($_POST['password']) && strlen($_POST['password']) > 0
) {

    try {
        $host = "localhost";
        $database = "lab9";
        $user = "webuser";
        $password = "P@ssw0rd";

        $conString = 'mysql:host=' . $host . ';dbname=' . $database;
        $pdo = new PDO($conString, $user, $password);

        $sql = "Select * from users where username = :username and password =:password";
        $stmt = $pdo->prepare($sql);

        $passhash = md5($_POST['password']);
        $stmt->bindValue(":username", $_POST['username']);
        $stmt->bindValue(":password",$passhash);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result != null){
            echo "Successfully logged in!";
            echo "<br>Welcome ".$_POST['username'];
            $pdo = null;
        }
        else{
            echo "Username and/or password are invaild";
            echo  "<br><a href = 'lab9-2.html'> Return to previous page </a> ";

            $pdo = null;
        }
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
else{
    echo "Missing form info";
}
?>