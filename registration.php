<?php

if (isset($_POST["submit"])) {
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $pwd = $_POST["pwd"];
    $pwdRepeat = $_POST["repeat_pwd"];
    $errors = array();
    if (empty($fullname) or empty($email) or empty($pwd) or empty($pwdRepeat)) {
        array_push($errors, "All fileds are required, fool!.");
    }
    if (!filter_var($email, FILTER_VALIDATE_IP)) {
        array_push($errors, "who are you deceiving? c'mon use a valid Email");
    }
    if (strlen($pwd) < 8) {
        array_push($errors, "Passwords must be at least 8 chars long, idiot.");
    }
}
