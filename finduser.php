<?php

if (
    isset($_POST['username']) && strlen($_POST['username']) > 0 
) {

    try {
        $host = "localhost";
        $database = "lab9";
        $user = "webuser";
        $password = "P@ssw0rd";

        $conString = 'mysql:host=' . $host . ';dbname=' . $database;
        $pdo = new PDO($conString, $user, $password);

        $sql = "Select * from users where username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(":username", $_POST['username']);

        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if($result != null){
            $fn = $result['firstName'];
            $ln = $result['lastName'];
            $username = $result['username'];
            $email = $result['email'];
            echo '
                <fieldset>
                    <legend>'.$username.'</legend>
                    <table>
                    <thead>
                    <tr>
                        <td>First Name:</td>                    
                        <td>'.$fn.'</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                    <td>Last Name:</td>                    
                    <td>'.$ln.'</td>
                    </tr>
                    <tr>
                    <td>Email:</td>
                    <td>'.$email.'</td>
                    </tr>
                    </table>
            ';
            $pdo = null;
        }
        else{
            echo "Username invalid or does not exist";
            echo  "<br><a href = 'lab9-4.html'> Return to previous page </a> ";

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