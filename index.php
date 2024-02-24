<?php

$err_msg = ''; // エラーメッセージ用の変数を初期化

if (isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password']; // 入力されたパスワード
  
  try {
    $db = new PDO('mysql:host=localhost; dbname=sample', 'shijo', 'password');
    // パスワードの比較ではなく、ユーザー名だけで検索
    $sql = 'SELECT * FROM users WHERE username=?';
    $stmt = $db->prepare($sql);
    $stmt->execute(array($username));
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ユーザーが見つかった場合、パスワードを検証
    if ($user && password_verify($password, $user['password'])) {
      // パスワードが一致した場合、home.phpへリダイレクト
      header('Location: http://localhost:8080/home.php');
      exit;
    } else {
      $err_msg = "ユーザ名またはパスワードが誤りです。" . "<br>";
    }
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
  <title>ログイン画面</title>
</head>

<body>
  <h1>ログイン画面</h1>

  <form action="" method="POST">
    <?php if ($err_msg !== null && $err_msg !== ''){ echo $err_msg; } ?>
    ユーザー名<input type="text" name="username" value=""><br>
    パスワード<input type="password" name="password" value=""><br>
    <input type="submit" name="login" value="ログイン">
  </form>

  <a href="signin.php">新規登録</a>

</body>

</html>