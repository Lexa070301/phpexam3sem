<?php
require_once "connect.php";
$usersGet = $db->prepare("SELECT * FROM admins;");
$usersGet->execute();
$admins = $usersGet->fetchAll();
$adminsCount = count($admins);
//print_r($admins);
session_start();
//$users = 'admin';
//$pass = '827ccb0eea8a706c4c34a16891f84e7b';
if ($_POST['submit']) {
    for ($i = 0; $i < $adminsCount; $i++) {
        $name = $admins[$i][1];
        $pass = $admins[$i][2];
        if ($name == $_POST['user'] and $pass == md5($_POST['pass'])) {
            $_SESSION['admin'] = $name;
            header("Location: index.php");
            exit;
        }
    }
    echo '<p>Логин или пароль неверны!</p>';
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
</head>
<body>
<div class="container">
  <form method="post">
    Username: <input class="form-control" type="text" name="user"/> <br/>
    Password: <input class="form-control" type="password" name="pass"/> <br/>
    <input class="btn btn-primary" type="submit" name="submit" value="Login"/>
  </form>
</div>
</body>
</html>