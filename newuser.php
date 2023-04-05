<?php


if (
    isset($_POST['firstname']) && strlen($_POST['firstname']) > 0 &&
    isset($_POST['lastname']) && strlen($_POST['lastname']) > 0 &&
    isset($_POST['email']) && strlen($_POST['email']) > 0 &&
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



        //good connection, so do you thing
        $sql = "Select username, email from users where username = :username or email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':username', $_POST['username']);
        $stmt->bindValue(":email", $_POST["email"]);
        
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result != null){
            echo "User already exists with this name and/or email";
            echo  "<br><a href = 'lab9-1.html'> Return to previous page </a> ";
            $Pdo = null;
        }
        else{
            $sql = "INSERT INTO users (username, firstName, lastName, email, password) values (:username, :firstName, :lastName, :email, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(":username",$_POST['username']);
            $stmt->bindValue(":firstName",$_POST['firstname']);
            $stmt->bindValue(":lastName", $_POST['lastname']);
            $stmt->bindValue(":email",$_POST['email']);

            $passHash = md5($_POST['password']);
            $stmt->bindValue(':password',$passHash);
            $stmt->execute();
            echo "An account for the user ". $_POST['firstname']. " has been created";
            $pdo = null;


        }

    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
else{
    echo "Form not filled properly";
}