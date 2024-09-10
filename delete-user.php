<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="index.css" type="text/css">
</head>

<body>
    <div class="container">
        <form action="delete-user.php" method="post">

            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $email = $_POST["email"];
                $pwd = $_POST["pwd"];

                require_once "database.php";

                $query = "SELECT * FROM users WHERE email = :email";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":email", $email);

                $stmt->execute();

                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    if (password_verify($pwd, $user["pwd"])) {
                        $query = "DELETE FROM users WHERE email = :email";

                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":email", $email);

                        if ($stmt->execute()) {
                            die("<div class='alert alert-success'>User deleted successfully.</div>");
                        } else {
                            die("<div class='alert alert-danger'>Failed to delete user.</div>");
                        }
                    } else {
                        die("<div class='alert alert-danger'>Password is incorrect</div>");
                    }
                } else {
                    die("<div class='alert alert-danger'>Wrong email.</div>");
                }
            }
            ?>

            <input type="text" name="email" placeholder="Email">


            <input type="password" name="pwd" placeholder="Password">


            <input type="submit" class="btn btn-danger" value="Delete" name="submit">

            <p><a href="index.php">Home</a></p>
        </form>
    </div>

</body>

</html>