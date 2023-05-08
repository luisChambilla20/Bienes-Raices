<?php
require "../../includes/app.php";

use App\Vendedor;

autenticado();

//OPTENER TODOS LOS VENDEDORES
$vendedor = new Vendedor();
$errores = Vendedor::getErrores();

if ($_POST) {
    $vendedor = new Vendedor($_POST['vendedor']);

    $errores = $vendedor->validar();

    if (empty($errores)) {
        $vendedor->guardar();
    }
}




incluirTemplate('header');
?>
<main class="contenedor seccion">
    <h1>Registrar Vendedor(a)</h1>

    <a href="../" class="boton boton-verde">volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" action="./crear.php" class="formulario" enctype="multipart/form-data">

        <?php include '../../includes/templates/formulario-vendedores.php' ?>

        <input type="submit" value="Registrar Vendedor(a)" class="boton boton-verde">
    </form>

</main>
<?php
incluirTemplate('footer');
?>