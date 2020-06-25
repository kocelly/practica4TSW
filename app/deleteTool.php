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

        $id = $_GET['identificador'];
        $query = "DELETE FROM herramientas WHERE identificador = $id";
        $result = mysqli_query($conexión, $query);

        if (!$result){
            die("Query failed");
        }

        $_SESSION['message'] = 'Producto eliminado correctamente';
        $_SESSION['typeOfMessage'] = 'danger';
        mysqli_close($conexión);
        header("Location: crud-product.php");

    }

?>
