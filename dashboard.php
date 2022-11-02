<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inicio</title>
    <link rel="icon" type="image/x-icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="style.css" />
</head>
<body>


    <div id="mySidenav" class="sidenav">
    <!-- <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a> -->
        <a href="dashboard.php">Inicio</a>
        <a href="register.php">Registro</a>
        <a href="pagoSalida.php">Pago</a>
        <a href="logout.php">Cerrar Sesión</a>
    <!-- <a href="#">Services</a>
    <a href="#">Clients</a>
    <a href="#">Contact</a> -->
        <div id="sidenavLogo" class="sidenav-bottom">
                <img src="assets/logo-fondo-oscuro.png" alt="logo" width="110" height="110">

        </div>
    </div>



    <!-- Use any element to open the sidenav -->
    <span onclick="openNav()">open</span>

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="main">
        <div class="form">
            <p>Usuario: <?php echo $_SESSION['username']; ?> </p>
            <p>Correo: <?php echo $_SESSION['email']; ?> </p>
            <p><a href="logout.php">Cerrar Sesión</a></p>
        </div>
    </div>

</body>
</html>

<!-- add the function openNav as js -->
<script>
/* Open the sidenav */
function openNav() {
  document.getElementById("mySidenav").style.display = "block";
}

/* Close/hide the sidenav */
function closeNav() {
  document.getElementById("mySidenav").style.display = "none";
}
</script>
