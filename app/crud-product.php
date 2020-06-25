<?php
    include('include/funciones.inc.php');

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

    if(isset($_POST['addTool'])){
        $product = $_POST['nombreP'];
        $precio = $_POST['precioP'];
        
        $conexión = mysqli_connect('localhost','root','');
        if (! $conexión) {
            exit('Error de conexión.');
        }
        // Selección de la base de datos.
        $ok = mysqli_select_db($conexión,'tallerDB');
        if (! $ok) {
            exit('No se pudo seleccionar la base de datos.');
        }
        $query = "INSERT INTO herramientas (texto, precio) VALUES ('$product', '$precio')";
        $result = mysqli_query($conexión, $query);
        if(!$result){
            die("Falla al insertar :(");
        }
        mysqli_close($conexión);
        //echo 'SAVED!';
        $_SESSION['message'] = "Agregaste un producto!";
        $_SESSION['typeOfMessage'] = "success";
        //mysqli_close($conn);
    }
?>
<?php include('include/header.php') ?>
<div class="container p-4">
    <div class="row">
        <div class="col-md-4">
            <?php if(isset($_SESSION['message'])){?>
                <div class="alert alert-<?= $_SESSION['typeOfMessage'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php
             }?>
            <div class="card card-body">
                <form action="crud-product.php" method="POST">
                    <h4>Agregar producto</h4>
                    <div class="form-group">
                        <input type="text" name="nombreP" class="form-control"
                        placeholder="Nombre del producto" autofocus>
                    </div>
                    <div class="form-group">
                        <input type="number" min=0 name="precioP" class="form-control"
                        placeholder="Precio del producto" autofocus>
                    </div>
                    <input type="submit" class="btn btn-primary btn-block" 
                    name="addTool" values="Save Tool">
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <table class="table table-striped align-content-center">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre articulo</th>
                        <th>Precio</th>
                        <th>Acciones</th>
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
                $query2 = "SELECT * FROM herramientas";
                $resultTool = mysqli_query($conexión, $query2);
                while($row = mysqli_fetch_array($resultTool)){?>
                    <tr>
                        <td> <?php echo $row['identificador'] ?></td>
                        <td> <?php echo $row['texto'] ?></td>
                        <td> <?php echo $row['precio'] ?></td>
                        <td class="align-content-center">
                            <a href="editTool.php?identificador=<?php echo $row['identificador'] ?>"
                            class="btn btn-warning">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="deleteTool.php?identificador=<?php echo $row['identificador'] ?>"
                            class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                <?php 
                }
                mysqli_close($conexión);
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include('include/footer.php') ?>