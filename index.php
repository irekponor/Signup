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
        $error = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $pwd = $_POST["pwd"];
            $pwdRepeat = $_POST["repeat_pwd"];

            // Input validation
            if (empty($fullname) || empty($email) || empty($pwd) || empty($pwdRepeat)) {
                $error .= "<div class='alert alert-danger'>Fill in all the fields.</div>";
            }

            // Check if passwords match
            elseif ($pwd != $pwdRepeat) {
                $error .= "<div class='alert alert-danger'>Passwords do not match.</div>";
            }

            // Check password quality
            elseif (!preg_match("/^[A-Za-z\d]{8,}$/", $pwd)) {
                $error .= "<div class='alert alert-danger'>Use a stronger password(at least 1 upper and lowercase, 1 no., 1 special char, min of 8 char.</div>";
            }

            // Check if email is valid
            elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error .= "<div class='alert alert-danger'>Email is invalid</div>";
            }

            // Check if email already exists
            try {
                require_once "database.php";
                $query = "SELECT * FROM users WHERE email = :email";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":email", $email);
                $stmt->execute();
                if ($stmt->rowCount() > 0) {
                    $error .= "<div class='alert alert-danger'>Email already exists.</div>";
                }
            } catch (PDOException $e) {
                $error .= "Query Failed:" . $e->getMessage() . "<br>";
            }

            // Insert new user into database
            if (empty($error)) {
                try {
                    $query = "INSERT INTO users (fullname, email, pwd) VALUES (:fullname, :email, :pwd);";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":fullname", $fullname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":pwd", $pwd);

                    $stmt->execute();

                    $error .= "<div class='alert alert-success'>Registration successful!.</div>";
                } catch (PDOException $e) {
                    $error .= "Query Failed:" . $e->getMessage() . "<br>";
                }
            }
        }
        ?>

        <!-- HTML form to register -->
        <form method="post">
            <input type="text" name="fullname" placeholder="Full Name">

            <input type="email" name="email" placeholder="Email">

            <input type="password" name="pwd" placeholder="Password">

            <input type="password" name="repeat_pwd" placeholder="Repeat Password">

            <button type="submit">Register</button>
        </form>
        <a href="delete-user.php">Delete Account</a>
    </div>

</body>

</html>