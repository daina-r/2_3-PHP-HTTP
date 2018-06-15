<?php

session_start();

if (!empty($_POST['right']) && !empty($_POST['answer'])) {
  if ($_POST['answer'] == $_POST['right']) {
    $evaluation = "Высокоинтеллектульный человек, или просто везунчик.";
  } else {
    $evaluation = "Бесконечно творческая натура, или экспериментатор.";
  }

  $question = $_SESSION['question'];
  $user = $_POST['user'];
  $length = 1730 - strlen($user) * 27;
  $img = imagecreatefrompng("img/netology-certificate.png");
  $ColorBlue = imagecolorallocate($img, 0, 188, 255);
  $ColorGray = imagecolorallocate($img, 50, 85, 105);
  $fontMontserrat = __DIR__.'/fonts/Montserrat-Regular.ttf';
  $fontRoboto = __DIR__.'/fonts/RobotoSlab-Regular.ttf';
  imagettftext($img, 130, 0, $length, 1200, $ColorBlue, $fontMontserrat, $user);
  imagettftext($img, 50, 0, 1330, 1440, $ColorGray, $fontRoboto, $question);
  imagettftext($img, 40, 0, 1000, 1670, $ColorGray, $fontRoboto, $evaluation);

  header('Content-Type: image/png');

  imagepng($img);
  imagedestroy($img);
}

if (!empty($_POST['right']) && empty($_POST['answer'])) {
  echo '<h3>Нужно определиться с ответом!</h3><br />';
  $test = $_SESSION['test'];
  
  //здесь мне не удалось сделать возврат к тому же вопросу, на который не поступил ответ//

  /*echo "
      <form action=\"test.php\" method=\"POST\" enctype=\"multipart/form-data\">
           <input type=\"hidden\" name=\"test\" value=\"$test\">
           <input type=\"submit\" value=\"Вернуться к выбору ответа\">
      </form>
  ";
  exit;*/
}

if (isset($_POST['test'])) {
    $content = file_get_contents('tests/'.$_POST['test']);
    $test = json_decode($content,true);
    $_SESSION['test'] = $test;
} elseif (empty($_POST)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Тест</title>
</head>
<body>
  <?php if(isset($test['answers'])) { ?>
    <h3>Выберите правильный ответ:</h3>
    <form action="test.php" method="POST">
        <input type="text" name="user" size="30" placeholder="Пожалуйста, введите свое полное имя" autofocus required><br /><br />
        <fieldset>
            <legend><?php echo $test['question']; ?></legend>
              <?php $_SESSION['question'] = $test['question'];

              foreach ($test['answers'] as $key => $answer) { ?>
                  <label><input type="radio" name="answer" value="<?php echo $answer; ?>"><?php echo $answer; ?></label>
              <?php } ?>
        </fieldset><br />
        <input type="hidden" name="right" value="<?php echo $test['correct']; ?>">
        <input type="submit" value="Ответить">
    </form>
  <?php } ?>
</body>
</html>