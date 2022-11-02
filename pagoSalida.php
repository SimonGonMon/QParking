<?php
//include auth_session.php file on all user panel pages
include("auth_session.php");

// set session variable licensePlate to ""
$_SESSION['licensePlate'] = "";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro</title>
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
            <h1>Pago de Estacionamiento</h1>
            <hr class="rounded">
        </div>

        <!-- create a form to type a license plate and a button to check the status of the vehicle -->
        <form method="post" class="form" id="formConsulta" >
            <div class="form-group">
 
                <!-- <!-- add a label "placa" with font montserrat -->
                <label for="placa" class="placa">Placa</label>
                
            
                  <input type="text" name="licensePlate" class="a" id="licensePlate" pattern="([A-Za-z]{3}\d{2}[A-Za-z]{1})|([A-Za-z]{3}\d{3})" maxlength="6" title="ABC123 o ABC12D" value="<?php echo $_SESSION['licensePlate']; ?>" placeholder="Ingrese la placa del vehículo" required>
                <button type="submit" name="botonConsulta" value="botonConsulta" class="login-button">Consultar</button>
                <!-- add button --

            </div>
        </form>

        <!-- divider -->
        <div class="divisor1">

        <hr class="rounded">

        </div>


        <div hidden class='form2'>
            <form class="form_long">
                <div class='tableConsulta'>
                    <table>
                        <tr>
                            <th>Placa</th>
                            <th>Fecha de Ingreso</th>
                            <th>Tiempo de Estacionamiento</th>
                            <th>Valor a Pagar</th>
                            <!-- estado de pago -->
                            <th>Estado de Pago</th>
                        </tr>
                        <tr>
                            <td>$licensePlate</td>
                            <td>$dateString</td>
                            <td>$hours horas</td>
                            <td>$price</td>
                            <td>$paymentStatus</td>
                        </tr>
                    </table>
                </div>

                

            </form>

        </div>

        <div hidden class="form3">
            <form>
                <button form="formConsulta" type="submit" class="login-button" name="botonPago">Generar Pago</button>
            </form>
        </div>

        <div hidden class="form4">
            <form>
                <button form="formConsulta" type="button" class="login-button" name="botonRefrescarPago">Verificar Pago</button>
            </form>
        </div>

        <!-- divider -->
        <div class="divisor2">

            <hr class="rounded">

        </div>

        <div hidden class="qrForm">
                <div class="qr">
                    <!-- center the image -->
                    <div class="qr-center">
                        <img src="assets/qr.png" alt="qr" width="200" height="200" class="qrCode">
                    </div>
                </div>
        </div>

    </div>

    <?php
    require('db.php');
    date_default_timezone_set('America/Bogota');

    function getApiToken() {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apify.epayco.co/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Basic YTlhODMzNzAzZDVjNjJkNTkzYzI5ZTFlMGUxMzdiZWE6Nzk1NWU3YzQ5ZWQ4N2IzM2QzM2MzZGJiNGYxMzkzYzU='
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        #get the entry "token" and return it
        $response = json_decode($response, true);
        $token = $response['token'];
        return $token;
    }

    function newPayLink($title, $description, $amount) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://apify.epayco.co/collection/link/create',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
        "quantity": 1,
        "onePayment":true,
        "amount": '.$amount.',
        "currency": "COP",
        "id": 0,
        "description": "'.$description.'",
        "title": "'.$title.'",
        "typeSell": "2"

        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json',
            'Authorization: Bearer '.getApiToken()

        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;
        

        // alert response
        //echo "<script>alert('$response');</script>";

        return $response;

    }






    // global $price

    // include("auth_session.php");

    // fetch from the table "vehicles" fromt the database where the license plate is the same as the one typed in the form
    if(isset($_POST['botonConsulta'])) {
        $licensePlate = $_POST['licensePlate'];
        $_SESSION['licensePlate'] = $licensePlate;

        // show the div form 3
        
        // show divisor1
        echo "<script>document.querySelector('.divisor1').hidden = false;</script>";

        // repopulate the form with the license plate typed
        echo "<script>document.getElementById('licensePlate').value = '$licensePlate';</script>";


        // check if the license plate has a pending payment in transactions table
        $query = "SELECT * FROM transactions WHERE plate = '$licensePlate' AND status = 'pending'";
        $result = mysqli_query($con, $query);
        $num = mysqli_num_rows($result);

        // if there is a pending payment, save variable $estado
        if($num == 1) {
            $estado = "Pago Iniciado";
        } else {
            $estado = "Pago Pendiente";
        }

        // uppercase the license plate
        $licensePlate = strtoupper($licensePlate);
        $query = "SELECT * FROM vehicles WHERE placa = '$licensePlate'";
        $result = mysqli_query($con, $query) or die(mysql_error());
        $row = mysqli_fetch_array($result);
        $count = mysqli_num_rows($result);

        // if the license plate is found in the database, then show the status of the vehicle in a table below (placa, estado, fecha de ingreso)
        // and calculate the time the vehicle has been parked and the price if each hour and fraction of hour is 2500 pesos

        if($count == 1 && $estado == "Pago Pendiente") {
            $status = $row['status'];
            $date = $row['fecha_ingreso'];
            $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
            $dateString = $date->format('d-m-Y H:i:s');
            $now = new DateTime();
            $diff = $date->diff($now);
            $hours = $diff->h;
            $hours = $hours + ($diff->days*24);
            $minutes = $diff->i;
            $minutes = $minutes/60;
            $hours = $hours + $minutes;
            $hours = round($hours, 2);
            $price = $hours * 2500;
            $priceUnformatted = $price;
            $price = number_format($price, 0, ',', '.');
            $_SESSION['price'] = $price;
            $_SESSION['licensePlate'] = $licensePlate;
            $_SESSION['priceUnformatted'] = $priceUnformatted;



            // if pago pendiente, then show the button to pay
            if($estado == "Pago Pendiente") {
                echo "<script>document.querySelector('.form3').hidden = false;</script>";
                echo "<script>document.querySelector('.form4').hidden = true;</script>";
            } else {
                echo "<script>document.querySelector('.form3').hidden = true;</script>";
                echo "<script>document.querySelector('.form4').hidden = false;</script>";

            }
            
            echo "<script>document.querySelector('.form2').hidden = false;</script>";
            

            // assign variables to the table
            echo "<script>document.querySelector('.tableConsulta td:nth-child(1)').innerHTML = '$licensePlate';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(2)').innerHTML = '$dateString';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(3)').innerHTML = '$hours horas';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(4)').innerHTML = '$price';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(5)').innerHTML = '$estado';</script>";

            $_SESSION['table_licensePlate'] = $licensePlate;
            $_SESSION['table_date'] = $dateString;
            $_SESSION['table_hours'] = $hours;
            $_SESSION['table_price'] = $price;
            $_SESSION['table_estado'] = $estado;

            


            
        }else if($count == 1 && $estado == "Pago Iniciado") {
            $query = "SELECT * FROM transactions WHERE plate = '$licensePlate' AND status = 'pending'";
            $result = mysqli_query($con, $query);
            $num = mysqli_num_rows($result);

            echo "<script>document.querySelector('.form3').hidden = true;</script>";
            echo "<script>document.querySelector('.form4').hidden = false;</script>";

            echo "<script>document.querySelector('.form2').hidden = false;</script>";

            // get from the database the price, the date and the time parked
            $row = mysqli_fetch_array($result);
            $amount = $row['amount'];
            $dateString = $row['date'];
            $parkedTime = $row['parkedtime'];
            $qrLink = $row['qr_link'];

            

            // assign variables to the table
            echo "<script>document.querySelector('.tableConsulta td:nth-child(1)').innerHTML = '$licensePlate';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(2)').innerHTML = '$dateString';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(3)').innerHTML = '$parkedTime horas';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(4)').innerHTML = '$amount';</script>";
            echo "<script>document.querySelector('.tableConsulta td:nth-child(5)').innerHTML = 'Pago Iniciado';</script>";

            // show qr and set the qr code
            echo "<script>document.querySelector('.qrCode').src = '$qrLink';</script>";


            // show the qr code
            echo "<script>document.querySelector('.qrForm').hidden = false;</script>";


            



        }else {
            echo "<script>alert('No se encontró la placa en el sistema');</script>";
        }
    }














    if(isset($_POST['botonPago'])) {
        $priceUnformatted = $_SESSION['priceUnformatted'];
        $licensePlate = $_POST['licensePlate'];

        // repopulate the input
        echo "<script>document.getElementById('licensePlate').value = '$licensePlate';</script>";

        // uppercase the license plate
        $licensePlate = strtoupper($licensePlate);

        // get now time in UTC-5
        date_default_timezone_set('America/Bogota');
        $now = new DateTime();
        $now = $now->format('d-m-Y H:i:s');


        // set a new vatriable with the response of newPayLink

        $title = "QParking | $licensePlate | $now"; 

        $description = "Pago de parqueadero para la placa $licensePlate";

        $payResponse = newPayLink($title, $description, $priceUnformatted);

        // decode payResponse which is a json and get the variables invoceNumber and routeQr
        $payResponse = json_decode($payResponse, true);
        $json = '[]';

        foreach ($payResponse as $key => $value) {
            $json = json_encode($value);
        }

        $invoiceNumber = json_decode($json, true)['invoceNumber'];
        $routeQr = json_decode($json, true)['routeQr'];

        $hours = $_SESSION['table_hours'];
        

        // add the transaction to the database
        $query = "INSERT INTO transactions (reference, plate, date, amount, status, parkedtime, qr_link) VALUES ('$invoiceNumber', '$licensePlate', '$now', '$priceUnformatted', 'pending',  '$hours', '$routeQr')";
        $result = mysqli_query($con, $query) or die(mysql_error());

        // set the image to the qr code
        echo "<script>document.querySelector('.qrCode').src = '$routeQr';</script>";


        // show the qr code
        echo "<script>document.querySelector('.qrForm').hidden = false;</script>";



        echo "<script>document.querySelector('.form3').hidden = true;</script>";
        echo "<script>document.querySelector('.form4').hidden = false;</script>";

        echo "<script>document.querySelector('.form2').hidden = false;</script>";
        // keep the variables in the table
        echo "<script>document.querySelector('.tableConsulta td:nth-child(1)').innerHTML = '$_SESSION[table_licensePlate]';</script>";
        echo "<script>document.querySelector('.tableConsulta td:nth-child(2)').innerHTML = '$_SESSION[table_date]';</script>";
        echo "<script>document.querySelector('.tableConsulta td:nth-child(3)').innerHTML = '$_SESSION[table_hours] horas';</script>";
        echo "<script>document.querySelector('.tableConsulta td:nth-child(4)').innerHTML = '$_SESSION[table_price]';</script>";
        echo "<script>document.querySelector('.tableConsulta td:nth-child(5)').innerHTML = 'Pago Iniciado';</script>";
        

        
        //echo "<script>console.log('$payResponse');</script>";
        echo "<script>console.log('" . json_encode($payResponse) . "');</script>";

        echo "<script>console.log('$invoiceNumber');</script>";
        echo "<script>console.log('$routeQr');</script>";

    }
        








    ?>

</body>
</html>

<!-- add the function openNav as js -->
<script>


    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }

/* Open the sidenav */
    function openNav() {
    document.getElementById("mySidenav").style.display = "block";
    }

    /* Close/hide the sidenav */
    function closeNav() {
    document.getElementById("mySidenav").style.display = "none";
    }
</script>
