<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];

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
} else {
    echo "<div class='alert alert-success'>You have successfully registered!.</div>";
}
