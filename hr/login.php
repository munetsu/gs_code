<?php
    session_start();

    // 関数読み込み
    include('funcs/funcs.php');

    $_SESSION['chk_ssid'] = session_id();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>loginMenu</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    
    <!-- header -->
    <hgroup class="heading">
    <h1 class="major">Login Form </h1>
    </hgroup>

    <!-- form starts here -->
    <form class="sign-up" action="login/login_check.php" name="loginform" method="post">
        <h1 class="sign-up-title">Sign up in seconds</h1>
        <input type="text" class="sign-up-input" placeholder="What's your email?" autofocus required name="lid" id="lid">
        <input type="password" class="sign-up-input" placeholder="Choose a password" required name="lpw" id="lpw">
        <input type="submit" value="Sign me up!" class="sign-up-button">
    </form>

    <div style="text-align:center">
        <a href="login/register.php" style="font-size:16px;color:white;text-decoration:underline;">新規登録の場合はこちら</a>
    </div>

    <!-- </div> -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>