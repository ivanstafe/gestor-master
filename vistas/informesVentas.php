<?php
session_start();
if (isset($_SESSION['nombre'])) {
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Informes de Ventas</title>

    </head>
    <title>Informes de ventas</title>
    <?php require_once "menu.php"; ?>

    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div id="cargaTablaVentas"></div>
                </div>
            </div>
        </div>
    </body>



    <script type="text/javascript" src="../js/informesVentas.js"></script>
    </body>

    </html>



<?php
} else {
    header("location:../index.php");
}
?>