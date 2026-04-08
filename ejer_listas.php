<?php
session_start();

if (!isset($_SESSION['tareas'])) {
    $_SESSION['tareas'] = [];
}

$mensaje = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $nueva_tarea = trim($_POST['tarea_input']);

    if (empty($nueva_tarea)) {
        $mensaje = "ERROR: La tarea no puede estar vacía.";
    } elseif (strlen($nueva_tarea) > 50) {
        $mensaje = "ERROR: La tarea es muy larga";
    } else {
        $_SESSION['tareas'][] = htmlspecialchars($nueva_tarea);
        
        header("Location: tareas.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<body>

    <h1>Lista de Tareas </h1>

    <?php if ($mensaje != ""): ?>
        <p><strong><?php echo $mensaje; ?></strong></p>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="tarea_input" placeholder="Escribe una tarea..." 
               value="<?php echo isset($_POST['tarea_input']) ? htmlspecialchars($_POST['tarea_input']) : ''; ?>">
        <button type="submit">Ingresar</button>
    </form>

    <hr>

    <h3>Tus Tareas:</h3>
    <ul>
        <?php if (empty($_SESSION['tareas'])): ?>
            <li>No hay tareas aún.</li>
        <?php else: ?>
            <?php foreach ($_SESSION['tareas'] as $tarea): ?> 
                <li><?php echo $tarea; ?></li>
            <?php endforeach; ?>
        <?php endif; ?>
    </ul>

</body>
</html>