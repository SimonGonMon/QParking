<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Register</title>
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

        <div id="sidenavLogo" class="sidenav-bottom">
            <img src="assets/logo-fondo-oscuro.png" alt="logo" width="110" height="110">

        </div>
    </div>

    <!-- Use any element to open the sidenav -->
    <!-- <span onclick="openNav()">open</span> -->

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
    <div id="main" class="mainpage">

        <div id="register-title" class="title">
            <h1>Registro Vehicular</h1>
            <hr class="rounded">
        </div>

        <!-- create a form to type a license plate and a button to check the status of the vehicle -->
        <form action="" method="post" class="form">
            <div class="form-group">
 
                <!-- <!-- add a label "placa" with font montserrat -->
                <label for="placa" class="placa">Placa</label>
                
            
                  <input type="text" name="licensePlate" class="a" id="licensePlate" pattern="([A-Za-z]{3}\d{2}[A-Za-z]{1})|([A-Za-z]{3}\d{3})" maxlength="6" title="ABC123 o ABC12D" placeholder="Ingrese la placa del vehículo" required>
    
                <button type="submit" class="login-button">Registrar</button>

            </div>
        </form>



    </div>

    <?php
    require('db.php');
    date_default_timezone_set('America/Bogota');
    // include("auth_session.php");

    // fetch from the table "vehicles" fromt the database where the license plate is the same as the one typed in the form
    if(isset($_POST['licensePlate'])){
        $licensePlate = $_POST['licensePlate'];
        // uppercase the license plate
        $licensePlate = strtoupper($licensePlate);
        $query = "SELECT * FROM vehicles WHERE placa = '$licensePlate'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);

        // create a variable with the username of the user that is logged in
        $username = $_SESSION['username'];

        // if the license plate is not in the database then insert it into the database with status = "parked"
        // table has the structure:  user | licensePlate | status
        $time = date("Y-m-d H:i:s");
        if($count == 0){
            // create a variable of the time now in america/bogota timezone
            


            $query = "INSERT INTO vehicles (user, placa, status, fecha_ingreso) VALUES ('$username', '$licensePlate', 'parked', '$time')";
            $result = mysqli_query($con, $query);
            echo "<script>alert('Vehículo estacionado exitosamente.')</script>";

            // in the table "parking_history" with the structure: user | licensePlate | date
            // insert the current user, license plate and the date of the registration
            $query = "INSERT INTO parking_history (user, placa, fecha, status) VALUES ('$username', '$licensePlate', '$time', 'entra')";
            $result = mysqli_query($con, $query);


            // if the license plate is already in the database and is not parked then update the status to "parked" and insert the date of the registration
        } else if($row['status'] == 'free'){
            $query = "UPDATE vehicles SET status = 'parked' WHERE placa = '$licensePlate'";
            $result = mysqli_query($con, $query);
            echo "<script>alert('Vehículo estacionado exitosamente.')</script>";

            $query = "INSERT INTO parking_history (user, placa, fecha, status) VALUES ('$username', '$licensePlate', '$time', 'entra')";
            $result = mysqli_query($con, $query);

            // if the license plate is already in the database and is parked then show an alert
        } else {
            echo "<script>alert('El vehículo ya se encuentra parqueado, imposible añadir.')</script>";

        }

    }


    ?>

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
