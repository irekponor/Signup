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
