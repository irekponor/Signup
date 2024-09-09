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
        <form action="delete-user.php" method="post">

            <?php

            if (isset($_POST["submit"])) {
                $email = $_POST["email"];
                $pwd = $_POST["pwd"];
                $pwdRepeat = $_POST["repeat_pwd"];

                $errors = false;


                if (empty($email) or empty($pwd) or empty($pwdRepeat)) {
                    echo "<div class='alert alert-danger'>All fields are required!.</div>";
                    $errors = true;
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class='alert alert-danger'>Email not found.</div>";
                    $errors = true;
                } elseif (strlen($pwd) < 8) {
                    echo "<div class='alert alert-danger'>Enter a correct password.</div>";
                    $errors = true;
                } elseif ($pwd !== $pwdRepeat) {
                    echo "<div class='alert alert-danger'>Passwords don't match!.</div>";
                    $errors = true;
                } else {
                    echo "<div class='alert alert-success'>Account deleted succesfully!</div>";
                    echo "<a href='index.php'>Home</a>";
                    $errors = true;
                }
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $pwd = $_POST["pwd"];
                $pwdRepeat = $_POST["repeat_pwd"];

                try {
                    require_once "database.php";

                    $query = "DELETE FROM users WHERE email = :email AND pwd = :pwd;";

                    $stmt = $pdo->prepare($query);

                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":pwd", $pwd);

                    $stmt->execute();

                    $pdo = null;
                    $stmt = null;


                    die();
                } catch (PDOException $e) {
                    die("Query Failed:" . $e->getMessage());
                }
            }
            ?>

            <input type="text" name="email" placeholder="Email">


            <input type="password" name="pwd" placeholder="Password">


            <input type="password" name="repeat_pwd" placeholder="Repeat Password">


            <input type="submit" class="btn btn-danger" value="Delete" name="submit">

        </form>
    </div>

</body>

</html>