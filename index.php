<?php
session_start();

// Crear carrito si no existe
if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}
// lista de productos comprados
if (!isset($_SESSION['carrito'])) {
    $_SESSION['lista_compra'] = [];
}

// Productos
$productos = [
    ["id" => 1, "nombre" => "Camisa", "precio" => 50000],
    ["id" => 2, "nombre" => "Pantalón", "precio" => 80000],
    ["id" => 3, "nombre" => "Gorra", "precio" => 12000],
    ["id" => 4, "nombre" => "sudadera", "precio" => 23000],
    ["id" => 5, "nombre" => "chaqueta", "precio" => 41000]
];


// Agregamos los productos al carrito
if (isset($_GET['accion']) && $_GET['accion'] == "agregar") {

    $id = $_GET['id'];
    $existe = false;
    $nombre = "";

    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $id) {
            $item['cantidad']++;
            $existe = true;
            $nombre = $item['nombre'];
        }
    }

    if (!$existe) {
        foreach ($productos as $p) {
            if ($p['id'] == $id) {
                $p['cantidad'] = 1;
                $_SESSION['carrito'][] = $p;
                $nombre = $p['nombre'];
                $_SESSION['lista_compra'][] = $p;
                $nombre = $p['nombre'];
            }
        }
    }

    // MENSAJE
    $_SESSION['mensaje'] = "Agregaste el articulo $nombre";

    header("Location: index.php");
}


//actualizzamos
if (isset($_POST['accion']) && $_POST['accion'] == "actualizar") {

    foreach ($_SESSION['carrito'] as &$item) {
        if ($item['id'] == $_POST['id']) {
            $item['cantidad'] = $_POST['cantidad'];
            $_SESSION['mensaje'] = "Actualizaste {$item['nombre']}";
        }
    }

    header("Location: index.php?ver=carrito");
}


//eliminacion de productos
if (isset($_GET['accion']) && $_GET['accion'] == "eliminar") {

    foreach ($_SESSION['carrito'] as $i => $item) {
        if ($item['id'] == $_GET['id']) {
            $_SESSION['mensaje'] = "Eliminaste el articulo {$item['nombre']}";
            unset($_SESSION['carrito'][$i]);
            unset($_SESSION['lista_compra'][$i]);
        }
    }

    header("Location: index.php?ver=carrito");
}

\
 
// finalizar compra
if (isset($_GET['accion']) && $_GET['accion'] == "checkout") {
    if (isset($_SESSION['lista_compra'])) {
        $valores = "";
        foreach ($_SESSION['lista_compra'] as $i) {
            $valores .= $i['nombre'] . " ,";

        }
        ;
    }
    $_SESSION['mensaje'] = "Finalizaste la compra correctamente los productos comprados fueron $valores";
    $_SESSION['carrito'] = [];
    $_SESSION['lista_compra'] = [];



    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tienda sencilla</title>
</head>

<body>
    <!-- MENSAJE DE NOTIFICACION -->
    <?php
    if (isset($_SESSION['mensaje'])) {
        echo "<p><b>{$_SESSION['mensaje']}</b></p>";
    }
    ?>

    <h1>Tienda</h1>



    <a href="index.php">Productos</a> |
    <a href="index.php?ver=carrito">Carrito (<?= count($_SESSION['carrito']) ?>)</a>

    <hr>

    <?php

    //SECCION DEL CARRITO
    
    if (isset($_GET['ver']) && $_GET['ver'] == "carrito") {

        echo "<h2>Carrito</h2>";

        $total = 0;

        foreach ($_SESSION['carrito'] as $item) {

            $sub = $item['precio'] * $item['cantidad'];
            $total += $sub;

            echo "
        
        <p>
            {$item['nombre']} - {$item['precio']} <br>

            <form method='POST' style='display:inline;'>
                <input type='hidden' name='accion' value='actualizar'>
                <input type='hidden' name='id' value='{$item['id']}'>
                <input type='number' name='cantidad' value='{$item['cantidad']}' min='1'>
                <button>OK</button>
            </form>

            <a href='?accion=eliminar&id={$item['id']}'>Eliminar</a>

            <br>Subtotal: $sub
        </p>
        ";
        }

        echo "<h3>Total: $total</h3>";
        echo "<a href='?accion=checkout'>Finalizar compra</a>";
    } else {

        // SECCION DEL PRODUCTOS
    
        echo "<h2>Producto</h2>";

        foreach ($productos as $p) {
            echo "
        <p>
            {$p['nombre']} - {$p['precio']}
            <a href='?accion=agregar&id={$p['id']}'>Agregar</a>
        </p>
        ";
        }
    }
    ?>

</body>

</html>