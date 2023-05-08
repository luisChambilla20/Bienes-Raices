<?php
require "../../includes/app.php";

use App\Propiedad;
use App\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;


autenticado();

$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT); //VERIFICAR FORMATO DE LAS CONSULTAS

if (!$id) {
    header('Location: ../');
}

$propiedad = Propiedad::forId($id);

$vendedores = Vendedor::all();

$errores = Propiedad::getErrores();

if ($_POST) {


    $arg = $_POST['propiedad'];
    $propiedad->sincronizar($arg);

    $errores = $propiedad->validar();

    $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

    if ($_FILES['propiedad']['tmp_name']['imagen']) {
        $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800, 600);
        $propiedad->setImage($nombreImagen);
    }


    //Verificar que no se tenga errores
    if (empty($errores)) {
        //ALAMCENRA IMAGEN
        if ($_FILES['propiedad']['tmp_name']['imagen']) {
            $image->save(CARPETA_IMAGEN . $nombreImagen);
        }

        $propiedad->guardar();
    }
}


incluirTemplate('header');

?>
<main class="contenedor seccion">
    <h1>Actualizar</h1>

    <a href="../" class="boton boton-verde">volver</a>

    <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
            <?php echo $error; ?>
        </div>
    <?php endforeach; ?>

    <form method="POST" class="formulario" enctype="multipart/form-data">
        <?php include '../../includes/templates/formulario.php' ?>

        <input type="submit" value="Actualizar propiedad propiedad" class="boton boton-verde">
    </form>




</main>

<?php
incluirTemplate('footer');
?>