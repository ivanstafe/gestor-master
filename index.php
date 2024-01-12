<?php 
	
require_once "clases/Conexion.php";
$obj = new conectar();
$conexion = $obj->conexion();

$sql = "SELECT * FROM usuarios WHERE tipo='administrador'";
$result = mysqli_query($conexion, $sql);
$validar = mysqli_num_rows($result) > 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login de usuario</title>
    <link rel="stylesheet" type="text/css" href="libs/bootstrap/css/bootstrap.css">
    <script src="libs/jquery-3.2.1.min.js"></script>
</head>
<body style="background-color: grey">
<br><br><br>
<div class="container">
    <div class="row">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="panel panel-primary">
                <div class="panel panel-heading"></div>
                <div class="panel panel-body">
                    <p>
                        <!-- <img src="img/"  height="190"> -->
                    </p>
                    <form id="formLogin">
                        <label>Nombre</label>
                        <input type="text" class="form-control input-sm" name="nombre" id="nombre">
                        <label>Password</label>
                        <input type="password" name="password" id="password" class="form-control input-sm">
                        <p></p>
                        <span class="btn btn-primary btn-sm" id="entrarSistema">Entrar</span>
                        <?php if (!$validar): ?>
                            <a href="registro.php" class="btn btn-danger btn-sm">Registrar</a>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
</div>
<script type="text/javascript" src="js/index.js"></script>
</body>
</html>
