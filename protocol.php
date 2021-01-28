<?php
require_once "connect.php";
if (isset($_GET['id'])) {
    $sessionId = $_GET['id'];

    $answersGet = $db->prepare("SELECT * FROM answers WHERE session_id = '$sessionId';");
    $answersGet->execute();
    $arr = $answersGet->fetchAll();
    $questios = $db->prepare("SELECT * FROM answers WHERE session_id = '$sessionId'  ORDER BY ip;");
    $questios->execute();
    $stats = $questios->fetchAll();
    $SessionQuestios = $db->prepare("SELECT count(session_id) AS question_count FROM questions WHERE session_id = '$sessionId' GROUP BY session_id ORDER BY session_id;");
    $SessionQuestios->execute();
    $questiosCount = $SessionQuestios->fetchAll();
    $questiosCount = $questiosCount[0]['question_count'];
    $answerCount = count($stats);
    $arrLength = count($arr);
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
    <?php
    if (isset($_GET['id'])) {
        if ($arr != array()) {
            $m = 0;
            $average = 0;
            $allsum = 0;
            while ($m < $answerCount) {
                $k = 0;
                $sum = 0;
                echo '<table class="table">
                        <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">IP адрес</th>
                          <th scope="col">Дата и всемя</th>
                          <th scope="col">Ответ</th>
                          <th scope="col">Баллы</th>
                        </tr>
                        </thead>
                        <tbody>';
                for ($j = $m; $j < $questiosCount + $m; $j++) {
                    $k++;
                    $ip = $arr[$j]['ip'];
                    $datetime = $arr[$j]['datetime'];
                    $answer = $arr[$j]['answer'];
                    $points = $arr[$j]['points'];
                    $sum += $points;
                    echo "<tr>
                            <th><span>$k</span></th>
                            <th><span>$ip</span></th>
                            <th><span>$datetime</span></th>
                            <th><span>$answer</span></th>
                            <th><span>$points</span></th>
                          </tr>";
                }
                echo '  </tbody>
                      </table>';
                echo "<span>Суммарный бал: $sum</span>  ";
                $m += $questiosCount;
                $allsum += $sum;
            }
            $average = $allsum / ($m / $questiosCount);
            echo "<span class='d-block mt-5'>Средний балл по сессии: $average</span>";

        } else {
            echo '<span><b>Error 404</b></span><br><span>Протокол не найден</span>';
        }
    } else {
        echo '<span><b>Error 404</b></span><br><span>Протокол не найден</span>';
    }
    ?>
</div>
</body>
</html>