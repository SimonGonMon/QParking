<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Registro</title>
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="style.css"/>
</head>
<body>

<div class="bg">
    <img src="assets/fondo-degradado.png" alt="bg" width="100%" height="100%">
</div>
<?php
    require('db.php');
    require('aes_encryption.php');
    // When form submitted, insert values into the database.
    if (isset($_REQUEST['username'])) {
        // removes backslashes
        $username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
        $username = mysqli_real_escape_string($con, $username);
        $email    = stripslashes($_REQUEST['email']);
        $email    = mysqli_real_escape_string($con, $email);
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($con, $password);
        $create_datetime = date("Y-m-d H:i:s");
        /* $query    = "INSERT into `users` (username, password, email, create_datetime)
                     VALUES ('$username', '" . hash("sha256",$password) . "', '$email', '$create_datetime')"; */
        $query    = "INSERT into `users` (username, password, email, create_datetime)
                     VALUES ('$username', '" . password_hash(base64_encode(AES_encrypt('encrypt',$password)), PASSWORD_BCRYPT) . "', '$email', '$create_datetime')";
        $result   = mysqli_query($con, $query);
        if ($result) {
            echo "<div class='form'>
                  <h3>Registro exitoso.</h3><br/>
                  <p class='link'><a href='login.php'>Iniciar Sesión</a></p>
                  </div>";
        } else {
            echo "<div class='form'>
                  <h3>* Faltan campos.</h3><br/>
                  <p class='link'><a href='registration.php'>Registrar</a> de nuevo.</p>
                  </div>";
        }
    } else {
?>
    <form class="form" action="" method="post">
        <div class="logo">
            <!-- set logo position centered and at the bottom of the div -->
            <img src="assets/logo-fondo-claro.png" alt="logo" width="110" height="110">
        </div>
        <!-- add text "QParking" -->
        <div class="app-title">
            <h1>QParking</h1>
        </div>
        <h1 class="login-title">Registro</h1>

        <input type="text" class="login-input" name="username" placeholder="Usuario" required />
        <input type="text" class="login-input" name="email" placeholder="E-Mail">
        <input type="password" class="login-input" name="password" placeholder="Contraseña">
        <input type="submit" name="submit" value="Registrar" class="login-button">
        <p class="link"><a href="login.php">Iniciar Sesión</a></p>
    </form>
<?php
    }
?>
</body>
</html>
