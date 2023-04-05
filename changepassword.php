<?php

if (
    isset($_POST['username']) && strlen($_POST['username']) > 0 &&
    isset($_POST['oldpassword']) && strlen($_POST['oldpassword']) > 0 &&
    isset($_POST['newpassword']) && strlen($_POST['newpassword']) > 0 &&
    isset($_POST['newpassword-check']) && strlen($_POST['newpassword-check']) > 0 
) {

    try {
        $host = "localhost";
        $database = "lab9";
        $user = "webuser";
        $password = "P@ssw0rd";

        $conString = 'mysql:host=' . $host . ';dbname=' . $database;
        $pdo = new PDO($conString, $user, $password);

        $oldHash = md5($_POST['oldpassword']);
        $newhash = md5($_POST['newpassword']);
        $sql = "SELECT * from users where username = :username and password =:password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':password',$oldHash);
        $stmt->bindValue(":username",$_POST['username']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result != null){
            $sql = 'UPDATE users set password = :newpass where username = :username';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':newpass',$newhash);
            $stmt->bindValue(":username", $_POST['username']);
            echo "Password successfully changed";
            $pdo = null;
        }
        else{
            echo "Username or password are invalid";
            echo  "<br><a href = 'lab9-3.html'> Return to previous page </a> ";
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