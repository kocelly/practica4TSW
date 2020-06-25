<?php
// Inclusión del archivo que contiene las funciones generales.
include('include/funciones.inc.php');
// Abrir/reactivar la sesión.
session_start();
// Inicialización de las variables.
$mensaje = '';
// ¿La sesión se ha iniciado al nivel de la aplicación?
if (isset($_SESSION['identificador'])) { // sí
  // Recuperar toda la información de sesión.
  $identificador = $_SESSION['identificador'];
  $contraseña = $_SESSION['contraseña'];
    // Activar la conexión automática.
    // Depositar dos cookies de un tiempo de vida de 30 días,
    // una para el identificador del usuario y una para su
    // contraseña.
    $vencimiento = time()+ (30 * 24 * 3600);
    setcookie('identificador',$identificador,$vencimiento);
    setcookie('contraseña',$contraseña,$vencimiento);
    // Preparar un mensaje.
    $mensaje = 'Conexión automática activada';
} else { // Sesión no abierta a nivel de aplicación.
  // Redirigir al usuario a la página de inicio de sesión
  header('Location: login.php');
  exit;
}
?>
<?php include('include/header.php') ?>
  <section class="container">
      <center>
        <h2 class="letrero2">Salir de la base de datos de Frutas</h2>
          <?php 
          // Mostrar los datos de la sesión. 
          echo 'nombre = ',$_SESSION['identificador'],'<br />'; 

          // Cancelar la sesión. 
          session_destroy();
          setcookie('identificador');
          setcookie('contraseña');
          // Mostrar los datos de la sesión. 
          echo 'nombre = ',$_SESSION['identificador'],'<br />';
        ?> 
          <a href="login.php">Regresar a Inicio de Sesion</a
    </center>          
  </section>
</section>
<?php include('include/footer.php') ?>