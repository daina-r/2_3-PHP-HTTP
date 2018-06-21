<?php

$dir = 'tests';
$files = array_diff( scandir( $dir), array('..', '.'));

if (!empty($_FILES["json"])) {
  $validation = pathinfo($_FILES["json"]["name"]);
  if (@$validation['extension'] === 'json') {
    move_uploaded_file($_FILES["json"]["tmp_name"], "tests/".$_FILES["json"]["name"]);
    header("Location: list.php");
  } elseif (@is_null($validation['extension'])) {
    echo '<h3>Вы не выбрали файл!<h3><br />';
  } else {
  echo '<h3>Можно загрузить только файл в формате .json<h3><br />';
  }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Страница загрузки файлов с тестами</title>
</head>
<body>
  	<h3>Вы можете добавить файл с тестом на сервер</h3>
    <p>(поддерживаются только файлы с расширением .json)</p><br/>
    <h3>Пример структуры файла test_1.json:</h3>
    <pre>

  {
  "question": "СКОЛЬКО ДНЕЙ В ГОДУ?",
  "answers": [
    1024,
    512,
    365,
    256
  ],
  "correct": 365
  }

    </pre>
  	<form action="admin.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="json"><br/><br/>
      <input type="reset" value="Очистить">
      <input type="submit" value="Отправить"><br/><br/><br/>
    </form>
    <h3>Список загруженных тестов:</h3>
      <?php foreach ($files as $key => $value) {
        $num = $key - 1;
        echo "$num. $value";
        echo '<br />';
      }
      echo '<br /><br /><br /><br />';
      ?>
    <a href="list.php"><button>Перейти к выбору теста</button></a>
</body>
</html>