<?php
session_start();
require_once "../clases/Conexion.php";

if (isset($_SESSION['nombre'])) {
    $con = new conectar();
    $conexion = $con->conexion();

    $nombreUsuario = $_SESSION['nombre'];
    $sql_tipo = "SELECT tipo FROM usuarios WHERE nombre = '$nombreUsuario'";
    $result_tipo = mysqli_query($conexion, $sql_tipo);

    if ($result_tipo && mysqli_num_rows($result_tipo) > 0) {
        $fila_tipo = mysqli_fetch_assoc($result_tipo);
        $_SESSION['tipo'] = $fila_tipo['tipo'];
    }
?>

    <!DOCTYPE html>
    <html>

    <head>
        <title>Bienvenida</title>
        <?php require_once "menu.php"; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">

        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f3f3f3;
                margin: 0;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                height: 100vh;
            }

            .bienvenida {
                text-align: center;
            }

            .bienvenida h1 {
                font-size: 25px;
                font-style: oblique;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                color: grey;
                /* Cambiar el color del título */
            }



            .animate-delay-1 {
                animation-delay: 0.5s;
            }

            .animate-delay-2 {
                animation-delay: 1s;
            }

      

            /* Animaciones personalizadas */
            @keyframes fadeInUp {
                0% {
                    transform: translateY(100px);
                    opacity: 0;
                }

                100% {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            /* Resto del estilo CSS se mantiene igual */
            /* ... */
        </style>
    </head>

    <body>
        <div class="bienvenida">
            <div class="bienvenida">
                <h1>
                    <span class="animate__animated animate__fadeInLeft">B</span>
                    <span class="animate__animated animate__fadeInLeft animate-delay-1">i</span>
                    <span class="animate__animated animate__fadeInLeft animate-delay-2">e</span>
                    <span class="animate__animated animate__fadeInLeft">n</span>
                    <span class="animate__animated animate__fadeInLeft animate-delay-1">v</span>
                    <span class="animate__animated animate__fadeInLeft animate-delay-2">e</span>
                    <span class="animate__animated animate__fadeInLeft">n</span>
                    <span class="animate__animated animate__fadeInLeft animate-delay-1">i</span>
                    <span class="animate__animated animate__fadeInLeft animate-delay-2">d</span>
                    <span class="animate__animated animate__fadeInLeft">o</span>


                    <span class="animate__animated animate__fadeInLeft">:</span>
                    <span class="animate__animated animate__fadeInUp animate-delay-1" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 25px; color:#3399FF;">
                        <?php echo $_SESSION['nombre']; ?>
                        <!--  echo $_SESSION['nombre'] . " (" . $_SESSION['tipo'] . ")"; -->

                    </span>

                </h1>

            </div>
            <br>


        </div>

        <script>
            const letters = document.querySelectorAll('.bienvenida h1 span');
            letters.forEach((letter, index) => {
                letter.style.animationDelay = `${index * 100}ms`; // Añade un retraso para cada letra
            });
        </script>
    </body>

    </html>

<?php
} else {
    header("location:../index.php");
}
?>