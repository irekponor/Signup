<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div class="container">


        <?php

        if (isset($_POST["submit"])) {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdRepeat = $_POST["repeat_pwd"];

            $errors = false;


            if (empty($fullname) or empty($email) or empty($pwd) or empty($pwdRepeat)) {
                echo "<div class='alert alert-danger'>All fields are required!.</div>";
                $errors = true;
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "<div class='alert alert-danger'>Enter a valid email.</div>";
                $errors = true;
            } elseif (strlen($pwd) < 8) {
                echo "<div class='alert alert-danger'>Password must be at least 8 characters long.</div>";
                $errors = true;
            } elseif ($pwd !== $pwdRepeat) {
                echo "<div class='alert alert-danger'>Passwords don't match!.</div>";
                $errors = true;
            } else {
                echo "<div class='alert alert-success'>Registration successful!</div>";
                $errors = true;
            }
        }


        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdRepeat = $_POST["repeat_pwd"];

            try {
                require_once "database.php";

                $query = "INSERT INTO users (fullname, email, pwd) VALUES (:fullname, :email, :pwd);";

                $stmt = $pdo->prepare($query);

                $stmt->bindParam(":fullname", $fullname);
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
        <form action="index.php" method="post">

            <input type="text" name="fullname" placeholder="Full Name">


            <input type="text" name="email" placeholder="Email">


            <input type="password" name="pwd" placeholder="Password">


            <input type="password" name="repeat_pwd" placeholder="Repeat Password">


            <input type="submit" class="btn btn-primary" value="Register" name="submit">

            <a href="delete-user.php">Delete Account</a>

        </form>
    </div>

</body>

</html>