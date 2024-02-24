<?php

if (isset($_POST['signin'])) {
  $username = $_POST['username'];
  // パスワードをハッシュ化する
  $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
  
  try {
    $db = new PDO('mysql:host=localhost; dbname=sample', 'shijo', 'password');
    $sql = 'INSERT INTO users(username, password) VALUES(?, ?)';
    $stmt = $db->prepare($sql);
    // ハッシュ化したパスワードを使用
    $stmt->execute(array($username, $passwordHash));
    $stmt = null;
    $db = null;

    header('Location: http://localhost:8080/index.php');
    exit;

  } catch (PDOException $e) {
    echo $e->getMessage();
    exit;
  }
}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>新規登録画面</title>
</head>

<body>
  <h1>新規登録画面</h1>

  <form action="" method="POST">
    ユーザー名<input type="text" name="username" value=""><br>
    パスワード<input type="password" name="password" value=""><br>
    <input type="submit" name="signin" value="新規登録">
  </form>

</body>

</html>