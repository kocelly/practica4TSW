<?php

    session_start();

    if (isset($_SESSION['identificador'])) { // sí
        // Recuperar toda la información de sesión.
        $identificador = $_SESSION['identificador'];
        $contraseña = $_SESSION['contraseña'];
        $role = $_SESSION['rol'];
    }

    if(!isset($_SESSION['rol'])){
        header('location: login.php');
    } else{
        if($_SESSION['rol'] != 'administrador'){
            header('location: login.php');
        }
    }

    if(isset($_GET['identificador'])){
        
        $conexión = mysqli_connect('localhost','root','');
        if (! $conexión) {
            exit('Error de conexión.');
        }
        // Selección de la base de datos.
        $ok = mysqli_select_db($conexión,'tallerDB');
        if (! $ok) {
            exit('No se pudo seleccionar la base de datos.');
        }

        $_SESSION['idTool'] = $_GET['identificador'];
        $id = $_SESSION['idTool'];
        $query = "SELECT * FROM herramientas WHERE identificador = $id";
        $result = mysqli_query($conexión, $query);
        if(mysqli_num_rows($result) == 1){
            $row = mysqli_fetch_array($result);
            $texto = $row['texto'];
            $precio = $row['precio'];
        }
        mysqli_close($conexión);
    }

    if(isset($_POST['update'])){
        $conexión = mysqli_connect('localhost','root','');
        if (! $conexión) {
            exit('Error de conexión.');
        }
        // Selección de la base de datos.
        $ok = mysqli_select_db($conexión,'tallerDB');
        if (! $ok) {
            exit('No se pudo seleccionar la base de datos.');
        }

        $id = $_SESSION['idTool'];
        $text = $_POST['texto'];
        $prize = $_POST['precio'];

        echo $id;
        echo $text;
        echo $prize;

        $query = "UPDATE herramientas SET texto = '$text', precio = $prize WHERE identificador = $id";
        mysqli_query($conexión, $query);
        $_SESSION['message'] = 'Producto editado correctamente';
        $_SESSION['typeOfMessage'] = 'warning';
        header("Location: crud-product.php");
        mysqli_close($conexión);
    }
?>

<?php include('include/header.php') ?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-4 mx-auto">
           <div class="card card-body">
                <form action="editTool.php?id=<?php echo $_SESSION['idTool']; ?>" method="POST">
                    <div class="form-group">
                        <input type="text" name="texto" value="<?php echo $texto ?>"
                        class="form-control" placeholder="Actualiza texto">
                    </div>
                    <div class="form-group">
                        <input type="text" name="precio" value="<?php echo $precio ?>"
                        class="form-control" placeholder="Actualiza precio">
                    </div>
                    <button class=" btn btn-success" name="update">
                        Actualizar
                    </button>
                </form>
           </div> 
        </div>
    </div>
</div>

<?php include('include/footer.php') ?>
