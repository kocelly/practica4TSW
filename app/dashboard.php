<?php
// Inclusión del archivo que contiene las funciones generales.
include('include/funciones.inc.php');
// Abrir/reactivar la sesión.
session_start();
// Inicialización de las variables.
$mensaje = '';
$role = '';
// ¿La sesión se ha iniciado al nivel de la aplicación?
if (isset($_SESSION['identificador'])) { // sí
  // Recuperar toda la información de sesión.
  $identificador = $_SESSION['identificador'];
  $contraseña = $_SESSION['contraseña'];
  $role = $_SESSION['rol'];
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

<!------------------------------------------------------------------------------------->

<?php include('include/header.php') ?>
  <main>
    <section class="dash-banner">
      <div class="container contenido-banner">
        <h2 class="H2">
          Bienvenido a tu inicio | <?php echo $role?>
        </h2>
      </div>
    </section>
    <?php 
      switch($role){
        case 'administrador':
          include('admin.php');
        break;
        case 'cliente':
          include('cliente.php');
        break;
      }
    ?>
  </main>
<?php include('include/footer.php') ?>
