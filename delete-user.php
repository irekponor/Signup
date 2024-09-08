<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css" type="text/css">
</head>

<body>
    <div class="container">
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];

            try {
                require_once "dbh-inc.php";

                $query = "DELETE FROM users WHERE username = :username AND pwd = :pwd;";

                $stmt = $pdo->prepare($query);

                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":pwd", $pwd);

                $stmt->execute();

                $pdo = null;
                $stmt = null;

                header("Location: ../index.php");

                die();
            } catch (PDOException $e) {
                die("Query Failed:" . $e->getMessage());
            }
        } else {
            header("Location: ../index.php");
        }
        ?>
        <form action="delete-user.php" method="post">

            <input type="text" name="email" placeholder="Email">


            <input type="password" name="pwd" placeholder="Password">


            <input type="password" name="repeat_pwd" placeholder="Repeat Password">


            <input type="submit" class="btn btn-danger" value="Delete" name="submit">

        </form>
    </div>

</body>

</html>