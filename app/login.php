<?php
// Inclusión del archivo que contiene las funciones generales.
include('include/funciones.inc.php');
// Función que verifica que las credenciales de identificación introducidas 
// son correctas.
function usuario_existe($identificador,$contraseña) {
  // Conexión y selección de la base de datos
  $conexión = mysqli_connect('localhost','root','');
  mysqli_select_db($conexión,'tallerDB');
  // Definición y ejecución de una consulta preparada.
  $sql  = 'SELECT 1 FROM usuarios ';
  $sql .= 'WHERE identificador = ? AND contrasena = ?';
  $consulta = mysqli_stmt_init($conexión);
  $ok = mysqli_stmt_prepare($consulta,$sql);
  $ok = mysqli_stmt_bind_param
          ($consulta,'ss',$identificador,$contraseña);
  $ok = mysqli_stmt_execute($consulta);
  mysqli_stmt_bind_result($consulta,$existe);
  $ok = mysqli_stmt_fetch($consulta);
  mysqli_stmt_free_result($consulta);
  // La identificación es correcta si la consulta ha devuelto 
  // una línea (el usuario existe y la contraseña 
  // es correcta).
  // Si este es el caso $existe contiene 1, de lo contrario está 
  // vacía. Basta con devolverla como un valor booleano.
  return (bool) $existe;
  mysqli_close($conexión);//1
}
// Inicialización de las variables.
$identificador = '';
$contraseña = '';
$mensaje = '';
$acción = '';
// ¿Se llama al script en la validación del formulario?
if (isset($_POST['conexión'])) { // sí
  // => conexión manual.
  // Recuperar la información introducida.
  $identificador = $_POST['identificador'];
  $contraseña = $_POST['contraseña'];
  // Indicar la acción a realizar a continuación.
  $acción = 'conexión';
  // Preparar un mensaje en caso de problema.
  $mensaje = 'Identificación incorrecta. '.
             'Volver a intentarlo.';
// De lo contrario, ¿hay una cookie de "identificador"?
} elseif (isset($_COOKIE['identificador'])) { // sí
  // => conexión automática.
  // Recuperar la información de las cookies
  $identificador = $_COOKIE['identificador'];
  $contraseña = $_COOKIE['contraseña'];
  // Indicar la acción a realizar a continuación.
  $acción = 'conexión';
  // Preparar un mensaje en caso de problema.
  $mensaje = 'Identificación automática incorrecta. '.
             'Inténtelo de forma manual.';
}
// Finalmente, ¿qué hacemos?
if ($acción == 'conexión') { // intentar una conexión
  // Verificar que el usuario existe.
  if (usuario_existe($identificador,$contraseña)) {
    // El usuario existe ...
    // => iniciar la sesión a nivel de aplicación
    session_start();
    session_regenerate_id(); // en el caso en que ...
    $_SESSION['identificador'] = $identificador;
    $_SESSION['contraseña'] = $contraseña;
    //Se obtiene el rol del usuario mediante consulta SQL
    $conexión = mysqli_connect('localhost','root','');
    mysqli_select_db($conexión,'tallerDB');
    $query = "select roledeAcceso from USUARIOS where identificador = '$identificador' and contrasena = '$contraseña'";
    $result_tools = mysqli_query($conexión, $query);
    $row = mysqli_fetch_array($result_tools);
    $role = $row['roledeAcceso'];
    //Agregamos la variable 'role' a nuestra sesion
    $_SESSION['rol'] = $role;
    mysqli_close($conexión);
    // Redirigir al usuario a otra página del sitio
    // (¡sólo hay una!).
    header('location: '.url('dashboard.php'));
    exit;
  } // usuario_existe
} // $acción == 'conexión'
// Si es la primera llamada, o si la conexión manual
// o automática ha fallado, dejar que se muestre el formulario.
?>
<!---------------------------------------------------------------------------->

<?php include('include/header.php') ?>

  <main>
    <form class="container col-6" action="login.php" method="post">
      <br>
      <h2 class="H2">
        Inicia sesión para poder interactuar...
      </h2>
      <br>
      <div class="form-group">
        <label for="exampleInputEmail1">Username</label>
        <input type="text" class="form-control" id="identificador" aria-describedby="emailHelp" name="identificador" 
        value="<?php echo hacia_formulario($identificador); ?>">
        <small id="emailHelp" class="form-text text-muted">We'll never share your information with anyone else.</small>
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" class="form-control" name="contraseña"
        value="<?php echo hacia_formulario($contraseña); ?>">
      </div>
      <button type="submit" class="btn btn-primary" name="conexión" value="Inicio de Sesión">
        Ingresar
      </button>
      <?php echo $mensaje; ?>
    </form>
  </main>

    <?php include('include/footer.php') ?>