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
        $message = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdRepeat = $_POST["repeat_pwd"];

            // Input validation
            if (empty($fullname) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
                die("<div class='alert alert-danger'>All fields are required!.</div>");
            }

            // Check if passwords match
            if ($pwd != $pwdRepeat) {
                die("<div class='alert alert-danger'>Passwords do not match.</div>");
            }

            // Check password quality
            if (!preg_match("/^[A-Za-z\d]{8,}$/", $pwd)) {
                die("<div class='alert alert-danger'>Use a strong password (1 uppercase, lowercase, 1 no, 1 special char, 8 chars min).</div>");
            }

            // Check if email is valid
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                die("<div class='alert alert-danger'>Email is not valid.</div>");
            }

            // Check if email already exists
            try {
                require_once "database.php";
                $query = "SELECT * FROM users WHERE email = :email";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    die("<div class='alert alert-danger'>Email already exists!.</div>");
                }
            } catch (PDOException $e) {
                die("Query Failed:" . $e->getMessage());
            }

            // Insert new user into database
            try {
                $query = "INSERT INTO users (fullname, email, pwd) VALUES (:fullname, :email, :pwd);";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":fullname", $fullname);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":pwd", $pwd);


                $stmt->execute();

                $pdo = null;
                $stmt = null;



                die("");
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