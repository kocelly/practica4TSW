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
    <br>
    <main class="container">
        <h3>Resultado de la consulta.</h3>
        <div class="row">
            <div class="col-md-8">
                <table class="table table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Nombre Articulo</th>
                            <th scope="col">Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $conexión = mysqli_connect('localhost','root','');
                        if (! $conexión) {
                            exit('Error de conexión.');
                        }
                        // Selección de la base de datos.
                        $ok = mysqli_select_db($conexión,'tallerDB');
                        if (! $ok) {
                            exit('No se pudo seleccionar la base de datos.');
                        }
                        $query = "SELECT * FROM herramientas";
                        $result_tools = mysqli_query($conexión, $query);

                        while($row = mysqli_fetch_array($result_tools)){?>
                            <tr>
                                <td> <?php echo $row['identificador'] ?></td>
                                <td> <?php echo $row['texto'] ?></td>
                                <td> $ <?php echo $row['precio'] ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <div class="card text-center bg-success text-white mb-3">
                    <div class="card-body">
                        <h3>Total de productos</h3>
                        <h4 class="display-4">
                            <i class="fas fa-tools"></i>
                            <?php 
                                $numero = mysqli_num_rows($result_tools)
                            ?>
                            <?php echo "$numero"?>
                        </h4>
                    </div>
                </div>        
            </div>            
        </div>
        <br>
    </main>
    <div class="container" align="center">
        <a href="dashboard.php" class="btn btn-primary btn-lg btn-block col-8">
        Volver
        <i class="fas fa-reply"></i>
        </a><br>
    </div>
<?php include('include/footer.php') ?>