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