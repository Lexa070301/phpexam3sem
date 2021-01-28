<?php
session_start();
require_once "connect.php";
if (isset($_GET['id'])) {
    $sessionId = $_GET['id'];
    //Получение вопросов
    $questionsGet = $db->prepare("SELECT * FROM questions WHERE session_id = '$sessionId';");
    $questionsGet->execute();
    $arr = $questionsGet->fetchAll();
    $arrLength = count($arr);

    $sessionGet = $db->prepare("SELECT * FROM sessions WHERE id = '$sessionId';");
    $sessionGet->execute();
    $session = $sessionGet->fetch();
}
$edit = false;
if (isset($_SESSION['admin']) && $_GET['edit'] == true) {
    $edit = true;
}
if (isset($_POST['send-answer'])) {
    $sessionId = $_GET['id'];
    $ip = $_SERVER['REMOTE_ADDR'];
    for ($i = 0; $i < $arrLength; $i++) {
        $questionId = $arr[$i]['id'];
        $questionType = $arr[$i]['question_type'];
        $post = $_POST["question-$questionId"];
        $sum = 0;
        $str = '';
        if ($questionType == 5) {
            $sum = intval(substr(stristr($post, '='), 1));
            $str = stristr($post, '=', true);
        } elseif ($questionType == 6) {
            $postArrayCount = count($post);
            for ($j = 0; $j < $postArrayCount; $j++) {
                $sum += intval(substr(stristr($post[$j], '='), 1));
                $str .= stristr($post[$j], '=', true) . ',';
            }
            $str = substr($str, 0, -1);
        } else {
            $str = strval($post);
        }
        $insertAnswer = $db->prepare("INSERT INTO answers (id, ip, datetime, session_id, question_id, answer, points) VALUES (?, ?, now(), ?, ?, ?, ?);");
        $insertAnswer->execute(array(null, $ip, $sessionId, $questionId, $str, $sum));

    }
    header("Location: index.php");
    exit;
}

if (isset($_POST['add-question'])) {
    $post = $_POST['type-question'];
    switch ($post) {
        case 1:
            echo 'test';
            break;
    }
//    $questionAdd = $db->prepare("INSERT INTO sessions (id, status) VALUES (?, ?);");
//    $questionAdd->execute(array(null, 'enabled'));
//    header("Location: index.php");
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
    <?php
    if (isset($_GET['id'])) {
        if ($session != false) {
            echo "<form action='' method='post'>";
            for ($i = 0; $i < $arrLength; $i++) {
                $questionId = $arr[$i]['id'];
                $questionType = $arr[$i]['question_type'];
                $question = $arr[$i]['question'];
                $answer = $arr[$i]['answer'];
                switch ($questionType) {
                    case 1:
                        echo "<label class='mb-3' style='width:100%'>
                                <span>$question</span>
                                <input class='form-control' type='number' name='question-$questionId' placeholder='Введите любое число' required>
                              </label>";
                        break;
                    case 2:
                        echo "<label class='mb-3' style='width:100%'>
                                <span>$question</span>
                                <input class='form-control' type='number' name='question-$questionId' placeholder='Введите неотрицательное число' min='0' required>
                              </label>";
                        break;
                    case 3:
                        echo "<label class='mb-3' style='width:100%'>
                                <span>$question</span>
                                <input class='form-control' type='text' name='question-$questionId' placeholder='Введите текст' minlength='1' maxlength='30' required>
                              </label>";
                        break;
                    case 4:
                        echo "<label class='mb-3' style='width:100%'>
                                <span>$question</span>
                                <textarea class='form-control' name='question-$questionId' placeholder='Введите текст'  minlength='1' maxlength='255' style='resize: none' required></textarea>
                              </label>";
                        break;
                    case 5:
                        $radioArray = explode(',', $answer);
                        $radioArrayCount = count($radioArray);
                        echo "<div class='mb-3' style='width:100%'><span>$question</span>";
                        for ($j = 0; $j < $radioArrayCount; $j++) {
                            $currentValue = stristr($radioArray[$j], '=');
                            $currentValue = substr($currentValue, 1);
                            $currentRadio = stristr($radioArray[$j], '=', true);
                            echo "<label class='d-block'><input type='radio' name='question-$questionId' value='$currentRadio=$currentValue' required><span>$currentRadio</span></label>";
                        }
                        echo "</div>";
                        break;
                    case 6:
                        $checkboxArray = explode(',', $answer);
                        $checkboxArrayCount = count($checkboxArray);
                        echo "<div class='mb-3' style='width:100%'><span>$question</span>";
                        for ($j = 0; $j < $checkboxArrayCount; $j++) {
                            $currentValue = stristr($checkboxArray[$j], '=');
                            $currentValue = substr($currentValue, 1);
                            $currentCheckbox = stristr($checkboxArray[$j], '=', true);
                            echo "<label class='d-block'><input type='checkbox' name='question-" . $questionId . "[]' value='$currentCheckbox=$currentValue' required><span>$currentCheckbox</span></label>";
                        }
                        echo "</div>";
                        break;
                }
            }
            if ($arrLength != 0 && !$edit) {
                echo "<input class='btn btn-primary' type='submit' name='send-answer' value='Отправить'>";
            }
            echo "</form>";
            if ($edit) {
                echo "<form action='' method='post' style='border: 1px solid lightgrey; border-radius: 10px;; padding: 15px'>
                        <label for='type-question' class='d-block mb-3'>
                          <span>Выберите тип вопроса</span>
                          <select class='form-select' name='type-question' id='type-question'>
                            <option value='1'>1</option>                      
                            <option value='2'>2</option>                      
                            <option value='3'>3</option>                      
                            <option value='4'>4</option>                      
                            <option value='5'>5</option>                      
                            <option value='6'>6</option>                      
                          </select>
                        </label>                      
                        <input class='btn btn-primary' type='submit' name='add-question' value='Добавить'>
                      </form>";
            }
        } else {
            echo '<span><b>Error 404</b></span><br><span>Сессия не найдена</span>';
        }
    } else {
        echo '<span><b>Error 404</b></span><br><span>Сессия не найдена</span>';
    }
    ?>
</div>
</body>
</html>
