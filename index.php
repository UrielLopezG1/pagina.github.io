<?php
require_once('conexion.php');
if(empty($_POST['descripcion']) || empty($_POST['inventario'])){

    #echo "POR FAVOR LLENE LOS DATOS";

}else{
    $imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name']));
    $precio =  $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $inventario = $_POST['inventario'];
    $query = "INSERT INTO persona (imagen, precio, descripcion, inventario) VALUES ('$imagen', '$precio', '$descripcion', '$inventario')";
    $resultado = $conexion->query($query);

    if($resultado){
        echo "Se ingresaron los datos";
    }else{
        echo "No se guardaron los datos";
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso de datos</title>
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

        form {
            width: 50%;
            margin: 20px auto;
            border: 1px solid #ccc;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #333;
            color: #3377FF;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 5px;
        }

        a {
            color: #333;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <center>
        <h1>Datos</h1>
        <form method = "POST" enctype = "multipart/form-data">
            <h1>Ingresa los datos</h1>
            <label>Foto: </label>
            <input type="file" name = "imagen" require = ""><br><br>
            <label>Precio: </label>
            <input type="text" name="precio"><br><br>
            <label>Descripcion: </label>
            <input type="text" name="descripcion"><br><br>
            <label >Inventario: </label>
            <input type="number" name = "inventario"><br><br>
            <center>
                <input type="submit" name = "Guardar" value = "Guardar">
                <button><a href="consulta.php">Consultar</a></button>
            </center>
        </form>
    </center>
</body>
</html>