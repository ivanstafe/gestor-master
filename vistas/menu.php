<?php require_once "enlaces.php"; ?>

<!DOCTYPE html>
<html>

<head>
  <title></title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="ruta/a/font-awesome.css">

  <link rel="stylesheet" href="ruta/a/font-awesome-animation.min.css">


</head>

<body>
  <div id="nav">
    <div class="navbar navbar-inverse navbar-fixed-top" data-spy="affix" data-offset-top="100">
      <div class="container">
        <div class="navbar-header">
          <!-- Código del logo u otros elementos del encabezado -->
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav navbar-center">
            <li><a style="color:#FFFFFF" href="inicio.php"><i class="fas fa-home"></i>Inicio</a></li>
            <li class="dropdown">
              <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-gift"></i> Productos<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a style="color:#333" href="categoriasProductos.php"><i class="fas fa-th"></i> Categorías</a></li>
                <li><a style="color:#333" href="productos.php"><i class="fas fa-cube"></i> Productos</a></li>
              </ul>
            <li class="dropdown">
              <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-box"></i> Inventario<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a style="color:#333" href="inventarioProductos.php"><i class="fas fa-box"></i> Inventario Productos</a></li>
                <li><a style="color:#333" href="inventarioInsumos.php"><i class="fas fa-box"></i> Inventario Insumos</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-paperclip"></i> Insumos<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a style="color:#333" href="proveedores.php"><i class="far fa-address-card"></i> Proveedores</a></li>

                <li><a style="color:#333" href="categoriasInsumos.php"><i class="fas fa-th"></i> Categorías</a></li>
                <li><a style="color:#333" href="insumos.php"><i class="fas fa-archive"></i> Insumos</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-wallet"></i> Gastos<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a style="color:#333" href="categoriasGastos.php"><i class="fas fa-th"></i> Categorías</a></li>
                <li><a style="color:#333" href="gastos.php"><i class="fas fa-hand-holding-usd"></i> Gastos</a></li>
              </ul>
            </li>
            <li><a style="color:#FFFFFF" href="clientes.php"><i class="fas fa-address-card"></i> Clientes</a></li>
            <li><a style="color:#FFFFFF" href="ventas.php"><i class="fas fa-dollar-sign faa-beat"></i> Vender</a></li>
            <li class="dropdown">
              <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-edit"></i> Informes<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a style="color:#333" href="informesGastos.php"><i class="fas fa-file-alt"></i> Gastos</a></li>
                <li><a style="color:#333" href="informesInsumos.php"><i class="fas fa-file-alt"></i> Insumos</a></li>
                <li><a style="color:#333" href="informesVentas.php"><i class="fas fa-file-alt"></i> Ventas</a></li>
              </ul>
            </li>
            <?php
            
// Verifica la sesión y el tipo de usuario
if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'Administrador') {
  // Si el usuario es administrador, muestra el enlace "Ajustes"
  echo '
  <li class="dropdown">
    <a style="color:#FFFFFF" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
      <i class="fas fa-edit"></i> Ajustes<span class="caret"></span>
    </a>
    <ul class="dropdown-menu">
      <li><a style="color:#333" href="ajusteProductos.php"><i class="fas fa-cogs"></i> Productos</a></li>
      <li><a style="color:#333" href="ajusteInsumos.php"><i class="fas fa-cogs"></i> Insumos</a></li>
      <li><a style="color:#333" href="notaCredito.php"><i class="fas fa-file-invoice-dollar"></i> Notas de Crédito</a></li>
    </ul>
  </li>
  ';
}
?>


            <?php
            // Verifica la sesión y el tipo de usuario
            if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'Administrador') {
              // Muestra el enlace "Usuarios" solo para administradores
              echo '<li><a style="color:#2ecc71" href="registrarUsuarios.php"><i class="fa fa-users"></i> Usuarios</a></li>';
            }
            ?>
            <li class="dropdown">
              <a href="#" style="color: #5bc0de;" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="far fa-user"></i> <?php echo $_SESSION['nombre']; ?> <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a style="color:#5bc0de" href="../acciones/cerrarSesion.php"><i class="fas fa-power-off"></i> Salir</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</body>

</html>

<script type="text/javascript">
  $(window).scroll(function() {
    if ($(document).scrollTop() > 150) {
      $('.logo').height(200);
    } else {
      $('.logo').height(100);
    }
  });
</script>

<style>
  /* Agrega espacio vertical entre los elementos de la barra */
  #navbar>ul.nav.navbar-nav.navbar-center>li {
    margin-top: 30px;
    /* Puedes ajustar este valor según tus necesidades */
    margin-bottom: 10px;
    /* Puedes ajustar este valor según tus necesidades */
  }
</style>