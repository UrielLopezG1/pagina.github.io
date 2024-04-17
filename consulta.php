<?php
include "conexion.php";
session_start();

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['restar'])) {
        $identificador = $_POST["restar"];

        // Primero, verifica si el inventario ya es 0 o menor
        $sql_check_inventory = "SELECT inventario FROM persona WHERE id = ?";
        $stmt = mysqli_prepare($conexion, $sql_check_inventory);
        mysqli_stmt_bind_param($stmt, "i", $identificador);
        mysqli_stmt_execute($stmt);
        $result_check_inventory = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result_check_inventory);

        if ($row['inventario'] > 0) {
            // Decrementar el inventario en la base de datos
            $sql = "UPDATE persona SET inventario = inventario - 1 WHERE id = ?";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "i", $identificador);
            if (!mysqli_stmt_execute($stmt)) {
                // Manejar el error aquí
            }

            // Comprobar nuevamente el inventario después de decrementar
            if ($row['inventario'] - 1 <= 0) {
                // Eliminar el registro completo cuando el inventario llega a 0
                $sql_delete_record = "DELETE FROM persona WHERE id = ?";
                $stmt = mysqli_prepare($conexion, $sql_delete_record);
                mysqli_stmt_bind_param($stmt, "i", $identificador);
                if (!mysqli_stmt_execute($stmt)) {
                    // Manejar el error aquí
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datos Guardados</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        h1 {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: center;
            vertical-align: middle;
            position: relative;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        form {
            display: inline;
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        button {
            background-color: #333;
            color: #4FFF33;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }

        a {
            color: #fff;
            text-decoration: none;
        }

       .center {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="center">Datos Guardados</h1>
    <div class="center">
        <table>
            <?php
            $query = mysqli_query($conexion, "SELECT * FROM persona");
            $result = mysqli_num_rows($query);

            if($result > 0){
                while($data = mysqli_fetch_array($query)){?>

                    <td>
                        <img height = "50px" src="data:image/jpg;base64, <?php echo base64_encode($data['imagen'])?>">
                        <br><br>
                        <?php echo '$'. $data['precio']?>
                        <br><br>
                        <?php echo $data['descripcion']?>
                        <br><br>
                        <?php echo 'Inventario:' . $data['inventario']?>
                        <br><br><br>
                        <form id="restar_<?php echo $data['id']?>" action="" method="post" style="display: inline;">
                            <input type="hidden" name="restar" value="<?php echo $data['id']?>">
                            <button type="submit">Comprar</button>
                        </form>
                    </td>

                <?php
                }
            }
           ?>
        </table>

        <button><a href="index.php">Regresar</a></button>
    </div>
</body>
</html>