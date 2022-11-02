<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Inicio de Sesión</title>
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

<!-- add a background -->
<div class="bg">
    <img src="assets/fondo-degradado.png" alt="bg" width="100%" height="100%">
</div>
<?php
    require('db.php');
    require('aes_encryption.php');
    session_start();
    // When form submitted, check and create user session.
    if (isset($_POST['username'])) {
        $username = stripslashes($_REQUEST['username']);    // removes backslashes
        $username = mysqli_real_escape_string($con, $username);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
      /*   //Check user is exist in the database
        $query    = "SELECT * FROM `users` WHERE username='$username'
                      AND password='" . hash("sha256",$password) . "'"; */
        $query    = "SELECT * FROM `users` WHERE username='$username'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $hashedPassword = mysqli_fetch_assoc($result)['password'];

            if (password_verify(base64_encode(AES_encrypt('encrypt',$password)), $hashedPassword)) {
                $_SESSION['username'] = $username;
                $query    = "SELECT * FROM `users` WHERE username='$username'";
                $result = mysqli_query($con, $query) or die(mysql_error());
                $rows = mysqli_num_rows($result);
                if ($rows == 1) {
                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['email'] = $row['email'];
                }
                // Redirect to user dashboard page
                header("Location: dashboard.php");
            } else {
                echo "<div class='form'>
                      <h3>Nombre de usuario o contraseña incorrectos.</h3><br/>
                      <p class='link'>Click aquí para <a href='login.php'>Iniciar Sesión</a> de nuevo.</p>
                      </div>";
            }
        } else {
            echo "<div class='form'>
                  <h3>Combinación de usuario y contraseña incorrectos.</h3><br/>
                  <p class='link'>Click para <a href='login.php'>iniciar sesión</a> otra vez.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" method="post" name="login">
        <div class="logo">
            <img src="assets/logo-fondo-claro.png" alt="logo" width="110" height="110">
        </div>
        <div class="app-title">
            <h1>QParking</h1>
        </div>
        <h1 class="login-title">Inicio de Sesión</h1>
        <input type="text" class="login-input" name="username" placeholder="Usuario" autofocus="true"/>
        <input type="password" class="login-input" name="password" placeholder="Contraseña"/>
        <input type="submit" value="Iniciar Sesión" name="submit" class="login-button"/>
        <p class="link"><a href="registro.php">Registrar</a></p>
  </form>
<?php
    }
?>
</body>
</html>
