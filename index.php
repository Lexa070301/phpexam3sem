<?php
session_start();
if ($_GET['do'] == 'logout') {
    unset($_SESSION['admin']);
    session_destroy();
}

if ($_SESSION['admin'] != "admin") {
    header("Location: login.php");
    exit;
}
require_once "connect.php";

for ($i = 0; $i < $arrLength; $i++) {
    for ($j = 0; $j < 2; $j++) {
        echo $arr[$i][$j] . '<br/>';
    }
}

//Добавление сессии
if (isset($_POST['new-session'])) {
    $sessionAdd = $db->prepare("INSERT INTO sessions (id, status) VALUES (?, ?);");
    $sessionAdd->execute(array(null, 'enabled'));
    header("Location: index.php");
    exit;
}
if (isset($_POST['delete-session'])) {
    $sessionId = $_POST['session-id'];
    $sessionDelete = $db->prepare("DELETE FROM sessions WHERE id = ?");
    $sessionDelete->execute(array($sessionId));
    header("Location: index.php");
    exit;
}
if (isset($_POST['close-session'])) {
    $sessionId = $_POST['session-id'];
    $sessionDelete = $db->prepare("UPDATE sessions SET status = 'closed' WHERE id = ?");
    $sessionDelete->execute(array($sessionId));
    header("Location: index.php");
    exit;
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
  <a href="index.php?do=logout" class="btn btn-primary">Logout</a>
  <h1>Добрый день <?= $_SESSION['admin'] ?></h1>
  <form action="" method="post">
    <input class="btn btn-primary" type="submit" value="Новая Сессия" name="new-session">
  </form>
  <h2>Сессии</h2>
  <table class="table">
    <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Статус</th>
      <th scope="col">Уникальная ссылка</th>
      <th scope="col">Посмотреть</th>
      <th scope="col">Редактировать</th>
      <th scope="col">Протокол</th>
      <th scope="col">Закрыть</th>
      <th scope="col">Удалить</th>
    </tr>
    </thead>
    <tbody>
    <?php
    //Получение сессий
    $sessionGet = $db->prepare("SELECT * FROM sessions;");
    $sessionGet->execute();
    $arr = $sessionGet->fetchAll();
    $arrLength = count($arr);
    for ($i = 0; $i < $arrLength; $i++) {
        $sessionId = $arr[$i][0];
        $sessionStatus = $arr[$i][1];
        $url = $_SERVER['HTTP_HOST'];
        echo "<tr>
              <th><span>$sessionId</span></th>
              <th><span>$sessionStatus</span></th>
              <th><span>$url/session.php?id=$sessionId</span></th>
              <th><a class='btn btn-primary btn-sm' href='/session.php?id=$sessionId'>Перейти</a></th>
              <th><a class='btn btn-success btn-sm' href='/session.php?id=$sessionId&edit=true'>Редактировать</a></th>
              <th><a class='btn btn-primary btn-sm' href='/protocol.php?id=$sessionId'>Посмотреть протокол</a></th>
              <th><form action='' method='post'>
                    <input type='hidden' name='session-id' value='$sessionId'>
                    <input class='btn btn-secondary btn-sm' type='submit' value='Закрыть' name='close-session'>
                  </form>
              </th>
              <th><form action='' method='post'>
                    <input type='hidden' name='session-id' value='$sessionId'>
                    <input class='btn btn-danger btn-sm' type='submit' value='Удалить' name='delete-session'>
                  </form>
              </th>
              </tr>";
    }
    ?>

    </tbody>
  </table>
</div>
</body>
</html>

