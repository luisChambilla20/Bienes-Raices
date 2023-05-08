<?php
require "../../includes/app.php";

use App\Vendedor;

autenticado();

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT); //VERIFICAR FORMATO DE LAS CONSULTAS

if (!$id) {
    header('Location: ../');
}

//OPTENER TODOS LOS VENDEDORES
$vendedor = Vendedor::forId($id);

$errores = Vendedor::getErrores();

if ($_POST) {
    $arg = $_POST['vendedor'];
    $vendedor->sincronizar($arg);

    $errores = $vendedor->validar();

    if (empty($errores)) {
        $vendedor->guardar();
    }
}

incluirTemplate('header');

?>
<main class="contenedor seccion">
    <h1>Actualizar Vendedor(a)</h1>

    <a href="../" class="boton boton-verde">volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario-vendedores.php' ?>

        <input type="submit" value="Guardar cambios" class="boton boton-verde">
    </form>




</main>

<?php
incluirTemplate('footer');
?>