<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<?php

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

    // Check password length
    if (!preg_match("/^[a-zA-Z0-9]+$/", $pwd)) {
        die("<div class='alert alert-danger'>Use a strong password (1 uppercase, lowercase, 1 no, 1 special char).</div>");
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

        header("Location: index.php");

        if (empty($error)) {
            die("<div class='alert alert-success'>Registration Successful!</div>");
        }
    } catch (PDOException $e) {
        die("Query Failed:" . $e->getMessage());
    }
} else {
    header("Location: index.php");
}

?>